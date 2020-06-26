@extends('backend.layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Department Office Management</h1>
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
                                <i class="fad fa-newspaper mr-2"></i> All List
                            </a>

                            <a href="{{ route('department-offices.create') }}"
                               class="list-group-item list-group-item-action">
                                <i class="fad fa-layer-plus mr-2"></i>New Office
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Table</h6>
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
                            <table id="departmentOfficeTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false">
                                        <input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
                                    <th>Photo</th>
                                    <th>Name</th>
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
@stop

@section('_script')
    <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change', '.office_checkbox', function () {
                selectRow(this)
            });

            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }

            getDepartmentOffices();

            function getDepartmentOffices(type = 'all') {
                $('#departmentOfficeTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '70vh',
                    scrollCollapse: true,
                    ajax: `department-offices-all/${type}`,
                    ordering: false,
                    columns: [
                        {
                            data: 'checkbox',
                            name: 'checkbox',
                        },
                        {
                            data: 'avatar',
                            name: 'avatar',
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: data => `<span class=${data === 1 ? 'text-success' : 'text-danger'}>${data === 1 ? 'Published' : 'Draft'}</span>`
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                });
            }

            $(document).on('click', '.all', function (e) {
                e.preventDefault();
                $(".captionText").text('List of All Services');
                getDepartmentOffices();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $(".captionText").text('Trash Data');
                getDepartmentOffices('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $(".captionText").text('List of Unpublished');
                getDepartmentOffices('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
                $(".captionText").text('List of Published');
                getDepartmentOffices('published');
            });

            $(document).on('click', '.trash', function (e) {
                e.preventDefault();
                let id = [];
                $('.office_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('department-offices.massremove')}}",
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('The data move to trash.');
                                $('#departmentOfficeTable').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
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
                            $('#departmentOfficeTable').DataTable().ajax.reload();
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
                                $('#departmentOfficeTable').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });

            // mass restored
            $(document).on('click', '.RestoreSA', function () {
                let id = [];
                $('.office_checkbox:checked').each(function () {
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
                                $('#departmentOfficeTable').DataTable().ajax.reload();
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
                            url: 'sa-kill',
                            method: "GET",
                            data: {id: id},
                            success: data => {
                                if (data) {
                                    snackbar('You successfully deleted the data');
                                    $('#departmentOfficeTable').DataTable().ajax.reload();
                                }
                            }
                        }).fail(err => console.log(err))
                    }
                });
            });

            // MULTI-DELETE
            $(document).on('click', '.DestroyServicesArticle', function (e) {
                const id = [];
                $('.office_checkbox:checked').each(function () {
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
                            url: '{{ route("sa.kill") }}',
                            method: "GET",
                            data: {id: id},
                            success: _ => {
                                snackbar('You successfully deleted the data');
                                $('#departmentOfficeTable').DataTable().ajax.reload();
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
                    $("#departmentOfficeTable").find('input[name="office_checkbox[]"]').prop('checked', true);
                    $('tr.odd, tr.even').addClass('highlight');
                } else {
                    $("#departmentOfficeTable").find('input[name="office_checkbox[]"]').prop('checked', false);
                    $('tr.odd, tr.even,tr').removeClass('highlight');
                }
            });
        });
    </script>
@stop
