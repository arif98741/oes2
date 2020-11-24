@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Edit Level</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit level</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-4">
                    </div>
                    <div class="col-5">
                        <h3 class="text-center admin-color">Edit Level</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{route('update_level',$level->id)}}" method="post">
                            @csrf
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="level_name">Level Name</label>
                                <div class="col-md-9">
                                    <input class="form-control" value="{{$level->level_name}}" id="level_name" type="text" name="level_name" placeholder="Enter level name">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-9 col-form-label" for="level_name"></label>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-animation">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
