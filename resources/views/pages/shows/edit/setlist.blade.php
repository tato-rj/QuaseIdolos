<div id="setlist"> 
	@forelse($show->setlist as $entry)
	@include('pages.shows.edit.rows.setlist')
	@empty
	@include('components.empty')
	@endforelse
</div>