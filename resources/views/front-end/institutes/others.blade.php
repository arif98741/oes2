@extends('front-end.master')
@section('body')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i> @if(Session::get('verification') || Session::get('error')) Email Verification @endif @if(!Session::get('verification') || Session::get('error')) Register @endif
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

                <form class="form-horizontal" id="others_form" action="{{route('others_register')}}" method="post" >
                    @csrf
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    @if(Session::get('error'))
                        <div class="alert alert-danger">
                            {{Session::get('error')}}
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Name</label>
                        <div class="col-md-9">
                        	<input type="hidden" name="institute_type" value="5">
                            <input class="form-control" id="name" value="{{$name}}" autocomplete="off" type="text" name="name" placeholder="enter your name, use only alphabets">
                            <small id="name_error"></small>
                            <span style="color:red;">{{ $errors->first('name') }}</span>
                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="Institute">Institute</label>
                        <div class="col-md-9">
                            <select class="form-control" id="Institute" name="institute_id">
                                <option value="">Please select institute</option>
                                @foreach($institutes as $institute)
                                    <option @php echo($institute_id == $institute->id) ? 'selected' : ''; @endphp value="{{$institute->id}}">{{$institute->name}}</option>
                                @endforeach
                            </select>
                            <small id="Institute_error"></small>
                            <span style="color:red;">{{ $errors->first('institute_id') }}</span>
                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="level">Level</label>
                        <div class="col-md-9">
                            <select class="form-control" id="level" name="level">
                                <option value="">Please select level</option>
                            </select>
                            <small id="level_error"></small>
                            <span style="color:red;">{{ $errors->first('level') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="batch">Batch</label>
                        <div class="col-md-9">
                            <select class="form-control" id="batch" name="batch">
                                <option value="">Please select batch</option>
                            </select>
                            <small id="level_error"></small>
                            <span style="color:red;">{{ $errors->first('batch') }}</span>
                        </div>
                    </div>
                    <!--<div class="form-group row">-->
                    <!--    <label class="col-md-3 col-form-label" for="roll_number">Roll Number</label>-->
                    <!--    <div class="col-md-9">-->
                    <!--        <input class="form-control" id="roll_number" value="{{$roll_number}}" autocomplete="off" type="number" name="roll_number" placeholder="enter your class roll">-->
                    <!--        <small id="roll_number_error"></small>-->
                    <!--        <span style="color:red;">{{ $errors->first('roll_number') }}</span>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="form-group row">-->
                    <!--    <label class="col-md-3 col-form-label"></label>-->
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
        @if($level != '' && $level != 0 )
        var level = '{{$level}}';
        var institute_id = '{{$institute_id}}';
            institute_level(institute_id,level,1);
        @endif
        @if($institute_id != '' && $level == '' )
        var institute_id = '{{$institute_id}}';
            institute_level(institute_id,0,0);
        @endif
       
        $("#Institute").change(function () {
            var id = $(this).val();
           if (id != '')
           {
            var type = 0;
            var level = 0;
               institute_level(id,level,type);
           }
        });

        function institute_level(id,level,type)
        {
            $.ajax({
                   url:'{{ url("/")}}/institute-level/'+id,
                   type:"get",
                   dataType:'html',
                   data:{type:type,level:level},
                   success:function(data){
                       $("#level").html(data);
                   }
               });
        }
        $("#level").change(function(){
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
        $("#save_btn").click(function(){
             $("#save_btn").prop("disabled",true);
             $("#others_form").submit();
        });
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
    </script>
@endsection

