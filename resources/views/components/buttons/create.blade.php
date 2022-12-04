<button data-bs-toggle="modal" data-bs-target="#create-{{$name}}-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus']){{$label}}</button>
@include('pages.'.$folder.'.modals.create')