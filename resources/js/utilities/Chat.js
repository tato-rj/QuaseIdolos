class Chat
{
	constructor()
	{
		$(document).on('keyup', '.chat-user input[name="message"]', function() {
			if ($(this).val()) {
				window.Echo
				.private('chat.'+app.gig.id)
				.whisper('typing', {
					from_id: $(this).data('from-id'),
					to_id: $(this).data('to-id'),
					message: app.user.firstName + ' está escrevendo...'
				});
			}
		});
	}

	load(event)
	{
		let obj = this;

        if (obj._ownChat(event.chat)) {
            if (obj._chatIsOpen()) {
                obj._loadChatHtml(event.url, event.chat.from_id).then(function() {
                    obj._pinChatToBottom();
                });
            } else {
                obj._showUnreadCount();
            }
        }
	}

	markAsRead(event)
	{
        if (this._ownChat(event.chat) && this._chatIsOpen())
			$('#chat-'+event.chat.id+'-check').removeClass('text-white opacity-4').addClass('text-green');
	}

	typing(event)
	{
		let userChat = '#chat-user-'+event.from_id;

        if (this._toMe(event) && this._chatIsOpen(userChat)) {
            this._openChat(userChat).find('.whisper-message').text(event.message);

            if (this.timer)
                clearTimeout(this.timer);

            this.timer = setTimeout(function() {
                $('.whisper-message').text('');
            }, 3000);
        }
	}

	send(form)
	{
		let obj = this;
		let $form = $(form);
	    let $input = $form.find('[name="message"]');
	    let $button = $form.find('button');

        $input.disable().addClass('opacity-4');
        $button.disable().addClass('opacity-4');

        axios.post($form.attr('action'), {message: $input.val()})
             .then(function(response) {
                $input.val('');
                $form.closest('.chat-user').find('.conversation-container').html(response.data);
             })
             .catch(function(error) {
             	alert('A sua mensagem não pode ser enviada');
             })
             .then(function() {
                obj._pinChatToBottom();
                $input.enable().removeClass('opacity-4');
                $button.enable().removeClass('opacity-4');
             });
	}

	getUser(button)
	{
		let obj = this;
		let $user = $(button);

		$user.disable().addClass('opacity-4');

	    axios.get(app.chatUrls.showUser, {params: {userId: $user.data('from-id')}})
			    .then(function(response) {
			    	$('#chat-user').html(response.data);

			    	obj._loadChatHtml($user.data('url'), $user.data('from-id')).then(function() {
			    		obj._pinChatToBottom();
			    		// $user.enable().removeClass('opacity-4');
			    	});
			    })
			    .catch(function(error) {
			    	// alert('Descuple, o chat não está disponível nesse momento');
			    });
	}

	getParticipants()
	{
		axios.get(app.chatUrls.showUsers)
			 .then(function(response) {
			 	$('#chat-list').html(response.data);
			 })
			 .catch(function(error) {
			 	// alert('Descuple, o chat não está disponível nesse momento');
			 });
	}

	reset()
	{
		this.getParticipants();
		
	    $('#chat-user').html('');
	    $('#chat-user').hide();
	    $('#chat-list').show();

	    $('#chat-back').hide();
	    $('#chat-header').show();
	}

	_ownChat(chat)
	{
		return app.user.id == chat.from_id || app.user.id == chat.to_id;
	}

	_toMe(event)
	{
		return event.to_id == app.user.id;
	}

	_chatIsOpen(element = null)
	{
		return this._openChat(element).length;
	}

	_openChat(element = null)
	{
		return element ? $(element) : $('.chat-user:visible');
	}

	_loadChatHtml(url, fromId)
	{
		let obj = this;

	    return axios.get(url)
	         .then(function(response) {
	            $('#chat-user-'+fromId).find('.conversation-container').html(response.data);

	            obj._showConversation();
	         })
	         .catch(function(error) {
	            alert('Esse chat não está disponível');
	         });
	}

	_showConversation()
	{
        $('#chat-list').hide();
        $('#chat-user').show();

        $('#chat-header').hide();
        $('#chat-back').show();
	}

	_pinChatToBottom()
	{
	    let $chat = this._openChat().find('.chat-container');

	    $chat.scrollTop($chat[0].scrollHeight);
	}

	_showUnreadCount()
	{
	    axios.get(app.chatUrls.unreadCount)
	         .then(function(response) {
	            $('.unread-count').html(response.data.global);

	            response.data.users.forEach(function(count) {
	                $('.unread-count-'+count.user_id).html(count.view);
	            });
	         });
	}
}

window.Chat = Chat;