@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Contact
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
    <div class="row">
        <div class="col-md-7">
            <form class="form-horizontal" action="{{route('contact')}}" method="post" id="contact_form">
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
                <label class="col-md-3 col-form-label" for="name">Name</label>
                <div class="col-md-9">
                    <input class="form-control" id="name" autocomplete="off" type="text" name="name" placeholder="enter name">
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
                <label class="col-md-3 col-form-label" for="email">Message</label>
                <div class="col-md-9">
                    <textarea class="form-control" id="message" rows="7" autocomplete="off" name="message" placeholder="enter message"></textarea>
                    <span class="message_msg "></span>
                    @error('message')
                    <div style="color: #ef0d0d;">{{ $message }}</div>
                    @enderror
                </div>
            </div>                 
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="district"></label>
                <div class="col-md-4">
                    <div class="g-recaptcha"data-sitekey="6LdnedsZAAAAAHoM_eG-_-GpbXKKn6SBfHSy61rF">
                    </div>
                    @error('g-recaptcha-response')
                    <div style="color: #ef0d0d;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div style="text-align: right;">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i> Submit</button>
            </div>  
        </form>
        </div>
    </div>
</div>
</div>
@endsection
