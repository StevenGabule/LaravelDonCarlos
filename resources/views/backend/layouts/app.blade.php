<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DonCarlos Admin - Dashboard</title>
    <link rel="short icon" href="{{ asset('assets/icons/87px-Ph_seal_don_carlos.jpg') }}">
    <link href="{{ asset('backend/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/bar.css') }}" rel="stylesheet">
    @yield('style_extended')
    <style>
        .sidebar .nav-item .nav-link[data-toggle=collapse].collapsed::after,
        .sidebar .nav-item .nav-link[data-toggle=collapse]::after{
            content: "";
        }
        a.collapse-item:hover {
            background-color: #1e1e2d !important;
        }
        a.text-small {
            font-size: 11px;
        }
    </style>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
            <div class="sidebar-brand-icon">
                <i class="fad fa-landmark-alt  pinkish"></i>
            </div>
            <div class="sidebar-brand-text mx-3 text-white">DonCarlos</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link nav-link-custom" href="{{ route('admin') }}">
                <i class="fad fa-fw fa-home-lg-alt blueish"></i>
                <span>Dashboard</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('article.index') }}">
                <i class="fad fa-fw fa-newspaper blueish"></i>
                <span>News</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('place.index') }}">
                <i class="fad fa-fw fa-mountain blueish"></i>
                <span>Tourism</span></a>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item active">
            <a class="nav-link collapsed"
               href="javascript:void(0)"
               data-toggle="collapse"
               data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fad fa-fw fa-hand-holding-box blueish"></i>
                <span>Services</span></a>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-gradient-nav py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Options:</h6>
                    <a class="collapse-item text-white" href="{{ route('service.index') }}">Services</a>
                    <a class="collapse-item text-white" href="{{ route('service-article.index') }}">Service Articles</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item active">
            <a class="nav-link collapsed"
               href="javascript:void(0)"
               data-toggle="collapse"
               data-target="#collapseFour"
               aria-expanded="true" aria-controls="collapseFour">
                <i class="fad fa-fw fa-hand-holding-box blueish"></i>
                <span>Transparency</span></a>

            <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-gradient-nav py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Options:</h6>
                    <a class="collapse-item text-white" href="{{ route('transparency.index') }}">Category</a>
                    <a class="collapse-item text-white" href="{{ route('transparency-posts.index') }}">Posts</a>
                </div>
            </div>
        </li>

        <li class="nav-item active">
            <a class="nav-link collapsed"
               href="javascript:void(0)"
               data-toggle="collapse"
               data-target="#collapseThree"
               aria-expanded="true" aria-controls="collapseThree">
                <i class="fad fa-fw fa-kaaba blueish"></i>
                <span>Baranggays</span></a>

            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                <div class="bg-gradient-nav py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Options:</h6>
                    <a class="collapse-item text-white" href="{{ route('baranggays.index') }}">Baranggays</a>
                    <a class="collapse-item text-white" href="{{ route('officials.index') }}">Officers</a>
                </div>
            </div>

        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('activities.index') }}">
                <i class="fad fa-fw fa-calendar-alt blueish"></i>
                <span>Events</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('messages.index') }}">
                <i class="fad fa-fw fa-mailbox blueish"></i>
                <span>Mails</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('departments.index') }}">
                <i class="fad fa-fw fa-industry blueish"></i>
                <span>Departments</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('department-offices.index') }}">
                <i class="fad fa-fw fa-phone-office blueish"></i>
                <span>Departments Offices</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('file-upload.index') }}">
                <i class="fad fa-fw fa-cloud-upload-alt blueish"></i>
                <span>Files</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('accounts') }}">
                <i class="fad fa-fw fa-users blueish"></i>
                <span>Accounts</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('page-content.index') }}">
                <i class="fad fa-fw fa-pager  blueish"></i>
                <span>Pages Content</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('need-content.index') }}">
                <i class="fad fa-fw fa-file-certificate blueish"></i>
                <span>Award And Mandate</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('hotlines.index') }}">
                <i class="fad fa-fw fa-calendar-alt blueish"></i>
                <span>Hotlines</span></a>
        </li>


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand bg-gradient-nav bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-2 my-2 my-md-0 mw-100 navbar-search">
                    <a href="{{ route('index') }}" target="_blank" class="btn btn-success btn-sm small">
                        <i class="fad fa-eye"></i> View Site
                    </a>
                </div>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-white font-weight-bolder small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle"
                                 src="{{ asset('backend/img/photo-1517849845537-4d257902454a.jfif') }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- HERE IS THE CONTENT AREA-->
            @yield('content')

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; DonCarlos <?= ((int)date('Y') === 2020) ? date('Y') : "2020-".date('Y') ?></span>
                </div>
            </div>
        </footer>
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset('backend/js/nprogress.min.js') }}"></script>
<script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>

@yield('_script')

<script>
    (function($) {
        NProgress.start();
        window.onload = _ => {
            NProgress.done();
        };
    })(jQuery)
</script>
</body>
</html>
