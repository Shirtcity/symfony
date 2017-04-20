FrontendCore.define('variants', ['devicePackage', 'modal'], function () {
	return {
		modal: TinyCore.Module.instantiate('modal'),
		mediator: TinyCore.Toolbox.request('mediator'),
		onStart: function () {

			var self = this,
				nWindowWidth,
				nModalWidth = '95%',
				nModalHeight = '95%';

			if (TinyCore !== undefined) {
				FrontendCore.requireAndStart('notification');
			}

			this.mediator.subscribe(['response:success'], this.updateVariants, this);

			$('.button-primary', '#variants-list').on('click', function (event) {

				event.preventDefault();

				nWindowWidth = $(window).width();

				if (nWindowWidth < 799) {
					nModalWidth = '100%';
					nModalHeight = '100%';
				}

				self.modal.open({
					iframe: true,
					href: this.href,
					width: nModalWidth,
					height: nModalHeight
				});

			});

		},
		updateVariants: function (oResponse) {

			var self = this;

			if (document.getElementById('variants-message-ok') !== null) {
				self.mediator.publish('notification', {
					type: 'ok',
					message: document.getElementById('variants-message-ok').value
				});

				$.get(oResponse.data.url, function (sHtml) {
					document.getElementById('variants-list').innerHTML = $(sHtml).find('#variants-list').html();
				});
			}

			this.modal.close();

		}
	};
});

