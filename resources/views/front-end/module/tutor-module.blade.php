@extends('front-end.master')
@section('body')
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Module
            <div class="card-header-actions">
                <a class="card-header-action" href="" target="_blank"></a>
            </div>
        </div>
        <style>

            #table-content a{
                text-decoration: none;
                color: #2f353a;
            }
        </style>
        <div class="card-body">
            <div class="row" style="justify-content: center;">
                <div class="col-md-10">
                    <div class="row" style="justify-content: center;">
                        <div class="col-md-5">
                            <form id="search_module" method="post">
                                @csrf
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul>

                                    </ul>
                                </div>
                                <div class="form-group">
                                  <label for="name">Subject Name</label>
                                  <select class="form-control" id="subject" name="subject">
                                  <option>Select Subject</option>
                                  @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                                  @endforeach
                                </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Module Name</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="table_content">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
    <script>
        $(".module-type").click(function () {

            var type = $(this).attr("type-id");
            var url = '{{route('get_module')}}';
            $.ajax({
                type:'get',
                url:url,
                data:{type:type},
                dataType:'html',
                success:function(response){
                    $("#table-content").html(response);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        $("#subject").change(function(){

            var form = $("#search_module");
            $.ajax({
                type:"POST",
                url: '{{route('search_exam_module')}}',
                dataType:'json',
                data:form.serialize(),
                success:function(data){
                    if($.isEmptyObject(data.error)){
                        $("#table_content").html(data.success);
                        $(".print-error-msg").css('display','none');

                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        
        });

        function printErrorMsg (msg) {

            $(".print-error-msg").find("ul").html('');

            $(".print-error-msg").css('display','block');

            $.each( msg, function( key, value ) {

                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    </script>
@endsection
