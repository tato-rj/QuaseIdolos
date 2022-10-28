<div class="d-flex justify-content-center flex-wrap"> 
	@foreach($users as $user)
	<a href="" data-bs-toggle="modal" data-bs-target="#edit-admin-{{$user->id}}-modal" class="link-none">
		@include('pages.users.avatar', ['size' => '100px', 'fontsize' => '2rem'])
	</a>
	@include('pages.team.edit')
	@endforeach
</div>
