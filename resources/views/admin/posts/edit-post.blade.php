@extends('admin.master')
@section('body')
    <style xmlns="http://www.w3.org/1999/html">
        .q-btn-bg{
            width: 40px;
        }
        .close-btn{
            padding: 10px;
            border-radius: 75%;
            background: #eaeef1;
            cursor: pointer;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Edit Post</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Post</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if ($errors->any() || Session::get('success')|| Session::get('error'))
        <div class="row error-message">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: right;padding: 10px;"><span class="close-btn">x</span></div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(Session::get('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                        @if(Session::get('error'))
                            <div class="alert alert-danger">
                                {{Session::get('error')}}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
    <form id="question_form" action="{{route('edit_post',$post->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label for="post_title">Title</label>
                                    <div class="select">
                                        <input required="required" value="{{$post->post_title}}" class="form-control" type="text" name="post_title" placeholder="title">
                                    </div>
                                    <span id="post_title_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <div class="select">
                                        <select required="required" class="form-control select-hidden" id="category"  name="category">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option @php echo($post->category == $category->id) ? 'selected' : '' @endphp value="{{$category->id}}">
                                                    {{$category->category_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span id="category_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sub_category">Sub Category</label>
                                    <div class="select">
                                        <select required="required" class="form-control select-hidden" id="sub_category"  name="sub_category">
                                            <option value="">Select Sub Category</option>
                                            @foreach($subcategories as $subcategory)
                                                <option @php echo($post->sub_category == $subcategory->id) ? 'selected' : '' @endphp value="{{$subcategory->id}}">
                                                    {{$subcategory->sub_categoy_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span id="category_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label for="slug">Slug</label>
                                    <div class="select">
                                        <input type="text" value="{{$post->slug}}" placeholder="Enter post slug" required="required" class="form-control" name="slug" id="slug">
                                    </div>
                                    <span id="slug_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div>
                                    <img src="{{url('/')}}/{{$post->image}}" height="200px;weight:200px;">
                                </div>
                                <div class="form-group" >
                                    <label for="image">Image</label>
                                    <div class="select">
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label for="content">Content</label>
                                    <div class="select">
                                        <textarea required="required" class="form-control" name="content" id="summernote">{!! $post->content !!}</textarea>
                                    </div>
                                    <span id="content_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <div class="select">
                                        <select class="form-control select-hidden" id="post_status"  name="post_status">
                                            <option @php echo($post->post_status == 1) ? 'selected' : '' @endphp value="1">Active</option>
                                            <option @php echo($post->post_status == 0) ? 'selected' : '' @endphp value="0">Inactive</option>

                                        </select>
                                    <span id="status_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <div class="form-group" >
                                    <div class="select">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </form>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
  $('#summernote').summernote({
    tabsize: 2,
        height: 400,
  });
});

    $("#category").change(function(){
        var cat_id = $(this).val();
        $.ajax({
        type: 'get',
        url: '{{url('get-post-sub-categories')}}',
        dataType:'json',
        data:{id:cat_id},
        success: function (data){
                   $("#sub_category").html(data);
          },
        error: function(e) {
            console.log(e);
        }
      });
    });
</script>
@endsection
