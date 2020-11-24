@extends('front-end.master')
@section('body')
<div class="row">
                    <div class="col-md-12">
                      <h2 class="text-center" style="color:#f86c6b;"> বিসিএস সহ সরকারি চাকরীর প্রস্তুতি শক্তিশালী করতে ঘরে বসেই মডেল টেস্ট</h2>
                      <h3 class="text-center" style="color:#ff9900;">এবং</h3> 
                      <h4 class="text-center" style="color:#ff9900;">কৃত্রিম বুদ্ধিমত্তা দ্বারা সাথে সাথেই ফলাফল প্রদান</h4> 
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-primary">
                          <div class="card-body pb-0">
                            <div class="btn-group float-right">
                              
                            </div>
                            <div class="text-value">{{$students}}</div>
                            <div>Total Students</div>
                          </div>
                          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart1" height="70"></canvas>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-info">
                          <div class="card-body pb-0">
                            
                            <div class="text-value">{{$modules}}</div>
                            <div>Total Modules</div>
                          </div>
                          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-warning">
                          <div class="card-body pb-0">
                            <div class="btn-group float-right">
                              
                            </div>
                            <div class="text-value">{{$questions}}</div>
                            <div>Total Questions</div>
                          </div>
                          <div class="chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart" id="card-chart3" height="70"></canvas>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-danger">
                          <div class="card-body pb-0">
                            <div class="btn-group float-right">
                              
                            </div>
                            <div class="text-value">{{$subjects}}</div>
                            <div>Total Subjects</div>
                          </div>
                          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart4" height="70"></canvas>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      </div>
 <div class="row">
                        <div class="col-md-6 m-auto">
                          <div class="chart-wrapper">
                            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                              <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                                  
                                </div>
                              </div>
                            </div>
                            <p style="text-align: center;color: #03ce03;margin: 0px;">মাসে সম্পন্ন মডিউলের সংখ্যা</p>
                            <canvas id="canvas-1" style="display: block; width: 493px; height: 246px;" width="493" height="246" class="chartjs-render-monitor"></canvas>
                          </div>
                        </div>
                        <div class="col-md-6 m-auto">
                          <div class="chart-wrapper">
                            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                              <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                                  
                                </div>
                              </div>
                            </div>
                            <p style="text-align: center;color: #20a8d8;margin: 0px;">{{date('M')}} মাসে সর্বোচ্চ নাম্বার প্রাপ্ত ছাত্রছাত্রী</p>
                            <canvas id="canvas-2" style="display: block; width: 493px; height: 246px;" width="493" height="246" class="chartjs-render-monitor"></canvas>
                          </div>
                        </div>
                      </div>
<div class="card card-default" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <i class="fa fa-picture-o"></i>Home
                    <div class="card-header-actions">
                        <a class="card-header-action" href="" target="_blank"></a>
                    </div>
                </div>
                <div class="card-body">
                  
                  @if(count($m_h_users) > 0)
                  <div class="row" style="display: none;">
                    <div class="col-md-12 m-auto">
                      <h5 class="text-center">Students who received the highest marks this month</h5>
                      <div class="carousel slide" id="carouselExampleCaptions" data-ride="carousel">
                        <ol class="carousel-indicators">
                          @foreach($m_h_users as $key=>$user)
                          <li class="@php echo($key ==0 ) ? 'active' : '' @endphp" data-target="#carouselExampleCaptions" data-slide-to="{{$key}}"></li>
                          @endforeach
                        </ol>
                        <div class="carousel-inner">
                          @foreach($m_h_users as $key=>$user)
                          <div  class="slider-image carousel-item @php echo($key ==0 ) ? 'active' : '' @endphp">
                            <!-- <img class="d-block w-100 slider-image" data-src="{{asset('/')}}assets/banner/1.jpg" alt="First slide [800x400]" src="{{asset('/')}}assets/banner/1.jpg" -->
                              <!-- data-holder-rendered="true"> -->
                            <div class="carousel-caption d-none d-md-block">
                              <span class="user-image">
                                @if($user->image != '')
                                  <img src="{{asset('/')}}{{$user->image}}">
                                  
                                @else
                                  <img src="{{asset('/')}}assets/banner/user-default-grey.png">
                                @endif
                              </span>
                              <h5>{{$user->name}}</h5>
                              <p>Total marks {{$user->student_mark}}</p>
                            </div>
                          </div>
                          @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                    </div>
                  </div>
                  <br/>
                  @endif
                    
                      
                      <div class="row">
                        
                      </div>
                    <!-- /.row-->
                </div>
</div>
<script src="{{asset('/')}}assets/front-end/exam/node_modules/chart.js/dist/Chart.min.js"></script>
<script>

var months=[];
var ids=[];
  
  @foreach($date as $key=>$m)
    months[{{$key}}] = '{{$m}}';
  @endforeach
  @foreach($ids as $key=>$id)
    ids[{{$key}}] = {{$id}};
  @endforeach
  var lineChart = new Chart($('#canvas-1'), {
  type: 'line',
  data: {
    labels: months,
    datasets: [{
      label: 'মডিউলের সংখ্যা',
      backgroundColor: '#99f399',
      borderColor: '#03ce03',
      pointBackgroundColor: '#03ce03',
      pointBorderColor: '#03ce03',
      data: ids
    }]
  },
  options: {
    responsive: true
  }
});

var marks=[];
var names=[];
  
  @foreach($marks as $key=>$m)
    marks[{{$key}}] = {{$m}};
  @endforeach
  @foreach($std_name as $key=>$name)
    names[{{$key}}] = '{{$name}}';
  @endforeach
  var lineChart = new Chart($('#canvas-2'), {
  type: 'line',
  data: {
    labels: names,
    datasets: [{ 
      label: 'প্রাপ্ত নাম্বার',
      backgroundColor: '#97dff9',
      borderColor: '#20a8d8 ',
      pointBackgroundColor: '#20a8d8 ',
      pointBorderColor: '#20a8d8 ',
      data: marks
    }]
  },
  options: {
    responsive: true
  }
});
</script>
@endsection
