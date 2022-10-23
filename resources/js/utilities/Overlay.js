class Overlay
{
	constructor(params)
	{
		this.element = params.element;
		this.speed = params.speed;
	}

	run()
	{
		let obj = this;

        $(document).ready(function() {
            $(obj.element).fadeOut(obj.speed);
        });
	}
}

window.Overlay = Overlay;