@extends('admin.master')
@section('body')
<style type="text/css">
    #search_question_result th{
        text-align: center;
    }#search_question_result td{
        text-align: center;
    }
</style>
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
                        <div class="alert alert-info kk_alert kk_processing_alert text-center" role="alert">
                            Processing...
                        </div>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul>

                            </ul>
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
                    @if(admin_type() == 2)
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
                    @if(admin_type() != 5 && admin_type() != 1)
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
                        </div>
                        <span id="subject_msg"></span>
                    </div>
                    <div class="form-group select-box width-200" >
                        <label for="exampleInputName2">Module</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check search-module-question" id="module" name="module">
                                <option value="">Select Module</option>
                            </select>
                        </div>
                        <span id="subject_msg"></span>
                    </div>
                    <div class="form-group select-box width-200" >
                        <label for="exampleInputName2">Top</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check search-module-question" id="top" name="top">
                                <option value="all">all</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="5">50</option>
                                <option value="100">100</option>

                            </select>
                        </div>
                        <span id="subject_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 5px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-danger btn-animation search_btn">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 5px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-warning btn-animation generate_pdf">
                                Generate PDF
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="modules_content">

                </div>
            </div>
        </div>
    </div>
    <script>
        $(".kk_processing_alert").hide();
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();
            if(student_grade != '')
            {
                $(".kk_processing_alert").show();
                $.ajax({
                url:'{{ url("/")}}/get-subjects/'+student_grade,
                type:"get",
                dataType:'json',
                success:function(data){
                    $(".kk_processing_alert").hide();
                    $("#subjects").html(data.subject);
                    @if(admin_type() == 2)
                    $("#semester").html(data.semester);
                    @endif
                    @if(admin_type() != 5 && admin_type() != 1)
                    $("#section").html(data.section);
                    @endif
                }
            });
            }
        });
        $("#subjects").change(function () {
            var form = $("#module_search_form");
            $(".kk_processing_alert").show();
            $.ajax({
                type:'post',
                url:'{{route('get_modules')}}',
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                    $(".kk_processing_alert").hide();
                    if($.isEmptyObject(data.error)){
                        $("#module").html(data.success);
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

        $(".search_btn").click(function (e) {
            e.preventDefault();
            var form = $("#module_search_form");
            var url = '{{route('module_report_generate')}}';
            $(".kk_processing_alert").show();
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                   $(".kk_processing_alert").hide();
                    if($.isEmptyObject(data.error)){

                        $("#modules_content").html(data.success.view);
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
        $(".generate_pdf").click(function (e) {
            e.preventDefault();
            var form = $("#module_search_form");
            var url = '{{route('module_generate_pdf')}}';
            $(".kk_processing_alert").show();
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                   $(".kk_processing_alert").hide();
                    if($.isEmptyObject(data.error)){
                        Popup(data.success.view);
                        // $("#modules_content").html(data.success.view);
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
        function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
//Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
    </script>
@endsection
