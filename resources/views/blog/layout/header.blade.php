<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ধনু পাঠশালা</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/ico" href="{{asset('/')}}assets/favicon-logo.png1" sizes="any" />
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700|Playfair+Display:400,700,900" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('/')}}assets/blog/fonts/icomoon/style.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/aos.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/blog/css/style.css">
      <script src="{{asset('/')}}assets/blog/js/jquery-3.3.1.min.js"></script>
    <style type="text/css">
      .site-section {
          padding: 3em 0 !important;
      }
    </style>
  </head>
  <body>

  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar" role="banner">
      <div class="container-fluid">
        <div class="row align-items-center">



          <div class="col-5 site-logo">
            <a href="{{route('blog')}}" class="text-black h2 mb-0">
              <span style="font-size: 26px;color: red;font-weight: 600;">OES</span>

            </a>
          </div>

          <div class="col-7 text-right">
            <nav class="site-navigation" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block mb-0">
                @foreach(get_sub_categories() as $sub)
                <li><a href="{{route('subcategory',$sub->id)}}">{{$sub->sub_categoy_name}}</a></li>
                @endforeach
                <li class="d-none d-lg-inline-block"><a href="{{route('search')}}" class="js-search-toggle"><span class="icon-search"></span></a></li>
              </ul>
            </nav>
            <a href="#" class="site-menu-toggle js-menu-toggle text-black d-inline-block d-lg-none"><span class="icon-menu h3"></span></a></div>
          </div>

      </div>
    </header>
