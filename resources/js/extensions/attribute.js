jQuery.fn.hasAttr = function(attr) {
	let value = this.attr(attr);
	return typeof value !== 'undefined' && value !== false;
};

jQuery.fn.animateCSS = function(animation, speed = 'slow') {
	let element = this;

	element.addClass('animate__animated animate__' + speed + ' animate__' + animation);
	
	setTimeout(function() {
		element.removeClass('animate__animated animate__' + speed + ' animate__' + animation);
	}, 800);
}

