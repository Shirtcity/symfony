$('#article-product, #article-product-color, .printable-variants input, .printable-variants select').change(function() {

	var form = $(this).closest('form');

	$.ajax({
		url : form.attr('action'),
		type: form.attr('method'),
		data : form.serialize(),
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
							
				$(this).val(newInputValue);
			});	
		}
	});
});




