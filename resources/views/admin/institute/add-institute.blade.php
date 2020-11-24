@extends('admin.master')
@section('body')
    <style >
        .q-btn-bg{
            width: 40px;
        }
        .close-btn{
            padding: 10px;
            border-radius: 75%;
            background: #eaeef1;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Add Institute</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Institute</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if ($errors->any() || Session::get('success')|| Session::get('error'))
        <div class="row error-message">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: right;padding: 10px;"><span class="close-btn">x</span></div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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

                    </div>
                </div>
            </div>
        </div>
    @endif
    <form id="question_form" action="{{route('add_institute')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Institute Name</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="institute_name" placeholder="Institute name">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Principal Name</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="principal_name" placeholder="Principal name">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Principal Email</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="principal_email" placeholder="Principal email">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Principal Phone</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="principal_phone" placeholder="Principal Phone">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Admin Email</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="admin_email" placeholder="Admin email">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Admin phone</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="admin_phone" placeholder="Admin phone">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Admin password</label>
                                    <div class="select row">
                	                        <div class="col-lg-9">
                	                           <input type="text" class="form-control" value="" id="password" name="password" placeholder="Enter password">
                	                         </div>
                                             <div class="col-lg-3">
                                                 <button type="button" onclick="makeid(8)" class="btn btn-primary">Generate</button>
                                             </div>
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Address</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="address" placeholder="Address">
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputName2">Institute Type</label>
                                    <div class="select">
                                        <select class="form-control select-hidden form-check"  name="type">
                                            @foreach($institute_types as $institute_type)
                                            <option value="{{$institute_type['id']}}">{{$institute_type['name']}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputName2">Status</label>
                                    <div class="select">
                                        <select class="form-control select-hidden form-check"  name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="form-group" >
                                    <div class="select">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                    <span id="student_grade_msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </form>

    <script>
        $("#Explanation").click(function () {
            $("#details").modal('show');
        });
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();

            $.ajax({
                url:'{{ url("/")}}/get-subjects/'+student_grade,
                type:"get",
                dataType:'html',
                success:function(data){
                    $("#subjects").html(data);
                }
            });
        });

        $(".close-btn").click(function () {
            $(".error-message").hide();
        });
        $(".form-check").change(function () {
            var field = [];
            var msg_id = [];
            field[0] = 'student_grade';
            field[1] = 'subject';
            field[2] = 'mark_value';
            field[3] = 'question_name_value';
            msg_id[0] = 'student_grade_msg';
            msg_id[1] = 'subject_msg';
            msg_id[2] = 'mark_msg';
            msg_id[3] = 'question_name_msg';
            var msg_name = [];
            msg_name[0] = 'student level';
            msg_name[1] = 'subject';
            msg_name[2] = 'question mark';
            msg_name[3] = 'Question';
            var length = field.length;
            for (var i=0;i<length;i++)
            {
                var value = $("#"+field[i]).val();
                if (value == '')
                {
                    $("#"+msg_id[i]).html('Please provide '+msg_name[i]);
                    $("#"+msg_id[i]).css("color","#f10a0a");
                }else
                {
                    $("#"+msg_id[i]).html('');
                }
            }
        });
          function makeid(length) {
     var result           = '';
     var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
     var charactersLength = characters.length;
     for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
     }

     $("#password").val(result);
  }
    </script>

@endsection
