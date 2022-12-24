jQuery.fn.hasAttr = function(attr) {
	let value = this.attr(attr);
	return typeof value !== 'undefined' && value !== false;
};

jQuery.fn.toggleIcon = function(stateA, stateB) {
	this.find('i').toggleClass('fa-'+stateA+' fa-'+stateB);
	return this;
};

jQuery.fn.icon = function() {
	return this.find('i');
};

jQuery.fn.grandparent = function() {
	return this.parent().parent();
};

jQuery.fn.animateCSS = function(animation, speed = 'slow') {
	let element = this;

	element.addClass('animate__animated animate__' + speed + ' animate__' + animation);
	
	setTimeout(function() {
		element.removeClass('animate__animated animate__' + speed + ' animate__' + animation);
	}, 800);
}

