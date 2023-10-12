@isset($gig)
<div class="mb-4"> 
	
@include('pages.setlists.admin.counter')
@include('pages.setlists.admin.setcounter')
</div>
@endisset

@if(request()->formato == 'minimizado')
@include('pages.setlists.admin.tables.small')
@elseif(request()->formato == 'metronomo')
@include('pages.setlists.admin.tables.metronome')
@else
@include('pages.setlists.admin.tables.large')
@endif