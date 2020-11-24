<div class="row" style="align-items: center;">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label class="my-2 py-1">Question</label>
                    <div>
                        <textarea class="form-control form-check" rows="5" id="question_name_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="question_name">{{$question->question_name}}</textarea>
                    </div>
                    <span id="question_name_msg"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-5 col-form-label">How many options</label>
                    <div class="col-sm-7">
                        <input class="form-control" type="number" value="2" id="box_qty" onclick="getImageBox(this)">
                    </div>
                </div>
                <?php
                $question_answer = json_decode($question->answer);
                $i = 1;
                $lettry_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
                foreach($question_answer->answer_choice as $item) {
                ?>
                <div class="row " id="list_box_<?php echo $i;?>" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2">
                        <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$i - 1]; ?></p>
                    </div>
                    <div class="col-9">
                        <div class="box">
                            <textarea class="form-control" name="answer_choice[]" rows="5" style="margin-top: 0px; margin-bottom: 0px; height: 143px;">{{$item->answer_choice}}</textarea>
                        </div>
                    </div>
                    <div class="col-1">
                        <p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">
                            <input type="radio" name="answer" @php echo ($question_answer->answer == $i) ? 'checked' : '' @endphp value="<?php echo $i;?>" style="text-align: center;font-size: 24px;">
                        </p>
                    </div>
                </div>
                <?php
                $i++;
                }?>

                <?php for ($desired_i = $i; $desired_i <= 20; $desired_i++) { ?>
                <div class="row " id="list_box_<?php echo $desired_i;?>" style="align-items: center;display: none;margin-bottom: 10px;">
                    <div class="col-2">
                        <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$desired_i - 1]; ?></p>
                    </div>
                    <div class="col-9">
                        <div class="box">
                            <textarea class="form-control" name="answer_choice[]" rows="5" style="margin-top: 0px; margin-bottom: 0px; height: 143px;"></textarea>
                        </div>
                    </div>
                    <div class="col-1">
                        <p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">
                            <input type="radio" name="answer" value="<?php echo $desired_i;?>" style="text-align: center;font-size: 24px;">
                        </p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>