<div class="site-section bg-white">
      <div class="container">
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