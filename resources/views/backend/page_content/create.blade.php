@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <form id="pageContentForm" method="post" enctype="multipart/form-data" class="needs-validation">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Page Content Article</h1>

                <div>
                    <a href="{{ route('page-content.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <span id="form_result"></span>
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
                                <textarea name="short_description" id="inputShortDescription" rows="3"
                                          class="form-control form-control-sm"></textarea>
                                <small id="shortDescriptionMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control inputDescription rounded-0"></textarea>
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
                            <div class="input-group is-invalid mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input"
                                           id="inputGroupFile01" name="avatar"
                                           aria-describedby="inputGroupFileAddon01"
                                           accept="image/x-png,image/gif,image/jpeg">
{{--                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file...</label>
                                </div>
                                <div id="avatarMessage" class="invalid-feedback">
                                    adaadaasdsad
                                </div>
                            </div>

                            <div class="border h-75 text-center pb-5 pt-5 pl-5 pr-5 mb-3">
                                <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                <img src="" class="img-fluid" id="previewImage" alt="">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">
                                    <i class="fad fa-save fa-fw mr-1"></i> Save
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

            $('#pageContentForm').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");

                const _title = $("#inputTitle");
                const _msgTitle = $("#titleMessage");

                const _shortDescription = $("#inputShortDescription");
                const _msgShortDescription = $("#shortDescriptionMessage");

                const _description = $("#inputDescription");
                const _msgDescription = $("#descriptionMessage");

                const _msgAvatar = $("#avatarMessage");

                $.ajax({
                    url: '{{ route('page-content.store') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $("#inputTitle, #inputShortDescription, #inputDescription")
                            .removeClass(['is-valid', 'is-invalid']);
                        $("#titleMessage, #shortDescriptionMessage, #descriptionMessage, #avatarMessage")
                            .removeClass(['text-success', 'text-danger']);
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Please wait...`)
                    },

                    success: ({id}) => {
                        window.location.href = `${id}/edit?created`
                    },

                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Save`);
                        const { description, short_description, title, avatar} = err.responseJSON.errors;

                        // title
                        if (title && title[0].length > 0) {
                            _title.addClass('is-invalid');
                            _msgTitle.addClass('text-danger')
                            _msgTitle.text(title[0]);
                        } else {
                            _title.addClass('is-valid');
                            _msgTitle.addClass('text-success');
                            _msgTitle.text("Looks good.");
                        }

                        // short description
                        if (short_description && short_description[0].length > 0) {
                            _shortDescription.addClass('is-invalid');
                            _msgShortDescription.addClass('text-danger')
                            _msgShortDescription.text(short_description[0]);
                        } else {
                            _shortDescription.addClass('is-valid');
                            _msgShortDescription.addClass('text-success');
                            _msgShortDescription.text("Looks good.");
                        }

                        // description
                        if (description && description[0].length > 0) {
                            _description.addClass('is-invalid');
                            _msgDescription.addClass('text-danger')
                            _msgDescription.text("Please fill up the description field");
                        } else {
                            _description.addClass('is-valid');
                            _msgDescription.addClass('text-success');
                            _msgDescription.text("Looks good.");
                        }

                        // avatar
                        if (avatar && avatar[0].length > 0) {
                            _description.addClass('is-invalid');
                            _msgAvatar.addClass('text-danger')
                            _msgAvatar.text(`${avatar[0]}`);
                        } else {
                            _description.addClass('is-valid');
                            _msgAvatar.addClass('text-success');
                            _msgAvatar.text("Looks good.");
                        }
                    }
                })
            })
        })
        console.clear();
    </script>
@stop
