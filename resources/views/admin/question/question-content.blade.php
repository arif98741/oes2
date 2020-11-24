<div class="table-responsive-sm">
    <table class="table" id="search_question_result">
        <thead>
            <tr>
                <th scope="col" >SL</th>
                <th scope="col" >Question</th>
                <th scope="col">Type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="result_question">
            @if(count($questions) > 0)
            @php 
                 $i = $start;
            @endphp
                @foreach ($questions as $question)
                <tr>
                    <td>{{$i}}</td>
                    <td>{!! $question->question_name !!}</td>
                    <td>{{$question->type}}</td>
                    <td><a href="{{route('edit_question',$question->id)}}" class="btn btn-danger btn-small" target="_blank">Edit</a></td>
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
 @if($total_question > 30)
<div class="row" id="loading" style="display: none;">
    <div class="col-md-8" style="margin: auto;text-align: center;border: 1px solid #20a8d8;color: #00a1da;">
        Loading...........
    </div>
</div>
<div class="alert alert-danger print-pagination-msg" style="display:none">
    <ul>
    </ul>
</div>
<div class="row" style="justify-content: center;margin-top: 15px;">     
    {{ $questions->links() }}
</div>
@endif