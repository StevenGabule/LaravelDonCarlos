@extends('backend.layouts.app')

@section('style_extended')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>--}}
    <link rel="stylesheet" href="{{ asset('backend/calendar/all.css') }}"/>
    <link rel="stylesheet" href="{{ asset('backend/calendar/fullcalendar.min.css') }}"/>
    <style>
       /* .calendarCustom {
            background-color: #1e1e2d;
            border: 2px solid #2c77f4;
            color: white;
            padding: 8px;
        }*/
    </style>
@stop

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Activities And Events Management</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div id='calendar'></div>
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
                            <a href="{{ route('activities.create') }}" class="list-group-item list-group-item-action"><i
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
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Activities And
                            Events</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-restore mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm destroyActivities"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm restoreActivities"><i
                                    class="fad fa-trash-restore mr-2"></i>Restore
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm  clonedActivities"><i
                                    class="fad fa-clone mr-2"></i>Clone
                            </button>
                        </div>
                        <div class="table-responsive overflow-hidden">
                            <table id="activitiesTable"
                                   class="table table-striped table-hover table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false"><input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
                                    <th style="width: 50px">Image</th>
                                    <th style="width:24%">Title</th>
                                    <th>Date Start</th>
                                    <th>Date End</th>
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
    <script src="{{ asset('backend/calendar/fullcalendar.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change', '.activity_checkbox', function () {
                selectRow(this)
            });

            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }

            getActivities();

            function getActivities(type = 'all') {
                $('#activitiesTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    order: [[6, 'desc']],
                    ajax: `act-all/${type}`,
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
                            render: _ => `<span class="font-weight-bold text-capitalize">${_.substr(0, 30)}...</span>`
                        },
                        {
                            data: 'date_start',
                            name: 'date_start',
                            render: _ => moment(_).format('LLL')
                        },
                        {
                            data: 'date_end',
                            name: 'date_end',
                            render: _ => moment(_).format('LLL')
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
                $(".captionText").text('List of Activities And Events');
                getActivities();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $(".captionText").text('Trash');
                getActivities('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $(".captionText").text('List of Unpublished Activities And Events');
                getActivities('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
                $(".captionText").text('List of published Activities And Events');
                getActivities('published');
            });

            $(document).on('click', '.trash', function (e) {
                e.preventDefault();
                let id = [];
                $('.activity_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('act.massremove')}}",
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully remove the checked data.');
                                $('#activitiesTable').DataTable().ajax.reload();
                            }
                            console.clear();
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
            });

            // remove single article
            $(document).on('click', '.removeActivities', function () {
                let id = $(this).attr('id');
                if (id.length > 0) {
                    swal({
                        title: `Question`,
                        text: "Are you sure to continue?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '{{ route('act.kill') }}',
                                method: "GET",
                                data: {id: id},
                                success: _ => {
                                    snackbar('You successfully remove the data.');
                                    $('#activitiesTable').DataTable().ajax.reload();
                                }
                            }).fail(err => console.log(err))
                        }
                    });

                } else {
                    alert('Please select atleast one checkbox')
                }
            })

        });

        $(document).on('click', '.restoreActivities', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('act.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored it.');
                            $('#activitiesTable').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.restoreActivities', function () {

            let id = [];
            $('.activity_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('act.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored all the checked data.');
                            $('#activitiesTable').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.clonedActivities', function () {
            let id = [];
            $('.activity_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('act.clone') }}',
                    method: "GET",
                    data: {id: id},
                    success: _ => {
                        snackbar('You successfully clone the data.');
                        $('#activitiesTable').DataTable().ajax.reload();
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
                                $('#activitiesTable').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });
        })

        $(document).on('click', '.destroyActivities', function (e) {
            const id = [];
            $('.activity_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            swal({
                title: `Question`,
                text: "Are you sure to continue?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route('act.kill') }}',
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully deleted the checked data');
                                $('#activitiesTable').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });
        });

        function snackbar(text = '') {
            let x = $("#snackbar");
            x.addClass("show");
            x.html(`<i class="fad fa-check mr-2 fa-fw"></i> ${text}`);
            setTimeout(() => x.removeClass("show"), 3000);
        }

        $('#checkAllIds').on('click', function () {
            if (this.checked === true) {
                $("#activitiesTable").find('input[name="activity_checkbox[]"]').prop('checked', true);
                $('tr.odd, tr.even').addClass('highlight');
            } else {
                $("#activitiesTable").find('input[name="activity_checkbox[]"]').prop('checked', false);
                $('tr.odd, tr.even,tr').removeClass('highlight');
            }
        });

        $(document).ready(function () {
            $("#calendar").fullCalendar({
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                themeSystem: 'bootstrap4',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },

                editable: true,
                displayEventTime: true,
                selectable: true,
                selectHelper: true,
                eventLimit: true,
                events: [
                        @foreach($activities as $activity) {
                        id: '{{ $activity->id }}',
                        title: '{{ $activity->title }}',
                        start: '{{ $activity->date_start }}',
                        end: '{{ $activity->date_end }}',
                        className: 'calendarCustom',

                        url: '/admin/activities/{{ $activity->id }}/edit',
                    },
                    @endforeach
                ],
                eventRender: function (event, element, view) {
                    event.allDay = event.allDay === 'true';
                },

                select: function (start, end, allDay) {

                },
                eventDrop: function (event, delta, revertFunc) {
                    edit(event);
                },
                eventResize: function (event, dayDelta, minuteDelta, revertFunc) {
                    edit(event);
                },
            });

            function edit(event) {
                let end;
                const start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                } else {
                    end = start;
                }

                Event = [];
                Event[0] = event.id;
                Event[1] = start;
                Event[2] = end;

                $.ajax({
                    url: '{{ route('fc.resize') }}',
                    type: "POST",
                    data: {
                        Event,
                        _token: '{{ csrf_token() }}'
                    },
                    success: data => {
                        console.log(data)
                    },
                    error: err => console.error(err)
                });
            }
        })
    </script>
@stop
