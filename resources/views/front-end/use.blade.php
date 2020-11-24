@extends('front-end.master')
@section('body')
<style type="text/css">
    .video-container {
    overflow: hidden;
    position: relative;
    width:100%;
}

.video-container::after {
    padding-top: 56.25%;
    display: block;
    content: '';
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
<div class="card card-default" style="margin-top: 1.5rem;">
    <div class="card-header">
        <i class="fa fa-picture-o"></i>কিভাবে রং ব্যবহার করব
        <div class="card-header-actions">
            <a class="card-header-action" href="" target="_blank"></a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8" style="margin: auto;">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/zPixgS6uYYU?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
