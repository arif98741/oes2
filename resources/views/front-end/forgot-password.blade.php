@extends('front-end.master')
@section('body')
    <div class="row">
        <div class="col-md-6 m-auto">
             <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Forgot Password
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
            @if(Session::get('access_error'))
                <div class="alert alert-danger">
                    {{Session::get('access_error')}}
                </div>
            @endif
                <form class="form-horizontal" action="{{route('forgot_password')}}" method="post">
                    @csrf
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    @if(Session::get('error'))
                        <div class="alert alert-danger">
                            {{Session::get('error')}}
                        </div>
                    @endif
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
                    <div style="text-align: right;">
                        <a href="{{route('login')}}">Login</a>
                        <button class="btn btn-sm btn-primary submit-btn" type="submit">
                            <i class="fa fa-dot-circle-o"></i> Submit</button>
                    </div>
                </form>
        <!-- /.row-->
        </div>
    </div>
        </div>
    </div>
@endsection
