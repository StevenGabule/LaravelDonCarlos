@extends('backend.layouts.app')
@section('style_extended')
    <style>
    </style>
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
                                    class="fad fa-newspaper mr-2"></i>All List</a>
                            <a href="{{ route('article.create') }}" class="list-group-item list-group-item-action"><i
                                    class="fad fa-layer-plus mr-2"></i>Create</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action drafted"><i
                                    class="fad fa-file-edit mr-2"></i>Drafts</a>
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">Primary Contacts</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm composeMail" data-toggle="modal"
                                    data-target="#sendingEmailToCustomerModal">
                                <i class="fad fa-send-back mr-2"></i>Compose
                            </button>

                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm DestroyArticles"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm RestoredArticles"><i
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
                                    <th>Subject</th>
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

    <!-- Modal -->
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
                        <input type="text" name="to" class="form-control form-control-sm" id="inputTo">
                        <small id="toMessage" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="inputSubject" class="col-form-label">Subject:</label>
                        <input type="text" name="subject" class="form-control form-control-sm" id="inputSubject">
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

    <!-- /.container-fluid -->
    <div id="snackbar" class="shadow rounded"></div>
@stop

@section('_script')
    <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {

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
                    pageLength: 15,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: `messages-all/${type}`,
                    order: [[0, "desc"]],
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
                            data: 'subject',
                            name: 'subject',
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
                        x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                    },
                    success: data => {
                        $("#sendingEmailToCustomerModal").modal('hide');
                        snackbar('You successfully added new service');
                        $("#messageForm")[0].reset();
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-paper-plane mr-1"></i> Send`);
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

            $('[data-dismiss="modal"]').on('click', function() {
                $("#messageForm")[0].reset();
            })
        });

        function snackbar(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }

    </script>
@stop
