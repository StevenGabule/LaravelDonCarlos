@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <form id="activitiesForm" method="post" enctype="multipart/form-data" class="needs-validation">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Event</h1>

                <div>
                    <a href="{{ route('activities.create') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-plus mr-2"></i>Create
                    </a>
                    <a href="{{ route('activities.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                    <input type="hidden" value="{{ $activity->id}}" name="activity_id">
                </div>
            </div>

            <div class="d-none alert alert-success alert-dismissible shadow-lg fade show" role="alert">
                <strong><i class="fad fa-meteor blueish mr-2"></i> Successfully Updated!</strong> The activities has
                been
                modified.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!-- alert -->

            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputTitle">Title</label>
                                <input type="text"
                                       class="form-control form-control-sm rounded-0"
                                       name="title"
                                       id="inputTitle"
                                       value="{{ $activity->title }}">
                                <small id="titleMessage" class="form-text"></small>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="inputStartDate">Event Date</label>
                                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                        <input type="text"
                                               id="inputEventStart"
                                               name="event_start"
                                               class="form-control form-control-sm datetimepicker-input"
                                               data-toggle="datetimepicker"
                                               data-target="#datetimepicker4"/>
                                        <div class="input-group-append" data-target="#datetimepicker4"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text">
                                                <i class="fal fa-calendar-day"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <small id="eventStartMessage" class="form-text"></small>
                                </div>

                                <div class="form-group col-4">
                                    <label for="inputOpeningTime">Opening Time</label>
                                    <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                        <input type="text"
                                               id="inputOpeningTime"
                                               name="opening_time"
                                               value="{{ $activity->opening_time }}"
                                               class="form-control form-control-sm datetimepicker-input"
                                               data-toggle="datetimepicker"
                                               data-target="#datetimepicker3"/>
                                        <div class="input-group-append" data-target="#datetimepicker3"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fal fa-clock"></i></div>
                                        </div>
                                    </div>
                                    <small id="openingTimeMessage" class="form-text"></small>
                                </div>

                                <div class="form-group col-4">
                                    <label for="inputClosingTime">Closing Time</label>
                                    <div class="input-group date" id="datetimepicker5" data-target-input="nearest">
                                        <input type="text"
                                               class="form-control form-control-sm datetimepicker-input"
                                               id="inputClosingTime"
                                               value="{{ $activity->closing_time }}"
                                               name="closing_time"
                                               data-toggle="datetimepicker"
                                               data-target="#datetimepicker5"/>
                                        <div class="input-group-append" data-target="#datetimepicker5"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fal fa-clock"></i></div>
                                        </div>
                                    </div>
                                    <small id="closingTimeMessage" class="form-text"></small>
                                </div>
                            </div><!-- end of form row -->

                            <div class="form-group">
                                <label for="inputShortDescription">Short Description</label>
                                <textarea
                                    name="short_description" rows="2" id="inputShortDescription"
                                    class="form-control form-control-sm">{{ $activity->short_description }}</textarea>
                                <small id="shortDescriptionMessage" class="form-text"></small>

                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <textarea
                                    name="address"
                                    rows="2" id="inputAddress"
                                    class="form-control form-control-sm">{{ $activity->address }}</textarea>
                                <small id="addressMessage" class="form-text"></small>

                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control form-control-sm rounded-0">{{ $activity->description }}</textarea>
                                <small id="descriptionMessage" class="form-text"></small>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card-body">
                            <h6>Featured Image</h6>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="avatar"
                                           aria-describedby="inputGroupFileAddon01"
                                           accept="image/x-png,image/gif,image/jpeg">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>

                            <div class="border h-75 text-center pb-5 pt-5 pl-5 pr-5 mb-3">
                                @if($activity->avatar !== null)
                                    <img src="{{ asset('backend/uploads/activities/large/'.$activity->avatar) }}"
                                         class="img-fluid" id="previewImage" alt="">
                                @else
                                    <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                    <img src="" class="img-fluid" id="previewImage" alt="">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="inputStatus" class="custom-select custom-select-sm">
                                    <option value="">-- Select the status --</option>
                                    <option value="1" {{ (int)$activity->status === 1 ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="0" {{ (int)$activity->status === 0 ? 'selected' : '' }}>Draft
                                    </option>
                                </select>
                                <small id="statusMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">
                                    <i class="fad fa-save fa-fw mr-2"></i>Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('_script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>

        $(document).ready(function () {

            $('#inputDescription').summernote({
                tabSize: 2,
                height: 300
            });

            $('#datetimepicker4').datetimepicker({
                defaultDate: '{{ $activity->event_start }}',
                format: 'L'
            });

            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });

            $('#datetimepicker5').datetimepicker({
                format: 'LT'
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = e => $('#previewImage').attr('src', e.target.result);
                    $(".fa-goner").remove();
                    reader.readAsDataURL(input.files[0])
                }
            }

            $("#inputGroupFile01").change(function () {
                readURL(this);
            });

            /* CREATING AN ARTICLE */
            $('#activitiesForm').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");

                const _title = $("#inputTitle");
                const _event_start = $("#inputEventStart");
                const _opening_time = $("#inputOpeningTime");
                const _closing_time = $("#inputClosingTime");
                const _short_description = $("#inputShortDescription");
                const _description = $("#inputDescription");
                const _address = $("#inputAddress");
                const _status = $("#inputStatus");

                const _titleMsg = $("#titleMessage");
                const _eventStartMsg = $("#eventStartMessage");
                const _openingTimeMsg = $("#openingTimeMessage");
                const _closingTimeMsg = $("#closingTimeMessage");
                const _short_descriptionMsg = $("#shortDescriptionMessage");
                const _descriptionMsg = $("#descriptionMessage")
                const _addressMsg = $("#addressMessage");
                const _statusMsg = $("#statusMessage");

                $.ajax({
                    url: '{{ route('activities.update.ajax') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $("#inputTitle, #inputEventStart, #inputOpeningTime, #inputClosingTime, #inputShortDescription, #inputDescription, #inputAddress, #inputStatus").removeClass(['is-valid', 'is-invalid']);
                        $("#titleMessage, #eventStartMessage, #openingTimeMessage, #closingTimeMessage, " +
                            "#descriptionMessage, #shortDescriptionMessage, #addressMessage, #statusMessage")
                            .removeClass(['text-success', 'text-danger']);
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> UPDATING...`)
                    },
                    success: data => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Update`)
                        $(".alert.alert-success").toggleClass('d-none');
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Update`);
                        const {
                            title,
                            short_description,
                            description,
                            event_start,
                            opening_time,
                            closing_time, status, address
                        } = err.responseJSON.errors;
                        console.log(err.responseJSON.errors);
                        // name
                        if (title && title[0].length > 0) {
                            _title.addClass('is-invalid');
                            _titleMsg.addClass('text-danger').text(title[0]);
                        } else {
                            _title.addClass('is-valid');
                            _titleMsg.addClass('text-success').text("Looks good.");
                        }

                        // status
                        if (status && status[0].length > 0) {
                            _status.addClass('is-invalid');
                            _statusMsg.addClass('text-danger').text(status[0]);
                        } else {
                            _status.addClass('is-valid');
                            _statusMsg.addClass('text-success').text("Looks good.");
                        }

                        // address
                        if (address && address[0].length > 0) {
                            _address.addClass('is-invalid');
                            _addressMsg.addClass('text-danger').text(address[0]);
                        } else {
                            _address.addClass('is-valid');
                            _addressMsg.addClass('text-success').text("Looks good.");
                        }

                        // short description
                        if (short_description && short_description[0].length > 0) {
                            _short_description.addClass('is-invalid');
                            _short_descriptionMsg.addClass('text-danger').text(short_description[0]);
                        } else {
                            _short_description.addClass('is-valid');
                            _short_descriptionMsg.addClass('text-success').text("Looks good.");
                        }

                        // description
                        if (description && description[0].length > 0) {
                            _description.addClass('is-invalid');
                            _descriptionMsg.addClass('text-danger').text(description[0]);
                        } else {
                            _description.addClass('is-valid');
                            _descriptionMsg.addClass('text-success').text("Looks good.");
                        }

                        // event start
                        if (event_start && event_start[0].length > 0) {
                            _event_start.addClass('is-invalid');
                            _eventStartMsg.addClass('text-danger').text(event_start[0]);
                        } else {
                            _event_start.addClass('is-valid');
                            _eventStartMsg.addClass('text-success').text("Looks good.");
                        }

                        // opening time
                        if (opening_time && opening_time[0].length > 0) {
                            _opening_time.addClass('is-invalid');
                            _openingTimeMsg.addClass('text-danger').text(opening_time[0]);
                        } else {
                            _opening_time.addClass('is-valid');
                            _openingTimeMsg.addClass('text-success').text("Looks good.");
                        }

                        // closing time
                        if (closing_time && closing_time[0].length > 0) {
                            _closing_time.addClass('is-invalid');
                            _closingTimeMsg.addClass('text-danger').text(closing_time[0]);
                        } else {
                            _closing_time.addClass('is-valid');
                            _closingTimeMsg.addClass('text-success').text("Looks good.");
                        }
                    }
                }).fail((err) => console.log(err))
            })
        })
        console.clear();
    </script>
@stop
