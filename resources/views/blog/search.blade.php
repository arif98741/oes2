@extends('blog.master')
@section('body')
<style type="text/css">
  .pagination li a{
    border-radius: 0px !important;

  }
  .pagination{
    margin-bottom: 0px !important;
  }
</style>

<div class="site-section" style="background: #f8f9fa;">
      <div class="container">
          <div class="search-container" style="    margin-bottom: 15px;">
            <div class="row">
              <div class="col-md-12">
                <form id="search_form" style="padding-right: 20px;">
                  @csrf
                  <input type="text" class="form-control search-field" placeholder="Search.." name="search">
                </form>
              </div>
            </div>
          </div>
          <div id="search_content">
          </div>
          <div id="main_content">
            <div class="row">
          @foreach($posts as $post)
          <div class="col-lg-4 mb-4">
            <div class="entry2">
              <a href="{{route('post',$post->slug)}}"><img src="{{asset('/')}}{{$post->image}}" alt="Image" class="img-fluid rounded"></a>
              <div class="excerpt">
              <span class="post-category text-white bg-secondary mb-3">{{$post->sub_categoy_name}}</span>

              <h2><a href="{{route('post',$post->slug)}}">{{$post->post_title}}</a></h2>
              <div class="post-meta align-items-center text-left clearfix">
                <span>{{date('M d-Y',strtotime($post->created_at))}}</span>
              </div>
              @php 

                $string = strip_tags($post->content);
                    if (strlen($string) > 200) {

                        $stringCut = substr($string, 0, 200);
                        $endPoint = strrpos($stringCut, ' ');
                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                    }
                @endphp
                <p>{{$string}}</p>
                <p><a href="{{route('post',$post->slug)}}">Read More</a></p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
          </div>
    </div>
  </div>
  <script>
    $(".search-field").keyup(function(){
      var value = $(this).val();
      if(value != '')
      {
         var form = $("#search_form");
          $.ajax({
              type:'post',
              url:'{{route('search')}}',
              data:form.serialize(),
              dataType:'json',
              success:function(response){
                $("#main_content").hide();
                $("#search_content").show();
                $("#search_content").html(response.view);
              },
              error: function(data){
                  console.log(data);
              }
          });
      }else{
        $("#search_content").hide();
        $("#main_content").show();
      }
    });
  </script>
@endsection