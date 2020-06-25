@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transparency Category Management</h1>
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
                                <i class="fad fa-newspaper mr-2"></i>All List</a>
                            <a href="javascript:void(0)" data-toggle="modal"
                               class="list-group-item list-group-item-action registerTransparency">
                                <i class="fad fa-layer-plus mr-2"></i> Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold header-text small captionText">List Table</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive overflow-hidden">
                            <table id="transparencyTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
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
    <div class="modal fade" id="NewEditTransparencyModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="transparencyForm" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="NameModalLabel">Register</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <div class="form-group">
                            <label for="inputTitle" class="col-form-label">Title</label>
                            <input type="text" name="title" class="form-control form-control-sm" id="inputTitle">
                        </div>

                        <div class="form-group">
                            <label for="inputDescription" class="col-form-label">Description</label>
                            <textarea class="form-control form-control-sm" name="short_description"
                                      id="inputDescription"
                                      rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <input id="transparencyID" type="hidden" value="">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-transparency">Save changes</button>
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
            const x = $("#btn-transparency");
            $(document).on('click', '.registerTransparency', function () {
                $("#NameModalLabel").text('Register New Service');
                $("#transparencyForm")[0].reset();
                $("#transparencyID").val('');
                x.attr('disabled', false);
                x.text('Save Changes');
                $("#NewEditTransparencyModal").modal('show');
            });

            /* CREATING AN ARTICLE */
            $('#transparencyForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                const id = $("#transparencyID").val();
                $.ajax({
                    url: id !== '' ? `transparency/${id}` : '{{ route('transparency.store') }}',
                    method: id !== '' ? 'PUT' : 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        x.attr('disabled', true);
                        x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                    },
                    success: ({errors, success}) => {
                        if (success) {
                            $("#NewEditTransparencyModal").modal('hide');
                            if (id !== '') {
                                snackbar('You successfully updated the service');
                            } else {
                                snackbar('You successfully added new service');
                            }
                            $('#transparencyTable').DataTable().ajax.reload();
                        }

                        let html = '';
                        if (errors.length > 0) {
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

            $(document).on('click', '.editTransparency', function (e) {
                e.preventDefault();
                const id = $(this).attr('id');

                $('#form_result').html('');
                $.ajax({
                    url: `transparency/${id}/edit`,
                    dataType: "json",
                    success: ({transparency}) => {
                        const {id, title, short_description} = transparency;
                        $("#inputTitle").val(title);
                        $("#inputDescription").val(short_description);
                        $('#transparencyID').val(id);
                        $('#NameModalLabel').text('Edit Transpancy');
                        $('#btn-transparency').text('Update');
                        x.attr('disabled', false);
                        $('#NewEditTransparencyModal').modal('show');
                    }
                });
            });

            getTransparency();

            function getTransparency() {
                $('#transparencyTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 15,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: `transparency-all`,
                    columns: [
                        {
                            data: 'title',
                            name: 'title',
                            render: _ => _.substr(0, 50) + '...'
                        },
                        {
                            data: 'short_description',
                            name: 'short_description',
                            render: data => data !== null ? data : 'No Description'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: data => moment(data).format('L')
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                        },
                    ],
                });
            }

            $(document).on('click', '.btnDelete', function (e) {
                const id = $(this).attr('id');

                swal({
                    title: "Confirmation",
                    text: "Deleting this data will also delete the associate content as well. Are you sure to continue?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, "Continue"],
                    closeModal: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `transparency/${id}/delete`,
                            method: "GET",
                            data: {id: id},
                            success: _ => {
                                snackbar('You successfully deleted the data');
                                $('#transparencyTable').DataTable().ajax.reload();
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

        });



    </script>
@stop
