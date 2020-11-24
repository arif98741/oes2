@extends('admin.master')
@section('body')
    <style xmlns="http://www.w3.org/1999/html">
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
                        <li class="breadcrumb-item active">True false</li>
                    </ol>
                </div>
                <h4 class="page-title">Question Type</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <form id="question_form" action="{{route('update_question',$question->id)}}" method="post">
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
                                        <option @php echo ($level->id == $question->student_grade) ? 'selected' : '' @endphp value="{{$level->id}}">
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
                                <select class="form-control select-hidden form-check" id="subject" name="subject">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option @php echo ($subject->id == $question->subject) ? 'selected' : '' @endphp value="{{$subject->id}}">
                                            {{$subject->subject_name}}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="type" value="1">
                                <input type="hidden" name="question_id" value="{{$question->id}}">
                            </div>
                            <span id="subject_msg"></span>
                        </div>
                        {{--<div class="form-group" style="float: left;margin-right: 10px;">--}}
                            {{--<label for="exampleInputName2">Chapter</label>--}}
                            {{--<div class="select">--}}
                                {{--<select class="form-control select-hidden" name="studentgrade">--}}
                                    {{--<option value="">Select Chapter</option>--}}
                                    {{--<option value="1">--}}
                                        {{--1--}}
                                    {{--</option>--}}
                                    {{--<option value="2">--}}
                                        {{--2--}}
                                    {{--</option>--}}
                                    {{--<option value="3">--}}
                                        {{--3--}}
                                    {{--</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
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
                                    Update
                                </button>
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
                            <input type="number" class="form-control form-check" min="1" value="{{$question->mark}}" id="mark_value" placeholder="Set Question Mark" name="question_mark">
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
                            <textarea class="form-control form-check" rows="5" id="explanation_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="explanation">{{$question->question_description}}</textarea>
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
                            <textarea class="form-control form-check"  rows="5" id="question_name_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="question_name">{{$question->question_name}}</textarea>
                        </div>
                        <span id="question_name_msg"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body" style="margin: auto">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="q-btn-bg">True</div>
                        <div style="align-items: center;display: flex;">
                            <input  type="radio" @php echo ($question->answer == 1) ? 'checked' : '' @endphp name="answer" value="1" style="text-align: center;font-size: 24px;">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="q-btn-bg">False</div>
                        <div style="align-items: center;display: flex;">
                            <input  type="radio" @php echo ($question->answer == 0) ? 'checked' : '' @endphp name="answer" value="0" style="text-align: center;font-size: 24px;">
                        </div>
                    </div>
                    <span id="answer_msg"></span>
                </div>
            </div>
        </div>
    </div>
        <input type="hidden" name="image_quantity" id="image_quantity" value="2">
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
    </script>
    {{--<script>--}}

        {{--$("#save").click(function (e) {--}}
            {{--e.preventDefault();--}}
            {{--var form = $("#question_form");--}}
            {{--console.log(form);--}}
            {{--var url = '{{route('save_question')}}';--}}
            {{--$.ajax({--}}
                {{--// type:'POST',--}}
                {{--url:url,--}}
                {{--data:form.serialize(),--}}
                {{--dataType:'json',--}}
                {{--success:function(response){--}}
                    {{--console.log(response);--}}
                {{--},--}}
                {{--error: function(data){--}}
                    {{--console.log(data);--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
@endsection
