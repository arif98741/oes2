@extends('front-end.master')
@section('body')
   <style>
      .h-200{
         min-height: 200px;
      }
      .width-40{
         width: 40px;
      }
      .p-none{
         padding: 0px;
      }
      .p-0-6{
         padding: 0px 6px;
      }
      .mark-table th
      {
         padding: 6px 10px;
         border: 1px solid #e0dddd;
      }
      .mark-table td{
         border: 1px solid #e0dddd;
      }
      .margin-auto
      {
         margin: auto;
         width: 100px;
      }
      #message_show{
         margin: auto;
         padding-top: 10px;
         color: #f86c6b;
      }
      #message_show ul{
         padding: 0px;
         margin: 0px;
      }
      .result-title
      {
          text-align: center;
          margin-bottom: 20px;
      }
      .front-text-color{
          color: #1d9bc6;
      }
      @media only screen and (max-width: 575px) {
         .r-m-b-20 {
            margin-bottom: 20px;
         }
          .result-title{
              font-size: 13px;
          }
      }
       @media screen and (max-width: 565px) {
        .h-200{
          min-height: auto;
        }
       }
   </style>
    @php 
    if($module->exam_time != 0)
    {
        $start_time = session('exam_start_time');
        $end_time   = session('exam_end_time');
        $end_time = $end_time - time();
        $time = 0;
        if($end_time > 0)
        {
          $time = ceil($end_time/60);
        }
    }
    @endphp
   <div id="content">
   <form id="answer_form">
      @csrf
         <input type="hidden" id="question_id" name="question_id" value="{{$question->id}}">
         <input type="hidden" id="module_id" name="module_id" value="{{$module_id}}">
         <input type="hidden" id="q_order" name="q_order" value="{{$q_order}}">
         <input type="hidden" id="question_type" name="question_type" value="{{$question_type}}">
         <input type="hidden" id="next_question" name="next_question" value="{{$next_question}}">
      <div class="card card-default" style="margin-top: 1.5rem;">
         <div class="card-header">
            <div class="row">
              <div class="col-md-5">
                <i class="fa fa-picture-o"></i> {{$title}}
                  <div class="card-header-actions">
                     <a class="card-header-action" href="" target="_blank"></a>
                  </div>
              </div>
              <div class="col-md-6">
                @if($module->exam_time != 0)
                <p>
                  <span id="timer_div"> </span>
                </p>
                <input type="hidden" id="exam_time" value="{{$time}}">
                @endif
              </div>
            </div>
         </div>
         <div id="message_show"></div>
         <div class="card-body">
          <div class="row">
                    <div class="col-md-12 text-center">
                        {!! $module->ads_content !!}
                    </div>
                  </div>
            <div class="row text-center">
                  <div class="col-sm-6 col-md-4">
                     <div class="card">
                        <div class="card-header">Question</div>
                        <div class="card-body h-200 " id="question_name">{!! $question->question_name !!}</div>
                     </div>
                  </div>
               <div class="col-sm-6 col-md-4 r-m-b-20">
                  <div class="card">
                     <div class="card-header">Answer</div>
                     <div class="card-body h-200" id="ajax_view">

                           <div class="form-check">
                              <input class="form-check-input answer" id="true" type="radio" value="1" name="answer">
                              <label class="form-check-label width-40" for="true">True</label>
                           </div>
                           <div class="form-check">

                              <input class="form-check-input answer" id="false" type="radio" value="0" name="answer">
                              <label class="form-check-label width-40" for="false">False</label>
                           </div>

                     </div>
                  </div>
                  <button class="btn btn-block btn-primary active margin-auto" id="submit_btn" type="button" aria-pressed="true">Submit</button>

               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="card">
                     <div class="card-header">{{$module->module_name}}</div>
                     <div class="card-body h-200 p-0-6">
                        <table class="table table-hover mark-table">
                           <thead>
                           <tr>
                              <th scope="col">#</th>
                              <th scope="col">Status</th>
                              <th scope="col">Mark</th>
                              <th scope="col">Obtain</th>
                           </tr>
                           </thead>
                           <tbody id="question_mark_status">
                                          @php 
                                          $obtain_mark = 0;
                                          $sl = 1;
                                          @endphp
                                          @if(count($tem_ans) > 0)
                                            @foreach($tem_ans as $temp)
                                              <tr>
                                                <th>{{$sl}}</th>
                                                <td>{{$temp->ans_is_right}}</td>
                                                <td>{{$temp->student_question_marks}}</td>
                                                <td>{{$temp->student_marks}}</td>
                                              </tr>

                                              @php 
                                                $obtain_mark = $obtain_mark + $temp->student_marks;
                                                $sl++;
                                              @endphp
                                            @endforeach
                                          @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            @if($total_mark != 0)
                                            <td id="total_mark">{{$total_mark}}</td>
                                            <td id="obtain_mark">{{$obtain_mark}}</td>
                                            @else
                                            <td id="total_mark"></td>
                                            <td id="obtain_mark"></td>
                                            @endif
                                        </tr>
                                        </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.row-->
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="result_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary next-question-btn">Next Question</button>
               </div>
            </div>
         </div>
      </div>
   </form>
   </div>
   <script>
      $("#submit_btn").click(function () {

          var filed = [];
           filed[0] = 'answer';
           filed[1] = 'question_id';
           filed[2] = 'module_id';
           var check = 1;
           var message = '<ul>';
           for (var i=0;i<filed.length;i++)
           {
              var value =  $("input[name="+filed[i]+"]").val();
              if (value == '')
              {
                  if (filed[i] == 'answer')
                  {
                      message += '<li>Please provide answer</li>';
                  }else if(filed[i] == 'question_id' || filed[i] == 'module_id')
                  {
                      message += '<li>Messing something please refresh page and then answer</li>';
                  }
                  check = 0;
              }
           }

           if ($('.answer').is(':checked'))
           {

           }else
           {
               message += '<li>Please provide answer</li>';
               check = 0;
           }
          message += '</ul>';

           if (check == 0)
           {
               $("#message_show").html(message);

           }else{
            $("#submit_btn").prop("disabled",true);
               $("#message_show").html('');
               var form = $("#answer_form");
               var url = '{{route('std_answer_matching')}}';
               $.ajax({
                   type:'post',
                   url:url,
                   data:form.serialize(),
                   dataType:'json',
                   success:function(response){
                       console.log(response);
                       $("#submit_btn").prop("disabled",false);
                    if(response.success == true){
                       $(".print-error-msg").css('display','none');
                        if(response.next_question == 0)
                               {

                                if (response.ins_type == 2 || response.ins_type == 4 || response.ins_type == 5) {

                                  if(response.module_type == 1)
                                    {
                                        alert('successfully finished your examination');
                                        window.location.href = '{{route('student_score')}}';
                                    }else{

                                        alert('successfully finished your examination');
                                        //location.reload();
                                        window.location.href = '{{route('student_score')}}';
                                    }
                                }else{
                                  
                                  if(response.module_type == 1)
                                    {
                                        alert('successfully finished your examination');
                                        window.location.href = '{{route('student_score')}}';
                                    }else{

                                        alert('successfully finished your examination');
                                        window.location.href = '{{route('student_score')}}';
                                        //window.location.href = '{{route('home')}}';
                                    }
                                }
                               }else {
                               $("#question_mark_status").append(response.result);
                               $("#total_mark").text(response.total_mark);
                               $("#obtain_mark").text(response.obtain_mark);
                               $(".modal-body").html(response.msg);
                               if (response.status == false) {
                                   $(".close-btn").hide();
                                   $(".next-question-btn").show();
                               } else {
                                   $(".close-btn").hide();
                                   $(".next-question-btn").show();
                               }
                               $("#result_modal").modal('show');
                           }
                           
                       }else{
                        if (response.exam_time == 1) {
                               alert(response.msg);
                              window.location.href = '{{route('student_score')}}';
                               return false;
                            }
                        printErrorMsg(response.error);
                            if (response.msg != '') {
                                $("#message_show").html(response.msg);
                            }

                               
                       }

                   },
                   error: function(data){
                       console.log(data);
                   }
               });
           }
      });
      function show_exam_result()
        {
          var url = '{{route('show_result',[$module_id])}}';
                                   $.ajax({
                                       type:'get',
                                       url:url,
                                       dataType:'json',
                                       success:function(response){
                                           console.log(response);
                                           $("#content").html(response.view);
                                       },
                                       error: function(data){
                                           console.log(data);
                                       }
                                   });
        }
      $(".next-question-btn").click(function () {
          $("#result_modal").modal('hide');
         var next_question = $("#next_question").val();
         var q_order = $("#q_order").val();
         var module_id = $("#module_id").val();

         var url = '{{route('ajax_student_exam',[":module_id",":question_id",":q_order"])}}';
         console.log(url);
          url = url.replace(':module_id',module_id);
          url = url.replace(':question_id',next_question);
          url = url.replace(':q_order',q_order);
         console.log(url);
          $.ajax({
              type:'get',
              url:url,
              dataType:'json',
              success:function(response){
                  console.log(response);
                      $("#next_question").val(response.next_question);
                      $("#q_order").val(response.q_order);
                      $("#module_id").val(response.module_id);
                      $("#question_id").val(response.question_id);
                      $("#question_type").val(response.question_type);
                      $("#question_name").html(response.question_name);
                      $("#ajax_view").html(response.view);
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
   <script>
@if($module->exam_time != 0 && $module->module_type == 2)
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
          time = hr+" :"+min+" :"+sec;
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
