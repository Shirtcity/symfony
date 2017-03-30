$('#article-product').change(function() {
	var form = $(this).closest('form');
	
	$.ajax({
		url : form.attr('action'),
		type: form.attr('method'),
		data : form.serialize(),
		success: function(html) {
			$('#article-product-color').replaceWith(
				$(html).find('#article-product-color')
			);
		}
	});
});



