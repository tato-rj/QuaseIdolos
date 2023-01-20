@extends('layouts.status')

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-6 col-md-10 col-12 mx-auto">
			<h3 class="mb-4 text-primary">{{config('app.name')}} <span class="opacity-6 text-muted">STATUS</span></h3>

			<div class="accordion" id="status-container">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="headingOne">
			      <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			        @fa(['icon' => 'check-circle', 'fa_color' => 'green'])Users
			      </button>
			    </h2>
			    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#status-container">
			      <div class="accordion-body">
			        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush