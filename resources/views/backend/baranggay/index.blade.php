@extends('backend.layouts.app')

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
                                    class="fad fa-newspaper mr-2"></i>All Lists</a>
                            <a href="{{ route('baranggays.create') }}" class="list-group-item list-group-item-action"><i
                                    class="fad fa-layer-plus mr-2"></i>Create</a>
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Baranggays</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
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
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false"><input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
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
    <div id="snackbarError" class="shadow rounded"></div>
@stop

@section('_script')
    <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change', '.baranggay_checkbox', function () {
                selectRow(this)
            });

            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }

            getBaranggays();

            function getBaranggays(type = 'all') {
                $('#baranggayTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: `ba/${type}`,
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
                    snackbarError('Please select atleast one checkbox');
                }
            });

            // remove single article
            $(document).on('click', '.removeBaranggay', function () {
                let id = $(this).attr('id');
                if (id.length > 0) {
                    $.ajax({
                        url: '{{ route('ba.massremove') }}',
                        method: "GET",
                        data: {id: id},
                        success: _ => {
                            snackbar('You successfully remove the data.');
                            $('#baranggayTable').DataTable().ajax.reload();
                        }
                    }).fail(err => console.log(err))
                } else {
                    snackbarError('Please select atleast one checkbox')
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
            } else {
                snackbarError('Select the item you want to restore.')
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
            } else {
                snackbarError('Select the item you want to clone.');
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
            } else {
                snackbarError('Select the item you want to clone.');
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
                            url: `ba-kill/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            },
                            method: "DELETE",
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
            } else {
                snackbarError('Check the item you want to delete.');
            }
        });

        $(document).on('click', '.DestroyBaranggay', function (e) {
            const id = [];
            $('.baranggay_checkbox:checked').each(function () {
                id.push($(this).val());
            });
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
                            url: `ba-kill/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            },
                            method: "DELETE",
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
            } else {
                snackbarError('Check the item you want to delete.');
            }

        })

        function snackbar(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }

        function snackbarError(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-wind-warning mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }

        $('#checkAllIds').on('click', function () {
            if (this.checked === true) {
                $("#baranggayTable").find('input[name="baranggay_checkbox[]"]').prop('checked', true);
                $('tr.odd, tr.even').addClass('highlight');
            } else {
                $("#baranggayTable").find('input[name="baranggay_checkbox[]"]').prop('checked', false);
                $('tr.odd, tr.even,tr').removeClass('highlight');
            }
        });

    </script>
@stop
