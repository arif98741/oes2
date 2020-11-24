@extends('admin.master')
@section('body')
<link href="{{asset('/')}}assets/admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Assignment Report</li>
                    </ol>
                </div>
                <h4 class="page-title">All Assignment Report</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul>

                        </ul>
                    </div>
                    <table class="table table-hover" id="module_table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Level</th>
                            <th>Subject</th>
                            @if(admin_type() == 2 || admin_type() == 1)
                            <th>Semester</th>
                            @endif
                            @if(admin_type() != 5)
                            <th>Section</th>
                            @endif
                            <th>ID</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="module_list_data">
                            @if(!empty($assignments))
                            @foreach($assignments as $assignment)
                            <tr>
                                <td>{{$assignment->title}}</td>
                                <td>{{$assignment->level_name}}</td>
                                <td>{{$assignment->subject_name}}</td>
                                <td>{{$assignment->semester_name}}</td>
                                <td>{{$assignment->name}}</td>
                                <td>{{$assignment->roll_no}}</td>

                                <td>
                                    @if($assignment->ans_id != '')
                                    <a href="{{route('std_answer_report',[$assignment->id,$assignment->ans_id])}}" class="btn btn-primary btn-sm" target="_blank">Answer</a>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <p style="color:red">No data found!</p>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
