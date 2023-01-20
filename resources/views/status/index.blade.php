@extends('layouts.status')

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-6 col-md-10 col-12 mx-auto">
			<h6 class="mb-4 fw-bold">DATABASE</h6>

			<div class="accordion" id="status-container">
				@foreach($report as $model => $errors)
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="headingOne">
				      <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse-{{$loop->iteration}}">
				        @fa(['icon' => $errors->isEmpty() ? 'check-circle' : 'times-circle', 'fa_color' => $errors->isEmpty() ? 'green' : 'red']){{class_basename($model)}}
				      </button>
				    </h2>
				    <div id="collapse-{{$loop->iteration}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#status-container">
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
				@endforeach
			</div>
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush