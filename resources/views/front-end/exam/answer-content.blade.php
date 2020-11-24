<style type="text/css">
  #answer-header{
    margin-top: 15px;
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 15px;
    background: #e4e5e6;
  }
  p span{
        margin-right: 10px;
  }
  .type-one .form-check{
    width: 49%;
      display: inline-block;
  }
  .type-one .answer{
    padding-left: 16px;
  }
  .type-one h6{
    font-size: 16px;
  }
  .type-two .form-check{
    width: 49%;
      display: inline-block;
  }
  .m-b-15{
    margin-bottom: 15px;
  }
  .content p{
    display: inline-block;
    margin: 0px;
  }
  .content{
    margin-top: 30px;
  }
  .m-b-0{
    margin-bottom: 0px;
  }
</style>
<div id="answer-header">
  <div class="row">
    <div class="col-md-6 text-center">
      <p class="m-b-0">Total Mark: {{$total_mark}}</p>
    </div>
    <div class="col-md-6 text-center">
      <p class="m-b-0">Obtain Mark: {{$obtain_mark}}</p>
    </div>
  </div>
</div>
<div>
@php 
  $sl = 1;
@endphp
  <div class="row content">
  @foreach($questions as $question)
    @if($question->question_type == 1)
      
        <div class="col-md-6 type-one m-b-15">
          <h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
          <div class="answer">
            @php
            $answer = $question->answer;
              $true_background = '';
              $false_background = '';
              if($question->std_answer == '')
              {
                if($answer == 1)
                {
                  $true_background = 'background:#00c300;';
                  $false_background = '';
                }else{
                  $true_background = '';
                  $false_background = 'background:#00c300;';
                }
              }else{
                if($question->std_answer == 1)
                {
                  if($question->std_answer == $answer)
                  {
                    $true_background = 'background: #00c300;';
                    $false_background = '';
                  }else{
                    $true_background = 'background: #f11e1e;';
                    $false_background = 'background: #00c300;';
                  }
                }elseif($question->std_answer == 0)
                {
                  if($question->std_answer == $answer)
                  {
                    $true_background = '';
                    $false_background = 'background: #00c300;';
                  }else{
                    $true_background = 'background: #00c300;';
                    $false_background = 'background: #f11e1e;';
                  }
                }
              }
            @endphp
            <div class="form-check" style="{{$true_background}}">
                <input type="radio" @php echo($question->answer = 1) ? 'checked' : '' @endphp class="form-check-input">
                <label class="form-check-label">True</label>
              </div>
              <div class="form-check" style="{{$false_background}}">
                <input type="radio" @php echo($question->answer = 0) ? 'checked' : '' @endphp class="form-check-input">
                <label class="form-check-label">False</label>
              </div>
          </div>
        </div>
    @elseif($question->question_type == 2)
        <div class="col-md-6 type-two m-b-15">
          <h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
          <div class="answer">
            @php 
              $answer_content = json_decode($question->answer);
              $answer = $answer_content->answer;
              $answer_choice = $answer_content->answer_choice;
            @endphp
            @foreach($answer_choice as $key=>$choice)
            @php
              $background = '';
              if($question->std_answer == '')
              {
                if($key+1 == $answer)
                {
                  $background = 'background: #ffff02;';
                }
              }else{
                if($key+1 == $question->std_answer)
                {
                  if($question->std_answer == $answer)
                  {
                    $background = 'background: #00c300;';
                  }else{
                    $background = 'background: #f11e1e;';
                  }
                  
                }elseif($key+1 == $answer)
                {
                  $background = 'background: #00c300;';
                }
              }
            @endphp
            <div class="form-check" style="{{$background}}">
                <input type="radio" @if($key+1 == $question->std_answer) checked @elseif($key+1 == $answer) checked @else @endif class="form-check-input">
                <label class="form-check-label">{{$choice->answer_choice}}</label>
            </div>
            @endforeach
          </div>
        </div>
    @elseif($question->question_type == 5)
        <div class="col-md-6 type-two m-b-15">
          <h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
          <div class="answer">
            @php 
            $border = 'border: 1px solid #e4e7ea;';
              if($question->ans_is_right == 'correct')
              {
                $border = 'border: 1px solid #00c300;';
              }else{
                $border = 'border: 1px solid #f11e1e;';
              }
            @endphp
            <input type="text" style="width: 80%;{{$border}}" value="{{$question->answer}}" name="answer_{{$sl}}" placeholder="Enter your answer" class="form-control">
          </div>
        </div>
    @elseif($question->question_type == 7)
        <div class="col-md-6 type-two m-b-15">
          <h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
          <div class="answer">
            @php 
              $answer_content = json_decode($question->answer);
              $answer = $answer_content->answer;
              $answer_choices = $answer_content->answer_choices;
            @endphp
            @foreach($answer_choice as $key=>$choice)
            @php
              $background = '';
              if($key+1 == $question->std_answer)
              {
                if($question->std_answer == $answer)
                {
                  $background = 'background: #00c300;';
                }else{
                  $background = 'background: #f11e1e;';
                }
                
              }elseif($key+1 == $answer)
              {
                $background = 'background: #00c300;';
              }
            @endphp
            <div class="form-check" style="margin-bottom: 5px;{{$background}}">
                <input type="radio" {{$question->std_answer}}  @if($key+1 == $question->std_answer) checked @elseif($key+1 == $answer) checked @else @endif id="answer_{{$sl}}_{{$key}}" value="{{$key+1}}" class="form-check-input answer answer_{{$sl}}">
                <label for="answer_{{$sl}}_{{$key}}" class="form-check-label">
                  <img src="{{asset('/')}}{{$answer_choices[$key]->answer}}" style="width:100%;">
                </label>
                
            </div>
            @endforeach
          </div>
        </div>
    @endif
    @php 
      $sl++;
    @endphp
  @endforeach
</div>
</div>