<div class="modal fade" id="{{$id}}">
  <div class="modal-dialog modal-{{$size ?? null}}">
    <div class="modal-content bg-primary rounded">
      @isset($titleLarge)
      <div class="modal-header border-0 p-4 align-items-start">
        <div>{{$titleLarge}}</div>
        <button type="button" class="btn-close btn-raw" style="width: inherit; height: inherit;" data-bs-dismiss="modal" aria-label="Close">@fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])</button>
      </div>
      @else
      <div class="modal-header border-0">
        <h5 class="modal-title text-white no-stroke">{{$title}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      @endisset
      <div class="modal-body">
        {{$slot}}
      </div>

      @isset($footer)
      <div class="modal-footer">
        {{$footer}}
      </div>
      @endisset
    </div>
  </div>
</div>