class DragDrop
{
	constructor(params)
	{
		this.formId = params.formId;
		this.method = params.method;
		this.maxFilesize = params.maxFilesize;
		this.parallelUploads = params.parallelUploads;
		this.thumbPath = params.thumbPath;
	}

	run()
	{
		let obj = this;

		Dropzone.options.dropForm = {
			method: obj.method,
			url: '#',
			maxFilesize: obj.maxFilesize, // MB
			parallelUploads: obj.parallelUploads,
			dictDefaultMessage: '',
		    headers: {},
		    accept: function(file, next) {
		    	obj._getPresignedUrl(file)
		    	 .then(function(response) {
		    	 	file.signedRequest = response.data;
		    	 	next();
		    	 })
		    	 .catch(function(error) {
		    	 	next('Could not get the presigned url.');
		    	 });
		    },
		    sending: function(file, xhr) {
		        var _send = xhr.send;
		        xhr.setRequestHeader('x-amz-acl', 'public-read');
		        xhr.send = function() {
		            _send.call(xhr, file);
		        }
		    },
		    processing: function(file) {
		        this.options.url = file.signedRequest;
		    },
			init: function() {
				obj._loadFiles(this);

				this.on('addedfile', file => {
					obj._getIcon(file, this);
				});
				this.on("sending", file => {});
				this.on("error", (file, error) => {});
				this.on("success", (file) => {});
				this.on("complete", (file) => {});
			}
		};

		return obj;
	}

	onClick(action)
	{
		$(document).on('click', '.dropzone.dz-clickable .dz-image', function() {
			action(this);
		});

		return this;
	}

	_getPresignedUrl(file)
	{
	    var params = {
	      fileName: file.name,
	      fileType: file.type,
	    };

		return axios.post($(this.formId).attr('presignedUrl'), params);
	}

	_loadFiles(dropzone)
	{
		axios.get($(this.formId).attr('loadFiles'))
			 .then(function(response) {
			 	response.data.forEach(function(file) {
				 	dropzone.emit("addedfile", file);
				 	dropzone.emit("complete", file);
			 	});
			 })
			 .catch(function(error) {
			 	console.log(error);
			 })
			 .then(function() {
			 	$(dropzone.element).fadeIn('fast');
			 	$('.dropzone-label').text($('.dropzone-label').data('label'));
			 });
	}

	_getIcon(file, dropzone)
	{
		let extensions = ['pdf', 'doc', 'docx', 'dwg', 'ai', 'afdesign'];
		let file_ext = file.name.split('.').pop();
		let file_type = file.type.split('/').shift();
		let thumbnail;

		if (file_type == 'image') {
			thumbnail = file.url;
		} else if (extensions.includes(file_ext)) {
			thumbnail = this.thumbPath + file_ext + ".svg";
		} else {
			thumbnail = this.thumbPath + "default.svg";
		}

		if (typeof thumbnail != 'undefined')
			dropzone.emit('thumbnail', file, thumbnail);
	}
}

window.DragDrop = DragDrop;