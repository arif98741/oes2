@extends('admin.master')
@section('body')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="{{asset('/')}}assets/admin/plugins/timepicker/tempusdominus-bootstrap-4.css" rel="stylesheet" />
        <link href="{{asset('/')}}assets/admin/plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                       <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Add Module</li>
                    </ol>
                </div>
                <h4 class="page-title">Add module</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <form id="add_module_form">
        @csrf
    <div class="row add-module">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group select-box width-200">
                        <label for="exampleInputName2">Module name</label>
                        <div class="select">
                            <input type="text" class="form-control" id="module_name" name="module_name">
                        </div>
                    </div>
                    <div class="form-group select-box width-200">
                        <label for="exampleInputName2">Module Type</label>
                        <div class="select">
                            <select class="form-control select-hidden" name="module_type" id="module_type">
                                <option value="">Select Type</option>
                                @foreach($module_types as $type)
                                    <option value="{{$type->id}}">
                                        {{$type->module_type}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group select-box width-200" >
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
                    @if(admin_type() == 2 || admin_type() == 1)
                    <div class="form-group select-box width-200" >
                        <label for="exampleInputName2">Semester</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="semester" name="semester">
                                <option value="">Select Semester</option>
                            </select>
                        </div>
                        <span id="student_grade_msg"></span>
                    </div>
                    @endif
                    @if(admin_type() != 5)
                    <div class="form-group select-box width-200" >
                        <label for="exampleInputName2">Section</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="section" name="section">
                                <option value="">Select Section</option>
                            </select>
                        </div>
                        <span id="student_grade_msg"></span>
                    </div>
                    @endif
                    <div class="form-group select-box width-200" >
                        <label for="exampleInputName2">Subject</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check search-module-question" id="subjects" name="subjects">
                                <option value="">Select Subject</option>
                            </select>
                            <input type="hidden" name="type" value="2">
                        </div>
                        <span id="subject_msg"></span>
                    </div>
                    @if(admin_type() == 5 || admin_type() == 1)
                    <div class="form-group select-box width-200" >
                        <label for="exampleInputName2">Batch</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="batch" name="batch">
                                <option value="">Select Batch</option>
                            </select>
                        </div>
                        <span id="student_grade_msg"></span>
                    </div>
                    @endif
                    <div class="form-group select-box">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-success btn-animation" id="save_modal">
                                Save
                            </button>
                        </div>
                    </div>
                    <div class="form-group select-box">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-warning btn-animation" id="sponsor_btn">
                                Sponsor
                            </button>
                        </div>
                    </div>
                    {{--<div class="form-group select-box">--}}
                        {{--<label for="exampleInputName2">&nbsp;</label>--}}
                        {{--<div class="select">--}}
                            {{--<a href="{{route('add_module')}}" class="btn btn-warning btn-animation">--}}
                                {{--Preview--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div> <!-- end col -->
        <div class="modal fade" id="sponsor_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle-1">Sponsor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <textarea class="form-control" name="sponsor" id="summernote">
                            OESর দ্বারা পরিচালিত মডিউল।
                        </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="question_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: 660px!important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle-1">Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="show_message" class="text-center" style="font-size: 15px;text-transform: capitalize;color: #fa0505;"></div>
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul>

                                </ul>
                            </div>
                            <div class="form-group" style="float: left;margin-right: 10px;">
                                <label for="exampleInputName2">Creator Name</label>
                                <div class="select">
                                    <input type="text" class="form-control" name="creator_name" id="creator_name">
                                </div>
                            </div>
                            <div class="form-group select-box" >
                                <label for="exampleInputName2">Exam Date and Time</label>
                                <div class="select">
                                   <input type="text" id="min-date"  name="exam_time"  class="form-control">
                                </div>
                            </div>
                            <div class="form-group select-box" >
                                <label for="exampleInputName2">Exam End Date and Time</label>
                                <div class="select">
                                   <input type="text" id="exam_end_time"  name="exam_end_time"  class="form-control">
                                </div>
                            </div>
                            <div class="form-group" style="float: left;margin-right: 10px;">
                                <label for="exampleInputName2">Exam Duration</label>
                                <div class="select">
                                    <input type="number" class="form-control" name="exam_duration" placeholder="duration as minutes" id="exam_duration">
                                </div>
                            </div>
                            <div class="form-group" style="float: left;margin-right: 10px;">
                                <label for="exampleInputName2">Negative Mark Per Question</label>
                                <div class="select">
                                    <input type="number" class="form-control" name="negative_mark" placeholder="Negative Mark Per Question" value="0" id="negative_mark">
                                </div>
                            </div>
                           <!--  <div class="form-group" style="float: left;margin-right: 10px;">
                                <label for="exampleInputName2">Time (Set as minute not required it's for exam with time)</label>
                                <div class="select">
                                    <input type="text" class="form-control" placeholder="1 min" id="mdate" name="time" data-dtp="dtp_mUBN7">
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row" id="module_question">
                    </div>

                </div>
            </div>
        </div>
    </div>
    </form>
    <script src="{{asset('/')}}assets/admin/plugins/timepicker/moment.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/timepicker/tempusdominus-bootstrap-4.js"></script>
    <script src="{{asset('/')}}assets/admin/plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $('#min-date').bootstrapMaterialDatePicker({
           format : 'MM/DD/YYYY HH:mm', minDate : new Date()
       });
        $('#exam_end_time').bootstrapMaterialDatePicker({
           format : 'MM/DD/YYYY HH:mm', minDate : new Date()
       });

       $("#sponsor_btn").click(function(){
            $("#sponsor_modal").modal('show');
       });
        $(document).ready(function() {
          $('#summernote').summernote({
            tabsize: 2,
                height: 150,
          });
        });
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();

            $.ajax({
                url:'{{ url("/")}}/get-subjects/'+student_grade,
                type:"get",
                dataType:'json',
                success:function(data){
                    $("#subjects").html(data.subject);
                    @if(admin_type() == 2 || admin_type() == 1)
                    $("#semester").html(data.semester);
                    @endif
                    @if(admin_type() != 5)
                    $("#section").html(data.section);
                    @endif
                    @if(admin_type() == 5 || admin_type() == 1)
                    $("#batch").html(data.batch);
                    @endif
                }
            });
        });
        $(".search-module-question").change(function () {
            var student_grade = $("#student_grade").val();
            var subject = $("#subjects").val();
            var question_type = $("#question_type").val();
            console.log(student_grade);
            console.log(subject);
            console.log(question_type);

            var url = '{{route('get_question_for_module')}}';
            $.ajax({
                type:'get',
                url:url,
                data:{student_grade:student_grade,subject:subject,question_type:question_type},
                dataType:'json',
                success:function(response){
                    console.log(response);

                    if (response.error == true)
                    {
                        $("#show_message").html(response.msg);
                    }else {
                        $("#show_message").html('');
                        $("#module_question").html(response.data);
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
        $("#save_modal").click(function () {
            var html = '<ul>';
            var check = 1;
            // if ($("#module_name").val() == '')
            // {
            //     html += '<li>Please Provide module name</li>';
            //     check = 0;
            // }if ($("#module_type").val() == '')
            // {
            //     html += '<li>Please Provide module type</li>';
            //     check = 0;
            // }
            if ($("#student_grade").val() == '')
            {
                html += '<li>Please Select Student level</li>';
                check = 0;
            }if ($("#subjects").val() == '')
            {
                html += '<li>Please Provide subjects</li>';
                check = 0;
            }if ($("#creator_name").val() == '')
            {
                html += '<li>Please Provide module creator name</li>';
                check = 0;
            }
            @if(admin_type() == 2)
            if ($("#semester").val() == '')
            {
                html += '<li>Please Provide semester</li>';
                check = 0;
            }
            @endif
            @if(admin_type() != 5 && admin_type() != 1)
            if ($("#section").val() == '')
            {
                html += '<li>Please Provide section</li>';
                check = 0;
            }
            @endif
            html += '</ul>';
            $("#show_message").html(html);
            if (check == 1)
            {
                var form = $("#add_module_form");
                var url = '{{route('add_modal_data')}}';
                $.ajax({
                    type:'post',
                    url:url,
                    data:form.serialize(),
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                        if($.isEmptyObject(data.error)){
                            $("#add_module_form")[0].reset();
                            $("#message_modal .modal-body").html('Inserted Successfully');
                            $("#message_modal").modal('show');
                            $(".print-error-msg").css('display','none');
                            var url = '{{route('edit_module',[":module_id"])}}';
                            url = url.replace(':module_id',data.success);
                            window.location.href = url;
                        }else{

                            printErrorMsg(data.error);
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
        function printErrorMsg (msg) {

            $(".print-error-msg").find("ul").html('');

            $(".print-error-msg").css('display','block');

            $.each( msg, function( key, value ) {

                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
        $( "body" ).delegate( ".single_question", "click", function() {
            var q_id = $(this).attr('question-id');
            console.log(q_id);
            var url = '{{route('single_question_info')}}';
            $.ajax({
                type:'get',
                url:url,
                data:{question_id:q_id},
                dataType:'json',
                success:function(response){
                    console.log(response);
                    $("#question_modal .modal-body").html(response.view);
                    $('#question_modal').modal('show');
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
        // question_modal
    </script>
@endsection
