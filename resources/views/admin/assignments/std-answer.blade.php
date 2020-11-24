<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{$assignment->title}}-{{$assignment->level_name}}-{{$assignment->subject_name}}-{{time()}}</title>
    <link rel="stylesheet" href="{{asset('/')}}assets/assignment-answer-pdf/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
        <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
      </div>
      <h1></h1>
      <div id="company" class="clearfix">
        <div>{{$std_info->name}}</div>
        <div>{{$std_info->roll_no}}</div>
        <div>{{date('d-M-Y',$asnwer->submitted_time)}}</div>
      </div>
      <div id="project">
        <div style="text-transform: capitalize;">{{$assignment->title}}</div>
        <div>{{$assignment->level_name}}</div>
        <div>{{$assignment->subject_name}}</div>
        @if(admin_type() == 2 || admin_type() == 1)
        <div>{{$assignment->semester_name}}</div>
        @endif
        @if(admin_type() != 5)
        <div>{{$assignment->name}}</div>
        @endif
      </div>
    </header>
    <main>
      <div>
        @php
          $images = json_decode($asnwer->student_answer);
        @endphp
        @foreach($images as $image)
        <img style="width: 100%;" src="{{url('/')}}/{{$image}}">
        @endforeach
      </div>

    </main>
   <div style="text-align: center;">
    Supported By <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
        <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
   </div>
   <div style="text-align: right;">
    <input class="download-btn" type="button" value="Print" onclick="window.print()" />
   </div>
  </body>
</html>
