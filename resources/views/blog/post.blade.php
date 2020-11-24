@extends('blog.master')
@section('body')
<style type="text/css">
  .empty-content{
    min-height: 200px;
    justify-content: center;
    align-items: center;
    display: flex;
    background: #f8f9fa;
  }
  .empty-content h4{
    color: red;
    text-transform: uppercase;
  }
</style>
  @if(empty($post))
    <div class="empty-content">
      <h4>Post not found!</h4>
    </div>
  @else
      <div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('{{asset('/')}}{{$post->image}}');padding: 20px;background-position: center center;">
      <div class="container">
        <div class="row same-height justify-content-center">
          <div class="col-md-12 col-lg-10">
            <div class="post-entry text-center">
              <span class="post-category text-white bg-success mb-3">{{$post->category_name}}</span>
              <span class="post-category text-white bg-secondary mb-3">{{$post->sub_categoy_name}}</span>
              <h3 class="mb-4"><a class="text-white">{{$post->post_title}}</a></h3>
              <div class="post-meta align-items-center text-center">
                <span>&nbsp;&nbsp; {{date('M d-Y',strtotime($post->created_at))}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="site-section py-lg">
      <div class="container">
        
        <div class="row blog-entries element-animate">

          <div class="col-md-12 col-lg-8 main-content">
            
            <div class="post-content-body">
              {!! $post->content !!}
            </div>
          </div>
          <!-- END main-content -->

          <div class="col-md-12 col-lg-4 sidebar">
            
            <!-- END sidebar-box -->  
            <div class="sidebar-box">
              <h3 class="heading">Popular Posts</h3>
              <div class="post-entry-sidebar">
                <ul>
                  @foreach($populers as $post)
                  <li>
                    <a href="{{route('post',$post->slug)}}">
                      <img src="{{asset('/')}}{{$post->image}}" alt="Image placeholder" class="mr-4">
                      <div class="text">
                        <h4>{{$post->post_title}}</h4>
                        <div class="post-meta">
                          <span class="mr-2">{{date('M d-Y',strtotime($post->created_at))}} </span>
                        </div>
                      </div>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <!-- END sidebar-box -->

            <div class="sidebar-box">
              <h3 class="heading">Categories</h3>
              <ul class="categories">
                @foreach($categoires as $category)
                <li><a href="{{route('category',$category->id)}}">{{$category->category_name}}</a></li>
                @endforeach
              </ul>
            </div>
            <!-- END sidebar-box -->
          </div>
          <!-- END sidebar -->
        </div>
      </div>
    </section>
  @endif
@endsection