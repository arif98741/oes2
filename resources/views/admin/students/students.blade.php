@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div>
                <h4 class="page-title">Students</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
            @endif
            @if(Session::get('error'))
                                <div class="alert alert-danger">
                                    {{Session::get('error')}}
                                </div>
            @endif
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-12">
                         <table class="table table-hover" id="student_data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    @if($institute_info['user_type'] == 2)
                                    <th>Semester</th>
                                    @endif
                                     @if($institute_info['user_type'] != 5)
                                    <th>Section</th>
                                    @endif
                                    @if($institute_info['user_type'] == 5)
                                    <th>Batch</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{asset('/')}}assets/admin/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{asset('/')}}assets/admin/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
            $('#student_data').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "{{url('admin/get-students-list')}}",
                "pageLength": 25

            } );
        } );
</script>
@endsection
