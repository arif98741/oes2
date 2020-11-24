@extends('front-end.master')
@section('body')
    <div class="card card-default" style="margin-top: 1.5rem;">
        <div class="card-header">
            <i class="fa fa-picture-o"></i>Exam Module
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
                <div class="col-md-12">
                    @if($institute->user_type == 10)
                        @if(!empty($batch))
                        <h6 class="text-center">Batch name : {{$batch->batch_name}}</h6>
                        <p style="text-align: center;margin:15px;">Batch start date <span style="color: #14de14;font-weight: bold;">{{date('Y-m-d',strtotime($batch->start_date))}}</span> and Batch End date <span style="color: #f54a4a;font-weight: bold;">{{date('Y-m-d',strtotime($batch->end_date))}}</span></p>
                        <div class="table-responsive">
                        <table class="table table-hover" id="module_data">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Module Name</th>
                                    <th scope="col">Exam Start</th>
                                    <th scope="col">Exam End</th>
                                    <th scope="col">Exam Time</th>
                                    <th scope="col">Institute Name</th>
                                    
                                </tr>
                            </thead>     
                        </table>
                    </div>
                        @else
                            <h5 class="alert alert-danger text-center">Your batch is closed!</h5>
                        @endif
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover" id="module_data">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Module Name</th>
                                    <th scope="col">Exam Start</th>
                                    <th scope="col">Exam End</th>
                                    <th scope="col">Exam Time</th>
                                    <th scope="col">Institute Name</th>
                                </tr>
                            </thead>     
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- <div class="card-body">
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
        
        </div> -->
    </div>
    <script type="text/javascript" src="{{asset('/')}}assets/admin/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{asset('/')}}assets/admin/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
            $('#module_data').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('search_exam_module_list')}}",
                "pageLength": 25

            } );
        } );
</script>
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
                url: '{{route('search_practice_module')}}',
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
