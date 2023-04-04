@isset($gig)
<div class="mb-4"> 
@include('pages.setlists.admin.counter', ['setlist' => $setlist->where('user_id', '!=', auth()->user()->id)])
@include('pages.setlists.admin.setcounter', ['setlist' => $setlist->where('user_id', '!=', auth()->user()->id)])
</div>
@endisset

@if(request()->formato == 'minimizado')
@include('pages.setlists.admin.tables.small')
@elseif(request()->formato == 'metronomo')
@include('pages.setlists.admin.tables.metronome')
@else
@include('pages.setlists.admin.tables.large')
@endif