<style>
	p span{
		    margin-right: 10px;
	}
	.type-one .form-check{
		width: 49%;
    	display: inline-block;
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
</style>
<form id="answer_form" action="{{route('answer_submit',$module->id)}}" method="post">
@csrf
<div class="alert alert-info kk_alert kk_processing_alert" role="alert" style="margin-top: 10px;">
    <p class="text-center">Processing...</p>
</div>
<div class="alert alert-danger print-error-msg" style="display:none">
    <ul>

    </ul>
</div>
@php 
	$sl = 1;
@endphp
@if(count($questions) > 0)
<div class="row content">
	@foreach($questions as $question)
		@if($question->question_type == 1)
			
				<div class="col-md-6 type-one m-b-15">
					<h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
					<div class="answer">
						<div class="form-check">
						    <input type="radio" name="answer_{{$sl}}" value="1" class="form-check-input">
						    <label class="form-check-label">True</label>
						  </div>
						  <div class="form-check">
						    <input type="radio" name="answer_{{$sl}}" value="0" class="form-check-input">
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
						<div class="form-check">
						    <input type="radio" name="answer_{{$sl}}" id="answer_{{$sl}}_{{$key}}" value="{{$key+1}}" class="form-check-input answer answer_{{$sl}}">
						    <label for="answer_{{$sl}}_{{$key}}" class="form-check-label">{{$choice->answer_choice}}</label>
						</div>
						@endforeach
					</div>
				</div>
		@elseif($question->question_type == 5)
				<div class="col-md-6 type-two m-b-15">
					<h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
					<div class="answer">
						<input type="text" style="width: 80%;" name="answer_{{$sl}}" placeholder="Enter your answer" class="form-control">
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
						<div class="form-check" style="margin-bottom: 5px;">
						    <input type="radio" name="answer_{{$sl}}" id="answer_{{$sl}}_{{$key}}" value="{{$key+1}}" class="form-check-input answer answer_{{$sl}}">
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
	<div class="col-md-12 text-center" style="margin-top: 15px;">
		<button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
	</div>
</div>
@else
	<p style="color:red;text-align: center;">No data found!</p>
@endif
</form>