@extends('front-end.master')
@section('body')
    <style>
        .text-transform-ca{
            text-transform:capitalize;
        }
        .text-right{
            text-align: right;
        }
    </style>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Profile
            <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <form class="form-horizontal" action="" method="post" id="basic_info_form">
                            @csrf
                            <div class="card-header">
                                <strong class="text-transform-ca">{{$user_info->name}}</strong>
                            </div>
                            <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="hf-email">Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="name" type="text"  value="{{$user_info->name}}" name="name" placeholder="Enter Your Name">
                                            <span id="name_msg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="hf-email">Email</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="email" readonly value="{{$user_info->email}}" type="email" name="email" placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="hf-email">Phone</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="phone" value="{{$user_info->user_mobile}}" type="number" name="phone" placeholder="Enter Your Phone">
                                            <span id="phone_msg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="select1">Level</label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="level" name="level">
                                                @foreach($levels as $level)
                                                <option @php echo ($level->id == $user_info->student_grade) ? 'selected' : '' ; @endphp value="{{$level->id}}">{{$level->level_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="level_msg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="select1">District</label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="district" name="district">
                                                @foreach($districts as $district)
                                                <option @php echo ($district->id == $user_info->district_id) ? 'selected' : '' ; @endphp value="{{$district->id}}">{{$district->bn_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="district_msg"></span>
                                        </div>
                                    </div>
                                    <!--<div class="form-group row">
                                        <label class="col-md-4 col-form-label">Two Step Verification</label>
                                        <div class="col-md-8 col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" type="radio" name="two_step_verification" @php echo ($user_info->two_step_verification == 1) ? 'checked' : '' ; @endphp type="checkbox" value="1">
                                                <label class="form-check-label" for="inline-checkbox1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" type="radio" name="two_step_verification" @php echo ($user_info->two_step_verification == 0) ? 'checked' : '' ; @endphp  type="checkbox" value="0">
                                                <label class="form-check-label" for="inline-checkbox2">No</label>
                                            </div>
                                        </div>
                                    </div>-->

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-sm btn-primary basic_info_btn" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="text-transform-ca">Change Password</strong></div>
                        <div class="card-body">
                            <form class="form-horizontal" action="" id="password_form" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="hf-email">Old Password</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="old_password" type="text"  name="old_password" placeholder="Enter Your Old Password">
                                        <span style="color: red;" id="old_password_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="hf-email">New Password</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="password"  type="password" name="password" placeholder="Enter Your New Password">
                                        <span style="color: red;" id="password_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="hf-email">Confirm Password</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="c_password"  type="password" name="c_password" placeholder="Enter Your New Password">
                                        <span style="color: red;" id="c_password_error"></span>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                            <button class="btn btn-sm btn-primary" id="password_btn" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                            </form>

                        </div>
                        
                    </div>
                    <!-- <div class="card">
                        <div class="card-header">
                            <strong class="text-transform-ca">Change Image</strong></div>
                        <div class="card-body">
                            <form class="form-horizontal" action="" method="post">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="file-input"></label>
                                    <div class="col-md-9">
                                        <img src="@if(empty($user_info->image)){{url('assets/front-end/images/default-image/default-three.jpg')}}@else{{url("/")}}@endif" height="150" width="173">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="file-input">New Image</label>
                                    <div class="col-md-9">
                                        <input id="image" type="file" name="image">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                    </div> -->
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="text-transform-ca">Update Profile Picture</strong></div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{route('update_picture')}}" id="picture_form" method="post" enctype="multipart/form-data">
                                @csrf
                                <p class="alert alert-info kk_processing_alert" style="display:none" role="alert">processing...</p>
                                <p class="alert alert-success kk_success_alert" style="display:none" role="alert"></p>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul>
                                    </ul>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="hf-email">Profile Picture</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="picture" type="file"  name="picture" accept="image/*">
                                        @if($user_info->image != '')
                                            <img src="{{asset('/')}}{{$user_info->image}}" style="width:100px;">
                                        @else
                                            <img src="{{asset('/')}}assets/user-default.png" style="width:100px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                            <button class="btn btn-sm btn-primary" id="picture_btn" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row-->
        </div>
    </div>

    <script>
        $("#basic_info_form").on('submit', function(e) {
            e.preventDefault();
            var form = $("#basic_info_form");
            var field = [];
                field[0] = 'name';
                field[1] = 'email';
                field[2] = 'level';
                field[3] = 'district';
                var length = field.length;
                for (var i = 0;i<length;i++)
                {
                    var value = $("#"+field[i]).val();
                    if (value == '')
                    {
                        $("#"+field[i]+'_msg').css("color","red");
                        $("#"+field[i]+'_msg').html("This data can't be changed if you empty it.");
                        return false;
                    }else{
                        $("#"+field[i]+'_msg').html('');
                    }
                }
            var form = $("#basic_info_form");
            var url = '{{route('update_user_info')}}';
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                    console.log(data);
                    location.reload();

                }
            });
        });

         $("#password_form").on('submit', function(e) {
            e.preventDefault();
             var form = $("#password_form");
            var field = [];
                field[0] = 'old_password';
                field[1] = 'password';
                var length = field.length;
                for (var i = 0;i<length;i++)
                {
                    var value = $("#"+field[i]).val();
                    if (value == '')
                    {
                        $("#"+field[i]+'_error').css("color","red");
                        $("#"+field[i]+'_error').html("This data can't be changed if you empty it.");
                        return false;
                    }else{
                        $("#"+field[i]+'_msg').html('');
                    }
                }
            var password = $("#password").val();
            var c_pass = $("#c_password").val();
            if (password == c_pass)
            {
                $("#c_password_error").css("color","red");
                $("#c_password_error").html("");
            }else {
                
                $("#c_password_error").css("color","red");
                $("#c_password_error").html("Confirm password don't matched.");
                return false;
            }
            var form = $("#password_form");
            var url = '{{route('change_user_password')}}';
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if (data.status == 1) {
                        alert(data.msg);
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                    

                }
            });
        });
         $("#picture_form").on('submit', function(e) {
            e.preventDefault();
            $("#picture_btn").prop('disabled', true);
            $('.kk_processing_alert').show();
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
                    } else{
                        $('.kk_error_alert').hide();
                        $('.kk_success_alert').show();
                        $('.kk_success_alert').html(data.message);
                        location.reload();
                    }

                    $('#picture_btn').prop('disabled', false);
                    $('.kk_processing_alert').hide();
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
