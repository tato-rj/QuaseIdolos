class Popup
{
	constructor(view)
	{
		this.$view = $(view);
	}

	show()
	{
		$('body').append(this.$view);
		
		this._selfDestruct();
	}

	_selfDestruct()
	{
		let obj = this;

	    setTimeout(function() {
	    	obj.$view.find('button[data-dismiss="alert"]').click();
	    }, obj.$view.data('countdown') * 1000);
	}
}

window.Popup = Popup;