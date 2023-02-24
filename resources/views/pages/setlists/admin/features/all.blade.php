<div class="d-center flex-wrap mb-2">
	@include('pages.setlists.admin.features.icon', [
		'hasFeature' => $gig->password()->required(), 
		'icon' => 'key'])
	@include('pages.setlists.admin.features.icon', [
		'hasFeature' => $gig->participatesInRatings(), 
		'icon' => 'trophy'])
	@include('pages.setlists.admin.features.icon', [
		'hasFeature' => $gig->participatesInChats(), 
		'icon' => 'comments'])
	@include('pages.setlists.admin.features.icon', [
		'hasFeature' => $gig->duration, 
		'icon' => 'stopwatch'])
</div>