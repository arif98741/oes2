@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">EYB</a></li>
                        <li class="breadcrumb-item active">Edit Sub Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Sub Category</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-4">
                    </div>
                    <div class="col-6">
                        <h3 class="text-center admin-color">Edit Sub Category</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{route('edit_subcategory',$sub_category->id)}}" method="post">
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
                                            <option @php echo($sub_category->category_id == $category->id) ? 'selected' : '' ; @endphp value="{{$category->id}}">
                                                {{$category->category_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="sub_categoy_name">Sub Category</label>
                                <div class="col-md-9">
                                    <input class="form-control" value="{{$sub_category->sub_categoy_name}}" id="sub_categoy_name" type="text" name="sub_categoy_name" >
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-9 col-form-label" for="category_name"></label>
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

    </script>
@endsection
