@isset($gig)
	@if($gig->duration)
		@if($gig->shouldFinish())
		<h6 class="mb-4 text-center animate__animated animate__slower animate__infinite animate__flash">Terminará automaticamente a qualquer momento</h6>
		@else
		<h6 class="mb-4 text-center">@fa(['icon' => 'clock'])Termina automaticamente às <span class="text-secondary">{{$gig->endingTime()->format('G:i')}}</span></h6>
		@endif
	@endif

@include('pages.setlists.admin.counter', ['setlist' => $setlist->where('user_id', '!=', auth()->user()->id)])
@endisset

@if(request()->has('compact'))
@include('pages.setlists.admin.tables.small')
@else
@include('pages.setlists.admin.tables.large')
@endif