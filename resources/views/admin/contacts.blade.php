@extends('admin.master')
@section('body')
<style>
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
                        <li class="breadcrumb-item active">Contacts</li>
                    </ol>
                </div>
                <h4 class="page-title">Contacts</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-12">
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
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h3 class="text-center admin-color">Contact List</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($contacts as $key=>$contact)
                                <tr>
                                    <td>{{$contact->name}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->message}}</td>
                                    <td>
                                        <a title="Make Active" href="mailto:?to={{$contact->email}}&subject=OES" class="btn btn-success btn-animation">
                                                Send Reply
                                        </a>
                                        <a title="Make Deactive" href="#" onclick="DeleteContact({{$contact->id}})" class="btn btn-danger btn-animation">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function DeleteContact(id)
  {
    if(confirm("Are you sure you want to delete this contact?")){
      $.ajax({
        type: 'get',
        url: '{{url('delete-contact')}}',
        dataType:'json',
        data:{id:id},
        beforeSend: function() {
          $('.delete-btn').prop('disabled', true);
        },
        success: function (data){
            $('.delete-btn').prop('disabled', false);
            if(data == 1)
            {
              alert('Successfully Deleted.');
              location.reload();
            }else{
              alert('Delete failed');
            }

          },
        error: function(e) {
            console.log(e);
        }
      });
    }
  }
    </script>
@endsection
