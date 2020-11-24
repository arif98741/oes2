@extends('front-end.master')
@section('body')
<div class="card card-default" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <i class="fa fa-picture-o"></i>Dashboard
                    <div class="card-header-actions">
                        <a class="card-header-action" href="" target="_blank"></a>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::get('success'))
                        <div class="alert alert-success text-center">
                            {{Session::get('success')}}
                        </div>
                    @endif
                     <div class="row">
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-primary">
                  <div class="card-body pb-0">
                    <div class="btn-group float-right">
                      
                    </div>
                    <div class="text-value">{{$modules}}</div>
                    <div>Available Modules</div>
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
                    
                    <div class="text-value">{{$answers}}</div>
                    <div>Complete Modules</div>
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
                    <div class="text-value">{{$module_marks}}</div>
                    <div>Total Module Marks</div>
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
                    <div class="text-value">{{$student_marks}}</div>
                    <div>Total obtain Marks</div>
                  </div>
                  <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.col-->
            </div>
                    <!-- /.row-->
                </div>
            </div>
@endsection
