<button data-bs-toggle="modal" data-bs-target="#create-{{$name}}-modal" class="btn btn-secondary mx-1 btn-lg">@fa(['icon' => 'plus']){{$label}}</button>
@php($label = null)
@include('pages.'.$folder.'.modals.create')