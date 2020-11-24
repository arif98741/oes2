@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
   <div class="row">
        <div class="col-md-7 m-auto" >
             <div class="card card-default" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <i class="fa fa-picture-o"></i> @if(Session::get('verification') || Session::get('error')) Email Verification @endif @if(!Session::get('verification') || Session::get('error')) Register @endif
                    <div class="card-header-actions">
                        <a class="card-header-action" href="" target="_blank"></a>
                    </div>
                </div>
                <style>
                    #module-form {
                        margin: auto;
                    }
                    #module-form sup{
                        color: #e70a0a;
                    }
                    .color-red{
                        color: red;
                    }
                    .color-green
                    {
                        color: green;
                    }
                    .d-none{
                        display: none;
                    }
                </style>
                <div class="card-body">
                    @if(Session::get('verification') || Session::get('error'))

                        <form class="form-horizontal" action="{{route('register')}}" method="post"  onsubmit="return validateForm()">
                            @csrf

                            @if(Session::get('error'))
                                <div class="alert alert-success">
                                    <span>Your code is not valid.Please try again valid code.</span>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="name">Code</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="code"  autocomplete="off" type="number" name="code" placeholder="Enter Your Code">
                                    <input class="form-control"  autocomplete="off" type="hidden" name="id" value="{{Session::get('id')}}" placeholder="Enter Your Code">
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                            </div>
                        </form>
                    @endif
                    @if(!Session::get('verification') && !Session::get('error'))
                        <form class="form-horizontal" action="{{route('register')}}" method="post" id="registration_form">
                        @csrf
                        <div class="alert alert-info kk_alert kk_processing_alert d-none" role="alert">
                            <p class="text-center">Processing...</p>
                        </div>
                        <div class="alert alert-success kk_alert kk_success_alert d-none" role="alert"></div>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul>
                            </ul>
                        </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="name">Name</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="name" autocomplete="off" type="text" name="name" placeholder="enter name, use only alphabets">
                                        <span class="name_msg "></span>
                                        @error('name')
                                        <div style="color: #ef0d0d;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="email">Email</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="email" autocomplete="off" type="email" name="email" placeholder="enter email">
                                        <span class="email_msg "></span>
                                        @error('email')
                                        <div style="color: #ef0d0d;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="password">Password</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="password" autocomplete="off" type="password" name="password" placeholder="enter password,use alphabets and numbers">
                                        <span class="password_msg "></span>
                                        @error('password')
                                        <div style="color: #ef0d0d;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="district">District</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="district" name="district">
                                            <option value="">Please select district</option>
                                            @foreach($districts as $district)
                                                <option value="{{$district->id}}">{{$district->bn_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="district_msg "></span>
                                        @error('district')
                                        <div style="color: #ef0d0d;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!--<div class="form-group row">-->
                                <!--    <label class="col-md-3 col-form-label" for="district"></label>-->
                                <!--    <div class="col-md-4">-->
                                <!--        <div class="g-recaptcha"-->
                                <!--             data-sitekey="6LdnedsZAAAAAHoM_eG-_-GpbXKKn6SBfHSy61rF">-->
                                <!--        </div>-->
                                <!--        @error('g-recaptcha-response')-->
                                <!--        <div style="color: #ef0d0d;">{{ $message }}</div>-->
                                <!--        @enderror-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div style="text-align: right;">
                                    <a href="{{route('login')}}">Login</a>
                                    <button class="btn btn-sm btn-primary submit-btn" type="submit">
                                        <i class="fa fa-dot-circle-o"></i> Submit</button>
                                </div>
                            </form>
                            @endif
                    <!-- /.row-->
                </div>
            </div>
        </div>
   </div>
    <script>
        $("#c-password").keyup(function () {
            var password = $("#password").val();
            var c_pass = $(this).val();
            if (password == c_pass)
            {
                $(".c_password_msg").removeClass('color-red');
                $(".c_password_msg").addClass('color-green');
                $(".c_password_msg").html("Password Matched. <span style='font-size:30px;position:absolute;top:26px;left:140px;'>&#128525;</span>");
            }else {
                $(".c_password_msg").removeClass('color-green');
                $(".c_password_msg").addClass('color-red');
                $(".c_password_msg").html("Password don't matched! <span style='font-size:30px;position:absolute;top:26px;left:178px;'>&#128533;</span>");
            }
        });
        $("#password").keyup(function () {
            var password = $("#password").val();
            var regex = '/^[a-z0-9]+$/i';
            if(password.length < 1)
            {
                $(".password_msg").html("can't empty");
            }else if (password.length < 6)
            {
                $(".password_msg").html("password weak.<span style='font-size:30px;position:absolute;top:26px;left:116px;'>&#128530;</span>");
            }else if (password.length >= 6)
            {
                $(".password_msg").html("password good.<span style='font-size:30px;position:absolute;top:26px;left:116px;'>&#128578;</span>");
            }else if(regex.test(password))
            {
                $(".password_msg").html("password strong.<span style='font-size:30px;position:absolute;top:26px;left:116px;'>&#128561;</span>");
            }else
            {
                $(".password_msg").html('');
            }

        });

$("#registration_form").on('submit', function(e) {
    e.preventDefault();
    $('button.submit-btn').prop('disabled', true);
    $('.kk_processing_alert').removeClass('d-none');
    $('.kk_success_alert').addClass('d-none');
    $(".print-error-msg").css('display','none');
    $.ajax({
        method: "POST",
        url: $(this).prop('action'),
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data)
        {
            $(".print-error-msg").css('display','none');
            if (data.error == true) {
                printErrorMsg(data.message);
            }else{
                 $('#registration_form')[0].reset();
                $('.kk_error_alert').addClass('d-none');
                $('.kk_success_alert').removeClass('d-none');
                console.log(data.message[0]);
                $('.kk_success_alert').html(data.message[0]);
                // window.location = data.route;
            }
            $('button.submit-btn').prop('disabled', false);
            $('.kk_processing_alert').addClass('d-none');
        }
    });
    });
function printErrorMsg (msg) {

    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}
    </script>
@endsection
