@extends('admin.master')
@section('body')
<link href="{{asset('/')}}assets/admin/plugins/timepicker/tempusdominus-bootstrap-4.css" rel="stylesheet" />
        <link href="{{asset('/')}}assets/admin/plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Add Assignment</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Assignment</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>


        <form id="add_assignment_form" enctype="multipart/form-data" method="post">
        @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8" style="margin:auto;">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul>

                            </ul>
                        </div>
                        <div class="progress" style="display: none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">Loading...
                            </div>
                        </div>
                    </div>
                    </div>
                <div class="row" style="align-items: center;">

                    <div class="col-md-4">

                    <div class="form-group" >
                        <label for="exampleInputName2">Level</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="student_grade" name="student_grade">
                                    <option value="">Select Level</option>
                                    @foreach($levels as $level)
                                        <option @php echo($assignment->student_grade == $level->id) ? 'selected' : ''; @endphp value="{{$level->id}}">
                                            {{$level->level_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        <span id="student_grade_msg"></span>
                        </div>
                        @if(admin_type() == 2 || admin_type() == 1)
                        <div class="form-group" >
                            <label for="exampleInputName2">Semester</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="semester" name="semester">
                                    <option value="">Select Semester</option>
                                    @foreach($semesters as $semester)
                                        <option @php echo($assignment->semester == $semester->id) ? 'selected' : ''; @endphp value="{{$semester->id}}">
                                            {{$semester->semester_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="student_grade_msg"></span>
                        </div>
                        @endif
                        @if(admin_type() != 5)
                        <div class="form-group " >
                            <label for="exampleInputName2">Section</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check" id="section" name="section">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option @php echo($assignment->section == $section->id) ? 'selected' : ''; @endphp value="{{$section->id}}">
                                            {{$section->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="student_grade_msg"></span>
                        </div>
                        @endif
                        <div class="form-group " >
                            <label for="exampleInputName2">Subject</label>
                            <div class="select">
                                <select class="form-control select-hidden form-check search-module-question" id="subjects" name="subjects">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option @php echo($assignment->subjects == $subject->id) ? 'selected' : ''; @endphp value="{{$subject->id}}">
                                            {{$subject->subject_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="subject_msg"></span>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputName2">Assignment Title</label>
                        <div class="select">
                            <input type="text" class="form-control" id="title" value="{{$assignment->title}}" name="title">
                        </div>
                    </div>
                    <div class="form-group " >
                        <label for="min-date">Exam Start Date and Time</label>
                        <div class="select">
                            <input type="text" id="min-date"  value="{{date('m/d/Y H:i',$assignment->exam_start)}}" name="exam_start"  class="form-control">
                        </div>
                    </div>
                    <div class="form-group " >
                        <label for="exam_end">Exam Duration Minutes </label>
                        <div class="select">
                            <input type="text" id="exam_end" value="{{($assignment->exam_end - $assignment->exam_start) / 60}}" name="exam_end" placeholder="Enter duration minutes "  class="form-control">
                        </div>
                    </div>
                    <div class="form-group " >
                        <label for="assignment">Assignment</label>

                        <div class="select">
                            <input type="file" id="assignment" name="assignment"   class="form-control">
                        </div>
                    </div>
                 </div>
                 <div class="col-md-4 text-center">
                    <a class="btn btn-primary btn-sm" href="{{url('/')}}/{{$assignment->assignment}}" target="_blank">Click here to view Assignment</a>
                </div>
                </div>

                <div class="col-md-10 text-right">
                    <button class="btn btn-primary btn-sm" id="save_assignment">Save</button>
                </div>
                </div>
            </div>
        </form>
        <br/>
        <br/>
        <div class="row">
        </div>
    <script src="{{asset('/')}}assets/admin/plugins/timepicker/moment.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/timepicker/tempusdominus-bootstrap-4.js"></script>
    <script src="{{asset('/')}}assets/admin/plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
    <script>
        $('#min-date').bootstrapMaterialDatePicker({
           format : 'MM/DD/YYYY HH:mm', minDate : new Date()
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
                }
            });
        });
       $("#add_assignment_form").on('submit', function(e) {
        e.preventDefault();
        $(".progress").show();
        $.ajax({
            type:"POST",
            url: '{{route('edit_assignment',$assignment->id)}}',
            dataType:'json',
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            success:function(data){
                $(".progress").hide();
                if($.isEmptyObject(data.error)){

                    $(".print-error-msg").css('display','none');
                    alert('Assignment Successfully Updated.');
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
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
        // question_modal
    </script>
@endsection
