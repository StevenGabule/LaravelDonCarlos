@extends('backend.layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Baranggay Officials Management</h1>
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
                                    class="fad fa-newspaper mr-2"></i>All Baranggay Officials</a>
                            <a href="javascript:void(0)" data-toggle="modal"
                               class="list-group-item list-group-item-action" id="newOfficial"><i
                                    class="fad fa-layer-plus mr-2"></i>Create</a>

                            <a href="javascript:void(0)" data-toggle="modal" data-target="#CreateGroupOfficialModal"
                               class="list-group-item list-group-item-action" id="newGroupOfficial"><i
                                    class="fad fa-layer-plus mr-2"></i>Create Group Official</a>

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
                        <h6 class="m-0 font-weight-bold header-text small captionText">List of Baranggay Officials</h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="text-right py-3 pr-3">
                            <button type="button" class="btn btn-sm btn-info shadow-sm trash"><i
                                    class="fad fa-trash-undo-alt mr-2"></i>Move To Trash
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm DestroyBaranggayOfficial"><i
                                    class="fad fa-trash mr-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm RestoredBaranggayOfficial"><i
                                    class="fad fa-trash-restore mr-2"></i>Restore
                            </button>
                            <button type="button" class="btn btn-sm btn-info shadow-sm clonedBaranggay"><i
                                    class="fad fa-clone mr-2"></i>Clone
                            </button>
                        </div>
                        <div class="table-responsive overflow-hidden">
                            <table id="officialsTable"
                                   class="table table-striped table-hover mb-0 table-sm custom-font-size">
                                <thead>
                                <tr>
                                    <th data-orderable="false">
                                        <input type="checkbox" name="checkAll" id="checkAllIds">
                                    </th>
                                    <th style="width: 50px">Image</th>
                                    <th>Name</th>
                                    <th>Baranggay</th>
                                    <th>Position</th>
                                    <th>From</th>
                                    <th>To</th>
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

    <!-- START OF NEW/EDIT OFFICIAL MODAL -->
    <div class="modal fade" id="NewEditOfficialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="OfficialForm" method="post" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="NameModalLabel">Register New Officer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <span id="form_result"></span>
                        <div class="form-row">

                            <div class="form-group col-6">
                                <label for="inputAvatar">Select Photo</label>
                                <input type="file"
                                       class="form-control-file"
                                       accept="image/x-png,image/gif,image/jpeg" id="inputAvatar"
                                       name="avatar">
                            </div>

                            <div class="form-group col-6">
                                <div>
                                    <i class="fad fa-images fa-goner" style="font-size: 60px;"></i>
                                    <img src="" alt="" class="img-fluid rounded d-none" id="previewImage"
                                         style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="baranggayId">Select the baranggay</label>
                                <select name="baranggay_id" id="baranggayId" class="form-control form-control-sm"
                                        required>
                                    <option value="">-- Select the baranggay --</option>
                                    @foreach($baranggays as $baranggay)
                                        <option value="{{ $baranggay->id }}">{{ $baranggay->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label for="inputType">Officer Position</label>
                                <select name="position" id="inputPosition" class="form-control form-control-sm"
                                        required>
                                    <option value="">-- Select the position --</option>
                                    <option value="1">Kagawad</option>
                                    <option value="2">Capitan</option>
                                    <option value="3">SK Chairman</option>
                                    <option value="4">Secretary</option>
                                    <option value="5">Treasurer</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" id="inputName"
                                   required>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="inputFrom">From</label>
                                <?php
                                $startDate = (int)date('Y');
                                $date = $startDate + 30;
                                ?>
                                <select name="from" id="inputFrom" class="form-control form-control-sm" required>
                                    <?php for($i = $startDate; $i <= $date; $i++) : ?>
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label for="inputTo">To</label>
                                <select name="to" id="inputTo" class="form-control form-control-sm" required>
                                    <?php for($i = $startDate; $i <= $date; $i++) : ?>
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select name="status" id="inputStatus" class="form-control form-control-sm" required>
                                <option value="1">Published</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <input id="official_id" type="hidden" value="" name="official_id">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-official">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal" id="CreateGroupOfficialModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="OfficialGroupForm" method="post" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="NameModalLabel">Register Group Officers</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <span id="form_group_result"></span>

                        <div class="form-row">

                            <div class="form-group col-3">
                                <label for="baranggayIdGroup">Select the baranggay</label>
                                <select name="baranggay_id" id="baranggayIdGroup" class="form-control form-control-sm"
                                        required>
                                    <option value="">Select the baranggay</option>
                                    @foreach($baranggays as $baranggay)
                                        <option value="{{ $baranggay->id }}">{{ $baranggay->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label for="inputFromGroup">From</label>
                                <?php
                                $startDate = (int)date('Y');
                                $date = $startDate + 30;
                                ?>
                                <select name="from" id="inputFromGroup" class="form-control form-control-sm" required>
                                    <?php for($i = $startDate; $i <= $date; $i++) : ?>
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label for="inputToGroup">To</label>
                                <select name="to" id="inputToGroup" class="form-control form-control-sm" required>
                                    <?php for($i = $startDate; $i <= $date; $i++) : ?>
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label for="inputStatusGroup">Status</label>
                                <select name="status" id="inputStatusGroup" class="form-control form-control-sm" required>
                                    <option value="1">Published</option>
                                    <option value="0">Draft</option>
                                </select>
                            </div>
                        </div>

                        <!-- officers input data -->
                        <div class="form-row">
                            <div class="form-group col-12">
                                <h6 class="border-bottom pb-1">Officers Data</h6>
                            </div>

                            <div class="form-group col-2 text-center"
                                 style="display:flex;align-items: center;justify-content: center">
                                <label for="inputAvatarCaptain" style="transform: translateY(-10px)">
                                    <img src="" id="previewImageCapitan" class="image-pos border rounded-circle p-1 d-none" alt="">
                                    <i class="fad fa-user-plus border rounded-circle p-3 faGoneCap" style="font-size: 32px"
                                       title="Click the image to browse image"></i>
                                </label>
                                <input type="file"
                                       class="form-control-file d-none"
                                       accept="image/x-png,image/gif,image/jpeg" id="inputAvatarCaptain"
                                       name="avatarCapitan">
                            </div>

                            <div class="form-group col-5">
                                <label for="inputNameCapitan" class="col-form-label">Name</label>
                                <input type="text" name="name_capitan" class="form-control form-control-sm"
                                       id="inputNameCapitan"
                                       required>
                            </div>

                            <div class="form-group col-5">
                                <label for="inputPositionCapitan" class="col-form-label">Office Position</label>
                                <select name="position_capitan"
                                        id="inputPositionCapitan" class="form-control form-control-sm"
                                        required>
                                    <option value="2" selected>Capitan</option>
                                </select>
                            </div>
                        </div><!-- end of form-row for capitan -->

                        <div class="form-row mt-3">
                            <div class="form-group col-2 text-center">
                                <label for="inputAvatarChairman" style="transform: translateY(-32px)">
                                    <img src="" id="previewImageChairman" class="image-pos border rounded-circle d-none" alt="">
                                    <i class="fad fa-user-plus border rounded-circle p-3 faGoneCha" style="font-size: 32px"
                                       title="Click the image to browse image"></i>
                                </label>
                                <input type="file"
                                       class="form-control-file d-none"
                                       accept="image/x-png,image/gif,image/jpeg" id="inputAvatarChairman"
                                       name="avatarChairman">
                            </div>

                            <div class="form-group col-5">
                                <input type="text" name="name_chairman" class="form-control form-control-sm"
                                       id="inputNameChairman"
                                       required>
                            </div>
                            <div class="form-group col-5">
                                <select name="position_chairman"
                                        id="inputPositionChairman" class="form-control form-control-sm"
                                        required>
                                    <option value="3" selected>SK Chairman</option>
                                </select>
                            </div>
                        </div><!-- end of form-row for SK Chairman -->

                        <div class="form-row">
                            <div class="form-group col-2 text-center">
                                <label for="inputAvatarSecretary" style="transform: translateY(-34px)">
                                    <img src="" id="previewImageSec" class="image-pos border rounded-circle d-none" alt="">
                                    <i class="fad fa-user-plus border rounded-circle p-3 faGoneSec" style="font-size: 32px"
                                       title="Click the image to browse image"></i>
                                </label>
                                <input type="file"
                                       class="form-control-file d-none"
                                       accept="image/x-png,image/gif,image/jpeg" id="inputAvatarSecretary"
                                       name="avatarSecretary">
                            </div>

                            <div class="form-group col-5">
                                <input type="text" name="name_secretary" class="form-control form-control-sm"
                                       id="inputNameSecretary"
                                >
                            </div>
                            <div class="form-group col-5">
                                <select name="position_secretary"
                                        id="inputPositionSecretary" class="form-control form-control-sm"
                                        required>
                                    <option value="4" selected>Secretary</option>
                                </select>
                            </div>
                        </div><!-- end of form-row for Baranggay Secretary -->

                        <div class="form-row">
                            <div class="form-group col-2 text-center"
                                 style="display:flex;align-items: center;justify-content: center">
                                <label for="inputAvatarTreasurer" style="transform: translateY(-39px)">
                                    <img src="" id="previewImageTrea" class="image-pos border rounded-circle d-none" alt="">
                                    <i class="fad fa-user-plus border rounded-circle p-3 faGoneTrea" style="font-size: 32px"
                                       title="Click the image to browse image"></i>
                                </label>
                                <input type="file"
                                       class="form-control-file d-none"
                                       accept="image/x-png,image/gif,image/jpeg" id="inputAvatarTreasurer"
                                       name="avatarTreasurer">
                            </div>

                            <div class="form-group col-5">
                                <input type="text" name="name_treasurer" class="form-control form-control-sm"
                                       id="inputNameTreasurer"
                                       required>
                            </div>
                            <div class="form-group col-5">
                                <select name="position_treasure"
                                        id="inputPositionTreasurer" class="form-control form-control-sm"
                                        required>
                                    <option value="5" selected>Treasurer</option>
                                </select>
                            </div>
                        </div><!-- end of form-row for Baranggay Treasurer -->
                        <div class="alert alert-warning small mx-lg-4 d-none" id="kagawadLimit" role="alert">
                            You can add only 7 members for kagawad.
                        </div>
                        <span id="KagawadDetails"></span>

                    </div><!-- end of modal body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-group-official">Save changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="snackbar" class="shadow rounded"></div>
@stop

@section('_script')
    <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script>
        console.clear();
        $(document).ready(function () {
            getBaranggays();
            $(document).on('change', '.bo_checkbox', function () {
                selectRow(this)
            });

            function selectRow(elem) {
                if (elem.checked) {
                    elem.parentNode.parentNode.className = 'highlight';
                } else {
                    elem.parentNode.parentNode.className = 'odd';
                }
            }

            function getBaranggays(type = 'all') {
                /*1-kagawad|2-Captain|3-SK|4-Secretary|5-treasurer*/
                const position = ['', 'Kagawad', 'Capitan', 'SK Chairman', 'Secretary', 'Treasurer'];
                $('#officialsTable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    scrollY: '60vh',
                    scrollCollapse: true,
                    pageLength: 15,
                    order: [[8, 'desc']],
                    ajax: `bo/${type}`,
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
                        },
                        {
                            data: 'baranggay.name',
                            name: 'baranggay.name',
                        },
                        {
                            data: 'position',
                            name: 'position',
                            render: data => position[data]
                        },
                        {
                            data: 'from',
                            name: 'from',
                        },
                        {
                            data: 'to',
                            name: 'to',
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
                $(".captionText").text('List of All Registered Baranggay Officials');
                getBaranggays();
            });

            $(document).on('click', '.viewTrash', function (e) {
                e.preventDefault();
                $(".captionText").text('Trash Data');
                getBaranggays('trash');
            });

            $(document).on('click', '.drafted', function (e) {
                e.preventDefault();
                $(".captionText").text('Un-Published');
                getBaranggays('drafted');
            });

            $(document).on('click', '.published', function (e) {
                e.preventDefault();
                $(".captionText").text('Published');
                getBaranggays('published');
            });

            $(document).on('click', '.trash', function (e) {
                e.preventDefault();
                let id = [];

                $('.bo_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('bo.massremove')}}",
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully remove the checked data.');
                                $('#officialsTable').DataTable().ajax.reload();
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
                    $.ajax({
                        url: '{{ route('bo.kill') }}',
                        method: "GET",
                        data: {id: id},
                        success: _ => {
                            snackbar('You successfully remove the data.');
                            $('#officialsTable').DataTable().ajax.reload();
                        }
                    }).fail(err => console.log(err))
                } else {
                    alert('Please select atleast one checkbox')
                }
            })
        });

        $(document).on('click', '.restoreBaranggayOfficial', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('bo.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored it.');
                            $('#officialsTable').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.RestoredBaranggayOfficial', function () {

            let id = [];
            $('.bo_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('bo.restore') }}',
                    method: "GET",
                    data: {id: id},
                    success: data => {
                        if (data) {
                            snackbar('You successfully restored all the data.');
                            $('#officialsTable').DataTable().ajax.reload();
                        }
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.clonedBaranggay', function () {
            let id = [];
            $('.bo_checkbox:checked').each(function () {
                id.push($(this).val());
            });

            if (id.length > 0) {
                $.ajax({
                    url: '{{ route('bo.clone') }}',
                    method: "GET",
                    data: {id: id},
                    success: _ => {
                        snackbar('You successfully clone the data.');
                        $('#officialsTable').DataTable().ajax.reload();
                    }
                }).fail(err => console.log(err))
            }
        });

        $(document).on('click', '.killBaranggayOfficial', function (e) {
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
                        url: '{{ route("bo.kill") }}',
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully deleted the data');
                                $('#officialsTable').DataTable().ajax.reload();
                            }
                        }
                    }).fail(err => console.log(err))
                }
            });
        });

        $(document).on('click', '.DestroyBaranggayOfficial', function () {
            const id = [];
            $('.bo_checkbox:checked').each(function () {
                id.push($(this).val());
            });
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
                        url: '{{ route('bo.kill') }}',
                        method: "GET",
                        data: {id: id},
                        success: data => {
                            if (data) {
                                snackbar('You successfully deleted the data');
                                $('#officialsTable').DataTable().ajax.reload();
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
                $("#officialsTable").find('input[name="bo_checkbox[]"]').prop('checked', true);
                $('tr.odd, tr.even').addClass('highlight');
            } else {
                $("#officialsTable").find('input[name="bo_checkbox[]"]').prop('checked', false);
                $('tr.odd, tr.even,tr').removeClass('highlight');
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                const x = $('#previewImage');
                reader.onload = e => x.attr('src', e.target.result);
                $(".fa-goner").addClass('d-none');
                x.addClass('d-block');
                reader.readAsDataURL(input.files[0])
            }
        }

        $("#inputAvatar").change(function () {
            readURL(this);
        });

        function readURLOfficers(input, elem, fa) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = e => elem.attr('src', e.target.result);
                fa.addClass('d-none');
                elem.addClass('d-block');
                reader.readAsDataURL(input.files[0])
            }
        }

        $("#inputAvatarCaptain").change(function () {
            const elem = $('#previewImageCapitan');
            const fas = $('.faGoneCap');
            readURLOfficers(this, elem, fas);
        });
        $("#inputAvatarChairman").change(function () {
            const elem = $('#previewImageChairman');
            const fas = $('.faGoneCha');
            readURLOfficers(this, elem, fas);
        });
        $("#inputAvatarSecretary").change(function () {
            const elem = $('#previewImageSec');
            const fas = $('.faGoneSec');
            readURLOfficers(this, elem, fas);
        });
        $("#inputAvatarTreasurer").change(function () {
            const elem = $('#previewImageTrea');
            const fas = $('.faGoneTrea');
            readURLOfficers(this, elem, fas);
        });

        $(document).on('click', '#newOfficial', function () {
            $("#NameModalLabel").text('Register New Officer');
            $("#OfficialForm")[0].reset();
            $("#previewImage").removeClass('d-block');
            $(".fa-goner").removeClass('d-none');
            $("#official_id").val('');
            $("#btn-official").text('Save Changes');
            $("#NewEditOfficialModal").modal('show');
        });

        $('#OfficialForm').on('submit', function (e) {
            e.preventDefault();
            const x = $("#btn-official");
            const id = $("#official_id").val();
            $.ajax({
                url: id !== '' ? '{{ route("bo.ajaxUpdate") }}' : '{{ route("officials.store") }}',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    x.attr('disabled', true);
                    x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                },
                success: ({errors, success}) => {
                    if (success) {
                        $("#NewEditOfficialModal").modal('hide');
                        $('#officialsTable').DataTable().ajax.reload();
                        if (id !== '') {
                            snackbar('You successfully updated the data');
                        } else {
                            snackbar('You successfully added new data');
                        }
                    }

                    let html = '';
                    if (errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < errors.length; count++) {
                            html += '<p class="mb-0">' + errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    $("#form_result").html(html);
                    x.attr('disabled', false);
                    x.html('Save Changes');
                },
                error: err => console.error(err)
            }).fail((err) => {
                console.error(err);
                x.attr('disabled', false);
            })
        });

        $(document).on('click', '.editOfficial', function () {
            const id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url: `officials/${id}/edit`,
                dataType: "json",
                success: ({official}) => {
                    const {id, name, baranggay_id, from, to, position, status, avatar} = official;
                    $(".fa-goner").addClass('d-none');
                    const x = $('#previewImage');
                    x.addClass('d-block');
                    x.attr('src', `/${avatar}`);
                    $("#NameModalLabel").text('Edit Officer');
                    $("#official_id").val(id);
                    $("#inputName").val(name);
                    $("#baranggayId").val(baranggay_id);
                    $("#inputFrom").val(from);
                    $("#inputTo").val(to);
                    $("#inputPosition").val(position);
                    $("#inputStatus").val(status);
                    $("#btn-official").text('Update Changes');
                    $("#NewEditOfficialModal").modal('show');
                }
            });
        });
        $("#inputFrom").on('change', function () {
            let _v = parseInt($(this).val());
            $("#inputTo").val(_v + 3)
        });

        $(document).on('click', '#newGroupOfficial', function () {
            $("#NameModalLabel").text('Register Group Officers');
            $("#OfficialGroupForm")[0].reset();
            $(".fa-group-goner").removeClass('d-none');
            $("#form_group_result").html('');
            $("#previewImageCapitan, #previewImageChairman, #previewImageSec, #previewImageTrea").removeClass('d-block');
            $(".faGoneCap, .faGoneCha, .faGoneSec, .faGoneTrea").removeClass('d-none');
            $("#btn-group-official").text('Save Changes');
            $("#CreateGroupOfficialModal").modal('show');
        });

        $("#inputFromGroup").on('change', function () {
            let _v = parseInt($(this).val());
            $("#inputToGroup").val(_v + 3)
        });


        $("#OfficialGroupForm").on('submit', function (e) {
            e.preventDefault();
            const x = $("#btn-group-official");
            $.ajax({
                url: '{{ route("bo.group") }}',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',

                beforeSend: function () {
                    x.attr('disabled', true);
                    x.html(`<div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Saving...</span></div>`);
                },
                success: ({articles, success, errors}) => {

                    if (success) {
                        $("#CreateGroupOfficialModal").modal('hide');
                        $('#officialsTable').DataTable().ajax.reload();
                        snackbar('You successfully added new datas');
                    }

                    let html = '';
                    if (errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < errors.length; count++) {
                            html += '<p class="mb-0">' + errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    $("#form_group_result").html(html);
                    x.attr('disabled', false);
                    x.html('Save Changes');
                },
                error: err => {
                    console.error(err);
                    x.attr('disabled', false);
                    x.html('Save Changes');
                }
            }).fail((err) => {
                console.error(err);
                x.attr('disabled', false);
            })
        });

        function add_kagawad(count = 0) {
            let _btn;
            if (count === 0) {
                _btn = '<button type="button" name="add_more" id="add_more" class="btn btn-primary btn-xs"><i class="fad fa-plus"></i></button>'
            } else {
                _btn = '<button type="button" name="remove" id="' + count + '" class="btn btn-danger btn-xs remove"><i class="fad fa-minus"></i></button>';
            }
            let _html = `
                    <div class="form-row" id="row${count}">
                        <div class="form-group col-lg-2 text-center" style="display:flex;align-items: center;justify-content: center">

                        </div>

                    <div class="form-group col-lg-5">
                        <input type="text" name="name_kagawad[]" class="form-control form-control-sm"
                               id="inputNameKagawad"
                               required>
                    </div>

                    <div class="form-group form-inline col-lg-5">
                        <select name="position_kagawad[]"
                                id="inputPositionKagawad" class="form-control form-control-sm mr-2 w-75"
                                required>
                            <option value="1" selected>Kagawad</option>
                        </select>
                        ${_btn}
                    </div>
                </div>`;
            $("#KagawadDetails").append(_html)
        }

        add_kagawad();
        var count = 1;
        $(document).on('click', '#add_more', function () {
            if (count <= 6) {
                count = count + 1;
                add_kagawad(count);
            } else {
                $("#kagawadLimit").removeClass('d-none');
            }

        });

        $(document).on('click', '.remove', function () {
            let row_no = $(this).attr("id");
            count = count - 1;
            $('#row' + row_no).remove();
            $("#kagawadLimit").addClass('d-none');
        });

        console.clear();
    </script>
@stop
