@php
    $answer = json_decode($question->answer);
    $answers = $answer->answer_choices;
    $count = count($answers);
    $lettry_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
@endphp
@for($i=0;$i<$count;$i++)
    <div class="row " id="list_box_<?php echo $i+1;?>" style="align-items: center;margin-bottom: 10px;">
        <div class="col-2">
            <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$i]; ?></p>
        </div>
        <div class="col-8">
            <div class="box">
                <img src="{{asset('/')}}{{$answers[$i]->answer}}" style="width:100%;">
            </div>
        </div>
        <div class="col-2">
            <p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">
                <input class="answer" type="radio" name="answer" value="<?php echo $i+1;?>" style="text-align: center;font-size: 24px;">
            </p>
        </div>
    </div>
@endfor