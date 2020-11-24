@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Image Response</li>
                    </ol>
                </div>
                <h4 class="page-title">Question Type</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <form id="question_form" action="{{route('save_question')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Level</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="student_grade" name="student_grade">
                                <option value="">Select Level</option>
                                @foreach($levels as $level)
                                    <option value="{{$level->id}}">
                                        {{$level->level_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="student_grade_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Subject</label>
                        <div class="select">
                            <select class="form-control select-hidden form-check" id="subjects" name="subjects">
                                <option value="">Select Subject</option>
                            </select>
                            <input type="hidden" name="type" value="7">
                        </div>
                        <span id="subject_msg"></span>
                    </div>

                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-danger btn-animation" data-animation="slideInDown" data-toggle="modal" data-target="#exampleModalLong-1">
                                Mark
                            </button>
                        </div>
                        <span id="mark_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-success btn-animation" id="Explanation">
                                Explanation
                            </button>
                        </div>
                        <span id="explanation_msg"></span>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="submit" class="btn btn-success btn-animation" id="save">
                                Save
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                            <label for="exampleInputName2">&nbsp;</label>
                            <div class="select">
                                <a class="btn btn-warning" href="{{route('manage_question_type',7)}}">Back</a>
                            </div>
                        </div>
                    <!-- <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-warning btn-animation">
                                Preview
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div> <!-- end col -->
        <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle-1">Question mark</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label class="mb-2 pb-1">Mark</label>
                            <input type="number" class="form-control form-check" min="1" id="mark_value" placeholder="Set Question Mark" value="1" name="question_mark">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Set</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="details" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle-1">Question Explanation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label class="mb-2 pb-1">Explanation</label>
                            <textarea class="form-control form-check" rows="5" id="explanation_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="explanation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Set</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @if ($errors->any() || Session::get('success_message'))
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

                            @if(Session::get('success_message'))
                                <div class="alert alert-success">
                                    {{Session::get('success_message')}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endif
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="my-2 py-1">Question</label>
                        <div>
                            <textarea class="form-control form-check" rows="5" id="question_name_value" style="margin-top: 0px; margin-bottom: 0px; height: 143px;" name="question_name"></textarea>
                        </div>
                        <span id="question_name_msg"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                   <div class="form-group row">
                        <label for="example-text-input" class="col-sm-5 col-form-label">How many options</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="number" value="4" id="box_qty" onclick="getImageBox(this)">
                        </div>
                    </div>
                    <?php
                    $lettry_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
                    for ($i = 1; $i <= 2; $i++) {
                    ?>
                    <div class="row list_box_class" id="list_box_<?php echo $i;?>" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2">
                            <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$i - 1]; ?></p>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <div class="col-sm-8"><label class="col control-label">Image file</label></div>
                                <div class="col-sm-8">
                                    <input type="file"  id="image_0" name="Image[]" accept=".png, .jpg, .jpeg .gif" >
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">
                                <input type="radio" name="answer" value="<?php echo $i;?>" style="text-align: center;font-size: 24px;">
                            </p>
                        </div>
                    </div>
                    <?php }?>

                    <?php for ($desired_i = $i; $desired_i <= 20; $desired_i++) { ?>
                    <div class="row list_box_class" id="list_box_<?php echo $desired_i;?>" style="align-items: center;display: none;margin-bottom: 10px;">
                        <div class="col-2">
                            <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$desired_i - 1]; ?></p>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <div class="col-sm-8"><label class="col control-label">Image file</label></div>
                                <div class="col-sm-8">
                                    <input type="file"  id="image_0" name="Image[]" accept=".png, .jpg, .jpeg .gif" >
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">
                                <input type="radio" name="answer" value="<?php echo $desired_i;?>" style="text-align: center;font-size: 24px;">
                            </p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="image_quantity" id="image_quantity" value="4">
    </form>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('question_name_value');
    </script>
    <script>
        var qtye = $("#box_qty").val();
        document.getElementById("image_quantity").value = qtye;

        common(qtye);
        function getImageBox() {

            var qty = $("#box_qty").val();
            console.log(qty);
            if (qty < 4) {
                $("#box_qty").val(4);
            } else if (qty > 20) {
                $("#box_qty").val(20);
            } else {
                $('.editor_hide').hide();
                document.getElementById("image_quantity").value = qty;
                common(qty);
            }

        }
        function common(quantity)
        {
            console.log(quantity);
            $(".list_box_class").hide();
            for (var i = 1; i <= quantity; i++)
            {
                $('#list_box_' + i).show();
            }
        }
    </script>
    <script>
        $("#Explanation").click(function () {
            $("#details").modal('show');
        });
        $("#student_grade").change(function () {
            var student_grade = $("#student_grade").val();

            $.ajax({
                url:'{{ url("/")}}/get-subjects/'+student_grade,
                type:"get",
                dataType:'json',
                success:function(data){
                    $("#subjects").html(data.subject);
                }
            });
        });

        $(".close-btn").click(function () {
            $(".error-message").hide();
        });
        $(".form-check").change(function () {
            var field = [];
            var msg_id = [];
            field[0] = 'student_grade';
            field[1] = 'subject';
            field[2] = 'mark_value';
            field[3] = 'question_name_value';
            msg_id[0] = 'student_grade_msg';
            msg_id[1] = 'subject_msg';
            msg_id[2] = 'mark_msg';
            msg_id[3] = 'question_name_msg';
            var msg_name = [];
            msg_name[0] = 'student level';
            msg_name[1] = 'subject';
            msg_name[2] = 'question mark';
            msg_name[3] = 'Question';
            var length = field.length;
            for (var i=0;i<length;i++)
            {
                var value = $("#"+field[i]).val();
                if (value == '')
                {
                    $("#"+msg_id[i]).html('Please provide '+msg_name[i]);
                    $("#"+msg_id[i]).css("color","#f10a0a");
                }else
                {
                    $("#"+msg_id[i]).html('');
                }
            }
        });
    </script>
@endsection
