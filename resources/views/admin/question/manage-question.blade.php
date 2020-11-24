@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Question Type</li>
                    </ol>
                </div>
                <h4 class="page-title">Question Type</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-10" style="margin: auto;">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col" >Type Name</th>
                                <th scope="col">Total Question</th>
                            </tr>
                            </thead>
                            <tbody class="question-t-body">
                            @foreach($question_types as $type)
                            <tr >
                                <th scope="row" style="background: #76e2cc;"><a style="color:#212529;" href="{{route('manage_question_type',$type->id)}}">{{$type->type}}</a></th>

                                <th class="total-question">
                                    {{QuestionTypeCount($type->id)}}
                                </th>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--end row-->
@endsection
