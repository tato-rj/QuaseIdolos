@modal(['title' => 'Setlist','id' => 'setlist-gig-'.$gig->id.'-modal', 'size' => 'lg'])
<div class="text-left" id="setlist-accordion">
	@responsiveTable([
		'legend' => 'música|músicas',
		'empty' => true,
		'rows' => $gig->setlist,
		'view' => 'pages.gigs.show.rows.setlist'
	])
</div>
@endmodal