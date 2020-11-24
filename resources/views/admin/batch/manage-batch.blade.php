@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Batch</li>
                    </ol>
                </div>
                <h4 class="page-title">All Batch</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-7">
                        <h3 class="text-center admin-color">Batch List</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Level</th>
                                <th>Batch</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($batches as $key=>$batch)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$batch->level_name}}</td>
                                    <td>{{$batch->batch_name}}</td>
                                    <td>{{date('Y-m-d',strtotime($batch->start_date))}}</td>
                                    <td>{{date('Y-m-d',strtotime($batch->end_date))}}</td>
                                    <td>
                                        <a href="{{route('edit_batch', ['id' =>$batch->id])}}" class="btn btn-warning btn-animation">
                                            Edit
                                        </a>
                                        <a class="btn btn-danger delete-btn" href="#" onclick="DeleteBatch({{$batch->id}})">delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-5">
                        <h3 class="text-center admin-color">Add Batch</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{action('BatchController@manage_batch')}}" method="post">
                            @csrf
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            <div class="row" style="justify-content: center;">
                                <div class="col-md-8">
                                    <div class="form-group" >
                                        <label for="exampleInputName2">Level</label>
                                        <div class="select">
                                            <select class="form-control select-hidden form-check" name="level_id">
                                                <option value="">Select Level</option>
                                                @foreach($levels as $level)
                                                    <option value="{{$level->id}}">
                                                        {{$level->level_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="student_grade_msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="batch_name">Batch</label>
                                        <input type="text" id="batch_name" name="batch_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="start_date">Start date</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8 text-right">
                                    <button type="submit" class="btn btn-success btn-animation">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
function DeleteBatch(id)
  {
    if(confirm("Are you sure you want to delete this section?")){
      $.ajax({
        type: 'get',
        url: '{{url('delete-batch')}}',
        dataType:'json',
        data:{id:id},
        beforeSend: function() {
          $('.delete-btn').prop('disabled', true);
        },
        success: function (data){
            $('.delete-btn').prop('disabled', false);
            if(data == 1)
            {
              alert('Successfully Deleted.');
              location.reload();
            }else{
              alert('Delete failed');
            }

          },
        error: function(e) {
            console.log(e);
        }
      });
    }
  }
    </script>
@endsection
