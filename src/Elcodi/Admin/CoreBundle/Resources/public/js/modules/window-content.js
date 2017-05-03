FrontendCore.define('window-content', ['devicePackage','modal' ], function () {
	return {
		oModal:  TinyCore.Module.instantiate( 'modal' ),
		mediator : FrontendMediator,
		onStart: function () {
			var aTargets = FrontendTools.getDataModules('window-content'),
				self = this;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'window-content');

			$(aTargets).each(function () {
				self.autobind(this);
			});
            
			this.mediator.subscribe( ['new:category'], this.updateCategory, this );
			this.mediator.subscribe( ['new:manufacturer'], this.updateManufacturer, this );
            this.mediator.subscribe( ['new:product_color'], this.updateProductColor, this );
            
            this.mediator.subscribe(['response:success'], this.closeModal, this);

		},
        closeModal: function() {
			this.oModal.close();
		},
		updateSelect: function( id, value, innerHTML ) {

			var oOption = document.createElement('option'),
				oSelect = document.getElementById(id);

			$('option:selected', oSelect).removeAttr('selected');

			oOption.value = value;
			oOption.innerHTML = innerHTML;
			oOption.setAttribute('selected','selected');

			oSelect.appendChild(oOption);
		},
        updateList: function( id, url ) {
            var self = this;
            
            $.get(url, function (sHtml) {
                document.getElementById(id).innerHTML = $(sHtml).find('#' + id).html();
                self.onStart();
            });
        },
		updateCategory: function( oResponse ) {

			this.updateSelect( 'elcodi_admin_article_form_type_article_principalCategory', oResponse.data.id, oResponse.data.name );

		},
		updateManufacturer: function( oResponse ) {

			this.updateSelect( 'elcodi_admin_product_form_type_product_product_manufacturer', oResponse.data.id, oResponse.data.name );

		},
        updateProductColor: function( oResponse ) {
			this.updateList( 'product-color-list', oResponse.data.url );

		},
		autobind: function( oTarget ){
            
			var self = this,
				nWindowWidth,
				nModalWidth = '95%',
				nModalHeight = '95%';

			$(oTarget).on('click',function(event) {

				event.preventDefault();

				if ( this.id === 'new-attribute') {
					parent.document.getElementById('modal-attribute').click();
					return false;
				}

				nWindowWidth = $(window).width();

				if (nWindowWidth < 799) {
					nModalWidth = '100%';
					nModalHeight = '100%';
				}

				var $modal = $("#cboxContent");

				// 4.Open in a modal this href
				self.oModal.open({
					href: this.href + '?modal=true',
					iframe: true,
					fastIframe : false,
					width: nModalWidth,
					height: nModalHeight,
					onOpen: function() {
						$modal.hide();
					},
					onComplete: function() {

						var $iframe = $("iframe").contents();

						$iframe.find("#cancel-button").on('click', function(event){
							event.preventDefault();
							self.oModal.close();
						});

						$iframe.find("#new-attribute").on('click', function(event){
							event.preventDefault();
							$('#modal-attribute').click();
							//self.oModal.close();
						});

						$iframe.find(".sidebar").remove();
						$iframe.find(".topbar").remove();
						$iframe.find(".col-10-12.push-right").attr('class','col-1-1');
						$iframe.find("form").each( function() {
                            var sAction = $(this).attr('action') + '?modal=true';
                            $(this).attr('action' , sAction );
                        });

						$modal.fadeIn();
					}
				});
			});
		}
	};
});