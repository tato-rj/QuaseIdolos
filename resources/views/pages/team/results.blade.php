<div class="d-flex justify-content-center flex-wrap"> 
	@forelse($users as $user)
	<a href="" data-bs-toggle="modal" data-bs-target="#edit-admin-{{$user->id}}-modal" class="link-none">
		@include('pages.users.avatar', ['size' => '100px', 'namesize' => '1.2rem'])
	</a>
	@include('pages.team.edit')
	@empty
	@include('components.empty')
	@endforelse
</div>
