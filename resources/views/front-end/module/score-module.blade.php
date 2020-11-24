@extends('front-end.master')
@section('body')
<style>

            #table-content a{
                text-decoration: none;
                color: #2f353a;
            }
            .card-body h5{
                padding: 10px;
            }
            .card-body h5 span{
                color: #1d9bc6;
            }
            .card-body th {
                padding: 10px 10px !important;
            }
            .card-body td {
                padding: 10px 10px !important;
            }
        </style>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Dear <span class="text-capitalize">{{$student_info->name}}</span>.Your all exam score.
            <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="alert alert-info kk_alert kk_processing_alert" role="alert">
                                    <p class="text-center">Processing...</p>
                                </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul>

                    </ul>
                </div>
            <div class="row">
                <div class="col-md-4">
                    <form id="search_level_by_inst" method="post">
                        @csrf
                        <div class="form-group">
                        <label for="name">Institute</label>
                        <select class="form-control" id="institute_type" name="institute_type">
                            <option value="">Select Institute</option>
                            @foreach($instraction_types as $type)
                            <option value="{{$type['id']}}"> {{$type['name']}} </option>
                            @endforeach
                        </select>
                    </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form id="search_subject_by_level" method="post">
                        @csrf
                        <div class="form-group">
                        <label for="name">Level</label>
                        <select class="form-control" id="level" name="level">
                            <option value="">Select level</option>
                        </select>
                    </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form id="search_student_answer" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Subject Name</label>
                            <select class="form-control" id="subject" name="subject">
                            <option value="">Select Subject</option>
                        </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover" id="module_result">
                        
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row-->
        </div>
    </div>

    <script>
        $('.kk_processing_alert').hide();
        $("#institute_type").change(function(){
            var form = $("#search_level_by_inst");
            $('.kk_processing_alert').show();
            $.ajax({
                type:"POST",
                url: '{{route('search_level_by_inst')}}',
                dataType:'json',
                data:form.serialize(),
                success:function(data){
                    $('.kk_processing_alert').hide();
                    if($.isEmptyObject(data.error)){
                        $("#level").html(data.success);
                        $(".print-error-msg").css('display','none');

                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        $("#level").change(function(){
            var form = $("#search_subject_by_level");
            $('.kk_processing_alert').show();
            $.ajax({
                type:"POST",
                url: '{{route('search_subject_by_level')}}',
                dataType:'json',
                data:form.serialize(),
                success:function(data){
                    $('.kk_processing_alert').hide();
                    if($.isEmptyObject(data.error)){
                        $("#subject").html(data.success);
                        $(".print-error-msg").css('display','none');

                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        $("#subject").change(function(){
            var form = $("#search_student_answer");
            $('.kk_processing_alert').show();
            $.ajax({
                type:"POST",
                url: '{{route('search_student_answer')}}',
                dataType:'json',
                data:form.serialize(),
                success:function(data){
                    $('.kk_processing_alert').hide();
                    if($.isEmptyObject(data.error)){
                        $("#module_result").html(data.success);
                        $(".print-error-msg").css('display','none');

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
    </script>
@endsection
