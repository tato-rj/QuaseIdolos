<div class="accordion-item">
	<h2 class="accordion-header">
	  <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse-{{$loop->iteration}}">
	    @fa(['icon' => $errors->isEmpty() ? 'check-circle' : 'times-circle', 'fa_color' => $errors->isEmpty() ? 'green' : 'red']){{className($model)}}
	  </button>
	</h2>
	<div id="collapse-{{$loop->iteration}}" class="accordion-collapse collapse" data-bs-parent="#status-container">
	  <div class="accordion-body">
	  	<ul class="mb-0 pl-3">
	        @forelse($errors as $error)
	        <li class="text-red">{{$error}}</li>
	        @empty
	        <li class="text-green" style="list-style-type: none;">All relationships are ok</li>
	        @endforelse
	    </ul>
	  </div>
	</div>
</div>