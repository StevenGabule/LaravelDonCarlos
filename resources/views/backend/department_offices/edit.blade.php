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

            <div class="row">
                <div class="col-xl-9 col-lg-8">

                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <span id="form_result"></span>
                            <div class="form-group">

                                <label for="inputName">Name</label>
                                <input type="text"
                                       class="form-control form-control-sm rounded-0"
                                       name="name" value="{{ $office->name }}"
                                       id="inputName">

                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <textarea name="address"
                                          id="inputAddress"
                                          class="form-control form-control-sm"
                                          rows="2">{{ $office->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="shortDescription">Short Description</label>
                                <textarea name="short_description"
                                          id="shortDescription"
                                          class="form-control form-control-sm"
                                          rows="2">{{ $office->short_description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control form-control-sm inputDescription rounded-0">{{ $office->description }}</textarea>
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
                                    <img src="{{ asset('backend/uploads/office/'.$office->avatar) }}" class="img-fluid" id="previewImage" alt="">
                                @else
                                    <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                    <img src="" class="img-fluid" id="previewImage" alt="">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="inputCategory">Select the department:</label>
                                <select name="department_category_id" id="inputCategory" class="form-control" required>
                                    <option value="">-- Select one--</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $department->id === $office->department_category_id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- Select the status --</option>
                                    <option value="1" {{ $office->status === 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ $office->status === 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">
                                    Update
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
            $('#officesTable').on('submit', function (e) {
                e.preventDefault();
                const x = $("#btnSave");
                $.ajax({
                    url: '{{ route('department-offices.updated') }}',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: () => {
                        x.attr('disabled', true);
                        x.html(`Updating...`);
                    },
                    success: ({id, success, errors}) => {
                        if (errors && errors.length > 0) {
                            let html = '';
                            html = '<div class="alert alert-danger">';
                            const errorLength = errors.length;
                            for (let count = 0; count < errorLength; count++) {
                                html += '<p class="mb-0">' + errors[count] + '</p>';
                            }
                            html += '</div>';

                            $("#form_result").html(html);
                        }
                        if(success) {
                            alert('updated!');
                        }
                        x.attr('disabled', false);
                        x.html(`  <i class="fad fa-save mr-2"></i> Update`);
                    },
                    error: err => {
                        x.attr('disabled', false);
                        x.html(`<i class="fad fa-save mr-2"></i> Update`);
                    },
                }).fail((err) => console.log(err))
            })
        })
    </script>
@stop
