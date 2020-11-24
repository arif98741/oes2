@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i> Institute Registration
            <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
            </div>
        </div>
        <style>
            #module-form {
                margin: auto;
            }
            #module-form sup{
                color: #e70a0a;
            }
            .color-red{
                color: red;
            }
            .color-green
            {
                color: green;
            }
        </style>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center"  style="margin-bottom: 15px;">
                    <button class="ins_btn btn btn-@php echo($selected == 'school') ? 'success' : 'primary' @endphp" type="button" int_atr="school" style="margin: 5px;" >School/College</button>
                    <button class="ins_btn btn btn-@php echo($selected == 'university') ? 'success' : 'primary' @endphp" type="button" int_atr="university" style="margin: 5px;" >University</button>
                    <button class="ins_btn btn btn-@php echo($selected == 'others') ? 'success' : 'primary' @endphp" type="button" int_atr="others" style="margin: 5px;" >Others</button>
                </div>
            </div>
            <div class="col-md-8" style="margin: auto;">
                @if(Session::get('success'))
                        <div class="alert alert-success text-center">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    @if(Session::get('error'))
                        <div class="alert alert-danger text-center">
                            {{Session::get('error')}}
                        </div>
                    @endif
                <div id="school_form_div" style="display:@php echo($selected == 'school') ? 'block' : 'none' @endphp">
                    <h4 class="text-center">School/College Registration form</h4>
                    <form class="form-horizontal" action="{{route('institute_register')}}" method="post" >
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Name <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input type="hidden" name="institute_type" value="4">
                                <input class="form-control" id="name" value="{{$name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                                <small id="name_error"></small>
                                <span style="color:red;">{{ $errors->first('name') }}</span>
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="Institute">Institute <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control Institute" in_name="school_form_div" id="Institute" name="institute_id">
                                    <option value="">Please select institute</option>
                                    @foreach($schools as $institute)
                                        <option @php echo($institute_id == $institute->id) ? 'selected' : ''; @endphp value="{{$institute->id}}">{{$institute->name}}</option>
                                    @endforeach
                                </select>
                                <small id="Institute_error"></small>
                                <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="level">Level <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control level" in_name="school_form_div" id="level" name="level">
                                    <option value="">Please select level</option>
                                </select>
                                <small id="level_error"></small>
                                <span style="color:red;">{{ $errors->first('level') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="section">Section <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control section" in_name="school_form_div" id="section" name="section">
                                    <option value="">Please select section</option>
                                </select>
                                <small id="section_error"></small>
                                 <span style="color:red;">{{ $errors->first('section') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                            <div class="col-md-9">
                                <input class="form-control" id="roll_number" value="{{$roll_number}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                                <small id="roll_number_error"></small>
                                <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                    </form>
                </div>
                <div id="university_form_div" style="display:@php echo($selected == 'university') ? 'block' : 'none' @endphp">
                    <h4 class="text-center">University Registration form</h4>
                    <form class="form-horizontal" action="{{route('university_register')}}" method="post" >
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Name <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input type="hidden" name="institute_type" value="2">
                                <input class="form-control" id="name" value="{{$name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                                <small id="name_error"></small>
                                <span style="color:red;">{{ $errors->first('name') }}</span>
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="Institute">Institute <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control Institute"  in_name="university_form_div" id="Institute" name="institute_id">
                                    <option value="">Please select institute</option>
                                    @foreach($universities as $institute)
                                        <option @php echo($institute_id == $institute->id) ? 'selected' : ''; @endphp value="{{$institute->id}}">{{$institute->name}}</option>
                                    @endforeach
                                </select>
                                <small id="Institute_error"></small>
                                <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="level">Level <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control level" in_name="university_form_div" id="level" name="level">
                                    <option value="">Please select level</option>
                                </select>
                                <small id="level_error"></small>
                                <span style="color:red;">{{ $errors->first('level') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="semester">Semester <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control semester" in_name="university_form_div" id="semester" name="semester">
                                    <option value="">Please select semester</option>
                                </select>
                                <small id="semester_error"></small>
                                 <span style="color:red;">{{ $errors->first('semester') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="section">Section <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control section" in_name="university_form_div" id="section" name="section">
                                    <option value="">Please select section</option>
                                </select>
                                <small id="section_error"></small>
                                 <span style="color:red;">{{ $errors->first('section') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                            <div class="col-md-9">
                                <input class="form-control" id="roll_number" value="{{$roll_number}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                                <small id="roll_number_error"></small>
                                <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                    </form>
                </div>
                <div id="others_form_div" style="display:@php echo($selected == 'others') ? 'block' : 'none' @endphp">
                    <h4 class="text-center">Others Registration form</h4>
                    <form class="form-horizontal" action="{{route('others_register')}}" method="post" >
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Name <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input type="hidden" name="institute_type" value="5">
                                <input class="form-control" id="name" value="{{$name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                                <small id="name_error"></small>
                                <span style="color:red;">{{ $errors->first('name') }}</span>
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="Institute">Institute <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control Institute" in_name="others_form_div" id="Institute" name="institute_id">
                                    <option value="">Please select institute</option>
                                    @foreach($others as $institute)
                                        <option @php echo($institute_id == $institute->id) ? 'selected' : ''; @endphp value="{{$institute->id}}">{{$institute->name}}</option>
                                    @endforeach
                                </select>
                                <small id="Institute_error"></small>
                                <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="level">Level <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control level" in_name="others_form_div" id="level" name="level">
                                    <option value="">Please select level</option>
                                </select>
                                <small id="level_error"></small>
                                <span style="color:red;">{{ $errors->first('level') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="batch">Batch <span title="required" style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="batch" name="batch">
                                    <option value="">Please select batch</option>
                                </select>
                                <small id="level_error"></small>
                                <span style="color:red;">{{ $errors->first('batch') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                            <div class="col-md-9">
                                <input class="form-control" id="roll_number" value="{{$roll_number}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                                <small id="roll_number_error"></small>
                                <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                            </div>
                        </div>
                        
                        <div style="text-align: right;">
                            <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        <!-- /.row-->
        </div>
    </div>
    <script>
        $(".ins_btn").click(function(){
            var ins_atr = $(this).attr('int_atr');
            
            $('.ins_btn').removeClass("btn-success");
            $('.ins_btn').removeClass("btn-primary");
            $('.ins_btn').addClass("btn-primary");
            $(this).removeClass("btn-success");
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-success");
            if(ins_atr != null)
            {
                if(ins_atr == 'school')
                {
                    $("#school_form_div").show();
                    $("#university_form_div").hide();
                    $("#others_form_div").hide();
                }else if(ins_atr == 'university')
                {
                    $("#school_form_div").hide();
                    $("#university_form_div").show();
                    $("#others_form_div").hide();
                }else if(ins_atr == 'others')
                {
                    $("#school_form_div").hide();
                    $("#university_form_div").hide();
                    $("#others_form_div").show();
                }
            }
        });
        @if($level != '' && $level != 0 )
        var level = '{{$level}}';
        var institute_id = '{{$institute_id}}';
            institute_level(institute_id,level,1);
        @endif
        @if($level != '' && $section == '')
	        var level = '{{$level}}';
	        institute_section(level,0,0);
        @endif
        @if($level != '' && $semester == '')
	        var level = '{{$level}}';
	        institute_semester(level,0,0);
        @endif
         @if($section != '' && $section != 0 )
        var level = '{{$level}}';
        var section = '{{$section}}';
            institute_section(level,section,1);
        
        @endif
        @if($semester != '' && $semester != 0 )
        var level = '{{$level}}';
        var semester = '{{$semester}}';
            institute_semester(level,semester,1);
        
        @endif
        $(".Institute").change(function () {
            var in_name = $(this).attr('in_name');
            console.log(in_name);
            var id = $(this).val();
           if (id != '')
           {
            var type = 0;
            var level = 0;
               institute_level(in_name,id,level,type);
           }
        });
        $(".level").change(function(){
            var level = $(this).val();
            $.ajax({
                   url:'{{ url("/")}}/institute-batch/'+level,
                   type:"get",
                   dataType:'json',
                   data:{level:level},
                   success:function(data){
                       $("#batch").html(data);
                   }
               });
        });
        function institute_level(in_name,id,level,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-level/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,level:level},
                   success:function(data){
                       $("#"+in_name+" #level").html(data);
                   }
               });
        }
        $(".level").change(function () {
            var id = $(this).val();
            var in_name = $(this).attr('in_name');
           if (id != '')
           {
            var type = 0;
            var section = 0;
            var semester = 0;
               institute_section(in_name,id,section,type);
               institute_semester(in_name,id,semester,1);
           }
        });
        function institute_section(in_name,id,section,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-section/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,section:section},
                   success:function(data){
                       $("#"+in_name+" #section").html(data);
                   }
               });
        } 
        function institute_semester(in_name,id,semester,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-semester/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,semester:semester},
                   success:function(data){
                       $("#"+in_name+" #semester").html(data);
                   }
               });
        }

        $('#save_btnn').click(function(e){
            e.preventDefault();
        
            var id = [];
                id[0] = 'name';
                id[1] = 'Institute';
                id[2] = 'level';
                id[3] = 'section';
                id[4] = 'roll_number';
                var message = [];
                    message[0] = 'name_error';
                    message[1] = 'Institute_error';
                    message[2] = 'level_error';
                    message[3] = 'section_error';
                    message[4] = 'roll_number_error';
                    var check = 1;
                    for(var i = 0;i<5;i++)
                    {
                        var value = $("#"+id[i]).val();
                        if (value == '')
                        {
                            $("#"+message[i]).html('This field can not empty!');
                            $("#"+message[i]).css('color','red');
                            check = 0;
                        }else {
                            $("#"+message[i]).html('');
                        }
                    }


        });
    </script>
@endsection

