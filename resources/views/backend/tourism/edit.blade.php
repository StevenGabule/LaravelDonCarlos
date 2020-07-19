@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .alert-success {
            background-color: #1e1e2d;
            border-color: #1e1e2d;
            color: white;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <form id="placeForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Place</h1>

                <div>
                    <a href="{{ route('place.create') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-plus mr-2"></i>New
                    </a>
                    <input type="hidden" name="place_id" value="{{ $place->id }}">

                    <a href="{{ route('place.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="d-none alert alert-success alert-dismissible shadow-lg fade show" role="alert">
                <strong><i class="fad fa-meteor blueish mr-2"></i> Successfully Updated!</strong> The place has been
                modified and ready to see.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Name</label>
                                <input type="text"
                                       class="form-control form-control-sm rounded-0"
                                       value="{{ $place->name }}"
                                       name="name"
                                       id="inputName">
                                <small id="nameMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputShortDescription">Short Description</label>
                                <textarea name="short_description"
                                          id="inputShortDescription" class="form-control form-control-sm"
                                          rows="3">{{ $place->short_description }}</textarea>
                                <small id="shortDescriptionMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <textarea name="address"
                                          id="inputAddress"
                                          class="form-control form-control-sm" rows="4">{{ $place->address }}</textarea>
                                <small id="addressMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control form-control-sm rounded-0">{!! $place->description !!}</textarea>
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
                                @if($place->avatar !== null)
                                    <img src="{{ $place->avatar }}" class="img-fluid" id="previewImage" alt="">
                                @else
                                    <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                    <img src="" class="img-fluid" id="previewImage" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select name="status" id="inputStatus" class="form-control form-control-sm">
                                    <option value="">-- Select the status --</option>
                                    <option value="1" {{ $place->status === 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ $place->status === 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                                <small id="statusMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">
                                    <i class="fad fa-save fa-fw mr-1"></i> Update
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
                placeholder: 'Leave your description here',
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


            /* UPDATING AN ARTICLE */
            const url_string = window.location.href;
            const url = new URL(url_string);
            const _created = url.href.split('/')[6].split('?')[1];

            if (_created === 'created') {
                const x = $(".alert.alert-success");
                setTimeout(() => x.toggleClass('d-none'), 3000);
                x.toggleClass('d-none');
            }

            $('#placeForm').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");

                const _name = $("#inputName");
                const _status = $("#inputStatus");
                const _short_description = $("#inputShortDescription");
                const _address = $("#inputAddress");
                const _description = $("#inputDescription");

                const _nameMsg = $("#nameMessage");
                const _statusMsg = $("#statusMessage");
                const _short_descriptionMsg = $("#shortDescriptionMessage");
                const _addressMsg = $("#addressMessage");
                const _descriptionMsg = $("#descriptionMessage");

                $.ajax({
                    url: '{{ route('place.update.ajax') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $("#inputStatus, #inputName, #inputShortDescription, #inputDescription, #inputAddress")
                            .removeClass(['is-valid', 'is-invalid']);
                        $("#nameMessage, #statusMessage, #shortDescriptionMessage, #descriptionMessage, #addressMessage")
                            .removeClass(['text-success', 'text-danger']);
                        x.attr('disabled', true);
                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> UPDATING...`)
                    },

                    success: ({success}) => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Update`);
                        if (success) {
                            $(".alert.alert-success").toggleClass('d-none');
                        }
                    },

                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Save`);

                        const {name, description, address, short_description, status} = err.responseJSON.errors;

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

                        // address
                        if (address && address[0].length > 0) {
                            _address.addClass('is-invalid');
                            _addressMsg.addClass('text-danger').text(address[0])
                        } else {
                            _address.addClass('is-valid');
                            _addressMsg.addClass('text-success');
                            _addressMsg.text("Looks good.");
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
                    }
                })
            })

        });
        console.clear();
    </script>
@stop
