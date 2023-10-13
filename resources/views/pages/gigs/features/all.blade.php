<div class="d-flex {{$classes ?? null}}">

	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->password()->required(), 
		'size' => $size ?? 'lg',
		'label' => 'password',
		'icon' => 'key'])
{{-- 	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->participatesInRatings(), 
		'size' => $size ?? 'lg',
		'label' => 'votação',
		'icon' => 'trophy']) --}}
	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->participatesInChats(), 
		'size' => $size ?? 'lg',
		'label' => 'chat',
		'icon' => 'comments'])
	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->duration, 
		'size' => $size ?? 'lg',
		'label' => 'hora pra terminar',
		'icon' => 'stopwatch'])

	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->excludedSongs()->isNotEmpty(), 
		'size' => $size ?? 'lg',
		'label' => 'música excluída',
		'icon' => 'filter'])
</div>