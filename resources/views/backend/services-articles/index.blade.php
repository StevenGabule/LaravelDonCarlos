@extends('backend.layouts.app')

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Services Blog Management</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <div class="col-lg-3 mb-4">

        <div class="card shadow mb-4">

          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold header-text small">Options</h6>
          </div>

          <div class="card-body p-0">
            <div class="list-group small rounded-0 border-0">
              <a href="javascript:void(0)"
                 class="list-group-item list-group-item-action list-group-custom all">
                <i class="fad fa-newspaper mr-2"></i>All Service Blog
              </a>

              <a href="{{ route('service-article.create') }}"
                 class="list-group-item list-group-item-action">
                <i class="fad fa-layer-plus mr-2"></i>New Service Blog
              </a>

              <a href="javascript:void(0)"
                 class="list-group-item list-group-item-action drafted"><i
                  class="fad fa-file-edit mr-2"></i>Draft</a>

              <a href="javascript:void(0)"
                 class="list-group-item list-group-item-action published"><i
                  class="fad fa-globe-asia mr-2"></i>Published</a>

              <a href="javascript:void(0)"
                 class="list-group-item list-group-item-action viewTrash"><i
                  class="fad fa-dumpster mr-2"></i>Trash</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-9 mb-4">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold header-text small captionText">List of Services Blog</h6>
          </div>

          <div class="card-body p-0">
            <div class="text-right py-3 pr-3">
              <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                  class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
              </button>
              <button type="button" class="btn btn-sm btn-info shadow-sm DestroyServicesArticle"><i
                  class="fad fa-trash mr-2"></i>Delete
              </button>
              <button type="button" class="btn btn-sm btn-info shadow-sm RestoreSA"><i
                  class="fad fa-trash-restore mr-2"></i>Restore
              </button>
            </div>
            <div class="table-responsive overflow-hidden">
              <table id="servicesArticleTable"
                     class="table table-striped table-hover mb-0 table-sm custom-font-size">
                <thead>
                <tr>
                  <th data-orderable="false">
                    <input type="checkbox" name="checkAll" id="checkAllIds">
                  </th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- /.container-fluid -->
  <div id="snackbar" class="shadow rounded"></div>

  <!-- CREATE/EDIT SERVICE MODAL -->
  <div class="modal fade" id="NewEditServicesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="servicesForm" method="post">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="NameModalLabel">Register New Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <span id="form_result"></span>
            <div class="form-group">
              <label for="nameService" class="col-form-label">Name</label>
              <input type="text" name="name" class="form-control form-control-sm" id="nameService">
            </div>

            <div class="form-group">
              <label for="description" class="col-form-label">Description</label>
              <textarea class="form-control form-control-sm" name="description" id="description"
                        rows="3"></textarea>
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control form-control-sm">
                <option value="1">Published</option>
                <option value="0">Draft</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <input id="serviceID" type="hidden" value="">
            <button type="submit" class="btn btn-primary btn-sm" id="btn-service">Save changes</button>
          </div>
        </form>

      </div>
    </div>
  </div>
@stop

