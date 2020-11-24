@extends('front-end.master')
@section('body')
<style type="text/css">
  .margin-b-0{
    margin-bottom: 0px;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card card-default" style="margin-top: 1.5rem;">
      <div class="card-header">
        <div class="row">
          <div class="col-md-5">
            <i class="fa fa-picture-o"></i> Answer
              <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
              </div>
          </div>
          <div class="col-md-6 text-center">
                <!--<button class="btn btn-success" id="downlaod_btn" type="button">download</button>-->
                <a class="btn btn-success"  href="{{route('answet_downlaod',$answer->id)}}">download</a>
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
          @include('front-end.exam.answer-content')
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$("#downlaod_btn").click(function (e) {
            e.preventDefault();
            $("#downlaod_btn").prop("disabled",true);
            var url = '{{route('answet_downlaod',$answer->id)}}';
            $.ajax({
                type:'get',
                url:url,
                dataType:'json',
                success:function(data){
                  $("#downlaod_btn").prop("disabled",false);
                    if($.isEmptyObject(data.error)){
                        Popup(data.view);
                    }else{
                      alert(data.message);
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
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
