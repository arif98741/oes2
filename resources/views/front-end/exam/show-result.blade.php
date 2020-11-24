<div class="card card-default" style="margin-top: 1.5rem;">
    <div class="card-header">
        <i class="fa fa-picture-o"></i>Exam Result
        <div class="card-header-actions">
            <a class="card-header-action" href="" target="_blank"></a>
        </div>
    </div>
    <div class="card-body">
        <h4 class="result-title">Dear <span class="front-text-color">{{$user_name}}</span> .You've finished the <span class="front-text-color">{{$module_name}}</span>.</h4>
        <div class="row text-center">
            <div class="col-sm-8 col-md-10" style="margin: auto;">
                <table class="table table-hover mark-table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Answer</th>
                        <th scope="col">Question Mark</th>
                        <th scope="col">Obtain Mark</th>
                    </tr>
                    </thead>
                    <tbody id="question_mark_status">
                    <?php $i =1;?>
                    @foreach($student_answers as $student_answer)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$student_answer->ans_is_right}}</td>
                            <td>{{$student_answer->student_question_marks}}</td>
                            <td>{{$student_answer->student_marks}}</td>
                        </tr>
                        <?php $i++;?>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">Total</td>
                        <td id="total_mark">{{$module_mark}}</td>
                        <td id="obtain_mark">{{$student_mark}}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.row-->
    </div>
</div>