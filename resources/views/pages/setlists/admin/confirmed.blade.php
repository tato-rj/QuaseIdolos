<div class="confirmed-request mx-auto mb-3">
	<div class="rounded border-secondary event-box py-3 px-2 row">
		<div class="col-12 d-flex justify-content-between">
			<div class="">
				<h2 class="no-stroke text-primary font-cursive">{{$entry->user->firstName}}</h2>
				<div class="d-flex align-items-center">
					<img src="{{$entry->song->artist->coverImage()}}" class="rounded-circle mr-3" style="width: 56px">
					<div>
						<h4 class="text-dark no-stroke m-0 text-truncate">{{$entry->song->name}}</h4>
						<p class="text-dark no-stroke m-0 text-truncate fw-bold">{{$entry->song->artist->name}}</p>
					</div>
				</div>
			</div>

			<div>
				@fa(['icon' => 'check-circle', 'fa_color' => 'green', 'fa_size' => '3x', 'mr' => 0])
			</div>
		</div>
	</div>
</div>