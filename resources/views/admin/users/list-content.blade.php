<div class="col-md-12" >
    <table class="table table-hover" >
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Verified At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead> 
        <tbody >
               @if(count($users) > 0)
				@foreach($users as $user)
					<tr>
						<td>{{$start}}</td>
						<td>{{$user->name}}</td>
						<td>{{$user->email}}</td>
						@if($user->email_verified_at != '')
						<td style="color: #29b348;">{{date('d M Y',strtotime($user->email_verified_at))}}</td>
						@else
						<td style="color: #ff4812;">Not verified</td>
						@endif
						@if($user->status == 1)
						<td style="color: #29b348;">Active</td>
						@else
						<td style="color: #ff4812;">Deactive</td>
						@endif
						<td> <button type="button" onclick="EditUser({{$user->id}})" class="btn btn-warning edit_btn">Edit</button> </td>
					</tr>
					@php 
					$start++;
					@endphp
				@endforeach
			@else
				<tr>
					<td colspan="5" class="text-center">
						<span style="color: #ff4812">No data found</span>
					</td>
				</tr>
			@endif                 
        </tbody>
    </table>
</div>

<div class="col-md-12">
	<div class="row" style="align-items: center">
		<div class="col-md-2" style="color: #29b348" >
			{{$total}} Users
		</div>
		<div class="col-md-10">
			@if(count($users)  > 0)
				{{ $users->links() }}
			@endif
		</div>
	</div>
</div>
