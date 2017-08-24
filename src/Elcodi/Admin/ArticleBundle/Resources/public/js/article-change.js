$('#article-product, #article-product-color, .printable-variants input, .printable-variants select, .printable-variants textarea').on('change', function() {
	updateArticlePreviewImages(this);
});

function updateArticlePreviewImages(element) {	
	var mainForm = $('form'),
		changedPrintableVaraintBlock = $(element).closest('.printable-variant-block'),
		printableVariantIsCompleted = checkIfPrintableVariantIsCompleted(changedPrintableVaraintBlock);

	if (printableVariantIsCompleted === true) {
		$('#article-images .thumbnail.article-preview').hide();
		$('.loading-gif').fadeIn();

		$.ajax({
			url : mainForm.attr('action'),
			type: mainForm.attr('method'),
			data : mainForm.serialize(),
			success: function(html) {
				$('#article-product-color select').replaceWith(
					$(html).find('#article-product-color select')
				);

				$('#article-images .box .grid').replaceWith(
					$(html).find('#article-images .box .grid')
				);

				$('#form-errors').replaceWith(
					$(html).find('#form-errors')
				);

				$('#tab-design input').each(function(){				
					var inputId = $(this).attr('id'),				
						newInputValue = $(html).find("#"+inputId).val();

					if (typeof newInputValue !== 'undefined') {
						$(this).val(newInputValue);
					}
				});				
		
				$('#tab-text input').each(function(){				
					var inputId = $(this).attr('id'),				
						newInputValue = $(html).find("#"+inputId).val();

					if (typeof newInputValue !== 'undefined') {
						$(this).val(newInputValue);
					}
				});	
		
				$('.loading-gif').fadeOut();				
			}
		});	
	}
}

function checkIfPrintableVariantIsCompleted(changedPrintableVaraintBlock) {
	var printableVariantIsCompleted = true;
	
	changedPrintableVaraintBlock.find('input').map(function(key, obj){
		if (obj.value == '') {
			printableVariantIsCompleted = false;
		}
	}, printableVariantIsCompleted);
	
	return printableVariantIsCompleted;
}




