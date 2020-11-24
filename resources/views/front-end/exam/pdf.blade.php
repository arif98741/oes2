<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Answer Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">

    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
        font-family: "Times New Roman", Times, serif;
    }
    .section{
        margin-top:30px;
        padding:50px;
        background:#fff;
    }
    .pdf-btn{
        margin-top:30px;
    }
</style>
<body>
<div class="row">
  <div class="col-md-10" style="margin:auto;">
    <div class="card card-default" style="margin-top: 1.5rem;">
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
</body>
</html>
