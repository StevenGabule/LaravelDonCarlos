@extends('backend.layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        @include('backend.shared._status')

        @include('backend.shared._analytics')


        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Most Recent News</h6>
                        <a href="{{ route('article.create') }}"
                           class="btn btn-danger btn-sm font-weight-bold text-small">Create</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm small">
                            <thead>
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Views</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($news as $new)
                                <tr>
                                    <td class="pl-4">{{ substr($new->title, 0, 30) . '...' }}</td>
                                    <td>4,000</td>
                                </tr>
                            @empty
                                <tr style="height: 220px">
                                    <td colspan="3">
                                        <p class="text-center font-weight-bold">Oops.. Data found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Most Added Tourist Spot</h6>
                        <a href="{{ route('place.create') }}" class="btn btn-danger btn-sm font-weight-bold text-small">Create</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm small">
                            <thead>
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Views</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($places as $place)
                                <tr>
                                    <td class="pl-4">{{ substr($place->name,0,40 ) . '...' }}</td>
                                    <td>4,000</td>
                                </tr>
                            @empty
                                <tr style="height: 220px">
                                    <td colspan="3">
                                        <p class="text-center font-weight-bold">Oops.. Data found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Most Transparent Post</h6>
                        <a href="{{ route('transparency-posts.create') }}"
                           class="btn btn-danger btn-sm font-weight-bold text-small">Create</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm small">
                            <thead>
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Views</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($tranPosts as $tranPost)
                                <tr>
                                    <td class="pl-4">{{ substr($tranPost->title, 0, 40) . '...' }}</td>
                                    <td>4,000</td>
                                </tr>
                            @empty
                                <tr style="height: 220px">
                                    <td colspan="3">
                                        <p class="text-center font-weight-bold">Oops.. Data found</p>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- end of row -->

        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Most Service Article</h6>
                        <a href="{{ route('service-article.create') }}"
                           class="btn btn-danger btn-sm font-weight-bold text-small">Create</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm small">
                            <thead>
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Views</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($servicePosts as $servicePost)
                                <tr>
                                    <td class="pl-4">{{ substr($servicePost->name, 0,40) . '...' }}</td>
                                    <td>4,000</td>
                                </tr>
                            @empty
                                <tr style="height: 220px">
                                    <td colspan="3">
                                        <p class="text-center font-weight-bold">Oops.. Data found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Most Recent Upload</h6>
                        <a href="{{ route('file-upload.create') }}" class="btn btn-danger btn-sm font-weight-bold text-small">Create</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm small">
                            <thead>
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Type</th>
                                <th>Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transparentFiles as $transparentFile)
                            <tr>
                                <td class="pl-4">{{ substr($transparentFile->name, 0, 40) . '...' }}</td>
                                <td>{{ ($transparentFile->type) }}</td>
                                <td>4,000</td>
                            </tr>
                            @empty
                                <tr style="height: 220px">
                                    <td colspan="3">
                                        <p class="text-center font-weight-bold">Oops.. Data found</p>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Activities and Upcoming</h6>
                        <a href="{{ route('activities.create') }}"
                           class="btn btn-danger btn-sm font-weight-bold text-small">Create</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm small">
                            <thead>
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Views</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td class="pl-4">{{ substr($activity->title, 0, 20) . '...' }}</td>
                                    <td>4,000</td>
                                    <td>{{ $activity->convert_date() }}</td>
                                </tr>

                            @empty
                                <tr style="height: 220px">
                                    <td colspan="3">
                                        <p class="text-center font-weight-bold">Oops.. Data found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->

@stop

@section('_script')
    <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('backend/js/dashboard/index.js') }}"></script>
    <script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script>
@endsection
