window.log = function(message) {
	console.log(message);
}

window.url = function(params) {
	let query = params.length ? '?'+encodeURIComponent(params[0])+'='+encodeURIComponent(params[1]) : '';
	window.history.pushState({}, document.title, window.location.pathname + query);
}
