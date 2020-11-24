@extends('front-end.master')
@section('body')
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Create Module
            <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
            </div>
        </div>
        <style>
            #module-form {
                margin: auto;
            }
            #module-form sup{
                color: #e70a0a;
            }
        </style>
        <div class="card-body">
            <div class="row text-center">

                <form class="text-left" id="module-form" action="{{route('store_module')}}" method="post">
                    @csrf
                    @if(Session::get('success_message'))
                        <div class="alert alert-success">
                            {{Session::get('success_message')}}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="subject">Select subject</label>
                        <select class="form-control" id="subject" name="subject">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                            <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                                @endforeach
                        </select>
                        @error('subject')
                        <div style="color: #ef0d0d;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total-question">Total Question</label>
                        <div class="form-control" id="total-question"></div>
                    </div>
                    <div class="form-group">
                        <label for="start">Start Question Number<sup> min*1,max*<span id="start_number"></span></sup></label>
                        <input class="form-control" type="number" id="start" name="start" min="1" value="">
                        @error('start')
                        <div style="color: #ef0d0d;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="max">Maximum Number Of Question <sup> min*10,max*20</sup></label>
                        <input class="form-control" type="number" id="max" min="5" name="max" max="20" value="">
                        @error('max')
                        <div style="color: #ef0d0d;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="module_type">Select module type</label>
                        <select class="form-control" id="module_type" name="module_type">
                            <option value="">Select module type</option>
                            @foreach($module_types as $module_type)
                                <option value="{{$module_type->id}}">{{$module_type->module_type}}</option>
                            @endforeach
                        </select>
                        @error('module_type')
                        <div style="color: #ef0d0d;">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <!-- /.row-->
        </div>
    </div>

    <script>

        $("#subject").change(function () {
            var subject = $("#subject").val();
            $.ajax({
                url:'{{ url("/")}}/get-total-question/'+subject,
                type:"get",
                dataType:'json',
                success:function(data){
                    if (data.count < 1)
                    {
                        $("#start").attr('readonly','readonly');
                        $("#max").attr('readonly','readonly');
                        $("#module_type").attr('disabled','disabled');
                    }else
                    {
                        $("#start").removeAttr('readonly');
                        $("#max").removeAttr('readonly');
                        $("#module_type").removeAttr('disabled');
                    }
                    $("#start").attr('max',data.count-10);
                    $("#total-question").text(data.count);
                    $("#start_number").text(data.count-10);
                }
            });
        });
    </script>
@endsection
