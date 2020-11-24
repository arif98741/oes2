@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Question Type</li>
                    </ol>
                </div>
                <h4 class="page-title">Question Type</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-5" style="margin: auto;">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col" >Type Name</th>
                                <th scope="col">Total Question</th>
                            </tr>
                            </thead>
                            <tbody class="question-t-body">
                            @foreach($question_types as $type)
                            <tr >
                                <th scope="row" style="background: #76e2cc;"><a style="color:#212529;" href="{{route('create_question',$type->id)}}">{{$type->type}}</a></th>

                                <th class="total-question">
                                    {{QuestionTypeCount($type->id)}}
                                </th>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form id="question_search">
                        @csrf
                        <div class="alert alert-info kk_alert kk_processing_alert" role="alert">
                            <p class="text-center">Processing...</p>
                        </div>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul>

                            </ul>
                        </div>
                        <div class="form-group" style="float: left;margin-right: 10px;max-width: 150px;">
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
                        <div class="form-group" style="float: left;margin-right: 10px;max-width: 150px;">
                            <label for="exampleInputName2">Subject</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="subjects" name="subjects">
                                    <option value="">Select Subject</option>
                                </select>
                                <input type="hidden" name="type" value="2">
                            </div>
                            <span id="subject_msg"></span>
                        </div>
                        <div class="form-group" style="float: left;margin-right: 10px;max-width: 150px;">
                            <label for="exampleInputName2">Type</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="question_type" name="type">
                                    <option value="">Select Type</option>
                                    @foreach($question_types as $type)
                                        <option value="{{$type->id}}">
                                            {{$type->type}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="float: left;margin-right: 10px;">
                            <label for="exampleInputName2">&nbsp;</label>
                            <div class="select">
                                <button type="button" class="btn btn-success btn-animation" id="search_btn">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive-sm">
                        <table class="table" id="search_question_result">
                            <thead>
                            <tr>
                                <th scope="col" >SL</th>
                                <th scope="col" >Question</th>
                                <th scope="col">Type</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="result_question">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--end row-->
    <script>
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();
            if(student_grade != '')
            {
               $.ajax({
                    url:'{{ url("/")}}/get-subjects/'+student_grade,
                    type:"get",
                    dataType:'json',
                    success:function(data){
                        $("#subjects").html(data.subject);
                    }
                });
            }

        });
        $("#search_btn").click(function () {

            var student_grade = $("#student_grade").val();
            var subject = $("#subjects").val();
         if (student_grade == '' || student_grade == 'Select Level')
         {
             $("#student_grade_msg").html('Please Provide Level');
             return false;
         }else {
             $("#student_grade_msg").html('');
         }
         if (subject == '' || subject == 'Select Subject')
         {
             $("#subject_msg").html('Please Provide Subject');
             return false;
         }else {
             $("#subject_msg").html('');
         }
            var form = $("#question_search");
            var url = '{{route('question_search')}}';
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'html',
                success:function(response){
                    console.log(response);
                    $("#result_question").html(response);
                },
                error: function(data){
                    // alert('Some Thing are missing.')
                }
            });
        });
    </script>
@endsection
