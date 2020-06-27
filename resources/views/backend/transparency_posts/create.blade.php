@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <form id="postsForm" method="post">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">New Transparency Post</h1>
                <div>
                    <a href="{{ route('transparency-posts.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputCategory">Select Transparency Category:</label>
                                <select name="transparency_id" id="inputCategory" class="custom-select">
                                    <option value="">-- Select Type--</option>
                                    @foreach($transparencies as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <small id="categoryMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputTitle">Title</label>
                                <input type="text"
                                       class="form-control form-control-sm rounded-0"
                                       name="title"
                                       id="inputTitle">
                                <small id="titleMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputShortDescription">Short Description</label>
                                <textarea name="short_description"
                                          id="inputShortDescription" class="form-control form-control-sm"
                                          rows="2"></textarea>
                                <small id="shortDescriptionMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control form-control-sm rounded-0"></textarea>
                                <small id="descriptionMessage" class="form-text"></small>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4">
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="inputStatus" class="custom-select">
                                    <option value="">-- Select the status --</option>
                                    <option value="1">Published</option>
                                    <option value="0">Draft</option>
                                </select>
                                <small id="statusMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">
                                    <i class="fad fa-save mr-2"></i> Save
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

    <script>

        $(document).ready(function () {

            $('#inputDescription').summernote({
                tabSize: 2,
                height: 300
            });

            $('#postsForm').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");
                const _title = $("#inputTitle");
                const _category = $("#inputCategory");
                const _status = $("#inputStatus");
                const _short_description = $("#inputShortDescription");
                const _description = $("#inputDescription");

                const _titleMsg = $("#titleMessage");
                const _categoryMsg = $("#categoryMessage");
                const _statusMsg = $("#statusMessage");
                const _short_descriptionMsg = $("#shortDescriptionMessage");
                const _descriptionMsg = $("#descriptionMessage")

                $.ajax({
                    url: '{{ route('transparency-posts.store') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $("#inputStatus, #inputTitle, #inputShortDescription, #inputDescription, #inputCategory")
                            .removeClass(['is-valid', 'is-invalid']);
                        $("#titleMessage, #statusMessage, #shortDescriptionMessage, #descriptionMessage, #categoryMessage")
                            .removeClass(['text-success', 'text-danger']);
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> SAVING...`)
                    },
                    success: ({id}) => {
                        window.location.href = `${id}/edit?created`
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Saving`);
                        const {title, description, short_description, status, transparency_id} = err.responseJSON.errors;

                        // title
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

                        // transparency_id
                        if (transparency_id && transparency_id[0].length > 0) {
                            _category.addClass('is-invalid');
                            _categoryMsg.addClass('text-danger').text(transparency_id[0]);
                        } else {
                            _category.addClass('is-valid');
                            _categoryMsg.addClass('text-success').text("Looks good.");
                        }
                    }
                }).fail((err) => console.log(err))
            })
        });
        console.clear()
    </script>
@stop
