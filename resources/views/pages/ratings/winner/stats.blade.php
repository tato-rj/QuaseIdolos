<div class="d-center mb-2">
   <div class="text-center mx-3">
      <h3 class="mb-0">@fa(['icon' => 'users', 'classes' => 'opacity-4 no-stroke']){{$votersCount}}</h3>
      <h5 class="text-secondary">Pessoas votaram</h5>
   </div>
   <div class="text-center mx-3">
      <h3 class="mb-0">@fa(['icon' => 'music', 'classes' => 'opacity-4 no-stroke']){{$ratings->groupBy('song_request_id')->count()}}</h3>
      <h5 class="text-secondary">Músicas votadas</h5>
   </div>
   <div class="text-center mx-3">
      <h3 class="mb-0">@fa(['icon' => 'vote-yea', 'classes' => 'opacity-4 no-stroke']){{$ratings->count()}}</h3>
      <h5 class="text-secondary">Total de votos</h5>
   </div>
</div>