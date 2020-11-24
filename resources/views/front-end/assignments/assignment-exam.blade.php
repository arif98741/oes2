@extends('front-end.master')
@section('body')
@php 
    if($assignment->exam_start != 0)
    {
        $start_time = session('ass_start_time');
        $end_time   = session('ass_end_time');
        $end_time = $end_time - time();
        $time = 0;
        if($end_time > 0)
        {
          $time = ceil($end_time/60);
        }
    }
    @endphp
    <style type="text/css">
        #timer_p{
            text-align: center;
            font-size: 15px;
            margin: 0px;
            font-weight: 500;
            color: red;
        }
    </style>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <i class="fa fa-picture-o"></i> Institute Assignment Exam
                    <div class="card-header-actions text-right">
                       {{date('d-M-Y H:i',$assignment->exam_start)}} - {{date('d-M-Y H:i',$assignment->exam_end) }}
                    </div>
                </div>
                <div class="col-md-6">
                    @if($assignment->exam_start != 0)
                        <p id="timer_p">
                          <span id="timer_div"> </span>
                        </p>
                        <input type="hidden" id="exam_time" value="{{$time}}">
                        @endif
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

            <div class="row" style="align-items: center;">
                <div class="col-md-5 text-center">
                    <a class="btn btn-primary btn-sm" href="{{url('/')}}/{{$assignment->assignment}}" target="_blank">Click here to view Assignment</a>
                </div>
                <div class="col-md-7">
                    <form class="form-horizontal" action="{{route('assignment_submit')}}" method="post" enctype="multipart/form-data">
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

                    <div class="form-group ">
                        <p style="color: red;">images formate only jpeg ,jpg,png</p>
                        <label class=" col-form-label" for="name">Submit images of your answer sheet</label>
                            <input class="form-control" value="{{$assignment->id}}" type="hidden" name="ass_id">
                            <input class="form-control" id="answer" type="file" name="answer[]" multiple="multiple" accept="image/*">
                            <small id="name_error"></small>
                            <span style="color:red;">{{ $errors->first('answer') }}</span>
                           
                    </div>
                    <div style="text-align: right;">
                        <button class="btn btn-sm btn-primary" id="save_btn" type="submit">
                            <i class="fa fa-dot-circle-o"></i> Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <script>
 @if($assignment->exam_start != 0)
showTimer();
      function showTimer()
      {
        var exam_time = $("#exam_time").val();
        
        var time = "00: "+exam_time+": 00";
        console.log(time);
        timer_div=document.getElementById("timer_div");
        timer_div.innerHTML=time;
        my_timer = setInterval(function(){
          var hr=0;var min=0; var sec =0;
          var time_up = false;
          t=time.split(":");
          hr = parseInt(t[0]);
          min = parseInt(t[1]);
          sec = parseInt(t[2]);
          if(sec == 0){

            if(min>0){
              sec=59;
              min--;
            }else if(hr >0){
              min=59;
              sec=59;
              hr--;
            }else{
              time_up = true;
            }
          }else{
            sec--;
          }
          if(hr<10)
          {
            hr = "0"+hr;
          }
          if(min<10){
            min="0"+min;
          }if(sec<10)
          {
            sec="0"+sec;
          }
          time = hr+"H :"+min+"M :"+sec+'S';
          if(time_up)
          {
            time = "TIME UP";
          }
          timer_div = document.getElementById("timer_div");
          timer_div.innerHTML=time;
          if(time_up)
          {
            clearInterval(my_timer);
          }
        },1000);
      }
@endif
   </script>
@endsection

