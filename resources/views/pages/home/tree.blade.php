
	<div class="row">
		<div class="steps col-lg-6 col-md-10 col-12 mx-auto d-flex flex-column align-items-center">
			@include('components.tree.step', ['step' => 1, 'text' => 'Escolha uma músia em nosso cardápio'])
			@include('components.tree.step', ['step' => 1, 'text' => 'Se inscreva na lista do karaokê'])
			@include('components.tree.step', ['step' => 1, 'text' => 'Vai cantar sozinho?', 'bar' => false])

			@include('components.tree.options', ['step' => 1])

			@include('components.tree.step', ['step' => 2, 'option' => 'no', 'text' => 'Chame um amigo(a)'])
			@component('components.tree.step', ['step' => 2, 'option' => 'no'])
			Espere ansiosamente pela<br>sua vez :p
			@endcomponent
			@include('components.tree.step', ['step' => 2, 'option' => 'no', 'text' => 'Sua vez já?', 'bar' => false])

			@component('components.tree.step', ['step' => 2, 'option' => 'yes'])
			Espere ansiosamente pela<br>sua vez :p
			@endcomponent
			@include('components.tree.step', ['step' => 2, 'option' => 'yes', 'text' => 'Sua vez já?', 'bar' => false])

			@include('components.tree.options', ['step' => 2])

			@include('components.tree.step', ['step' => 3, 'option' => 'no', 'text' => 'Vai treinando a música e tomando um drink', 'bar' => false])

			@component('components.tree.step', ['step' => 3, 'option' => 'yes', 'bar' => false, 'id' => 'cante'])
			Suba ao palco e cante com a
			<img src="{{asset('images/brand/logo_lg.svg')}}">
			@endcomponent
		</div>
	</div>