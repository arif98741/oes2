@extends('admin.master')
@section('body')
<style type="text/css">
    .pagination{
        justify-content: center;
    }
</style>
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
            <div class="card-body" style="position: relative;">
                <div class="alert alert-info text-center" role="alert" id="processing" style="position:absolute;width: 96%;top: 45%;z-index: 5;">processing...</div>
                <form id="search_form">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group" >
                                <div class="select">
                                    <input class="form-control" type="text"  id="search" name="search" placeholder="search">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group" >
                                <div class="select">
                                    <select name="by_date" class="form-control">
                                        <option value="">Sort by date</option>
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group" >
                                <div class="select">
                                    <select name="by_verified" class="form-control">
                                        <option value="">Sort by verified</option>
                                        <option value="asc">Verified</option>
                                        <option value="desc">Not Verified</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group" >
                                <div class="select">
                                    <select name="by_status" class="form-control">
                                        <option value="">Sort by status</option>
                                        <option value="asc">Active</option>
                                        <option value="desc">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group" >
                                <div class="select">
                                    <input class="form-control btn btn-success" id="search_btn" type="button" value="search">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row" id="users_data">


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
                        <label for="status">Password</label>
                        <input type="text" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                            <select class="form-control" name="status" id="user_status">
                            </select>
                        <input type="hidden" name="user_id" id="user_id">
                    </div>
                    <div class="form-group">
                        <label for="status">Verified</label>
                            <select class="form-control" name="verified" id="verified">
                            </select>
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
<script>
$("#search").keyup(function(){
  search();
});
    get_list()
function get_list()
{
    $.ajax({
            method: "GET",
            url: '{{route('admin.user_list')}}',
            dataType: 'JSON',
            success: function(data)
            {
                $('#processing').hide();
                if(data.error == true)
                {
                    alert(data.message);
                }else{
                    $("#users_data").html(data.success.view);
                }
            }
        });
}
function EditUser(id)
{
    $.ajax({
            method: "GET",
            url: '{{route('admin.edit_user')}}',
            data: {id:id},
            dataType: 'JSON',
            success: function(data)
            {
                console.log(data);
                if(data.error == true)
                {
                    alert(data.message);
                }else{
                    $("#user_id").val(id);
                    $("#user_status").html(data.status);
                    $("#verified").html(data.verified);
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
$("#search_btn").click(function(){
    search();
});

function search()
{
    var form = $("#search_form");
    $.ajax({
    type:"POST",
    url : '{{route('admin.search_user')}}',
    dataType:'json',
    data:form.serialize(),
    }).done(function (data) {
        $('#processing').hide();
        $("#users_data").html(data.success.view);
    }).fail(function () {
        $('#processing').hide();
        alert('Data could not be loaded.');
    });
}
$("body").delegate(".pagination a", "click", function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $('#processing').show();
    getStock(url);
});
function getStock(url) {
    var form = $("#search_form");
    $.ajax({
      type:"POST",
      url : url,
      dataType:'json',
      data:form.serialize(),
      }).done(function (data) {
        $('#processing').hide();
        $("#users_data").html(data.success.view);
      }).fail(function () {
        $('#processing').hide();
        alert('Data could not be loaded.');
      });
}
function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}
</script>
@endsection
