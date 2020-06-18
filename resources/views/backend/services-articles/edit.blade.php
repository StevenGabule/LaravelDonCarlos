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
        <form id="serviceArticleForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h1 class="h3 mb-0 text-gray-800">Edit Service Article</h1>

                <div>

                    <a href="{{ route('service-article.create') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-plus mr-2"></i>New
                    </a>

                    <input type="hidden" name="service_article_id" value="{{ $sa->id }}">

                    <a href="{{ route('service-article.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="d-none alert alert-success alert-dismissible shadow-lg fade show" role="alert">
                <strong><i class="fad fa-meteor blueish mr-2"></i> Successfully Updated!</strong> The service article has been
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
                                       value="{{ $sa->name }}"
                                       name="name"
                                       id="inputName"
                                       required
                                       data-parsley-pattern="[a-zA-Z 0987654321-]+$"
                                       data-parsley-length="[6, 50]"
                                       data-parsley-trigger="keyup">
                            </div>

                            <div class="form-group">
                                <label for="shortDescription">Label Description</label>
                                <textarea name="short_description"
                                          id="shortDescription"
                                          class="form-control form-control-sm"
                                          rows="2"
                                          required
                                          data-parsley-trigger="keyup"
                                          data-parsley-length="[6, 50]">{{ $sa->short_description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description"
                                          id="inputDescription"
                                          class="form-control rounded-0" required
                                          data-parsley-trigger="keyup">{!! $sa->description !!}</textarea>
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
                                @if($sa->avatar !== null)
                                    <img src="{{ asset("backend/uploads/service-article") }}/{{ $sa->avatar }}" class="img-fluid" id="previewImage" alt="">
                                @else
                                    <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                    <img src="" class="img-fluid" id="previewImage" alt="">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="inputCategory">Select Service Category:</label>
                                <select name="service_id" id="inputCategory" class="form-control" required>
                                    <option value="">-- Select Type--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $sa->services_id === $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">-- Select the status --</option>
                                    <option value="1" {{ $sa->status === 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ $sa->status === 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#serviceArticleForm').parsley();

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

            $('#serviceArticleForm').on('submit', function (e) {
                e.preventDefault();
                if ($('#serviceArticleForm').parsley().isValid()) {
                    $.ajax({
                        url: '{{ route('sa.update.ajax') }}',
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                            setTimeout(() => $(".alert.alert-success").toggleClass('d-none'), 5000)
                        },
                        success: ({success}) => {
                            if (success) {
                                $(".alert.alert-success").toggleClass('d-none');
                            }
                        },
                        error: err => console.error(err),
                    })
                }
            })
        });
    </script>
@stop
