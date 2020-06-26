@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Departments Management</h1>
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
                               class="list-group-item list-group-item-action newDepartment">
                                <i class="fad fa-layer-plus mr-2"></i> New Department
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
                        <br>
                        <div class="table-responsive overflow-hidden">
                            <table id="departmentsTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th style="width: 20%">Name</th>
                                    <th style="width: 50%">Description</th>
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
    <div class="modal fade" id="NewEditDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="departmentForm" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="NameModalLabel">Register New Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <div class="form-group">
                            <label for="inputName" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" id="inputName">
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control form-control-sm" name="description" id="description"
                                      rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <input id="departmentID" type="hidden" value="">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-department">Save changes</button>
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

            $(document).on('click', '.newDepartment', function () {
                $("#NameModalLabel").text('Register New Department');
                $("#departmentForm")[0].reset();
                $("#departmentID").val('');
                $("#btn-department").text('Save Changes');
                $("#NewEditDepartmentModal").modal('show');
            });

            $('#departmentForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();
                const x = $("#btn-department");
                const id = $("#departmentID").val();
                $.ajax({
                    url: id !== '' ? `departments/${id}` : '{{ route('departments.store') }}',
                    method: id !== '' ? 'PUT' : 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        x.attr('disabled', true);
                        x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                    },
                    success: ({errors, success}) => {
                        if (success) {
                            $("#NewEditDepartmentModal").modal('hide');
                            if (id !== '') {
                                snackbar('You successfully updated the service');
                            } else {
                                snackbar('You successfully added new service');
                            }
                            $('#departmentsTable').DataTable().ajax.reload();
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

            $(document).on('click', '.btnEdit', function () {
                const id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url: `departments/${id}/edit`,
                    dataType: "json",
                    success: ({department}) => {
                        const {id, name, description} = department;
                        $("#inputName").val(name);
                        $("#description").val(description);
                        $('#departmentID').val(id);
                        $('#NameModalLabel').text('Edit Department');
                        $('#btn-department').text('Update');
                        $('#NewEditDepartmentModal').modal('show');
                    }
                })
            });

            getDepartments();

            function getDepartments() {
                $('#departmentsTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: '{{ route("departments.all") }}',
                    /*order: [[4, "desc"]],*/
                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'description',
                            name: 'description',
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                        },
                    ],
                });
            }

            $(document).on('click', '.btnDelete', function (e) {
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
                            url: 'departments-kill',
                            method: "GET",
                            data: {id: id},
                            success: data => {
                                if (data) {
                                    snackbar('You successfully deleted the data');
                                    $('#departmentsTable').DataTable().ajax.reload();
                                }
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
