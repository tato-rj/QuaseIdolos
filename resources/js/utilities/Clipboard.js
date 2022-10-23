class Clipboard
{
	constructor(params)
	{
		this.element = params.element;
		this.success = params.success;
		this.error = params.error;

		this.clip = new ClipboardJS(this.element);
	}

	run()
	{
		let obj = this;

		this.clip.on('success', function(e) {
		  obj._showTooltip(e.trigger, 'Copied!');
		  obj._hideTooltip(e.trigger);
		});

		this.clip.on('error', function(e) {
		  obj._showTooltip(e.trigger, 'Failed...');
		  obj._hideTooltip(e.trigger);
		});
	}

	_showTooltip(elem, message)
	{
	    $(elem).attr('data-bs-original-title', message);
	    bootstrap.Tooltip.getInstance(elem).show();
	}

	_hideTooltip(elem)
	{
		setTimeout(function() {
			bootstrap.Tooltip.getInstance(elem).hide();
		}, 500);
	}
}

window.Clipboard = Clipboard;