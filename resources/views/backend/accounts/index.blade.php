@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Accounts Management</h1>
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
                                <i
                                    class="fad fa-newspaper mr-2"></i>All Users</a>
                            <a href="javascript:void(0)" data-toggle="modal"
                               class="list-group-item list-group-item-action newService">
                                <i class="fad fa-layer-plus mr-2"></i> New Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Accounts</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive overflow-hidden">
                            <table id="usersTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
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

    <!-- CREATE ACCOUNT MODAL -->
    <div class="modal fade" id="NewEditUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="userForm" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="NameModalLabel">Create New Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <div class="form-group">
                            <label for="inputName" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" id="inputName">
                            <small id="nameMessage" class="form-text"></small>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-form-label">Email</label>
                            <input type="text" name="email" class="form-control form-control-sm" id="inputEmail">
                            <small id="emailMessage" class="form-text"></small>
                        </div>


                        <div class="form-group">
                            <label for="inputPassword" class="col-form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm"
                                   id="inputPassword">
                            <small id="passwordMessage" class="form-text"></small>
                        </div>

                        <div class="form-group">
                            <label for="inputPasswordConfirmation" class="col-form-label">Confirm password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm"
                                   id="inputPasswordConfirmation">
                            <small id="passwordConfirmMessage" class="form-text"></small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <input id="userId" type="hidden" value="">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-user">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- EDIT- NAME/EMAIL ACCOUNT MODAL -->
    <div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="userEditForm" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel">Edit Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result_edit"></span>
                        <div class="form-group">
                            <label for="editName" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" id="editName">
                        </div>

                        <div class="form-group">
                            <label for="editEmail" class="col-form-label">Email</label>
                            <input type="text" name="email" class="form-control form-control-sm" id="editEmail">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <input id="userEditId" name="userEditId" type="hidden" value="">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-edit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  CHANGE PASSWORD ACCOUNT MODAL -->
    <div class="modal fade" id="EditUserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="userEditPasswordForm" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result_password"></span>
                        <div class="form-group">
                            <label for="inputNewPassword" class="col-form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm"
                                   id="inputNewPassword">
                        </div>

                        <div class="form-group">
                            <label for="inputPasswordConfirmed" class="col-form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm"
                                   id="inputPasswordConfirmed">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <input id="userEditPasswordId" name="userEditPasswordId" type="hidden" value="">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-edit-password">Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('_script')
    <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click', '.newService', function () {
                $("#NameModalLabel").text('Create New Account');
                $("#userForm")[0].reset();
                $("#userId").val('');
                $("#btn-user").text('Create');
                $("#form_result").html('');
                $("#NewEditUserModal").modal('show');
            });

            $(document).on('click', '.btnEdit', function () {
                const id = $(this).attr('id');
                $('#form_result_edit').html('');
                $.ajax({
                    url: '{{ route('account.edit') }}',
                    data: {id: id},
                    dataType: "json",
                    success: ({user}) => {
                        const {id, name, email} = user;
                        $("#editName").val(name);
                        $("#editEmail").val(email);
                        $('#userEditId').val(id);
                        $('#EditModalLabel').text('Edit Account');
                        $('#btn-edit').text('Update');
                        $('#EditUserModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.btnChangePassword', function () {
                const id = $(this).attr('id');
                $('#form_result_password').html('');
                $('#userEditPasswordId').val(id);
                $("#userEditPasswordForm")[0].reset();
                $("#EditUserPasswordModal").modal('show');
            });

            $("#userEditForm").on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();
                const x = $("#btn-edit");

                $.ajax({
                    url: '{{ route('account.update') }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        x.attr('disabled', true);
                        x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                    },
                    success: ({success, errors}) => {
                        if (success === true) {
                            $("#EditUserModal").modal('hide');
                            snackbar('You successfully updated the account');
                            $('#usersTable').DataTable().ajax.reload();
                        }

                        let html = '';
                        if (errors.length > 0) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < errors.length; count++) {
                                html += '<p class="mb-0">' + errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        $("#form_result_edit").html(html);
                        x.attr('disabled', false);
                        x.html('Save Changes');
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html('Create');
                    }
                })
            })

            $("#userEditPasswordForm").on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();
                const x = $("#btn-edit-password");

                $.ajax({
                    url: '{{ route('account.update.password') }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> SAVING...`);
                    },
                    success: ({success, errors}) => {
                        if (success === true) {
                            $("#EditUserPasswordModal").modal('hide');
                            snackbar('You successfully updated the account');
                            $('#usersTable').DataTable().ajax.reload();
                        }

                        let html = '';
                        if (errors.length > 0) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < errors.length; count++) {
                                html += '<p class="mb-0">' + errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        $("#form_result_password").html(html);
                        x.attr('disabled', false);
                        x.html('Save Changes');
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html('Create');
                    }
                })
            })

            $('#userForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();
                const x = $("#btn-user");

                $.ajax({
                    url: '{{ route('account.store') }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        x.attr('disabled', true);
                        x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                    },
                    success: ({success, errors}) => {
                        if (success === true) {
                            $("#NewEditUserModal").modal('hide');
                            snackbar('You successfully added new user');
                            $('#usersTable').DataTable().ajax.reload();
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
                    error: err => {
                        x.attr('disabled', false);
                        x.html('Create');
                    }
                })

            });

            getUsers();

            /*Name, Email, Date, Actions,*/
            function getUsers() {
                $('#usersTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: '{{ route('accounts.all') }}',
                    order: [[2, "desc"]],
                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },

                        {
                            data: 'created_at',
                            name: 'created_at',
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
                            url: `account-destroy/${id}`,
                            method: "GET",
                            data: {id: id},
                            success: _ => {
                                snackbar('You successfully deleted the user');
                                $('#usersTable').DataTable().ajax.reload();
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
