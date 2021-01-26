@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tourism Management</h1>
        </div>
        {{-- <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold header-text">Earnings Overview</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                 aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold header-text">Revenue Sources</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                 aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                            <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                            <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

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
                                    class="fad fa-newspaper mr-2"></i>All Places</a>
                            <a href="{{ route('place.create') }}" class="list-group-item list-group-item-action"><i
                                    class="fad fa-layer-plus mr-2"></i>New Place</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action drafted"><i
                                    class="fad fa-file-edit mr-2"></i>Draft</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action published"><i
                                    class="fad fa-globe-asia mr-2"></i>Published</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action viewTrash"><i
                                    class="fad fa-dumpster mr-2"></i>Trash</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Places</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm DestroyPlaces"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm RestoredPlaces"><i
                                    class="fad fa-trash-restore mr-2"></i>Restore
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm  clonePlace"><i
                                    class="fad fa-clone mr-2"></i>Clone
                            </button>
                        </div>
                        <div class="table-responsive overflow-hidden">
                            <table id="placesTables"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false"><input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
                                    <th style="width: 50px">Image</th>
                                    <th style="width:40%">Name</th>
                                    <th>Address</th>
                                    <th>Status</th>
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
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('change', '.place_checkbox', function () {
                selectRow(this)
            });
            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }
            getPlaces();
            function getPlaces(type = 'all') {
                $('#placesTables').DataTable({
                    "destroy": true,
                    processing: true,
                    serverSide: true,
                    pageLength: 15,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: `p-all/${type}`,
                    ordering: false,
                    order: [[5, "desc"]],
                    columns: [
                        {
                            data: 'checkbox',
                            name: 'checkbox',
                        },
                        {
                            data: 'avatar',
                            name: 'avatar',
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: _ => _.substr(0, 50) + '...'
                        },
                        {
                            data: 'address',
                            name: 'address',
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: data => `<span class=${data === 1 ? 'text-success' : 'text-danger'}>${data === 1 ? 'Published' : 'Draft'}</span>`
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: data => moment(data).format('L')
                        },
                        {
                            data: 'action',
                            name: 'action',
                        },
                    ],
                });
            }

            $(document).on('click', '.all', function (e) {
                e.preventDefault();
                $(".captionText").text('List of All Places');
                getPlaces();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $(".captionText").text('Trash Data');
                getPlaces('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $(".captionText").text('List of Unpublished Places');
                getPlaces('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
                $(".captionText").text('List of published Places');
                getPlaces('published');
            });

            $(document).on('click', '.trash', function (e) {
                e.preventDefault();
                let id = [];
                $('.place_checkbox:checked').each(function () {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('place.massremove')}}",
                        method: "get",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully remove the checked places.');
                                $('#placesTables').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
            });

            // remove single article
            $(document).on('click', '.removePlace', function () {
                let id = $(this).attr('id');
                if (id.length > 0) {
                    $.ajax({
                        url: `place/${id}`,
                        method: "DELETE",
                        data: {
                            id: id,
                            _token: '{{ csrf_token()}}'
                        },
                        success: _ => {
                            snackbar('You successfully remove the article.');
                            $('#placesTables').DataTable().ajax.reload();
                        }
                    }).fail(err => console.log(err))
                } else {
                        snackbar('Check the data you want to delete.');
                }
            })
        });

        $(document).on('click', '.restorePlace', function (e) {
            e.preventDefault();
            const id = $(this).attr('id');

            if (id.length > 0) {
                $.ajax({
                    url: 'p-restore',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored it.');
                            $('#placesTables').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.RestoredPlaces', function () {

            let id = [];
            $('.place_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: 'p-restore',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored the data.');
                            $('#placesTables').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            } else {
                snackbar('Check the data you want to clone.');
            }
        });

        $(document).on('click', '.clonePlace', function () {
            let id = [];
            $('.place_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: 'p-clone',
                    method: "GET",
                    data: {id: id},
                    success: _ => {
                        snackbar('You successfully clone the articles.');
                        $('#placesTables').DataTable().ajax.reload();
                    }
                }).fail(err => console.log(err))
            } else {
                snackbar('Check the data you want to clone.');
            }
        });

        $(document).on('click', '.killArticle', function (e) {
            const id = $(this).attr('id');
            if (id.length > 0) {
                swal({
                    title: "Confirmation",
                    text: "Are you sure to continue?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, "Continue"],
                    closeModal: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `p-kill/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            },
                            method: "DELETE",
                            data: {id: id},
                            success: data => {
                                if (data) {
                                    snackbar('You successfully deleted the data');
                                    $('#placesTables').DataTable().ajax.reload();
                                }
                            }
                        }).fail(err => console.log(err))
                    }
                });
            } else {
                snackbar('Check the data you want to delete.');
            }
        });

        $(document).on('click', '.DestroyPlaces', function (e) {
            const id = [];
            $('.place_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0) {
                swal({
                    title: "Are you sure?",
                    text: "All places are checked will be delete permanently",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, "Yes, delete it!"],
                    closeModal: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `p-kill/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            },
                            method: "DELETE",
                            data: {id: id},
                            success: _ => {
                                snackbar('You successfully deleted the checked data');
                                $('#placesTables').DataTable().ajax.reload();
                            }
                        }).fail(err => console.log(err))
                    }
                });
            } else {
                snackbar('Check the data you want to delete.');
            }
        });

        function snackbar(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }

        $('#checkAllIds').on('click', function () {
            if (this.checked === true) {
                $("#placesTables").find('input[name="place_checkbox[]"]').prop('checked', true);
                $('tr.odd, tr.even').addClass('highlight');
            } else {
                $("#placesTables").find('input[name="place_checkbox[]"]').prop('checked', false);
                $('tr.odd, tr.even,tr').removeClass('highlight');
            }
        });

    </script>
@stop
