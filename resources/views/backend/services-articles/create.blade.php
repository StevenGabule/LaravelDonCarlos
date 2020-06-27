@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <form id="serviceArticlesForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">New Service Article</h1>
                <div>
                    <a href="{{ route('service-article.index') }}"
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

                                <label for="inputName">Name</label>

                                <input type="text"
                                       class="form-control form-control-sm rounded-0"
                                       name="name"
                                       id="inputName"
                                >
                                <small id="nameMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="shortDescription">Short Description</label>
                                <textarea name="short_description"
                                          id="shortDescription"
                                          class="form-control form-control-sm"
                                          rows="3"></textarea>
                                <small id="shortDescriptionMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control form-control-sm inputDescription rounded-0"></textarea>
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
                                <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                <img src="" class="img-fluid" id="previewImage" alt="">
                            </div>

                            <div class="form-group">
                                <label for="inputCategory">Select Service Category:</label>
                                <select name="service_id" id="inputCategory" class="custom-select">
                                    <option value="">-- Select Type--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <small id="categoryMessage" class="form-text"></small>
                            </div>

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
            $('#serviceArticlesForm').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");

                const _name = $("#inputName");
                const _category = $("#inputCategory");
                const _status = $("#inputStatus");
                const _short_description = $("#inputShortDescription");
                const _description = $("#inputDescription");

                const _nameMsg = $("#nameMessage");
                const _categoryMsg = $("#categoryMessage");
                const _statusMsg = $("#statusMessage");
                const _short_descriptionMsg = $("#shortDescriptionMessage");
                const _descriptionMsg = $("#descriptionMessage");

                $.ajax({
                    url: '{{ route('service-article.store') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $("#inputStatus, #inputName, #inputShortDescription, #inputDescription, #inputCategory")
                            .removeClass(['is-valid', 'is-invalid']);
                        $("#nameMessage, #statusMessage, #shortDescriptionMessage, #descriptionMessage, #categoryMessage")
                            .removeClass(['text-success', 'text-danger']);
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> SAVING...`)
                    },
                    success: ({id, success}) => {
                        if (success) {
                            window.location.href = `${id}/edit?created`
                        }
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Save`);
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Save`);
                        const {name, description, short_description, status, service_id} = err.responseJSON.errors;

                        // name
                        if (name && name[0].length > 0) {
                            _name.addClass('is-invalid');
                            _nameMsg.addClass('text-danger').text(name[0]);
                        } else {
                            _name.addClass('is-valid');
                            _nameMsg.addClass('text-success').text("Looks good.");
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

                        // category
                        if (service_id && service_id[0].length > 0) {
                            _category.addClass('is-invalid');
                            _categoryMsg.addClass('text-danger').text(service_id[0]);
                        } else {
                            _category.addClass('is-valid');
                            _categoryMsg.addClass('text-success').text("Looks good.");
                        }
                    }
                }).fail((err) => console.log(err))
            })
        })
    </script>
@stop
