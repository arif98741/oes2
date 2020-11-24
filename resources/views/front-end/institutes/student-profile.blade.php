@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <i class="fa fa-picture-o"></i> Institute Profile
                    <div class="card-header-actions">
                        <a class="card-header-action" href="" target="_blank"></a>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm"  onclick="DeleteInstitute()">Delete Institute</button>
                </div>
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

                <form class="form-horizontal" action="{{route('update_institute_profile')}}" method="post" >
                    @csrf
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
                    @if(is_active() != 1)
                        <div class="alert alert-danger text-center">
                           Your application has not been accepted by the academic administration.your application is being processed.
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Name</label>
                        <div class="col-md-9">
                        	<input type="hidden" name="institute_type" value="{{$institute_info->user_type}}">
                            <input class="form-control" id="name" value="{{$user_info->name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                            <small id="name_error"></small>
                            <span style="color:red;">{{ $errors->first('name') }}</span>
                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="institute">Institute</label>
                        <div class="col-md-9">
                            <input class="form-control" readonly="readonly" value="{{$institute_info->name}}" type="text" id="institute">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="level">Level</label>
                        <div class="col-md-9">
                            <select class="form-control" id="level" name="level">
                                <option value="">Please select level</option>
                                @foreach($levels as $level)
                                    <option @php echo($user_info->level == $level->id) ? 'selected' : ''; @endphp value="{{$level->id}}">{{$level->level_name}}</option>
                                @endforeach
                            </select>
                            <small id="level_error"></small>
                            <span style="color:red;">{{ $errors->first('level') }}</span>
                        </div> 
                    </div>
                    @if(isset($semesters))
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="semester">Semester</label>
                        <div class="col-md-9">
                            <select class="form-control" id="semester" name="semester">
                                <option value="">Please select semester</option>
                                @foreach($semesters as $semester)
                                    <option @php echo($user_info->semester == $semester->id) ? 'selected' : ''; @endphp value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                @endforeach
                            </select>
                            <small id="semester_error"></small>
                             <span style="color:red;">{{ $errors->first('semester') }}</span>
                        </div>
                    </div>
                    @endif
                    @if(isset($sections))
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="section">Section</label>
                        <div class="col-md-9">
                            <select class="form-control" id="section" name="section">
                                <option value="">Please select section</option>
                                @foreach($sections as $section)
                                    <option @php echo($user_info->section == $section->id) ? 'selected' : ''; @endphp value="{{$section->id}}">{{$section->name}}</option>
                                @endforeach
                            </select>
                            <small id="section_error"></small>
                             <span style="color:red;">{{ $errors->first('section') }}</span>
                        </div>
                    </div>
                    @endif
                    @if($institute_info->user_type == 5)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="batch">Batch</label>
                        <div class="col-md-9">
                            <select class="form-control" id="batch" name="batch">
                                <option value="">Please select batch</option>
                                @foreach($batches as $batch)
                                    <option @php echo($user_info->batch == $batch->id) ? 'selected' : ''; @endphp value="{{$batch->id}}">{{$batch->batch_name}}</option>
                                @endforeach
                            </select>
                            <small id="section_error"></small>
                             <span style="color:red;">{{ $errors->first('batch') }}</span>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>
                        <div class="col-md-9">
                            <input class="form-control" id="roll_number" value="{{$user_info->roll_no}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">
                            <small id="roll_number_error"></small>
                            <span style="color:red;">{{ $errors->first('roll_number') }}</span>
                        </div>
                    </div>
                    <!--<div class="form-group row">-->
                    <!--    <label class="col-md-3 col-form-label" for="district"></label>-->
                    <!--    <div class="col-md-4">-->
                    <!--        <div class="g-recaptcha"-->
                    <!--             data-sitekey="6LdnedsZAAAAAHoM_eG-_-GpbXKKn6SBfHSy61rF">-->
                    <!--        </div>-->
                    <!--        <span style="color:red;">{{ $errors->first('g-recaptcha-response') }}</span>-->
                           
                    <!--    </div>-->
                    <!--</div>-->
                    <div style="text-align: right;">
                        <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                            <i class="fa fa-dot-circle-o"></i> Submit</button>
                    </div>
                </form>

        <!-- /.row-->
        </div>
    </div>
<script>
       
         $("#level").change(function () {
            var id = $(this).val();
           if (id != '')
           {
            var type = 0;
            var section = 0;
            var semester = 0;
               institute_section(id,section,type);
               institute_semester(id,semester,0);
               institute_batch(id);
           }
        });
        function institute_section(id,section,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-section/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,section:section},
                   success:function(data){
                       $("#section").html(data);
                   }
               });
        } 
        function institute_semester(id,semester,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-semester/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,semester:semester},
                   success:function(data){
                       $("#semester").html(data);
                   }
               });
        }
        function institute_batch(id)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-batch/'+id,
                   type:"get",
                   dataType:'json',
                   data:{level:id},
                   success:function(data){
                       $("#batch").html(data);
                   }
               });
        }
    
        $('#save_btnn').click(function(e){
            e.preventDefault();
        
            var id = [];
                id[0] = 'name';
                id[1] = 'Institute';
                id[2] = 'level';
                id[3] = 'roll_number';
                var message = [];
                    message[0] = 'name_error';
                    message[1] = 'Institute_error';
                    message[2] = 'level_error';
                    message[3] = 'roll_number_error';
                    var check = 1;
                    for(var i = 0;i<4;i++)
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
function DeleteInstitute()
  {
    if(confirm("Are you sure you want to delete this lavel?")){
      var url = '{{route('remove_institute')}}';
      window.location = url;
    }
  }
</script>
@endsection

