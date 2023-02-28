@isset($gig)
@include('pages.setlists.admin.counter', ['setlist' => $setlist->where('user_id', '!=', auth()->user()->id)])
@endisset

@if(request()->formato == 'minimizado')
@include('pages.setlists.admin.tables.small')
@elseif(request()->formato == 'metronomo')
@include('pages.setlists.admin.tables.metronome')
@else
@include('pages.setlists.admin.tables.large')
@endif