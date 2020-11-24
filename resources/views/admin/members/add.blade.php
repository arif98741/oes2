@extends('admin.master')
@section('body')
    <style>
        .q-btn-bg{
            width: 40px;
        }
        .close-btn{
            padding: 10px;
            border-radius: 75%;
            background: #eaeef1;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Add Member</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Member</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if ($errors->any() || Session::get('success')|| Session::get('error'))
        <div class="row error-message">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: right;padding: 10px;"><span class="close-btn">x</span></div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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

                    </div>
                </div>
            </div>
        </div>
    @endif
    <form id="question_form" action="{{route('admin.add_member')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Name</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="name" placeholder="name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Email</label>
                                    <div class="select">
                                        <input class="form-control" type="email" name="email" placeholder=" email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Phone</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Address</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="address" placeholder="Address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="exampleInputName2">Password</label>
                                    <div class="select">
                                        <input class="form-control" type="text" name="password" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputName2">Status</label>
                                    <div class="select">
                                        <select class="form-control select-hidden form-check"  name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="form-group" >
                                    <div class="select">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
@endsection
