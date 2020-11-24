@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Edit Semester</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Semester</h4>
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
                        <h3 class="text-center admin-color">Edit Semester</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="text-align: center;color: red;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{route('update_semester',$semester->id)}}" method="post">
                            @csrf
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group" >
                                        <label for="exampleInputName2">Level</label>
                                        <div class="select">
                                            <select class="form-control select-hidden form-check" name="level_id">
                                                <option value="">Select Level</option>
                                                @foreach($levels as $level)
                                                    <option value="{{$level->id}}" @if($semester->level_id == $level->id) selected @endif>
                                                        {{$level->level_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="student_grade_msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputName2">Semester</label>
                                        <input type="text" name="semester" value="{{$semester->semester_name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8 text-right">
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
