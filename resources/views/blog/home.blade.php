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
      <div class="site-section bg-light">
      <div class="container">
        <div class="row align-items-stretch retro-layout-2">
          @foreach($categories as $cat)
          <div class="col-md-4">
            <a href="{{route('category',$cat->id)}}" class="h-entry mb-30 v-height gradient" style="background-image: url('{{asset('/')}}{{$cat->image}}')">
              
              <div class="text">
                <span class="post-category text-white bg-success mb-3">Category</span>
                <h2>{{$cat->category_name}}</h2>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div id="regular_section">
          <div class="row mb-3">
            <div class="col-12">
              <h2>Recent Posts</h2>
            </div>
          </div>
          <div class="row">
            @foreach($recent_posts as $post)
            <div class="col-lg-4 mb-4">
              <div class="entry2">
                <a href="{{route('post',$post->slug)}}"><img src="{{asset('/')}}{{$post->image}}" alt="Image" class="img-fluid rounded"></a>
                <div class="excerpt">
                <span class="post-category text-white bg-warning ">{{$post->sub_categoy_name}}</span>

                <h2 style="margin-bottom: 0px;"><a href="{{route('post',$post->slug)}}">{{$post->post_title}}</a></h2>
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
          <div class="row text-center pt-5 border-top">
            <div class="col-md-12">
              <!-- <div class="custom-pagination"> -->
                {{$recent_posts->links()}}
              <!-- </div> -->
            </div>
          </div>
        </div>
        <div id="change_able-section">
        </div>
      </div>
    </div>
@endsection