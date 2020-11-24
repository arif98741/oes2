  
<div class="site-footer" style="padding: 15px;">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <!-- <h3 class="footer-heading mb-4">About Us</h3> -->
            <p></p>
          </div>
          <div class="col-md-3 ml-auto">
            <ul class="list-unstyled float-left mr-5">
              @foreach(get_categories() as $key=>$cat)
                @if($key < 5)
                <li style="margin-bottom: 0px;"><a href="{{route('category',$cat->id)}}">{{$cat->category_name}}</a></li>
                @endif
               @endforeach
            </ul>
            <ul class="list-unstyled float-left">
              @foreach(get_sub_categories() as $key=>$sub)
                @if($key < 5)
                <li style="margin-bottom: 0px;"><a href="{{route('subcategory',$sub->id)}}">{{$sub->sub_categoy_name}}</a></li>
                @endif
               @endforeach
            </ul>
          </div>
          <div class="col-md-4">
            

            <div>
              <h3 class="footer-heading mb-4">Connect With Us</h3>
              <p>
                <a target="_blank" href="https://web.facebook.com/rangdhanupathshala"><span class="icon-facebook pt-2 pr-2 pb-2 pl-0"></span></a>
                <a href="#"><span class="icon-twitter p-2"></span></a>
                <a href="#"><span class="icon-instagram p-2"></span></a>
                <a href="#"><span class="icon-envelope p-2"></span></a>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('/')}}assets/blog/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/jquery-ui.js"></script>
  <script src="{{asset('/')}}assets/blog/js/popper.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/bootstrap.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/owl.carousel.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/jquery.stellar.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/jquery.countdown.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/jquery.magnific-popup.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/bootstrap-datepicker.min.js"></script>
  <script src="{{asset('/')}}assets/blog/js/aos.js"></script>
  <script src="{{asset('/')}}assets/blog/js/main.js"></script>
  </body>
</html>