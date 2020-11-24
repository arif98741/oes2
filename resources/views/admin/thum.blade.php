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

    <link href="{{asset('/')}}assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}assets/admin/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}assets/admin/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>


<!-- Begin page -->
<div class="accountbg"></div>
<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <div class="text-center">
                <h5><span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
        <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span></h5>
            </div>

            <div class="px-3 pb-3">
                <form class="form-horizontal m-t-20" action="{{route('backend')}}" method="post">
                    @csrf
                    @if(Session::get('error'))
                        <div class="alert alert-danger">
                            {{Session::get('error')}}
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" name="email" type="text" required="" placeholder="Email">
                            @error('email')
                            <div style="color: #ef0d0d;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" name="password" required="" placeholder="Password">
                            @error('password')
                            <div style="color: #ef0d0d;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{--<div class="form-group row">--}}
                        {{--<div class="col-12">--}}
                            {{--<div class="custom-control custom-checkbox">--}}
                                {{--<input type="checkbox" class="custom-control-input" id="customCheck1">--}}
                                {{--<label class="custom-control-label" for="customCheck1">Remember me</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <!-- <div class="form-group m-t-10 mb-0 row">
                        <div class="col-sm-7 m-t-20">
                            <a href="" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your password ?</small></a>
                        </div>
                    </div> -->
                </form>
            </div>

        </div>
    </div>
</div>



<!-- jQuery  -->
<script src="{{asset('/')}}assets/admin/js/jquery.min.js"></script>
<script src="{{asset('/')}}assets/admin/js/popper.min.js"></script>
<script src="{{asset('/')}}assets/admin/js/bootstrap.min.js"></script>
<!-- App js -->
<script src="{{asset('/')}}assets/admin/js/app.js"></script>

</body>
</html>
