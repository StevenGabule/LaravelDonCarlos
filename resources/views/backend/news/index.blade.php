@extends('backend.layouts.app')

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
                                    class="fad fa-newspaper mr-2"></i>All List</a>
                            <a href="{{ route('article.create') }}" class="list-group-item list-group-item-action"><i
                                    class="fad fa-layer-plus mr-2"></i>Create</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action drafted"><i
                                    class="fad fa-file-edit mr-2"></i>Drafts</a>
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Articles</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
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
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false"><input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
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

            $(document).on('change', '.article_checkbox', function () {
                selectRow(this)
            });

            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }

            $('#checkAllIds').on('click', function () {
                if (this.checked === true) {
                    $("#articlesTables").find('input[name="article_checkbox[]"]').prop('checked', true);
                    $('tr.odd, tr.even').addClass('highlight');
                } else {
                    $("#articlesTables").find('input[name="article_checkbox[]"]').prop('checked', false);
                    $('tr.odd, tr.even,tr').removeClass('highlight');
                }
            });

            function getArticle(type = 'all') {
                $('#articlesTables').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 15,
                    scrollY: '60vh',
                    scrollCollapse: true,
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
                            render: data => `<span class=${parseInt(data) === 1 ? 'text-success' : 'text-danger'}>${parseInt(data) === 1 ? 'Published' : 'Draft'}</span>`
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
                $(".captionText").text('Trash Articles');
                getArticle('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $(".captionText").text('List of Unpublished Article');
                getArticle('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
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
                    url: `restore`,
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored it.');
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
            const id = $(this).attr('id');
            swal({
                title: "Confirmation",
                text: "Are you sure to continue?",
                icon: "warning",
                dangerMode: true,
                buttons: [true,"Continue"],
                closeModal: false
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

            if (id.length > 0) {
                swal({
                    title: "Are you sure?",
                    text: "All articles are check will be delete permanently",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true,"Yes, delete it!"],
                    closeModal: false
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

    </script>
@stop
