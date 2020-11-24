<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> OES  System</title>
    <!-- Icons-->
    <link rel="icon" type="image/ico" href="{{asset('/')}}assets/favicon-logo.png1" sizes="any" />
    <link href="{{asset('/')}}assets/front-end/exam/node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/front-end/exam/node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/front-end/exam/node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/front-end/exam/node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{asset('/')}}assets/front-end/exam/css/style.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/front-end/exam/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script src="{{asset('/')}}assets/front-end/exam/node_modules/jquery/dist/jquery.min.js"></script>

    <style type="text/css">
        .navbar-brand span{

        }
        .nav-link i{
            margin-right: 10px;
        }
    </style>
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/user/dashboard') }}">
        <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
        <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">

        </li>
        @if(session('user_id'))
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="font-size: 24px;color: #530000" role="button" aria-haspopup="true" aria-expanded="false">

                @if(user_info()->image != '')
                    <img src="{{asset('/')}}{{user_info()->image}}" style="width: 36px;height: 36px;border-radius: 50%;">
                @else
                    <img src="{{asset('/')}}assets/user-default.png" style="width: 36px;height: 36px;border-radius: 50%;">
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="{{route('profile')}}">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="{{route('logout')}}">
                    <i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
        @endif
    </ul>
    <!-- <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button> -->
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                @if(session('user_id'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.dashboard')}}">
                        <i class="nav-icon cui-home"></i> Dashboard</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">
                        <i class="nav-icon cui-home"></i> Dashboard</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('study')}}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> Study</a>
                </li>
                @if(session('user_id'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('module')}}">
                        <i class="fa fa-modx" aria-hidden="true"></i> Module</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('student_score')}}">
                        <i class="icon-graph"></i> Your Score</a>
                </li>

               <!--  <li class="nav-item">
                    <a class="nav-link" href="{{route('tutor_module')}}">
                        <i class="fa fa-modx" aria-hidden="true"></i> Tutor Module</a>
                </li> -->
                @if(is_active() == 10)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('tutor_assignment')}}">
                        <i class="fa fa-modx" aria-hidden="true"></i> Tutor Assignment</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('institute_registration')}}">
                        <i class="fa fa-fort-awesome fa-lg"></i> Institute Registration
                    </a>
                </li>
                @if(haveInstituteStudent() != false)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('student_institute')}}">
                        <i class="fa fa-user fa-lg"></i> Institute profile
                    </a>
                </li>
                @endif
                @if(is_active() == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('practice_module')}}">
                            <i class="fa fa-modx" aria-hidden="true"></i> Past Exam
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('institute_exam_module')}}">
                            <i class="fa fa-modx" aria-hidden="true"></i> Today Exam
                        </a>
                    </li>
                @endif
                @endif
                @if(!session('user_id'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('blog')}}">
                        <i class="fa fa-plus-square-o" aria-hidden="true"></i> Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('contact')}}">
                        <i class="fa fa-comments" aria-hidden="true"></i> Contact</a>
                </li>

            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <!-- Breadcrumb-->
        <!-- <ol class="breadcrumb"> -->
            <!-- Breadcrumb Menu-->
            <!-- <li class="breadcrumb-menu d-md-down-none"> -->

            <!-- </li> -->
        <!-- </ol> -->
        <div class="container-fluid">
            <div class="animated fadeIn">
                @yield('body')
            </div>
        </div>
    </main>
</div>
<footer class="app-footer">
    <div style="margin: auto;">
        <a href="#"><span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
        <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span></a>
        <span>&copy; 2020 </span>
    </div>
</footer>
<!-- CoreUI and necessary plugins-->

<script src="{{asset('/')}}assets/front-end/exam/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/pace-progress/pace.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>

<!-- <script src="{{asset('/')}}assets/front-end/exam/js/charts.js"></script> -->
<script src="{{asset('/')}}assets/front-end/exam/js/main.js"></script>
</body>
</html>
