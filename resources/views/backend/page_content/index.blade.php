@extends('backend.layouts.app')

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Page Content Management's</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
      <div class="col-lg-3 mb-4">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold header-text small">Options</h6>
          </div>
          <div class="card-body p-0">
            <div class="list-group small rounded-0 border-0">

              <a href="javascript:void(0)"
                 class="list-group-item list-group-item-action list-group-custom all"><i
                  class="fad fa-newspaper mr-2"></i>All List</a>

              <a href="{{ route('page-content.create') }}" class="list-group-item list-group-item-action"><i
                  class="fad fa-layer-plus mr-2"></i>Create</a>

            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-9 mb-4">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold header-text small captionText">List of Articles</h6>
          </div>

          <div class="card-body p-0">
            <div class="text-right py-3 pr-3">
            </div>
            <div class="table-responsive overflow-hidden">
              <table id="articlesTables"
                     class="table table-striped table-hover mb-0 table-sm custom-font-size">
                <thead>
                <tr>
                  <th style="width: 50px">Image</th>
                  <th style="width:40%">Title</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- /.container-fluid -->
  <div id="snackbar" class="shadow rounded"></div>
@stop

@section('_script')
  <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $(document).ready(function () {
      const BASE_URL = '{{ asset('storage/uploads/page_content/thumbnail') }}'
      $('#articlesTables').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        scrollY: '60vh',
        scrollCollapse: true,
        ajax: `{{ route('page_content.all') }}`,
        order: [[0, "desc"]],
        columns: [
          {
            data: 'avatar',
            name: 'avatar',
            render: (data) => {
              if (data === null) return '<i class="fad fa-images fa-2x" aria-hidden="true"></i>'
              return `<img src="${BASE_URL}/${data}" alt="image" width="50" />`
            }
          }, {
            data: 'title',
            name: 'title',
          },
          {
            data: 'short_description',
            name: 'short_description',
            render: _ => _.substr(0, 50) + '...'
          },
          {
            data: 'created_at',
            name: 'created_at',
          },
          {
            data: 'action',
            name: 'action',
          },
        ],
      });

    });

  </script>
@stop
