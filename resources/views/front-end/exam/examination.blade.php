@extends('front-end.master')
@section('body')
<style type="text/css">
  .margin-b-0{
    margin-bottom: 0px;
  }
</style>
@php
    if($module->exam_time != 0 && $module->exam_end_time != 0 && $module->exam_end != 0)
    {
      $time = 0;

      $start_time =  get_module_start_time($module->id);
      $minutes = 0;
      $secounds = 0;
      if($start_time != false)
      {
         $end_time = $module->exam_end - $module->exam_time;
        if($end_time > 0)
        {
          $end_time = $end_time/60;
          $start_time = time() - $start_time;
          $start_time = $start_time/60;
          $time = $end_time - $start_time;
          $english_format_number = number_format($time, 2, '.', '');
          $time_array = explode('.',$english_format_number);
          $minutes = isset($time_array[0]) ? $time_array[0] : 0;
          $secounds = isset($time_array[1]) ? $time_array[1] : 0;
        }
      }
    }
    @endphp
<div class="row">
  <div class="col-md-12">
    <div class="card card-default" style="margin-top: 1.5rem;">
      <div class="card-header">
        <div class="row">
          <div class="col-md-5">
            <i class="fa fa-picture-o"></i> Examination
              <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
              </div>
          </div>
          <div class="col-md-6">
            @if($module->exam_time != 0 && $module->exam_end_time != 0 && $module->exam_end != 0)
            <p>
              <span id="timer_div"> </span>
            </p>
            <input type="hidden" id="minutes" value="{{$minutes}}">
            <input type="hidden" id="secounds" value="{{$secounds}}">
            @endif
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="question-header">
          @if($institute->user_type == 1)
          <h6 class="text-center">
            <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
            <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
          </h6>
          <p class="text-center margin-b-0">{{$institute->level_name}} , {{$institute->subject_name}}</p>
          <p class="text-center margin-b-0">{{$institute->module_name}}</p>
          <p class="text-center margin-b-0">Total Marks: {{$total_mark}}</p>
          @else
          <h6 class="text-center">{{ucwords(strtolower($institute->name))}}</h6>
          <p class="text-center margin-b-0">{{$institute->level_name}} , {{$institute->subject_name}}</p>
          <p class="text-center margin-b-0">{{$institute->module_name}}</p>
          <p class="text-center margin-b-0">Total Marks: {{$total_mark}}</p>
          @endif
        </div>
        <div id="study_content">
          @include('front-end.exam.exam-content')
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$('.kk_processing_alert').hide();

$("#answer_form").on('submit', function(e) {
    e.preventDefault();
    $('#submit_btn').prop('disabled', true);
    $('.kk_processing_alert').show();
    $('.kk_success_alert').hide();
    $(".print-error-msg").css('display','none');
    $.ajax({
        method: "POST",
        url: $(this).prop('action'),
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data)
        {
            $(".print-error-msg").css('display','none');
            if (data.error == true) {
                alert(data.message);
                if(data.ex == true)
                {
                    window.location = data.route;
                }
                // printErrorMsg(data.message);
            }else{
                $('.kk_error_alert').hide();
                $('.kk_success_alert').show();
                alert(data.message)
                window.location = data.route;
            }
            $('#submit_btn').prop('disabled', false);
            $('.kk_processing_alert').hide();
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

  @if($module->exam_time != 0 && $module->exam_end_time != 0 && $module->exam_end != 0)
showTimer();
      function showTimer()
      {
        var minutes = $("#minutes").val();
        var secounds = $("#secounds").val();
        if(minutes < 10)
        {
          minutes = '0'+minutes;
        }
        if(secounds > 60)
        {
          secounds = 60;
        }
        if(secounds < 10)
        {
          secounds = '0'+secounds;
        }
        var time = "00: "+minutes+": "+secounds;
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
          time = hr+" :"+min+" :"+sec;
          if(time_up)
          {
            time = "TIME UP";
          }
          timer_div = document.getElementById("timer_div");
          timer_div.innerHTML=time;
          if(time_up)
          {
            $('#answer_form').submit()
            clearInterval(my_timer);
          }
        },1000);
      }
@endif
</script>
@endsection
