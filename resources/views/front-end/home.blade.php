@extends('front-end.master')
@section('body')
    <style type="text/css">
        .container-fluid {
            background: #fff;
            padding-top: 30px !important;
            padding-bottom: 30px !important;
        }

        @media screen and (max-width: 1170px) {
            .main-title {
                font-size: 22px;
            }
        }
    </style>
    <div class="row">

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
                <div class="chartjs-size-monitor"
                     style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                    <div class="chartjs-size-monitor-expand"
                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink"
                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:200%;height:200%;left:0; top:0">

                        </div>
                    </div>
                </div>
                <p style="text-align: center;color: #03ce03;margin: 0px;">Completed Module in a Month</p>
                <canvas id="canvas-1" style="display: block; width: 493px; height: 246px;" width="493" height="246"
                        class="chartjs-render-monitor"></canvas>
            </div>
        </div>
        <div class="col-md-6 m-auto">
            <div class="chart-wrapper">
                <div class="chartjs-size-monitor"
                     style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                    <div class="chartjs-size-monitor-expand"
                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink"
                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:200%;height:200%;left:0; top:0">

                        </div>
                    </div>
                </div>
                <p style="text-align: center;color: #20a8d8;margin: 0px;">{{date('M')}} Highest Number Gained Student</p>
                <canvas id="canvas-2" style="display: block; width: 493px; height: 246px;" width="493" height="246"
                        class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>

    <script src="{{asset('/')}}assets/front-end/exam/node_modules/chart.js/dist/Chart.min.js"></script>
    <script>

        var months = [];
        var ids = [];

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
                    label: 'Number of Module',
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

        var marks = [];
        var names = [];

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
                    label: 'gained number',
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
