@extends('backend.layouts.app')



@section('style_extended')
    <style>
        tbody tr td {
            vertical-align: middle !important;
        }

        .dataTables_length label {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
            padding-left: 15px;
        }

        .custom-select.custom-select-sm.form-control.form-control-sm {
            margin-left: 5px;
            margin-right: 5px;
        }

        .dataTables_filter label {
            align-items: center;
            display: inline-flex;
            margin-left: 200px;
        }

        .dataTables_filter label input {
            margin-left: 5px;
        }

        table.dataTable {
            border-collapse: collapse !important;
        }

        tbody tr.odd, tr.even {
            border-bottom: 1px solid #f0f3ff !important;
        }

        .dataTables_processing {
            background: #1B1B2A;
            color: white;
            padding: 20px;
            width: 150px;
            margin: auto;
        }

        .dataTables_paginate.paging_simple_numbers {
            padding-bottom: 4px;
            margin-top: 4px;
        }

        .dataTables_paginate.paging_simple_numbers ul {
            font-size: 11px;
        }

        .page-item.active .page-link {
            background-color: #1e1e2d !important;
            border-color: #1e1e2d !important;
            font-weight: 600;
            border-radius: 3px;
        }

        .page-link {
            color: #36b9cc;
            font-weight: bold;
            transition: all 100ms linear;
            border: none;
        }

        .page-link:hover {
            background-color: #d52a1a;
            color: white;
        }

        .dataTables_paginate.paging_simple_numbers ul li {
            margin-left: 6px;
        }

        .dataTables_info {
            margin-left: 15px;
            font-size: 13px;
        }


    </style>
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">--}}
@stop


@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">News &amp; Blog Management's</h1>
        </div>

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
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
                                    class="fad fa-newspaper mr-2"></i>All Articles</a>
                            <a href="{{ route('article.create') }}" class="list-group-item list-group-item-action"><i
                                    class="fad fa-layer-plus mr-2"></i>Create Article</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action drafted"><i
                                    class="fad fa-file-edit mr-2"></i>Draft Articles</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action published"><i
                                    class="fad fa-globe-asia mr-2"></i>Published Articles</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action viewTrash"><i
                                    class="fad fa-dumpster mr-2"></i>Trash Articles</a>
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
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-restore mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm DestroyArticles"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm RestoredArticles"><i
                                    class="fad fa-trash-restore mr-2"></i>Restore
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm  clonedArticles"><i
                                    class="fad fa-clone mr-2"></i>Clone
                            </button>
                        </div>
                        <div class="table-responsive overflow-hidden">
                            <table id="articlesTables"
                                   class="table table-striped table-hover table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false"><input type="checkbox" name="checkAll" id="checkAllIds"></th>
                                    <th style="width: 50px">Image</th>
                                    <th style="width:40%">Title</th>
                                    <th>Category</th>
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

            getArticle();

            function getArticle(type = 'all') {
                $('#articlesTables').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 15,
                    ajax: `all/${type}`,
                    order: [[0, "desc"]],
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
                            data: 'title',
                            name: 'title',
                            render: _ => _.substr(0, 50) + '...'
                        },
                        {
                            data: 'category.name',
                            name: 'category.name',
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
                $('#articlesTables').DataTable().destroy();
                $(".captionText").text('List of All Articles');
                getArticle();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $('#articlesTables').DataTable().destroy();
                $(".captionText").text('Trash Articles');
                getArticle('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $('#articlesTables').DataTable().destroy();
                $(".captionText").text('List of Unpublished Article');
                getArticle('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
                $('#articlesTables').DataTable().destroy();
                $(".captionText").text('List of published Article');
                getArticle('published');
            });

            $(document).on('click', '.trash', function (e) {
                e.preventDefault();
                let id = [];
                $('.article_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('article.massremove')}}",
                        method: "get",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully remove the checked articles.');
                                $('#articlesTables').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
            });

            // remove single article
            $(document).on('click', '.removeArticle', function () {
                let id = $(this).attr('id');
                if (id.length > 0) {
                    $.ajax({
                        url: `article/${id}`,
                        method: "DELETE",
                        data: {
                            id: id,
                            _token: '{{ csrf_token()}}'
                        },
                        success: _ => {
                            snackbar('You successfully remove the article.');
                            $('#articlesTables').DataTable().ajax.reload();
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
            })
        });

        $(document).on('click', '.restoreArticle', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');

            if (id.length > 0) {
                $.ajax({
                    url: `restore/${id}`,
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restore it.');
                            $('#articlesTables').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.RestoredArticles', function () {

            let id = [];
            $('.article_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: 'restore',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored all the articles.');
                            $('#articlesTables').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.clonedArticles', function () {
            let id = [];
            $('.article_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: 'clone',
                    method: "GET",
                    data: {id: id},
                    success: _ => {
                        snackbar('You successfully clone the articles.');
                        $('#articlesTables').DataTable().ajax.reload();
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.killArticle', function (e) {
            var id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `kill`,
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully deleted the article');
                                $('#articlesTables').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });
        })

        $(document).on('click', '.DestroyArticles', function (e) {
            const id = [];
            $('.article_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            swal({
                title: "Are you sure?",
                text: "All articles are check will be delete permanently",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `kill`,
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully deleted the articles');
                                $('#articlesTables').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });
        })

        function snackbar(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }
        $('#checkAllIds').on('click', function () {
            if (this.checked === true) {
                $("#articlesTables").find('input[name="article_checkbox[]"]').prop('checked', true);
            } else {
                $("#articlesTables").find('input[name="article_checkbox[]"]').prop('checked', false);
            }
        });

    </script>
@stop
