class Metronome
{
	constructor(element = null)
	{
		this.$element = $(element);
	}

	get()
	{
		let obj = this;

		return axios.get(obj.$element.data('url'))
			 .then(function(response) {
			 	$('#metronome-container').html(response.data);
			 	obj.bpm = $('#metronome-container').find('#bpm span').text();
			 });
	}

	getTempo()
	{
		return $('#bpm span').text();
	}

	highlightSetlist()
	{
		$('.setlist-row').addClass('opacity-4');

		$('#song-'+$('#bpm').data('song-id')).removeClass('opacity-4');
	}
}

window.Metronome = Metronome;