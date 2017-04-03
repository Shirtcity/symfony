$('#article-product').change(function() {
	var form = $(this).closest('form');

	$.ajax({
		url : Routing.generate('admin_article_new_component_update'),
		type: form.attr('method'),
		data : form.serialize(),
		success: function(html) {
			$('#article-product-color').replaceWith(
				$(html).find('#article-product-color')
			);
		}
	});
});



