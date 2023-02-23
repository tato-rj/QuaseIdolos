@php($song = $row)

@auth
  @admin
    @php($songRequests = auth()->user()->liveGigExists() ? auth()->user()->liveGig->setlist()->waiting()->get() : collect())
  @else
    @php($songRequests = auth()->user()->songRequests()->waiting()->get())
  @endadmin
@else
  @php($songRequests = collect())
@endauth

@simpleRow
  @slot('column1')
  @include('pages.cardapio.results.row.name')
  @endslot

  @slot('actions')
  <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

  @include('pages.cardapio.components.song.modal')
  @endslot
@endsimpleRow

{{-- @php($song = $row)

@switch(str_replace('*', '', $field))
  @case('name')
      @include('pages.cardapio.results.row.name')
      @break

  @case('actions')
    <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

    @include('pages.cardapio.components.song.modal')
    @break
@endswitch --}}
