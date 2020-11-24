<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>OES</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{asset('/')}}assets/favicon-logo.pn1g">

    <!-- jvectormap -->
    <script src="{{asset('/')}}assets/admin/js/jquery.min.js"></script>
    <link href="{{asset('/')}}assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}assets/admin/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}assets/admin/css/style.css" rel="stylesheet" type="text/css">

</head>

<body class="fixed-left">

<!-- Loader -->
{{--<div id="preloader"><div id="status"><div class="spinner"></div></div></div>--}}

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
            <i class="ion-close"></i>
        </button>

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="text-center">
                <!--<a href="index.html" class="logo"><i class="mdi mdi-assistant"></i>Zoter</a>-->
                <a href="{{url('dashboard')}}" class="logo">
                    <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>

                </a>
            </div>
        </div>

        <div class="sidebar-inner niceScrollleft">

            <div id="sidebar-menu">
                <ul>
                    <li class="menu-title">Main</li>

                    @if(!session('super_status'))
                     <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-bullseye"></i> <span> Academic</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{action('LevelController@manage_level')}}"><i class="mdi mdi-bullseye"></i> Manage Levels</a>
                                    </li>
                                    <li>
                                        <a href="{{action('SubjectController@manage_subject')}}"><i class="mdi mdi-bullseye"></i> Manage Subjects</a>
                                    </li>
                                    @if(admin_type() == 2 || admin_type() == 1)
                                    <li>
                                        <a href="{{action('SemesterController@manage_semester')}}"><i class="mdi mdi-bullseye"></i> Manage Semesters</a>
                                    </li>
                                    @endif
                                   @if(admin_type() != 5)
                                    <li>
                                        <a href="{{action('SectionController@manage_section')}}"><i class="mdi mdi-bullseye"></i> Manage Sections</a>
                                    </li>
                                    @else
                                    <li>
                                        <a href="{{action('BatchController@manage_batch')}}"><i class="mdi mdi-bullseye"></i> Manage Batch</a>
                                    </li>
                                    @endif

                                    @if(session('admin_status'))
                                    <li>
                                        <a href="{{route('manage_institute')}}"><i class="mdi mdi-bullseye"></i> Manage Institutes</a>
                                    </li>
                                    @else
                                    <li>
                                        <a href="{{route('manage_student')}}"><i class="mdi mdi-bullseye"></i> Manage Students</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>

                    <li>
                    @endif
                    <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-bullseye"></i> <span>Education</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{route('manage_question')}}"><i class="mdi mdi-bullseye"></i> Manage Questions</a>
                                    </li>
                                    <li>
                                        <a href="{{route('manage_module')}}"><i class="mdi mdi-bullseye"></i> Manage Module</a>
                                    </li>
                                    <!--<li>-->
                                    <!--    <a href="{{route('manage_assignment')}}"><i class="mdi mdi-bullseye"></i> Manage Written Exam</a>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                    <!--    <a href="{{url('exam-report')}}"><i class="mdi mdi-bullseye"></i> Exam Report</a>-->
                                    <!--</li>-->
                                    <li>
                                        <a href="{{route('module_report')}}"><i class="mdi mdi-bullseye"></i>Module Report</a>
                                    </li>
                                </ul>
                    </li>
                    @if(session('admin_status'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-bullseye"></i> <span>Posts</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{route('manage_categories')}}"><i class="mdi mdi-bullseye"></i> Manage Categries</a>
                            </li>
                            <li>
                                <a href="{{route('manage_sub_category')}}"><i class="mdi mdi-bullseye"></i> Manage Sub Categories</a>
                            </li>
                            <li>
                                <a href="{{route('manage_posts')}}"><i class="mdi mdi-bullseye"></i> Manage Posts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.users')}}"><i class="mdi mdi-bullseye"></i>Users</a>

                    </li>
                    <li>
                        <a href="{{route('admin.members')}}"><i class="mdi mdi-bullseye"></i>Members</a>

                    </li>
                    <li>
                        <a href="{{route('admin.contact')}}"><i class="mdi mdi-bullseye"></i>Contacts</a>

                    </li>
                     @endif
                </ul>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->

    <!-- Start right Content here -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <!-- Top Bar Start -->
            <div class="topbar">

                <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">

                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset('/')}}assets/admin/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                                <a class="dropdown-item" href="{{route('admin_logout')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="mdi mdi-menu"></i>
                            </button>
                        </li>
                    </ul>

                    <div class="clearfix"></div>

                </nav>

            </div>
            <!-- Top Bar End -->

            <div class="page-content-wrapper ">
                <div class="container-fluid">
                    @yield('body')
                </div><!-- container -->

            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        <footer class="footer">
            <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
        <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
        </footer>

    </div>
    <!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->

<script src="{{asset('/')}}assets/admin/js/popper.min.js"></script>
<script src="{{asset('/')}}assets/admin/js/bootstrap.min.js"></script>
<script src="{{asset('/')}}assets/admin/js/jquery.nicescroll.js"></script>
<script src="{{asset('/')}}assets/admin/js/app.js"></script>


</body>
</html>
