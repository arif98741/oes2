@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="row">
        <div class="col-md-6 m-auto">
             <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i> @if(Session::get('verification') || Session::get('error')) Email Verification @endif @if(!Session::get('verification') && !Session::get('error')) login @endif
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
        </style>
        <div class="card-body">
            
            @if(Session::get('error'))
                        <div class="alert alert-danger">
                            {{Session::get('error')}}
                        </div>
                    @endif
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
            
                <form class="form-horizontal" action="{{route('login')}}" method="post" id="login_form" >
                    @csrf
                    @if(Session::get('success_message'))
                        <div class="alert alert-danger">
                            {{Session::get('success_message')}}
                        </div>
                    @endif
                    <div class="alert alert-info kk_alert kk_processing_alert d-none" role="alert">
                        <p class="text-center">Processing...</p>
                    </div>
                    <div class="alert alert-success kk_alert kk_success_alert_f d-none" role="alert"></div>
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul>
                        </ul>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="email">Email</label>
                        <div class="col-md-9">
                            <input class="form-control" id="email" type="email" name="email" placeholder="Enter email">
                            <span class="email_msg color-red error-msg"></span>
                            @error('email')
                            <div style="color: #ef0d0d;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="password">Password</label>
                        <div class="col-md-9">
                            <input class="form-control" id="password"  type="password" name="password" placeholder="Enter password">
                            <span class="password_msg color-red error-msg"></span>
                            @error('password')
                            <div style="color: #ef0d0d;">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div style="text-align: right;">
                        <a href="{{route('forgot_password')}}">Forgot password?</a>
                        <button class="btn btn-sm btn-primary submit-btn" type="submit">
                            <i class="fa fa-dot-circle-o"></i> Submit</button>
                    </div>
                </form>
        <!-- /.row-->
        </div>
    </div>
        </div>
    </div>
    <script>
    $("#login_form").on('submit', function(e) {
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
                $('.kk_error_alert').addClass('d-none');
                $('.kk_success_alert').removeClass('d-none');
                $('.kk_success_alert').html(data.message);
                window.location = data.route;
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
