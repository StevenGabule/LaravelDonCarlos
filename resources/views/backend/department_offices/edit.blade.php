@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <form id="officesTable" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Department Office</h1>
                <div>
                    <a href="{{ route('department-offices.create') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-plus mr-2"></i>New
                    </a>
                    <input type="hidden" name="office_id" id="office_id" value="{{ $office->id }}">
                    <a href="{{ route('department-offices.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="d-none alert alert-primary alert-dismissible shadow-lg fade show" role="alert">
                <strong><i class="fad fa-meteor blueish mr-2"></i> Successfully Updated!</strong> The baranggay has been
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
                                       name="name" value="{{ $office->name }}"
                                       id="inputName">
                                <small id="nameMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <textarea name="address"
                                          id="inputAddress"
                                          class="form-control form-control-sm"
                                          rows="2">{{ $office->address }}</textarea>
                                <small id="addressMessage" class="form-text"></small>

                            </div>

                            <div class="form-group">
                                <label for="shortDescription">Short Description</label>
                                <textarea name="short_description"
                                          id="shortDescription"
                                          class="form-control form-control-sm"
                                          rows="2">{{ $office->short_description }}</textarea>
                                <small id="shortDescriptionMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control form-control-sm inputDescription rounded-0">{{ $office->description }}</textarea>
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
                                @if($office->avatar !== null)
                                    <img src="{{ asset('backend/uploads/office/large/'.$office->avatar) }}" class="img-fluid" id="previewImage" alt="">
                                @else
                                    <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                    <img src="" class="img-fluid" id="previewImage" alt="">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="inputCategory">Select the department:</label>
                                <select name="department_category_id" id="inputCategory" class="custom-select custom-select-sm">
                                    <option value="">-- Select one--</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $department->id === $office->department_category_id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <small id="categoryMessage" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="inputStatus" class="custom-select custom-select-sm">
                                    <option value="">-- Select the status --</option>
                                    <option value="1" {{ $office->status === 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ $office->status === 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                                <small id="statusMessage" class="form-text"></small>

                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">
                                    <i class="fad fa-save"></i> Update
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

            const url_string = window.location.href;
            const url = new URL(url_string);
            const _created = url.href.split('/')[6].split('?')[1];
            if (_created === 'created') {
                const x = $(".alert.alert-primary");
                setTimeout(() => x.toggleClass('d-none'), 3000);
                x.toggleClass('d-none');
            }

            /* CREATING AN ARTICLE */
            $('#officesTable').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");

                const _name = $("#inputName");
                const _address = $("#inputAddress");
                const _short_description = $("#shortDescription");
                const _description = $("#inputDescription");
                const _department_category_id = $("#inputCategory");
                const _status = $("#inputStatus");

                const _nameMsg = $("#nameMessage");
                const _addressMsg = $("#addressMessage");
                const _short_descriptionMsg = $("#shortDescriptionMessage");
                const _descriptionMsg = $("#descriptionMessage")
                const _statusMsg = $("#statusMessage");
                const _categoryMsg = $("#categoryMessage");
                const allIds = $("#nameMessage, #addressMessage, #statusMessage, #shortDescriptionMessage, #descriptionMessage, #categoryMessage");

                $.ajax({
                    url: '{{ route('department-offices.updated') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $(".alert.alert-primary").addClass('d-none');
                        $("#inputStatus, #inputName, #inputAddress, #shortDescription, #inputDescription, #inputCategory").removeClass(['is-valid', 'is-invalid']);
                        allIds.removeClass(['text-success', 'text-danger']);
                        allIds.addClass('d-none');
                        x.attr('disabled', true);

                        x.html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> SAVING...`)
                    },
                    success: data => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Update`);
                        $(".alert.alert-primary").removeClass('d-none');
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Save`);
                        console.log(err.responseJSON.errors);

                        allIds.removeClass('d-none');
                        const {name, description, short_description, status, department_category_id, address} = err.responseJSON.errors;

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

                        // department_category_id
                        if (department_category_id && department_category_id[0].length > 0) {
                            _department_category_id.addClass('is-invalid');
                            _categoryMsg.addClass('text-danger').text("The department field is required.");
                        } else {
                            _department_category_id.addClass('is-valid');
                            _categoryMsg.addClass('text-success').text("Looks good.");
                        }
                    },

                }).fail((err) => console.log(err))
            })
        })
    </script>
@stop
