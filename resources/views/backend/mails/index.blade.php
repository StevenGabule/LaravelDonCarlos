@extends('backend.layouts.app')
@section('style_extended')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/tokenfield-typeahead.min.css"
          integrity="sha256-wjzCZMOsihqVFmuuKOTcseOy9q46Q7VqMTktUoWDilw=" crossorigin="anonymous"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css"
          integrity="sha256-4qBzeX420hElp9/FzsuqUNqVobcClz1BjnXoxUDSYQ0=" crossorigin="anonymous"/>
@stop
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mails Management's</h1>
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
                               class="list-group-item list-group-item-action list-group-custom all"><i
                                    class="fad fa-newspaper mr-2"></i>All Mails</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action read"><i
                                    class="fad fa-file-edit mr-2"></i>Read</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action unread"><i
                                    class="fad fa-file-edit mr-2"></i>Unread</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action sent"><i
                                    class="fad fa-globe-asia mr-2"></i>Sent</a>
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">Primary Contacts</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm composeMail" data-toggle="modal"
                                    data-target="#sendingEmailToCustomerModal">
                                <i class="fad fa-send-back mr-2"></i>Compose
                            </button>

                            <button type="button" class="btn btn-sm btn-info shadow-sm moveToTrash"><i
                                    class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm destroyMail">
                                <i class="fad fa-trash mr-2"></i> Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm restoreMail"><i
                                    class="fad fa-trash-restore mr-2"></i>Restore
                            </button>
                        </div>
                        <div class="table-responsive overflow-hidden">
                            <table id="mailsTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false">
                                        <input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
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

    <!-- Send Message Modal -->
    <div class="modal fade" id="sendingEmailToCustomerModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <form id="messageForm" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Compose</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputTo" class="col-form-label">Recipient:</label>
                        <input type="text" name="to" class="form-control form-control-sm"
                               id="inputTo">
                        <div id="emailList">
                        </div>
                        <small id="toMessage" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="inputSubject" class="col-form-label">Subject:</label>
                        <input type="text" name="subject" class="form-control form-control-sm" id="inputSubject"
                               value="">
                        <small id="subjectMessage" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="inputMessage" class="col-form-label">Message:</label>
                        <textarea class="form-control form-control-sm" rows="4" name="message"
                                  id="inputMessage"></textarea>
                        <small id="senderMessage" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="inputUpload">Upload a file</label>
                        <input type="file" class="custom-file" name="avatar[]" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-danger" id="btnMail">
                        <i class="fad fa-paper-plane mr-1"></i> Send
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- VIEW MESSAGE MODAL -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1"
         role="dialog"
         aria-labelledby="viewMsgModal" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-content-">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewMsgModal">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div id="outputMessage"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Close</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
    <script>
        $(document).ready(function () {

            $('#inputTo').tokenfield({
                autocomplete: {
                    source: [],
                    delay: 100
                },
            });

            getMails();

            $(document).on('change', '.message_checkbox', function () {
                selectRow(this)
            });

            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }

            $('#checkAllIds').on('click', function () {
                if (this.checked === true) {
                    $("#mailsTable").find('input[name="message_checkbox[]"]').prop('checked', true);
                    $('tr.odd, tr.even').addClass('highlight');
                } else {
                    $("#mailsTable").find('input[name="message_checkbox[]"]').prop('checked', false);
                    $('tr.odd, tr.even,tr').removeClass('highlight');
                }
            });

            function getMails(type = 'all') {
                $('#mailsTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: `messages-all/${type}`,
                    order: [[4, "desc"]],
                    columns: [
                        {
                            data: 'checkbox',
                            name: 'checkbox',
                        },

                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'status',
                            name: 'status',
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

            $('#messageForm').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnMail");
                const _to = $("#inputTo");
                const _toMsg = $("#toMessage");
                const _subject = $("#inputSubject");
                const _subjectMsg = $("#subjectMessage");
                const _message = $("#inputMessage");
                const _messageMsg = $("#senderMessage");

                $.ajax({
                    url: '{{ route('messages.store') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function () {
                        $(".form-text").addClass('d-none');
                        $("#inputTo, #inputMessage, #inputSubject").removeClass(['is-valid', 'is-invalid']);
                        $("#toMessage, #subjectMessage, #senderMessage").removeClass(['text-success', 'text-danger']);
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Please wait...`);
                    },
                    success: data => {
                        $("#sendingEmailToCustomerModal").modal('hide');
                        snackbar('You successfully added new service');
                        $("#messageForm")[0].reset();
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-paper-plane mr-1"></i> Send`);
                        $('#mailsTable').DataTable().ajax.reload();
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-paper-plane mr-1"></i> Send`);
                        $(".form-text").removeClass('d-none');
                        const {to, subject, message} = err.responseJSON.errors;
                        if (to && to[0].length > 0) {
                            _to.addClass('is-invalid');
                            _toMsg.addClass('text-danger').text(to[0]);
                        } else {
                            _to.addClass('is-valid');
                            _toMsg.addClass('text-success').text("Looks good.");
                        }

                        if (subject && subject[0].length > 0) {
                            _subject.addClass('is-invalid');
                            _subjectMsg.addClass('text-danger').text(subject[0]);
                        } else {
                            _subject.addClass('is-valid');
                            _subjectMsg.addClass('text-success').text("Looks good.");
                        }

                        if (message && message[0].length > 0) {
                            _message.addClass('is-invalid');
                            _messageMsg.addClass('text-danger').text(message[0]);
                        } else {
                            _message.addClass('is-valid');
                            _messageMsg.addClass('text-success').text("Looks good.");
                        }
                    }
                })
            });

            $('[data-dismiss="modal"]').on('click', function () {
                $("#messageForm")[0].reset();
                $(".form-text").addClass('d-none');
                $("#inputTo, #inputMessage, #inputSubject").removeClass(['is-valid', 'is-invalid']);
                $("#toMessage, #subjectMessage, #senderMessage").removeClass(['text-success', 'text-danger']);
            })


            $(document).on('click', '.all', function (e) {
                e.preventDefault();
                $(".captionText").text('All Mails');
                getMails();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $(".captionText").text('Trash Mails');
                getMails('trash');
            });


            $(document).on('click', '.read', function (e) {
                e.preventDefault();
                $(".captionText").text('Read Mails');
                getMails('read');
            });


            $(document).on('click', '.unread', function (e) {
                e.preventDefault();
                $(".captionText").text('Unread Mails');
                getMails('unread');
            });

            $(document).on('click', '.sent', function (e) {
                e.preventDefault();
                $(".captionText").text('Sent Email');
                getMails('sent');
            });

            $(document).on('click', '.viewMessage', function (e) {
                e.preventDefault();
                let id = $(this).attr('id');
                if (id.length > 0) {
                    $.ajax({
                        url: `messages/${id}`,
                        method: "GET",
                        data: {id: id},
                        beforeSend: () => {
                            $("#outputMessage").html(`<div class="d-flex justify-content-center">
                              <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                            </div>`);
                        },
                        success: ({messages}) => {
                            const {id, name, subject, message} = messages;
                            $("#outputMessage").html(`
                               <strong>Name</strong><br /> ${name} <br /> <br />
                               <strong>Subject</strong><br /> ${subject} <br /> <br />
                                <strong>Message</strong><br />${message}
                            `);
                            $("#mailsTable").DataTable().ajax.reload();
                        }
                    })
                }
                $("#viewMessageModal").modal('show');
            });

        });

        $(document).on('click', '.restoreMail', function () {

            let id = [];
            $('.message_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('message.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        snackbar('You successfully restored all the mails.');
                        $('#mailsTable').DataTable().ajax.reload();
                        $('#checkAllIds').prop('checked', false);
                    }
                })
            } else {
                snackbar('Select the item you want to clone.');
            }
        });

        $(document).on('click', '.restoreIndMail', function () {
            let id = $(this).attr('id');
            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('message.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        snackbar('You successfully restored the mails.');
                        $('#mailsTable').DataTable().ajax.reload();
                        $('#checkAllIds').prop('checked', false);
                    }
                })
            } else {
                snackbar('Select the item you want to clone.');
            }
        });

        function snackbar(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }

        /*moveToTrash*/
        $(document).on('click', '.moveToTrash', function (e) {
            e.preventDefault();
            let id = [];
            $('.message_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: "{{ route('message.remove')}}",
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        snackbar('You successfully remove the checked data.');
                        $('#mailsTable').DataTable().ajax.reload();
                        $('#checkAllIds').prop('checked', false);
                    }
                }).fail(err => console.log(err))
            } else {
                snackbar('Please select atleast one checkbox');
            }
        });

        $(document).on('click', '.moveTrash', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            if (id.length > 0) {
                $.ajax({
                    url: "{{ route('message.remove')}}",
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        snackbar('You successfully remove the checked data.');
                        $('#mailsTable').DataTable().ajax.reload();
                        $('#checkAllIds').prop('checked', false);
                    }
                }).fail(err => console.log(err))
            } else {
                snackbar('Please select atleast one checkbox');
            }
        });

        $(document).on('click', '.destroyMail', function (e) {
            let id = [];
            $('.message_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0) {
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
                            url: '{{ route('message.kill') }}',
                            method: "GET",
                            data: {id: id},
                            success: data => {
                                if (data) {
                                    snackbar('You successfully deleted the data');
                                    $('#mailsTable').DataTable().ajax.reload();
                                    $('#checkAllIds').prop('checked', false);
                                }
                            }
                        })
                    }
                });
            } else {
                snackbar('Check the item you want to delete.');
            }
        });


        console.clear();
    </script>
@stop
