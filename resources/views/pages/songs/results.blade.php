@if(hasPagination($songs))
<h5 class="mb-3">Mostrando {{$songs->firstItem()}} a {{$songs->lastItem()}} de {{$songs->total()}} @choice('música|músicas', $songs->count())</h5>
@else
<h5 class="mb-3">Mostrando {{$songs->count()}} @choice('música|músicas', $songs->count())</h5>
@endif

@foreach($songs as $song)
	@include('pages.songs.row')
@endforeach

@if(hasPagination($songs))
{{ $songs->links() }}
@endif