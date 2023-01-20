<div class="p-2">
	<div  class="border p-4 border-secondary border-5 rounded chart-container" data-target="#{{$id}}" data-model="{{$model}}" data-column="{{$column}}">
		<h4 class="mb-3">{{$title}}</h4>
		<div class="d-apart mb-3">
			<div>
				<select class="form-control form-select rounded border-0" name="group_by" style="font-size: .875rem; line-height: 1.5;">
					<option value="monthly" selected>Por mês</option>
					<option value="yearly">Por ano</option>
				</select>
			</div>
			<div class="d-flex align-items-center">
				<input type="text" name="from" class="rounded border-0 form-control datepicker" autocomplete="off" size="10" style="font-size: .875rem; line-height: 1.5" value="{{now()->subYear()->format('d/m/Y')}}">
				<h6 class="mb-0 mx-2">até</h6>
				<input type="text" name="to" class="rounded border-0 form-control datepicker" autocomplete="off" size="10" style="font-size: .875rem; line-height: 1.5" value="{{now()->format('d/m/Y')}}">
			</div>
		</div>

		<canvas id="{{$id}}"></canvas>
	</div>
</div>