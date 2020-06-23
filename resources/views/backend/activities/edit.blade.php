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
                <strong><i class="fad fa-meteor blueish mr-2"></i> Successfully Updated!</strong> The activities has been
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
                                       value="{{ $activity->title }}"
                                       required
                                       data-parsley-length="[6, 50]"
                                       data-parsley-trigger="keyup">

                            </div>

                            <div class="form-group">
                                <label for="inputShortDescription">Short Description</label>
                                <textarea
                                    name="short_description" rows="2" id="inputShortDescription"
                                    class="form-control form-control-sm" required
                                    data-parsley-length="[6, 255]"
                                    data-parsley-trigger="keyup">{{ $activity->short_description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <textarea
                                    name="address"
                                    rows="2" id="inputAddress" class="form-control form-control-sm"
                                    required
                                    data-parsley-length="[6, 255]"
                                    data-parsley-trigger="keyup">{{ $activity->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" id="inputDescription"
                                          class="form-control inputDescription rounded-0" required
                                          data-parsley-trigger="keyup">{{ $activity->description }}</textarea>
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
                                    <img src="{{ asset('backend/uploads/activities/'.$activity->avatar) }}" class="img-fluid" id="previewImage" alt="">
                                @else
                                    <i class="fad fa-images fa-goner" style="font-size: 100px;"></i>
                                    <img src="" class="img-fluid" id="previewImage" alt="">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">-- Select the status --</option>
                                    <option value="1" {{ (int)$activity->status === 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ (int)$activity->status === 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="dateStart">Started Date</label>
                                <input type="datetime-local"
                                       id="dateStart"
                                       value="{{ $activity->date_start }}"
                                       class="form-control form-control-sm" name="date_start" required>
                            </div>

                            <div class="form-group">
                                <label for="dateEnd">End Date </label>
                                <input type="datetime-local"
                                       value="{{ $activity->date_end }}"
                                       id="dateEnd" class="form-control form-control-sm" name="date_end" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <script>
        $('#activitiesForm').parsley();

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
            $('#activitiesForm').on('submit', function (e) {
                e.preventDefault();
                if ($('#activitiesForm').parsley().isValid()) {
                    $.ajax({
                        url: '{{ route('activities.update.ajax') }}',
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: ({success, error}) => {
                            if (success) {
                                $(".alert.alert-success").toggleClass('d-none');
                            }
                            if (error.length > 0) {
                                alert(error)
                            }
                        }
                    }).fail((err) => console.log(err))
                }
            })
        })
        console.clear();
    </script>
@stop
