$(document).on('click', 'button.toggle-password', function(e) {
	e.preventDefault();
	let $input = $($(this).data('target'));

	if ($input.attr('type') == 'password') {
		$(this).text('Hide');
		$input.attr('type', 'text');
	} else {
		$(this).text('Show');
		$input.attr('type', 'password');
	}
});