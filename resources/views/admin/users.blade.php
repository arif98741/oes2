@extends('admin.master')
@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">OES</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
                <h4 class="page-title">Users</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover" id="users_data">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Institute</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="xp-varying-modal-label" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4>Edit User</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form id="update_form">
                                            @csrf
                                            <div class="alert alert-info kk_processing_alert d-none" role="alert">processing...</div>
                                            <div class="alert alert-success kk_success_alert d-none" role="alert"></div>
                                            <div class="alert alert-danger print-error-msg" style="display:none">
                                                <ul>
                                                </ul>
                                            </div>
                                          <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="user_status">
                                            </select>
                                            <input type="hidden" name="user_id" id="user_id">
                                          </div>
                                          <div class="form-group text-right">
                                            <button class="btn btn-primary btn-sm" type="button" id="update_btn">Update</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{asset('/')}}assets/admin/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{asset('/')}}assets/admin/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#users_data').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('admin.get_users_list')}}",
        } );
    });
    function EditUser(id)
    {
        $.ajax({
            method: "GET",
            url: '{{route('admin.edit_user')}}',
            data: {id:id},
            dataType: 'JSON',
            success: function(data)
            {
                if(data.error == true)
                {
                    alert(data.message);
                }else{
                    $("#user_id").val(id);
                    $("#user_status").html(data.status);
                    $("#types").html(data.type);
                    $("#edit_modal").modal('show');
                }
            }
        });

    }
    $("#update_btn").on('click', function(e) {
            e.preventDefault();
            $("#update_btn").prop('disabled', true);
            $('.kk_processing_alert').removeClass('d-none');
            $(".print-error-msg").css('display','none');

            $.ajax({
                method: "POST",
                url: '{{route('admin.edit_user')}}',
                data: $("#update_form").serialize(),
                dataType: 'JSON',
                success: function(data)
                {
                    $(".print-error-msg").css('display','none');
                    if (data.error == true) {
                        printErrorMsg(data.message);
                    } else{
                        $('.kk_error_alert').addClass('d-none');
                        $('.kk_success_alert').removeClass('d-none');
                        $('.kk_success_alert').html(data.message);

                        location.reload();
                    }

                    $('#update_btn').prop('disabled', false);
                    $('.kk_processing_alert').addClass('d-none');
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
