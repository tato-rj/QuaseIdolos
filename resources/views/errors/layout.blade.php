@extends('layouts.app', ['title' => 'Reservas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6 py-5">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12 mx-auto text-center">
            <h1 class="opacity-4 no-stroke">@fa(['icon' => 'sad-cry', 'mr' => 0])</h1>
            <h4 class="mb-4">@yield('title')</h4>
            <h6 class="m-0 opacity-8 lh-1 text-secondary">ERRO</h6>
            <h1 class="text-secondary mb-5" style="font-size: 6rem">@yield('code', __('Oh no'))</h1>
    
            <a class="btn btn-secondary btn-lg" href="{{route('home')}}">@fa(['icon' => 'home'])Voltar para a página inicial</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush