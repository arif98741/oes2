@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Module</li>
                    </ol>
                </div>
                <h4 class="page-title">All module</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="module_search_form">
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
                    <div class="form-group" style="float: left;margin-right: 5px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-danger btn-animation search_btn">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <a href="{{route('add_module')}}" class="btn btn-success btn-animation">
                                Add New
                            </a>
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
                <div class="card-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul>

                        </ul>
                    </div>
                    <table class="table table-hover" id="module_table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Level</th>
                            <th>Subject</th>
                            @if(admin_type() == 2 || admin_type() == 1)
                            <th>Semester</th>
                            @endif
                            @if(admin_type() != 5)
                            <th>Section</th>
                            @endif
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="module_list_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">

    </script>
    <script>
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

        $(".search_btn").click(function () {

            var form = $("#module_search_form");
            var url = '{{route('search_module')}}';
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
