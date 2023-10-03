<div class="d-flex {{$classes ?? null}}">

	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->password()->required(), 
		'size' => $size ?? 'lg',
		'icon' => 'key'])
	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->participatesInRatings(), 
		'size' => $size ?? 'lg',
		'icon' => 'trophy'])
	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->participatesInChats(), 
		'size' => $size ?? 'lg',
		'icon' => 'comments'])
	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->duration, 
		'size' => $size ?? 'lg',
		'icon' => 'stopwatch'])

	@include('pages.gigs.features.icon', [
		'hasFeature' => $gig->excludedSongs()->isNotEmpty(), 
		'size' => $size ?? 'lg',
		'icon' => 'filter'])
</div>