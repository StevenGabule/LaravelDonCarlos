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
@stop

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Baranggay's Management</h1>
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
                                    class="fad fa-newspaper mr-2"></i>All Baranggays</a>
                            <a href="{{ route('baranggays.create') }}" class="list-group-item list-group-item-action"><i
                                    class="fad fa-layer-plus mr-2"></i>Create</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action drafted"><i
                                    class="fad fa-file-edit mr-2"></i>Draft Baranggays</a>
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action published"><i
                                    class="fad fa-globe-asia mr-2"></i>Published Baranggays</a>
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Baranggays</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-restore mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm DestroyBaranggay"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm RestoredBaranggay"><i
                                    class="fad fa-trash-restore mr-2"></i>Restore
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm  clonedBaranggay"><i
                                    class="fad fa-clone mr-2"></i>Clone
                            </button>
                        </div>
                        <div class="table-responsive overflow-hidden">
                            <table id="baranggayTable"
                                   class="table table-striped table-hover table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false"><input type="checkbox" name="checkAll" id="checkAllIds"></th>
                                    <th style="width: 50px">Image</th>
                                    <th style="width:40%">Name</th>
                                    <th>Population</th>
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

            getBaranggays();

            function getBaranggays(type = 'all') {
                $('#baranggayTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    ajax: `ba/${type}`,
                    // order: [[0, "desc"]],
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
                            render: _ => `<span class="font-weight-bold text-capitalize">${_}</span>`
                        },
                        {
                            data: 'population',
                            name: 'population',
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
                $('#baranggayTable').DataTable().destroy();
                $(".captionText").text('List of All Registered Baranggay');
                getBaranggays();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $('#baranggayTable').DataTable().destroy();
                $(".captionText").text('Trash Data');
                getBaranggays('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $('#baranggayTable').DataTable().destroy();
                $(".captionText").text('List of Unpublished Baranggay');
                getBaranggays('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
                $('#baranggayTable').DataTable().destroy();
                $(".captionText").text('List of published Baranggay');
                getBaranggays('published');
            });

            $(document).on('click', '.trash', function (e) {
                e.preventDefault();
                let id = [];
                $('.baranggay_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('ba.massremove')}}",
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully remove the checked data.');
                                $('#baranggayTable').DataTable().ajax.reload();
                            }
                            console.clear();
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
            });

            // remove single article
            $(document).on('click', '.removeBaranggay', function () {
                let id = $(this).attr('id');
                if (id.length > 0) {
                    swal({
                        title: `Question`,
                        text: "Are you sure to delete this data?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '{{ route('ba.kill') }}',
                                method: "GET",
                                data: {id: id},
                                success: _ => {
                                    snackbar('You successfully remove the data.');
                                    $('#baranggayTable').DataTable().ajax.reload();
                                }
                            }).fail(err => console.log(err))
                        }
                });

                } else {
                    alert('Please select atleast one checkbox')
                }
            })
        });

        $(document).on('click', '.restoreBaranggay', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('ba.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restore it.');
                            $('#baranggayTable').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.RestoredBaranggay', function () {

            let id = [];
            $('.baranggay_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('ba.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored all the data.');
                            $('#baranggayTable').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.clonedBaranggay', function () {
            let id = [];
            $('.baranggay_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('ba.clone') }}',
                    method: "GET",
                    data: {id: id},
                    success: _ => {
                        snackbar('You successfully clone the data.');
                        $('#baranggayTable').DataTable().ajax.reload();
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.killArticle', function (e) {
            const id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "Are you sure to delete this data?",
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
                                snackbar('You successfully deleted the data');
                                $('#baranggayTable').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });
        })

        $(document).on('click', '.DestroyBaranggay', function (e) {
            const id = [];
            $('.baranggay_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            swal({
                title: `Question`,
                text: "Are you to delete this data?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route('ba.kill') }}',
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully deleted the data');
                                $('#baranggayTable').DataTable().ajax.reload();
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
                $("#baranggayTable").find('input[name="baranggay_checkbox[]"]').prop('checked', true);
            } else {
                $("#baranggayTable").find('input[name="baranggay_checkbox[]"]').prop('checked', false);
            }
        });

    </script>
@stop
