$('#article-product, #article-product-color').change(function() {
	var form = $(this).closest('form'),
		articleId = $('fieldset').attr('data-fc-article-id'),
		url = Routing.generate('admin_article_new_component_update');
		
	if(articleId){
		url = Routing.generate('admin_article_update_component', { id: articleId });
	}

	$.ajax({
		url : url,
		type: form.attr('method'),
		data : form.serialize(),
		success: function(html) {
			$('#article-product-color select').replaceWith(
				$(html).find('#article-product-color select')
			);
			
			$('#article-images').replaceWith(
				$(html).find('#article-images')
			);
		}
	});
});



