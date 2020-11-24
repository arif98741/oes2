<div class="table-responsive-sm">
    <table class="table" id="search_question_result">
        <thead>
            <tr>
                <th scope="col" >SL</th>
                <th>Exam Name</th>
                <th>Student Name</th>
                <th>District</th>
                <th>Correct Answer</th>
                <th>Wrong Answer</th>
                <th>Total Mark</th>
                <th>Obtain Marks</th>
            </tr>
        </thead>
        <tbody>
            @if(count($modules) > 0)
            @php 
                 $i = 1;
            @endphp
                @foreach ($modules as $module)
                <tr>
                    <td>{{$i}}</td>
                    <td>{!! $module->module_name !!}</td>
                    <td>{{$module->name}}</td>
                    <td>{{$module->bn_name}}</td>
                    @php 
                        $student_answers = json_decode($module->student_answer);
                        $correct = 0;
                        $wrong   = 0;
                        foreach($student_answers as $ans)
                        {
                            if($ans->ans_is_right == 'correct')
                            {
                                $correct++;
                            }elseif($ans->ans_is_right == 'wrong')
                            {
                                $wrong++;
                            }
                        }
                    @endphp
                    <td>{{$correct}}</td>
                    <td>{{$wrong}}</td>
                    <td>{{$module->module_mark}}</td>
                    <td>{{$module->student_mark}}</td>
                    </tr>
                    @php 
                        $i++;
                    @endphp
                @endforeach
            @else

            @endif
        </tbody>
    </table>
</div>