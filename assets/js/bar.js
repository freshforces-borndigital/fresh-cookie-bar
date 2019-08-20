(function ($) {
	'use strict';

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	if ('1' !== getCookie('freshcookiebar')) {

		var $button = $('<button />')
			.html(freshcookiebarOpts.button_text)
			.addClass('button freshcookiebar-button')
			.css({
				position: 'relative',
				display: 'inline-block',
				backgroundColor: freshcookiebarOpts.button_bg_color,
				color: freshcookiebarOpts.button_text_color,
				marginLeft: 10,
				padding: '5px 30px',
				border: 0,
				borderRadius: 4
			});

		var $barInner = $('<div />')
			.addClass('freshcookiebar-inner')
			.css({
				marginLeft: 'auto',
				marginRight: 'auto',
				padding: '10px 32px',
				textAlign: 'center',
				lineHeight: 1.6
			})
			.append(freshcookiebarOpts.content)
			.append($button);

		var $privacybar = $('<div />')
			.addClass('freshcookiebar-bar')
			.css({
				position: 'fixed',
				backgroundColor: freshcookiebarOpts.bg_color,
				color: freshcookiebarOpts.text_color,
				textAlign: 'center',
				left: 0,
				bottom: 0,
				right: 0,
				zIndex: 9999999,
				width: '100%',
				fontSize: freshcookiebarOpts.font_size
			})
			.append($barInner)
			.appendTo('body');

		$button.on('click', function () {
			setCookie('freshcookiebar', '1', 365);
			$privacybar.stop().fadeOut(500, function () {
				$(this).remove();
			});
		});
	}
}(jQuery));
