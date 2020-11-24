@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Posts</li>
                    </ol>
                </div>
                <h4 class="page-title">All Posts</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="post_search_form">
                        @csrf
                    <div class="form-group select-box width-200">
                        <label for="post_title">Post Title</label>
                        <div class="select">
                            <input type="text" class="form-control" name="post_title" id="post_title">
                        </div>
                    </div>
                    <div class="form-group select-box width-200">
                        <label for="category_id">Category</label>
                        <div class="select">
                            <select class="form-control select-hidden" name="category_id" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{$category->category_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group select-box width-200" >
                        <label for="sub_category">Sub Category</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="sub_category" name="sub_category">
                                <option value="">Select Sub Category</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 5px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-danger btn-animation search_btn">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <a href="{{route('add_post')}}" class="btn btn-success btn-animation">
                                Add New
                            </a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul>

                        </ul>
                    </div>
                    <table class="table table-hover" id="module_table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="post_list_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(".search_btn").click(function () {

            var form = $("#post_search_form");
            var url = '{{route('search_post')}}';
            $.ajax({
                type:'post',
                url:url,
                data:form.serialize(),
                dataType:'json',
                success:function(data){
                    if($.isEmptyObject(data.error)){

                        $("#post_list_data").html(data.success);
                        $(".print-error-msg").css('display','none');
                    }else{

                        printErrorMsg(data.error);
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        function printErrorMsg (msg) {

            $(".print-error-msg").find("ul").html('');

            $(".print-error-msg").css('display','block');

            $.each( msg, function( key, value ) {

                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
function DeletePost(id)
  {
    if(confirm("Are you sure you want to delete this post?")){
      $.ajax({
        type: 'get',
        url: '{{url('delete-post')}}',
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
  $("#category_id").change(function(){
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
