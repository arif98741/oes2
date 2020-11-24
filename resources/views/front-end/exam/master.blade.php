<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>eyb exam board</title>
    <!-- Icons-->
    <link rel="icon" type="image/ico" href="{{asset('/')}}assets/front-end/exam/img/favicon.ico" sizes="any" />
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
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{asset('/')}}assets/front-end/exam/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="{{asset('/')}}assets/front-end/exam/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">
            {{--<a class="nav-link" href="#">--}}
                {{--<i class="icon-bell"></i>--}}
                {{--<span class="badge badge-pill badge-danger">5</span>--}}
            {{--</a>--}}
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img class="img-avatar" src="{{asset('/')}}assets/front-end/exam/img/avatars/6.jpg" alt="admin@bootstrapmaster.com">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="{{route('logout')}}">
                    <i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('create_module')}}">
                        <i class="nav-icon icon-pencil"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('create_module')}}">
                        <i class="nav-icon icon-pencil"></i>Create Module</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('module')}}">
                        <i class="nav-icon icon-pencil"></i>Module</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('student_score')}}">
                        <i class="icon-graph"></i> </i>Your Score</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">
                        <i class="nav-icon icon-pencil"></i>Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">
                        <i class="nav-icon icon-pencil"></i>Register</a>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none">
                {{--<div class="btn-group" role="group" aria-label="Button group">--}}
                    {{--<a class="btn" href="#"><i class="icon-graph"></i>--}}
                    {{--</a>--}}
                {{--</div>--}}
            </li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @yield('body')
            </div>
        </div>
    </main>
    <aside class="aside-menu">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">
                    <i class="icon-list"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                    <i class="icon-speech"></i>
                </a>
            </li>
        </ul>
        <!-- Tab panes-->
        <div class="tab-content">
            <div class="tab-pane active" id="timeline" role="tabpanel">
                <div class="list-group list-group-accent">
                    <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Today's Exam</div>
                    <div class="list-group-item list-group-item-accent-warning list-group-item-divider">
                        <div>Subject Name
                            <strong>Quiz Name</strong>
                        </div>
                        <small class="text-muted mr-3">
                            <i class="icon-calendar"></i>  1 - 3pm</small>
                    </div>
                    <div class="list-group-item list-group-item-accent-info">
                        <div>Subject Name
                            <strong>Quiz Name</strong>
                        </div>
                        <small class="text-muted mr-3">
                            <i class="icon-calendar"></i>  4 - 5pm</small>
                    </div>
                    <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Tomorrow</div>
                    <div class="list-group-item list-group-item-accent-success list-group-item-divider">
                        <div>
                            <strong>#10 Startups.Garden</strong> Meetup</div>
                        <small class="text-muted mr-3">
                            <i class="icon-calendar"></i>  1 - 3pm</small>
                        <small class="text-muted">
                            <i class="icon-location-pin"></i>  Palo Alto, CA</small>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="messages" role="tabpanel">
                <div class="message">
                    <div class="py-3 pb-5 mr-3 float-left">
                        <div class="avatar">
                            <img class="img-avatar" src="{{asset('/')}}assets/front-end/exam/img/avatars/7.jpg" alt="admin@bootstrapmaster.com">
                            <span class="avatar-status badge-success"></span>
                        </div>
                    </div>
                    <div>
                        <small class="text-muted">Lukasz Holeczek</small>
                        <small class="text-muted float-right mt-1">1:52 PM</small>
                    </div>
                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                </div>
                <hr>
                <div class="message">
                    <div class="py-3 pb-5 mr-3 float-left">
                        <div class="avatar">
                            <img class="img-avatar" src="{{asset('/')}}assets/front-end/exam/img/avatars/7.jpg" alt="admin@bootstrapmaster.com">
                            <span class="avatar-status badge-success"></span>
                        </div>
                    </div>
                    <div>
                        <small class="text-muted">Lukasz Holeczek</small>
                        <small class="text-muted float-right mt-1">1:52 PM</small>
                    </div>
                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                </div>
            </div>
            <div class="tab-pane p-3" id="settings" role="tabpanel">
                <h6>Settings</h6>
                <div class="aside-options">
                    <div class="clearfix mt-4">
                        <small>
                            <b>Option 1</b>
                        </small>
                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                            <input class="switch-input" type="checkbox" checked="">
                            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                        </label>
                    </div>
                    <div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                    </div>
                </div>
                <div class="aside-options">
                    <div class="clearfix mt-3">
                        <small>
                            <b>Option 2</b>
                        </small>
                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                            <input class="switch-input" type="checkbox">
                            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                        </label>
                    </div>
                    <div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                    </div>
                </div>
                <div class="aside-options">
                    <div class="clearfix mt-3">
                        <small>
                            <b>Option 3</b>
                        </small>
                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                            <input class="switch-input" type="checkbox">
                            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                        </label>
                    </div>
                </div>
                <div class="aside-options">
                    <div class="clearfix mt-3">
                        <small>
                            <b>Option 4</b>
                        </small>
                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                            <input class="switch-input" type="checkbox" checked="">
                            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                        </label>
                    </div>
                </div>
                <hr>
                <h6>System Utilization</h6>
                <div class="text-uppercase mb-1 mt-4">
                    <small>
                        <b>CPU Usage</b>
                    </small>
                </div>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">348 Processes. 1/4 Cores.</small>
                <div class="text-uppercase mb-1 mt-2">
                    <small>
                        <b>Memory Usage</b>
                    </small>
                </div>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">11444GB/16384MB</small>
                <div class="text-uppercase mb-1 mt-2">
                    <small>
                        <b>SSD 1 Usage</b>
                    </small>
                </div>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">243GB/256GB</small>
                <div class="text-uppercase mb-1 mt-2">
                    <small>
                        <b>SSD 2 Usage</b>
                    </small>
                </div>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">25GB/256GB</small>
            </div>
        </div>
    </aside>
</div>
<footer class="app-footer">
    <div>
        <a href="#">EYB</a>
        <span>&copy; 2020 examine your brain.</span>
    </div>
    <div class="ml-auto">

    </div>
</footer>
<!-- CoreUI and necessary plugins-->

<script src="{{asset('/')}}assets/front-end/exam/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/pace-progress/pace.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{asset('/')}}assets/front-end/exam/node_modules/chart.js/dist/Chart.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
<script src="{{asset('/')}}assets/front-end/exam/js/main.js"></script>
</body>
</html>
