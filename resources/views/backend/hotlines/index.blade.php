@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hotlines information and management</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold header-text small captionText">List Table Phone Number</h6>
                            <a href="{{ route('hotlines.create') }}"
                               class="btn btn-sm btn-primary">
                                New Phone Number
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive overflow-hidden">
                            <table id="departmentsTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th>Phone number</th>
                                    <th>Category In</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($hotlines as $hotline)
                                    <tr>
                                        <td>{{ $hotline->phone_number }}</td>
                                        <td>{{ $hotline->hotline_category->name }}</td>
                                        <td>
                                            <a href="{{ route('hotlines.edit', ['hotline' => $hotline->id]) }}">Edit</a>
                                            <a href="javascript:void(0)"
                                               onclick="event.preventDefault();document.getElementById('delete-number-card-{{$hotline->id}}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-number-card-{{$hotline->id}}" action="{{ route('hotlines.destroy', ['hotline' => $hotline->id]) }}"
                                                  method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <p class="text-center pt-3 text-muted">No available number</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold header-text small captionText">List Table Phone Number Category</h6>
                            <a href="{{ route('hotlines_category.create') }}"
                               class="btn btn-sm btn-primary">
                                Phone Number Category
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive overflow-hidden">
                            <table id="departmentsTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($hotlineCategory as $hotlineCat)
                                    <tr>
                                        <td>{{ $hotlineCat->name }}</td>
                                        <td>
                                            <a href="{{ route('hotlines_category.edit', ['hotlines_category' => $hotlineCat->id]) }}">Edit</a>
                                            <a href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('delete-number-{{$hotlineCat->id}}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-number-{{$hotlineCat->id}}" action="{{ route('hotlines_category.destroy', ['hotlines_category' => $hotlineCat->id]) }}"
                                                  method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <p class="text-center pt-3 text-muted">No available number</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
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
    <script>
        $(document).ready(function () {

        });
    </script>
@stop
