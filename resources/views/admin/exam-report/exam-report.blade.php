@extends('admin.master')
@section('body')
<link href="{{asset('/')}}assets/admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Exam Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Exam Report</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="module_search_form" action="{{route('exam_report')}}" method="post">
                        @csrf
                    <div class="form-group select-box width-200">
                        <label for="exampleInputName2">Module Type</label>
                        <div class="select">
                            <select class="form-control select-hidden" name="module_type" id="module_type">
                                <option value="0">Select Type</option>
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
                                    <option value="0">Select Semester</option>
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
                                    <option value="0">Select Section</option>
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
                    <div class="form-group select-box width-200" >
                            <label for="exampleInputName2">Date</label>
                            <div class="select">
                               <input type="text" autocomplete="off" id="exam_date" value="" name="exam_date"  class="form-control">
                            </div>
                            <span id="student_grade_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 5px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="submit" class="btn btn-danger btn-animation search_btn">
                                Search
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
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

    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/dataTables.bootstrap.min.js"></script>
    <script src="{{asset('/')}}assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
       jQuery('#exam_date').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    </script>
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
                    @if(admin_type() == 2 || admin_type() == 1)
                    $("#semester").html(data.semester);
                    @endif
                    @if(admin_type() != 5)
                    $("#section").html(data.section);
                    @endif
                }
            });
            }
        });

        $(".search_btnnn").click(function () {

            var form = $("#module_search_form");
            var url = '{{route('exam_report')}}';
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if($.isEmptyObject(data.error)){

                        $("#module_list_data").html(data.success);
                        $(".print-error-msg").css('display','none');
                    }else{

                        printErrorMsg(data.error);
                    }
                },
                error: function(data){
                    console.log(data);
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
