<section class="bg-center position-relative h-100vh d-center" style="background-image: url({{asset('images/bg.jpg')}});">
	<div class="position-absolute-center w-100 h-100 bg-primary opacity-8"></div>
	<div class="container position-relative">
		<div class="text-center">
			<div class="mb-5">
				<img src="{{asset('images/brand/logo_lg.svg')}}" style="max-width: 500px; width: 90%" class="mb-2">
				<h2>@lang('views/home.header.title.text') <span class="text-secondary">@lang('views/home.header.title.highlight')</span></h2>
				{{-- <h2>A SUA BANDA DE <span class="text-secondary">KARAOKÊ</span></h2> --}}
			</div>
			@if(auth()->check() && auth()->user()->admin && auth()->user()->admin->manage_setlist)
			<div class="d-center flex-column">
				<a href="{{route('setlists.admin')}}" class="btn btn-secondary btn-lg mb-3">@fa(['icon' => 'users'])@lang('views/home.header.btn-setlist')</a>
				<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3 text-uppercase">@fa(['icon' => 'utensils'])@lang('views/header.songs-menu')</a>
			</div>
			@else
			<div class="d-center flex-column">
				<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3">@lang('views/home.header.btn-cardapio')</a>
			</div>
			@endif
		</div>
	</div>
</section>