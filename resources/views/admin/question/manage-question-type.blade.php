@extends('admin.master')
@section('body')
<style type="text/css">
    .pagination{
        justify-content: center;
    }
</style>
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
        <div class="col-lg-12" style="margin: auto;">
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
                        <div class="form-group" style="float: left;margin-right: 10px;width: 200px;">
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
                        <div class="form-group" style="float: left;margin-right: 10px;width: 200px;">
                            <label for="exampleInputName2">Subject</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="subjects" name="subjects">
                                    <option value="">Select Subject</option>
                                </select>
                                <input type="hidden" name="type" value="2">
                            </div>
                            <span id="subject_msg"></span>
                        </div>
                        <div class="form-group" style="float: left;margin-right: 10px;width: 200px;">
                            <label for="exampleInputName2">Type</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="question_type" name="type">
                                    <option value="">Select Type</option>
                                    @foreach($question_types as $q_type)
                                        <option value="{{$q_type->id}}">
                                            {{$q_type->type}}
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
                        <div class="form-group" style="float: left;margin-right: 10px;">
                            <label for="exampleInputName2">&nbsp;</label>
                            <div class="select">
                                <a href="{{route('create_question',$type)}}" class="btn btn-primary">Create Question</a>
                            </div>
                        </div>
                        <div class="form-group" style="float: left;margin-right: 10px;">
                            <label for="exampleInputName2">&nbsp;</label>
                            <div class="select">
                                <a href="{{route('manage_question')}}" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </form>
                    <div id="question_content">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--end row-->
<script>
$('.kk_processing_alert').hide();
$('#loading').hide();
$(function() {
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            getStock(url);
            $('#loading').show();
        });
    function getStock(url) {
        var form = $("#question_search");
        $.ajax({
            type:"POST",
            url : url,
            data:form.serialize(),
        }).done(function (data) {
            $('#loading').hide();
            $('#question_content').html(data);
        }).fail(function () {
            $('#loading').hide();
            alert('Data could not be loaded.');
        });
    }
});
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();
            if(student_grade != '')
            {
                $('.kk_processing_alert').show();
               $.ajax({
                    url:'{{ url("/")}}/get-subjects/'+student_grade,
                    type:"get",
                    dataType:'json',
                    success:function(data){
                        $('.kk_processing_alert').hide();
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
         $('.kk_processing_alert').show();
            var form = $("#question_search");
            var url = '{{route('question_search')}}';
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'html',
                success:function(response){
                    $('.kk_processing_alert').hide();
                    if($.isEmptyObject(response.error)){
                        console.log(response)
                        $("#question_content").html(response);
                        $(".print-error-msg").css('display','none');
                    }else{
                        printErrorMsg(response.error);
                    }
                },
                error: function(data){
                    // alert('Some Thing are missing.')
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
