<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title></title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{asset('/')}}assets/favicon-logo.png1">

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


    <!-- Start right Content here -->

    <div class="content-page" style="margin-left: 0px;">
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
                                <a class="dropdown-item" href="{{url('exam-report')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i>Back Report</a>
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

                <div class="container-fluid" style="padding-right: 40px;padding-left: 40px;">
                   <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Report</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul>

                        </ul>
                    </div>
                    <table class="table table-hover" id="module_table">
                        <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Level</th>
                            @if(admin_type() == 2 || admin_type() == 1)
                            <th>Semester</th>
                            @endif
                            @if(admin_type() != 5)
                            <th>Section</th>
                            @endif
                            <th>ID</th>
                             <th>Subject</th>
                            <th>Question mark</th>
                            <th>Answer mark</th>
                        </tr>
                        </thead>
                        <tbody >

                            @if(count($modules) > 0)

                                @foreach($modules as $module)
                                @if($module->student_mark != '')
                                    <tr>
                                        <td>{{$module->module_name}}</td>
                                        <td>{{$module->level_name}}</td>
                                        @if(admin_type() == 2 || admin_type() == 1)
                                            <td>{{$module->semester_name}}</td>
                                        @endif
                                        @if(admin_type() != 5)
                                           <td>{{$module->name}}</td>
                                        @endif
                                        <td>{{$module->roll_no}}</td>
                                        <td>{{$module->subject_name}}</td>
                                        <td>{{$module->qus_mark}}</td>
                                        <td>{{$module->student_mark}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            @else
                            <p style="color:red;">No data found!</p>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 d-print-none text-right">
            <input class="btn btn-primary" type="button" value="Print" onclick="window.print()" />
       </div>
    </div>
                </div><!-- container -->

            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        <footer class="footer" style="left:0px;">
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
</body>
</html>
