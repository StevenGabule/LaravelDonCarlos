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

            getArticle();

            function getArticle() {
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
                        },{
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
                buttons: [true, "Continue"],
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
                        },
                        error: err => {
                            console.error(err.responseJSON.errors)
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
                    buttons: [true, "Yes, delete it!"],
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
