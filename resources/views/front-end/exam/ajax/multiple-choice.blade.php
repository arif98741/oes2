@php
    $answer = json_decode($question->answer);
    $answers = $answer->answer_choice;
    $count = count($answers);
    $lettry_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
@endphp
@for($i=0;$i<$count;$i++)
<div class="answer-box">
    <div class="row " id="list_box_<?php echo $i+1;?>" style="align-items: center;margin-bottom: 10px;">
        <div class="col-1">
            <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$i]; ?></p>
        </div>
        <div class="col-9">
            <div class="box">
                <textarea class="form-control" disabled rows="5" style="text-align: center;margin-top: 0px; margin-bottom: 0px; height: 143px;">{{$answers[$i]->answer_choice}}</textarea>
            </div>
        </div>
        <div class="col-1" style="padding: 0px;">
            <p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">
                <input class="answer" type="radio" name="answer" value="<?php echo $i+1;?>" style="text-align: center;font-size: 24px;">
            </p>
        </div>
    </div>
</div>    
@endfor