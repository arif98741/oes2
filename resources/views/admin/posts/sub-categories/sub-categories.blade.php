@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Sub Categories</li>
                    </ol>
                </div>
                <h4 class="page-title">All Sub Categories</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-7">
                        <h3 class="text-center admin-color">Sub Category List</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($sub_categories as $key=>$sub_category)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$sub_category->category_name}}</td>
                                    <td>{{$sub_category->sub_categoy_name}}</td>
                                    <td>
                                        <a href="{{route('edit_subcategory', ['id' =>$sub_category->id])}}" class="btn btn-warning btn-animation">
                                            Edit
                                        </a>
                                        <a class="btn btn-danger delete-btn" href="#" onclick="DeleteSubCategory({{$sub_category->id}})">delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-5">
                        <h3 class="text-center admin-color">Add Sub Category</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{action('PostCategories@manageSubCategory')}}" method="post">
                            @csrf
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="category_id">Category</label>
                                <div class="col-md-9">
                                    <select class="form-control select-hidden form-check" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">
                                                {{$category->category_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="sub_categoy_name">Sub Category</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="sub_categoy_name" type="text" name="sub_categoy_name" >
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
function DeleteSubCategory(id)
  {
    if(confirm("Are you sure you want to delete this sub category?")){
      $.ajax({
        type: 'get',
        url: '{{url('delete-sub-category')}}',
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
