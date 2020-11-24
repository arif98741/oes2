@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">All Institute</li>
                    </ol>
                </div>
                <h4 class="page-title">All Institute</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <a class="btn btn-primary" href="{{route('add_institute')}}">Add Institute</a>
                    <div class="table-responsive" style="padding: 10px;">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>Institute Name</th>
                                <th>Principal Name</th>
                                <th>P.Email-Phone</th>
                                <th>A.Email-Phone</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($institutes as $institute)
                            <tr>
                                <td>{{$institute->institute_name}}</td>
                                <td>{{$institute->principal_name}}</td>
                                <td>
                                    <p>Email: {{$institute->principal_email}}</p>
                                    <p>Phone: {{$institute->principal_phone}}</p>
                                </td>
                                <td>
                                    <p>Email: {{$institute->admin_email}}</p>
                                    <p>Phone: {{$institute->admin_phone}}</p>
                                </td>
                                <td>{{$institute->address}}</td>
                                <td>{{$institute->name}}</td>
                                <td>
                                    @if($institute->status == 1)Active @else Inactive @endif

                                    <a class="btn btn-primary btn-sm" href="{{route('edit_institute',$institute->id)}}">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endsection
