@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Sections</li>
                    </ol>
                </div>
                <h4 class="page-title">All Sections</h4>
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
                        <h3 class="text-center admin-color">Section List</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Level</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sections as $key=>$section)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$section->level_name}}</td>
                                    <td>{{$section->name}}</td>
                                    <td>
                                        <a href="{{route('edit_section', ['id' =>$section->id])}}" class="btn btn-warning btn-animation">
                                            Edit
                                        </a>
                                        <a class="btn btn-danger delete-btn" href="#" onclick="DeleteSection({{$section->id}})">delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <h3 class="text-center admin-color">Add Section</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{action('SectionController@manage_section')}}" method="post">
                            @csrf
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            <div class="row">
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
                                        <label for="exampleInputName2">Section</label>
                                        <input type="text" name="name" class="form-control">
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
function DeleteSection(id)
  {
    if(confirm("Are you sure you want to delete this section?")){
      $.ajax({
        type: 'get',
        url: '{{url('delete-section')}}',
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
