@extends('backend.layouts.app')
@section('style_extended')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <form id="articleForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Create New Article</h1>

                <div>
                    <button type="submit"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm submittingAsPublished">
                        Published
                    </button>
                    <a href="{{ route('article.create') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm submittingAsDraft">
                        Save as Draft
                    </a>
                    <a href="{{ route('article.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        Cancel
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputTitle">Title:</label>
                                <input type="text" class="form-control form-control-sm rounded-0" name="title" id="inputTitle">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Description:</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control rounded-0"></textarea>
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
                                           aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>

                            <div class="border h-75 text-center pb-5 pt-5 pl-5 pr-5 mb-3">
                                <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                <img src="" class="img-fluid" id="previewImage" alt="">
                            </div>

                            <div class="form-group">
                                <label for="inputCategory">Select Category:</label>
                                <select name="category_id" id="inputCategory" class="form-control">
                                    <option value="">-- Select Category--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
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

            /* CREATING AN ARTICLE */
            $('#articleForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('article.store') }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: data => {
                        console.log(data);
                    },
                    error: err => console.error(err),
                })
            })

        });
    </script>
@stop
