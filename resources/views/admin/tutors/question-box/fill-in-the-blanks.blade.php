@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Multiple Choice</li>
                    </ol>
                </div>
                <h4 class="page-title">Question Type</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <form id="question_form" action="{{route('save_question')}}" method="post">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Level</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="student_grade" name="student_grade">
                                <option value="">Select Level</option>
                                @foreach($levels as $level)
                                    <option value="{{$level->id}}">
                                        {{$level->level_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="student_grade_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Subject</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="subjects" name="subjects">
                                <option value="">Select Subject</option>
                            </select>
                            <input type="hidden" name="type" value="5">
                        </div>
                        <span id="subject_msg"></span>
                    </div>

                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-danger btn-animation" data-animation="slideInDown" data-toggle="modal" data-target="#exampleModalLong-1">
                                Mark
                            </button>
                        </div>
                        <span id="mark_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-success btn-animation" id="Explanation">
                                Explanation
                            </button>
                        </div>
                        <span id="explanation_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="submit" class="btn btn-success btn-animation" id="save">
                                Save
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                            <label for="exampleInputName2">&nbsp;</label>
                            <div class="select">
                                <a class="btn btn-warning" href="{{route('manage_question_type',5)}}">Back</a>
                            </div>
                        </div>
                    <!-- <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-warning btn-animation">
                                Preview
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div> <!-- end col -->
        <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle-1">Question mark</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label class="mb-2 pb-1">Mark</label>
                            <input type="number" class="form-control form-check" min="1" id="mark_value" placeholder="Set Question Mark" value="1" name="question_mark">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Set</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="details" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle-1">Question Explanation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label class="mb-2 pb-1">Explanation</label>
                            <textarea class="form-control form-check" rows="5" id="explanation_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="explanation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Set</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @if ($errors->any() || Session::get('success_message'))
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

                            @if(Session::get('success_message'))
                                <div class="alert alert-success">
                                    {{Session::get('success_message')}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endif
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="my-2 py-1">Question</label>
                        <div>
                            <textarea class="form-control form-check" rows="5" id="question_name_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="question_name"></textarea>
                        </div>
                        <span id="question_name_msg"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="my-2 py-1">Answer</label>
                        <div>
                            <input class="form-control" id="answer" name="answer">
                        </div>
                        <span id="answer_msg"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('question_name_value');
    </script>
    <script>
        $("#Explanation").click(function () {
            $("#details").modal('show');
        });
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();

            $.ajax({
                url:'{{ url("/")}}/get-subjects/'+student_grade,
                type:"get",
                dataType:'json',
                success:function(data){
                    $("#subjects").html(data.subject);
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

        $("#save").click(function(e){
            e.preventDefault();
            var field = [];
            var msg_id = [];
            field[0] = 'student_grade';
            field[1] = 'subject';
            field[2] = 'mark_value';
            field[3] = 'answer';
            msg_id[0] = 'student_grade_msg';
            msg_id[1] = 'subject_msg';
            msg_id[2] = 'mark_msg';
            msg_id[3] = 'answer_msg';
            var check = 0;
            var length = field.length;
            for (var i=0;i<length;i++)
            {
                var value = $("#"+field[i]).val();
                if (value == '')
                {
                    $("#"+msg_id[i]).html("This field can't empty!");
                    $("#"+msg_id[i]).css("color","#f10a0a");

                    check = 1;
                }else
                {
                    $("#"+msg_id[i]).html('');
                }
            }
            var desc = CKEDITOR.instances.question_name_value.getData();
            console.log(desc);
            if(desc == '')
            {
                $("#question_name_msg").html("This field can't empty!");
                $("#question_name_msg").css("color","#f10a0a");
                return false;
            }else{

                $("#question_name_msg").html("");

            }
            if(check != 0)
            {
                return false;
            }else{

               $("#question_form").submit();
            }

        });
    </script>
@endsection
