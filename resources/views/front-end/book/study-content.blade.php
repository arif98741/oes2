<style>
	p span{
		    margin-right: 10px;
	}
	.type-one .form-check{
		width: 28%;
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
</style>
@php 
	$sl = $start;
@endphp
@if(count($questions) > 0)
<div class="row content">
	@foreach($questions as $question)
		@if($question->question_type == 1)
			
				<div class="col-md-6 type-one m-b-15">
					<h6><span>{{$sl}} . </span>{!! $question->question_name !!}</h6>
					<div class="answer">
						<div class="form-check">
						    <input type="radio" @php echo($question->answer = 1) ? 'checked' : '' @endphp class="form-check-input">
						    <label class="form-check-label">True</label>
						  </div>
						  <div class="form-check">
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
						<div class="form-check">
						    <input type="radio" @php echo($key+1 == $answer) ? 'checked' : '' @endphp class="form-check-input">
						    <label class="form-check-label">{{$choice->answer_choice}}</label>
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
@else
	<p style="color:red;text-align: center;">No data found!</p>
@endif
@if($total_question > 50)
<div class="row" id="paginate_loading" style="display: none;">
    <div class="col-md-8" style="margin: auto;text-align: center;border: 1px solid #20a8d8;color: #00a1da;">
    	Loading...........
    </div>
</div>
<div class="alert alert-danger print-pagination-msg" style="display:none">
    <ul>
    </ul>
</div>
<div class="row" id="paginate_content" style="justify-content: center;margin-top: 15px;">       
    {{ $questions->links() }}
</div>
@endif