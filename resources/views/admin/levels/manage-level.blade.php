@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Level</li>
                    </ol>
                </div>
                <h4 class="page-title">All level</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    {{--<a style="float: right;margin-bottom: 20px;" href="{{route('add_module')}}" class="btn btn-success btn-animation">--}}
                        {{--Add New--}}
                    {{--</a>--}}
                    <div class="col-5">
                        <h3 class="text-center admin-color">Level List</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($levels as $key=>$level)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$level->level_name}}</td>
                                    <td>
                                        <a href="{{route('edit_level', ['id' =>$level->id])}}" class="btn btn-warning btn-animation">
                                            Edit
                                        </a>
                                        <a class="btn btn-danger delete-btn" href="#" onclick="DeleteLevel({{$level->id}})">delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <h3 class="text-center admin-color">Add Level</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{action('LevelController@manage_level')}}" method="post">
                            @csrf
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="level_name">Level Name</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="level_name" type="text" name="level_name" placeholder="Enter level name">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-9 col-form-label" for="level_name"></label>
                                <div class="col-md-2">
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
function DeleteLevel(id)
  {
    if(confirm("Are you sure you want to delete this lavel?")){
      $.ajax({
        type: 'get',
        url: '{{url('delete-lavel')}}',
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
