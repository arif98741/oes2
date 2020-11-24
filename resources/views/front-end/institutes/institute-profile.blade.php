@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i> Register Institute
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
            <div class="col-md-12" style="margin: auto;">
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
                <div class="row">
                    @php 
                        $unique = 1;
                    @endphp
                    @foreach($institutes as $institute)
                    @if($institute->institute_type == 5)
                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <div style="border: 1px solid #ccc;box-shadow: 0px 0px 3px -1px;padding: 15px 10px;">
                                
                                @if($institute->status == 1)
                                    <div class="alert alert-success text-center" role="alert">
                                      Active
                                    </div>
                                @else
                                    <div class="alert alert-danger text-center" role="alert">
                                      Not Activated
                                    </div>
                                @endif
                                
                                <button type="button" class="btn btn-danger btn-sm"  onclick="DeleteInstitute({{$institute->id}})" style="text-align: right;float: right;padding: 7px;border-radius: 0px;border-bottom: 2px solid #f86c6b;">Delete Institute</button>
                                <h4 class="text-center" style="background: #364450;padding: 8px 0px;color: #fff;font-size: 16px;">Others form</h4>
                                <form class="form-horizontal" action="{{route('update_institute_profile')}}" method="post" id="others_form_div">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="name">Name <span title="required" style="color: red;">*</span></label>
                                        <div class="col-md-9">
                                            <input type="hidden" name="institute_type" value="{{$institute->institute_type}}">
                                            <input class="form-control" id="name" value="{{$institute->name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                                            <small id="name_error"></small>
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
                                           
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="Institute">Institute <span title="required" style="color: red;">*</span></label>
                                        <div class="col-md-9">
                                            <input type="hidden" name="institute_id" value="{{$institute->institute_id}}">
                                            <select class="form-control Institute" code="{{$unique}}" id="Institute_{{$unique}}" disabled >
                                                <option value="">Please select institute</option>
                                                @foreach($others as $other)
                                                    <option @php echo($institute->institute_id == $other->id) ? 'selected' : ''; @endphp value="{{$other->id}}">{{$other->name}}</option>
                                                @endforeach
                                            </select>
                                            <small id="Institute_error"></small>
                                            <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                                           
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="level">Level <span title="required" style="color: red;">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control level" code="{{$unique}}" id="level_{{$unique}}" name="level">
                                                @php 
                                                    $levels = get_levels($institute->institute_id);
                                                @endphp
                                                <option value="">Please select level</option>
                                                @foreach($levels as $level)
                                                    <option @php echo($institute->level == $level->id) ? 'selected' : ''; @endphp value="{{$level->id}}">{{$level->level_name}}</option>
                                                @endforeach
                                            </select>
                                            <small id="level_error"></small>
                                            <span style="color:red;">{{ $errors->first('level') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="batch">Batch <span title="required" style="color: red;">*</span></label>
                                        <div class="col-md-9">
                                            @php 
                                                $batches = get_batches($institute->institute_id,$institute->level);
                                            @endphp
                                            <select class="form-control" code="{{$unique}}" id="batch_{{$unique}}" name="batch">
                                                <option value="">Please select batch</option>
                                                @foreach($batches as $batch)
                                                    <option @php echo($institute->batch == $batch->id) ? 'selected' : ''; @endphp value="{{$batch->id}}">{{$batch->batch_name}}</option>
                                                @endforeach
                                            </select>
                                            <small id="level_error"></small>
                                            <span style="color:red;">{{ $errors->first('batch') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="roll_number" value="{{$institute->roll_no}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                                            <small id="roll_number_error"></small>
                                            <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div style="text-align: right;">
                                        <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                                            <i class="fa fa-dot-circle-o"></i> Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif($institute->institute_type == 2)
                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <div style="border: 1px solid #ccc;box-shadow: 0px 0px 3px -1px;padding: 15px 10px;">
                                @if($institute->status == 1)
                                    <div class="alert alert-success text-center" role="alert">
                                      Active
                                    </div>
                                @else
                                    <div class="alert alert-danger text-center" role="alert">
                                      Not Activated
                                    </div>
                                @endif
                                <button type="button" class="btn btn-danger btn-sm"  onclick="DeleteInstitute({{$institute->id}})" style="text-align: right;float: right;padding: 7px;border-radius: 0px;border-bottom: 2px solid #f86c6b;">Delete Institute</button>
                                <h4 class="text-center" style="background: #364450;padding: 8px 0px;color: #fff;font-size: 16px;">University form</h4>
                            <form class="form-horizontal" action="{{route('update_institute_profile')}}" method="post" >
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="name">Name <span title="required" style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <input type="hidden" name="institute_type" value="{{$institute->institute_type}}">
                                        <input class="form-control" id="name" value="{{$institute->name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                                        <small id="name_error"></small>
                                        <span style="color:red;">{{ $errors->first('name') }}</span>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="Institute">Institute<span title="required" style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <input type="hidden" name="institute_id" value="{{$institute->institute_id}}">
                                        <select class="form-control Institute" disabled code="{{$unique}}" id="Institute_{{$unique}}" >
                                            <option value="">Please select institute</option>
                                            @foreach($universities as $university)
                                                <option @php echo($institute->institute_id == $university->id) ? 'selected' : ''; @endphp value="{{$university->id}}">{{$university->name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="Institute_error"></small>
                                        <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="level">Level <span title="required" style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control level" code="{{$unique}}" id="level_{{$unique}}" name="level">
                                            @php 
                                                $levels = get_levels($institute->institute_id);
                                            @endphp
                                            <option value="">Please select level</option>
                                            @foreach($levels as $level)
                                                <option @php echo($institute->level == $level->id) ? 'selected' : ''; @endphp value="{{$level->id}}">{{$level->level_name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="level_error"></small>
                                        <span style="color:red;">{{ $errors->first('level') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="semester">Semester</label>
                                    <div class="col-md-9">
                                        <select class="form-control" code="{{$unique}}" id="semester_{{$unique}}" name="semester">
                                            <option value="">Please select semester</option>
                                            @php
                                                $semesters = get_semesters($institute->level);
                                            @endphp
                                            @foreach($semesters as $semester)
                                                <option @php echo($institute->semester == $semester->id) ? 'selected' : ''; @endphp value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="semester_error"></small>
                                         <span style="color:red;">{{ $errors->first('semester') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="section">Section</label>
                                    <div class="col-md-9">
                                        <select class="form-control" code="{{$unique}}" id="section_{{$unique}}" name="section">
                                            <option value="">Please select section</option>
                                            @php
                                                $sections = get_sections($institute->level);
                                            @endphp
                                            @foreach($sections as $section)
                                                <option @php echo($institute->section == $section->id) ? 'selected' : ''; @endphp value="{{$section->id}}">{{$section->name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="section_error"></small>
                                         <span style="color:red;">{{ $errors->first('section') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="roll_number" value="{{$institute->roll_no}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                                        <small id="roll_number_error"></small>
                                        <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                                    </div>
                                </div>
                                
                                <div style="text-align: right;">
                                    <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                                        <i class="fa fa-dot-circle-o"></i> Update</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    @elseif($institute->institute_type == 4)
                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <div style="border: 1px solid #ccc;box-shadow: 0px 0px 3px -1px;padding: 15px 10px;">
                                @if($institute->status == 1)
                                    <div class="alert alert-success text-center" role="alert">
                                      Active
                                    </div>
                                @else
                                    <div class="alert alert-danger text-center" role="alert">
                                      Not Activated
                                    </div>
                                @endif
                                <button type="button" class="btn btn-danger btn-sm"  onclick="DeleteInstitute({{$institute->id}})" style="text-align: right;float: right;padding: 7px;border-radius: 0px;border-bottom: 2px solid #f86c6b;">Delete Institute</button>
                                <h4 class="text-center" style="background: #364450;padding: 8px 0px;color: #fff;font-size: 16px;">School/College form</h4>
                            <form class="form-horizontal" action="{{route('update_institute_profile')}}" method="post" >
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="name">Name <span title="required" style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <input type="hidden" name="institute_type" value="{{$institute->institute_type}}">
                                        <input class="form-control" id="name" value="{{$institute->name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                                        <small id="name_error"></small>
                                        <span style="color:red;">{{ $errors->first('name') }}</span>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="Institute">Institute<span title="required" style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <input type="hidden" name="institute_id" value="{{$institute->institute_id}}">
                                        <select class="form-control Institute" code="{{$unique}}" id="Institute_{{$unique}}" disabled>
                                            <option value="">Please select institute</option>
                                            @foreach($schools as $school)
                                                <option @php echo($institute->institute_id == $school->id) ? 'selected' : ''; @endphp value="{{$school->id}}">{{$school->name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="Institute_error"></small>
                                        <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="level">Level <span title="required" style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control level" code="{{$unique}}" id="level_{{$unique}}" name="level">
                                            @php 
                                                $levels = get_levels($institute->institute_id);
                                            @endphp
                                            <option value="">Please select level</option>
                                            @foreach($levels as $level)
                                                <option @php echo($institute->level == $level->id) ? 'selected' : ''; @endphp value="{{$level->id}}">{{$level->level_name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="level_error"></small>
                                        <span style="color:red;">{{ $errors->first('level') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="section">Section</label>
                                    <div class="col-md-9">
                                        <select class="form-control" code="{{$unique}}" id="section_{{$unique}}" name="section">
                                            <option value="">Please select section</option>
                                            @php
                                                $sections = get_sections($institute->level);
                                            @endphp
                                            @foreach($sections as $section)
                                                <option @php echo($institute->section == $section->id) ? 'selected' : ''; @endphp value="{{$section->id}}">{{$section->name}}</option>
                                            @endforeach
                                        </select>
                                        <small id="section_error"></small>
                                         <span style="color:red;">{{ $errors->first('section') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="roll_number" value="{{$institute->roll_no}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                                        <small id="roll_number_error"></small>
                                        <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                                    </div>
                                </div>
                                
                                <div style="text-align: right;">
                                    <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                                        <i class="fa fa-dot-circle-o"></i> Update</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    @endif  
                    @php 
                        $unique++;
                    @endphp  
                    @endforeach
                </div>
            </div>
        <!-- /.row-->
        </div>
    </div>
    <script>
        $(".Institute").change(function () {
            var code = $(this).attr('code');
            var id = $(this).val();
           if (id != '')
           {
            var type = 0;
            var level = 0;
               institute_level(code,id,level,type);
           }
        });
        function institute_level(code,id,level,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-level/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,level:level},
                   success:function(data){
                       $("#level_"+code).html(data);
                   }
               });
        }
        $(".level").change(function () {
            var id = $(this).val();
            var code = $(this).attr('code');
           if (id != '')
           {
            var type = 0;
            var section = 0;
            var semester = 0;
               institute_section(code,id,section,type);
               institute_semester(code,id,semester,0);
               institute_batch(code,id);
           }
        });
        function institute_section(code,id,section,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-section/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,section:section},
                   success:function(data){
                       $("#section_"+code).html(data);
                   }
               });
        } 
        function institute_semester(code,id,semester,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-semester/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,semester:semester},
                   success:function(data){
                       $("#semester_"+code).html(data);
                   }
               });
        }
        function institute_batch(code,id)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-batch/'+id,
                   type:"get",
                   dataType:'json',
                   data:{level:id},
                   success:function(data){
                       $("#batch_"+code).html(data);
                   }
               });
        }
function DeleteInstitute(id)
  {
    if(confirm("Are you sure you want to delete this lavel?")){
      var url = '{{route('remove_institute',[":id"])}}';
          url = url.replace(':id',id);
      window.location = url;
    }
  }
    </script>
@endsection

