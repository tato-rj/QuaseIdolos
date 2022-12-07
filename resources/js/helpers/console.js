window.log = function(message) {
	console.log(message);
}

window.url = function(params) {
	let query = params.length ? '?'+params[0]+'='+params[1] : '';
	window.history.pushState({}, document.title, window.location.pathname + query);
}