@extends('backend.layouts.app')
@section('style_extended')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/min/dropzone.min.css" integrity="sha256-AgL8yEmNfLtCpH+gYp9xqJwiDITGqcwAbI8tCfnY2lw=" crossorigin="anonymous" />
    <style>
        .card.shadow.mb-4 {
            min-height: 300px;
        }
        .dropzone {
            min-height: 350px !important;
            border: 10px dotted #34bfa3;
        }

        .dropzone .dz-message {
            margin: 8em 0px;
        }

        .dropzone .dz-message .dz-button {
            color: #34bfa3;
        }

    </style>
@stop
@section('content')
    <div class="container-fluid">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('file-upload.store') }}" id="fileUploadForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Upload New File</h1>
                <div>
                    <a href="{{ route('file-upload.index') }}"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fad fa-long-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div id="file"  class="dropzone"></div>
                        </div>
                    </div>
                </div> <!-- drop and drop files -->
            </div>
        </form>
    </div>
@stop

@section('_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/min/dropzone.min.js" integrity="sha256-v7sFPKIh3GHvV9MMFBXcSBLG/BDUC7h1fpfDC5tp1FM=" crossorigin="anonymous"></script>
    <script>
        var drop = new Dropzone('#file', {
            url: "{{ route('file-upload.store') }}",
            acceptedFiles: '.doc,.docx,.dot, .wbk,.docm,.dotx,.dotm,.docb,.xls,.xlt,.xlm,.ppt,.pptx,.pdf, .epub, .pub, .xps',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        });
    </script>
@stop
