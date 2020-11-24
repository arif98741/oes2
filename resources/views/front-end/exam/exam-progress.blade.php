@extends('front-end.master')
@section('body')
<div class="card card-default" style="margin-top: 1.5rem;">
    <div class="card-header">
        <i class="fa fa-picture-o"></i>Your Score
        <div class="card-header-actions">
            <a class="card-header-action" href="" target="_blank"></a>
        </div>
    </div>
    <style>

        #table-content a{
            text-decoration: none;
            color: #2f353a;
        }
        .card-body h5{
            text-align: center;
            padding: 10px;
        }
        .card-body h5 span{
            color: #1d9bc6;
        }
        .width-40{
            width: 40px;
        }
        .h-200{
            min-height: 200px;
        }
        .p-0-6{
            padding: 0px 6px;
        }
        .mark-table th
        {
            padding: 6px 10px;
            border: 1px solid #e0dddd;
        }
        .mark-table td{
            border: 1px solid #e0dddd;
        }
        .margin-auto
        {
            margin: auto;
            width: 100px;
        }
        .carousel-control-prev{
            position: absolute;
            background: red;
            width: 0px;
            color: green;
            bottom: 0px;
            left: 33%;
        }
        .carousel-control-next{
            position: absolute;
            background: red;
            width: 0px;
            color: green;
            bottom: 0px;
            right: 33%;
        }
        .carousel-btn{
            /*padding: 10px;*/
            /*background: red;*/
        }
    </style>
    <div class="card-body">
        <h5><span>{{$progress->module_name}}</span></h5>

        <div class="carousel" id="carouselExampleControls" data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                <?php $i = 1;

                ?>
                @foreach($data as $key=>$value)
                <div class="carousel-item <?php if($key == 0){echo 'active';}?>">
                    <div class="row text-center">
                        <div class="col-sm-6 col-md-4">
                            <div class="card">
                                <div class="card-header">Question</div>
                                <div class="card-body h-200 " id="question_name">
                                    {{$value['data']['question_name']}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 r-m-b-20">
                            <div class="card">
                                <div class="card-header">Answer</div>
                                <div class="card-body h-200" id="ajax_view">
                                    <?php echo $value['html']?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card">
                                <div class="card-header">Marks</div>
                                <div class="card-body h-200 p-0-6">
                                    <table class="table table-hover mark-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Status</th>
                                            <th scope="col">Mark</th>
                                            <th scope="col">Obtain</th>
                                        </tr>
                                        </thead>
                                        <tbody id="question_mark_status">
                                        <?php
//                                            echo '<pre>';
//                                            print_r($marks_array[$key]['data']);
                                        ?>
                                        @foreach($marks_array[$key]['data'] as $item)
                                            <tr>
                                                <td>{{$item['ans_is_right']}}</td>
                                                <td>{{$item['question_mark']}}</td>
                                                <td>{{$item['student_mark']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="1">Total</td>
                                            <td id="total_mark">{{$marks_array[$key]['total']}}</td>
                                            <td id="obtain_mark">{{$marks_array[$key]['obtain']}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php $i++;?>
                @endforeach
            </div>
            <div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-btn btn btn-primary" style="padding: 3px 8px;" aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-btn btn btn-primary" style="padding: 3px 8px;" aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <!-- /.row-->
    </div>
</div>

@endsection
