@isset($gig)
@include('pages.setlists.admin.counter', ['setlist' => $setlist->where('user_id', '!=', auth()->user()->id)])
@endisset

@if(request()->has('compact'))
@include('pages.setlists.admin.tables.small')
@else
@include('pages.setlists.admin.tables.large')
@endif