@section('_script')
  <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/js/moment.min.js') }}"></script>
  <script>
    $(document).ready(function () {

      $(document).on('change', '.serviceArticle_checkbox', function () {
        selectRow(this)
      });

      function selectRow(elem) {
        if (elem.checked) {
          elem.parentNode.parentNode.className = 'highlight';
        } else {
          elem.parentNode.parentNode.className = 'odd';
        }
      }

      $(document).on('click', '.newService', function () {
        $("#NameModalLabel").text('Register New Service');
        $("#servicesForm")[0].reset();
        $("#serviceID").val('');
        $("#btn-service").text('Save Changes');
        $("#NewEditServicesModal").modal('show');
      });

      /* CREATING AN ARTICLE */
      $('#servicesForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        const x = $("#btn-service");
        const id = $("#serviceID").val();
        $.ajax({
          url: id !== '' ? `service/${id}` : '{{ route('service.store') }}',
          method: id !== '' ? 'PUT' : 'POST',
          data: formData,
          dataType: 'json',
          beforeSend: function () {
            x.attr('disabled', true);
            x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Loading...</span></div>`);
          },
          success: ({errors, success}) => {
            if (success) {
              $("#NewEditServicesModal").modal('hide');
              if (id !== '') {
                snackbar('You successfully updated the service');
              } else {
                snackbar('You successfully added new service');
              }
              $('#servicesArticleTable').DataTable().ajax.reload();
            }

            let html = '';
            if (errors) {
              html = '<div class="alert alert-danger">';
              for (let count = 0; count < errors.length; count++) {
                html += '<p class="mb-0">' + errors[count] + '</p>';
              }
              html += '</div>';
            }
            $("#form_result").html(html);
            x.attr('disabled', false);
            x.html('Save Changes');
          },
          error: err => console.error(err)
        }).fail((err) => {
          console.error(err);
          x.attr('disabled', false);
        })
      });

      $(document).on('click', '.editServices', function () {
        const id = $(this).attr('id');
        $('#form_result').html('');
        $.ajax({
          url: `service/${id}/edit`,
          dataType: "json",
          success: ({service}) => {
            const {id, name, short_description, status} = service;
            $("#nameService").val(name);
            $("#description").val(short_description);
            $("#status").val(status);
            $('#serviceID').val(id);
            $('#NameModalLabel').text('Edit Service');
            $('#btn-service').text('Update');
            $('#NewEditServicesModal').modal('show');
          }
        })
      });

      getServiceArticles();
      const placesUrl = '{{ asset('') }}'
      function getServiceArticles(type = 'all') {
        $('#servicesArticleTable').DataTable({
          destroy: true,
          processing: true,
          serverSide: true,
          scrollY: '70vh',
          scrollCollapse: true,
          ajax: `sa-all/${type}`,
          ordering: false,
          columns: [
            {
              data: 'checkbox',
              name: 'checkbox',
            },
            {
              data: 'avatar',
              name: 'avatar',
              render: (data) => {
                if (data === null) return '<i class="fad fa-images fa-2x" aria-hidden="true"></i>'
                return `<img src="${placesUrl}/${data}" alt="image" width="32" />`
              }
            },
            {
              data: 'name',
              name: 'name',
              render: _ => _.substr(0, 50) + '...'
            },
            {
              data: 'short_description',
              name: 'short_description',
              render: data => data !== null ? data : 'No Description'
            },
            {
              data: 'status',
              name: 'status',
              render: data => `<span class=${data === 1 ? 'text-success' : 'text-danger'}>${data === 1 ? 'Published' : 'Draft'}</span>`
            },
            {
              data: 'created_at',
              name: 'created_at',
              render: data => moment(data).format('L')
            },
            {
              data: 'action',
              name: 'action',
            },
          ],
        });
      }

      $(document).on('click', '.all', function (e) {
        e.preventDefault();
        $(".captionText").text('List of All Services');
        getServiceArticles();
      });

      $(document).on('click', '.viewTrash', function (e) {
        e.preventDefault();
        $(".captionText").text('Trash Data');
        getServiceArticles('trash');
      });

      $(document).on('click', '.drafted', function (e) {
        e.preventDefault();
        $(".captionText").text('List of Unpublished Services');
        getServiceArticles('drafted');
      });

      $(document).on('click', '.published', function (e) {
        e.preventDefault();
        $(".captionText").text('List of published Services');
        getServiceArticles('published');
      });

      $(document).on('click', '.trash', function (e) {
        e.preventDefault();
        let id = [];
        $('.serviceArticle_checkbox:checked').each(function () {
          id.push($(this).val());
        });

        if (id.length > 0) {
          $.ajax({
            url: "{{ route('sa.massremove')}}",
            method: "GET",
            data: {id: id},
            success: data => {
              if (data) {
                snackbar('You successfully remove the service data.');
                $('#servicesArticleTable').DataTable().ajax.reload();
              }
            }
          }).fail(err => console.log(err))
        } else {
          alert('Please select atleast one checkbox')
        }
      });

    });

    $(document).on('click', '.removeServiceArticle', function () {
      const id = $(this).attr('id');
      if (id.length > 0) {
        $.ajax({
          url: 'sa-massremove',
          method: "GET",
          data: {id: id},
          success: _ => {
            snackbar('You successfully removed the data.');
            $('#servicesArticleTable').DataTable().ajax.reload();
          }
        }).fail(err => console.log(err))
      } else {
        snackbar('Please select atleast one checkbox.');
      }
    })

    $(document).on('click', '.restoreServiceSA', function (e) {
      e.preventDefault();
      const id = $(this).attr('id');

      if (id.length > 0) {
        $.ajax({
          url: 'sa-restore',
          method: "GET",
          data: {id: id},
          success: data => {
            if (data) {
              snackbar('You successfully restore it.');
              $('#servicesArticleTable').DataTable().ajax.reload();
            }
          }
        }).fail(err => console.log(err))
      }
    });

    // mass restored
    $(document).on('click', '.RestoreSA', function () {
      let id = [];
      $('.serviceArticle_checkbox:checked').each(function () {
        id.push($(this).val());
      });

      if (id.length > 0) {
        $.ajax({
          url: 'sa-restore',
          method: "GET",
          data: {id: id},
          success: data => {
            if (data) {
              snackbar('You successfully restored the data.');
              $('#servicesArticleTable').DataTable().ajax.reload();
            }
          }
        }).fail(err => console.log(err))
      }
    });

    $(document).on('click', '.killServiceSA', function (e) {
      const id = $(this).attr('id');
      swal({
        title: "Confirmation",
        text: "Are you sure to continue?",
        icon: "warning",
        dangerMode: true,
        buttons: [true, "Continue"],
        closeModal: false
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: `sa-kill/${id}`,
            headers: {
              'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            method: "DELETE",
            data: {id: id},
            success: data => {
              if (data) {
                snackbar('You successfully deleted the data');
                $('#servicesArticleTable').DataTable().ajax.reload();
              }
            }
          }).fail(err => console.log(err))
        }
      });
    });

    // MULTI-DELETE
    $(document).on('click', '.DestroyServicesArticle', function (e) {
      const id = [];
      $('.serviceArticle_checkbox:checked').each(function () {
        id.push($(this).val());
      });
      swal({
        title: "Confirmation",
        text: "Are you sure to continue?",
        icon: "warning",
        dangerMode: true,
        buttons: [true, "Continue"],
        closeModal: false
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: `sa-kill/${id}`,
            headers: {
              'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            method: "DELETE",
            data: {id: id},
            success: _ => {
              snackbar('You successfully deleted the data');
              $('#servicesArticleTable').DataTable().ajax.reload();
            }
          }).fail(err => console.log(err))
        }
      });
    });

    function snackbar(text = '') {
      let x = $("#snackbar");
      x.addClass("show");
      x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
      setTimeout(() => x.removeClass("show"), 3000);
    }

    $('#checkAllIds').on('click', function () {
      if (this.checked === true) {
        $("#servicesArticleTable").find('input[name="serviceArticle_checkbox[]"]').prop('checked', true);
        $('tr.odd, tr.even').addClass('highlight');
      } else {
        $("#servicesArticleTable").find('input[name="serviceArticle_checkbox[]"]').prop('checked', false);
        $('tr.odd, tr.even,tr').removeClass('highlight');
      }
    });

  </script>
@stop
