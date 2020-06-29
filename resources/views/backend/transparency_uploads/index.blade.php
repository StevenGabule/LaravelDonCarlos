@extends('backend.layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">File System Management</h1>
        </div>

        <div class="row">
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
                               class="list-group-item list-group-item-action list-group-custom">
                                <i class="fad fa-newspaper mr-2"></i>All Files
                            </a>

                            <a href="{{ route('file-upload.create') }}" class="list-group-item list-group-item-action">
                                <i class="fad fa-cloud-upload-alt mr-2"></i> Upload A File
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold header-text small captionText">List Table</h6>
                    </div>

                    <div class="card-body p-0">

                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm deleteFiles"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                        </div>

                        <div class="table-responsive overflow-hidden">
                            <table id="filesTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false">
                                        <input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
                                    <th>Filename</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Clicked</th>
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
            $(document).on('mouseover', '[data-toggle="tooltip"]', function() {
                $(this).tooltip();
            })

            $(document).on('change', '.file_checkbox', function () {
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
                    $("#filesTable").find('input[name="file_checkbox[]"]').prop('checked', true);
                    $('tr.odd, tr.even').addClass('highlight');
                } else {
                    $("#filesTable").find('input[name="file_checkbox[]"]').prop('checked', false);
                    $('tr.odd, tr.even,tr').removeClass('highlight');
                }
            });

            function snackbar(text = '') {
                let x = $("#snackbar");
                x.addClass("show");
                x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
                setTimeout(() => x.removeClass("show"), 3000);
            }

            getFilesUpload();

            function getFilesUpload() {
                $('#filesTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    ajax: "{{ route('file.render') }}",
                    order: [[5, "desc"]],
                    columns: [
                        {
                            data: 'checkbox',
                            name: 'checkbox',
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: data => data.split('.').slice(0,-1).join('')
                        },
                        {
                            data: 'type',
                            name: 'type',
                            searchable: false,

                        },
                        {
                            data: 'size',
                            name: 'size',
                            searchable: false,
                        },
                        {
                            data: 'clicked',
                            name: 'clicked',
                            searchable: false,
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            searchable: false,
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                        },
                    ],
                });
            }

            $(document).on('click', '.btnDelete', function (e) {
                e.preventDefault();
                const id = $(this).attr('id');
                if (id.length > 0) {
                    swal({
                        title: "Confirmation",
                        text: "Are you sure to this file?",
                        icon: "warning",
                        dangerMode: true,
                        buttons: [true, "Continue"],
                        closeModal: false
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ route('file.mass.remove')}}",
                                headers: {
                                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                                },
                                method: "POST",
                                data: {id: id},
                                success: data => {
                                    if (data) {
                                        snackbar('You successfully deleted checked datas and files.');
                                        $('#filesTable').DataTable().ajax.reload();
                                    }
                                    console.clear();
                                }
                            }).fail(err => console.log(err))
                        }
                    });
                } else {
                    snackbar('Please select atleast one checkbox');
                }
            });

            $(document).on('click', '.deleteFiles', function (e) {
                e.preventDefault();
                let id = [];
                $('.file_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    swal({
                        title: "Confirmation",
                        text: "Are you sure to this file?",
                        icon: "warning",
                        dangerMode: true,
                        buttons: [true, "Continue"],
                        closeModal: false
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ route('file.mass.remove')}}",
                                headers: {
                                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                                },
                                method: "POST",
                                data: {id: id},
                                success: data => {
                                    if (data) {
                                        snackbar('You successfully deleted checked datas and files.');
                                        $('#filesTable').DataTable().ajax.reload();
                                    }
                                    console.clear();
                                }
                            }).fail(err => console.log(err))
                        }
                    });
                } else {
                    snackbar('Please select atleast one checkbox');
                }
            });
        });
    </script>
@stop