@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">EYB</a></li>
                        <li class="breadcrumb-item active">Tutorial</li>
                    </ol>
                </div>
                <h4 class="page-title">Question Type</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Level</label>
                        <div class="select">
                            <select class="form-control select-hidden" name="studentgrade">
                                <option value="">Select Level</option>
                                <option value="1">
                                    1
                                </option>
                                <option value="2">
                                    2
                                </option>
                                <option value="3">
                                    3
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Subject</label>
                        <div class="select">
                            <select class="form-control select-hidden" name="studentgrade">
                                <option value="">Select Subject</option>
                                <option value="1">
                                    1
                                </option>
                                <option value="2">
                                    2
                                </option>
                                <option value="3">
                                    3
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">Chapter</label>
                        <div class="select">
                            <select class="form-control select-hidden" name="studentgrade">
                                <option value="">Select Chapter</option>
                                <option value="1">
                                    1
                                </option>
                                <option value="2">
                                    2
                                </option>
                                <option value="3">
                                    3
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-danger btn-animation" data-animation="slideInDown" data-toggle="modal" data-target="#exampleModalLong-1">
                                Question Mark
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-success btn-animation">
                                Question Save
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="float: left;margin-right: 10px;">
                        <label for="exampleInputName2">&nbsp;</label>
                        <div class="select">
                            <button type="button" class="btn btn-warning btn-animation">
                                Question Preview
                            </button>
                        </div>
                    </div>
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
                            <input type="number" class="form-control" placeholder="Set Question Mark">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="my-2 py-1">Question</label>
                        <div>
                            <textarea class="form-control" rows="5" style="margin-top: 0px; margin-bottom: 0px; height: 143px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-5 col-form-label">How many options</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="number" value="2" id="box_qty" onclick="getImageBox(this)">
                        </div>
                    </div>
                    <?php
                    $lettry_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
                    for ($i = 1; $i <= 2; $i++) {
                    ?>
                    <div class="row " id="list_box_<?php echo $i;?>" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2">
                            <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$i - 1]; ?></p>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="col-sm-8"><label class="col control-label">Image file</label></div>
                                <div class="col-sm-8">
                                    <input type="file"  id="image_0" name="Image[]" accept=".png, .jpg, .jpeg .gif" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                                <div ><label class="col control-label">Speech to text</label></div>
                                <div>
                                    <input type="text" name="response_answer" value="" style="text-align: center;">
                                </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php for ($desired_i = $i; $desired_i <= 20; $desired_i++) { ?>
                    <div class="row " id="list_box_<?php echo $desired_i;?>" style="align-items: center;display: none;margin-bottom: 10px;">
                        <div class="col-2">
                            <p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;"><?php echo $lettry_array[$desired_i - 1]; ?></p>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="col-sm-8"><label class="col control-label">Image file</label></div>
                                <div class="col-sm-8">
                                    <input type="file"  id="image_0" name="Image[]" accept=".png, .jpg, .jpeg .gif" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div ><label class="col control-label">Speech to text</label></div>
                            <div>
                                <input type="text" name="response_answer" value="" style="text-align: center;">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="image_quantity" id="image_quantity" value="2">
    <script>
        var qtye = $("#box_qty").val();
        document.getElementById("image_quantity").value = qtye;

        common(qtye);
        function getImageBox() {

            var qty = $("#box_qty").val();
            console.log(qty);
            if (qty < 3) {
                $("#box_qty").val(2);
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
            for (var i = 1; i <= quantity; i++)
            {
                $('#list_box_' + i).show();
            }
        }
    </script>
@endsection
