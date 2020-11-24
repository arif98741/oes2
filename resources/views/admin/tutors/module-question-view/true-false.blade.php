<div class="row" style="align-items: center;">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label class="my-2 py-1">Question</label>
                    <div>
                        <textarea class="form-control form-check"  rows="5" id="question_name_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="question_name">{{$question->question_name}}</textarea>
                    </div>
                    <span id="question_name_msg"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body" style="margin: auto">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="q-btn-bg">True</div>
                    <div style="align-items: center;display: flex;">
                        <input  type="radio" @php echo ($question->answer == 1) ? 'checked' : '' @endphp name="answer" value="1" style="text-align: center;font-size: 24px;">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="q-btn-bg">False</div>
                    <div style="align-items: center;display: flex;">
                        <input  type="radio" @php echo ($question->answer == 0) ? 'checked' : '' @endphp name="answer" value="0" style="text-align: center;font-size: 24px;">
                    </div>
                </div>
                <span id="answer_msg"></span>
            </div>
        </div>
    </div>
</div>