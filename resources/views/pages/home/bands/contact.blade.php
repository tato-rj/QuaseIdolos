<section class="container mb-8 mt-6">
	<div class="row">
		<div class="col-lg-8 col-md-10 col-12 mx-auto">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4 col-10 mx-auto">
						<div class="position-relative" style="transform: rotate(5deg);">
							<div class="bg-secondary w-100 h-100 position-absolute left-0 top-0" style="transform: rotate(5deg);"></div>
							<video id="player" data-poster="{{asset('images/video-poster.jpeg')}}">
							  <source src="{{asset('videos/promo.mp4')}}" type="video/mp4" />
							</video>
						</div>
					</div>
					<div class="col-lg-8 col-10 mx-auto d-center py-3">
						<div>
							<h3>@lang('views/home.contact.title.text') <span class="text-secondary">@lang('views/home.contact.title.highlight')</span>.</h3>
							<h6 class="mb-4">@lang('views/home.contact.description')</h6>
							<a href="{{route('reservas')}}" class="btn btn-secondary btn-lg">@lang('views/home.contact.btn')</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>