<style>
    .table {
        margin-bottom: 10px;
        width: 100%;
        background-color: transparent;
    }
    table {
        border-collapse: collapse;
        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        border-spacing: 2px;
        border-color: grey;
    }
    thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 1px solid #dee2e6;
    }
    .table td{
        padding: .75rem;
        border-top: 1px solid #dee2e6;
    }
    .table th {
        padding: .75rem;
        /*border-top: 1px solid #dee2e6;*/
    }
    th {
        font-weight: 500;
        text-align: inherit;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    .table > tbody > tr > td, .table > tfoot > tr > td, .table > thead > tr > td {
        padding: 8px 12px;
        vertical-align: middle;
    }
    .institute-name{
        line-height: 22px;
        margin: 10px 0;
        font-weight: 600;
        font-size: 1.5rem;
        color: inherit;
    }
    .text-center {
        text-align: center!important;
    }
    .module-name{
        font-size: 1.25rem;
        margin: 10px 0;
        font-weight: 600;
    }
    .margin-b-0{
        margin-bottom: 0px;
    }
    #search_question_result th{
        text-align: center;
    }#search_question_result td{
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                 @if($institute->user_type == 1)
                  <p class="text-center">
                    <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
                    <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
                  </p>
                  <p class="text-center margin-b-0">{{$institute->level_name}} , {{$institute->subject_name}}</p>
                  <p class="text-center margin-b-0">{{$institute->module_name}}</p>
                  <p class="text-center margin-b-0">Total Marks: {{$total_mark}}</p>
                  @else
                  <p class="text-center">{{ucwords(strtolower($institute->name))}}</p>
                  <p class="text-center margin-b-0">{{$institute->level_name}} , {{$institute->subject_name}}</p>
                  <p class="text-center margin-b-0">{{$institute->module_name}}</p>
                  <p class="text-center margin-b-0">Total Marks: {{$total_mark}}</p>
                  @endif
            </div>
            <div class="card-body" style="margin-top: 15px;">
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
                            <th>Obtain marks</th>
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
            </div>
            <div class="card-footer text-center">
                <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>
                <span style="color: #ff9900;font-size: 13px;font-weight: bold;"> </span>
            </div>
        </div>
    </div>
</div>
