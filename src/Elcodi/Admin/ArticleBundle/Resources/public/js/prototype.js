// add a delete link to all of the existing tag form li elements
$('.printable-variants > div').children('div').each(function() {
	addTagFormDeleteLink($(this));
});

$('.add-printable-variant').on('click', function(e) {
	e.preventDefault();

	var $collectionHolder = $(this).closest('.printable-variants');
	var $newLink = $(this).closest('.add-printable-variant');

	// count of elements in the current collection
	$collectionHolder.data('index', $('.printable-variants-block .printable-variant-block').length);

	// add a new tag form 
	addPrintableForm($collectionHolder, $newLink);
});

function addPrintableForm($collectionHolder, $newLink) {
	// Get the data-prototype explained earlier
	var prototype = $collectionHolder.data('prototype');

	// get the new index
	var index = $collectionHolder.data('index');

	// Replace '__name__' in the prototype's HTML to
	// instead be a number based on how many items we have
	var newFormPrototype = prototype.replace(/__name__/g, index);

	// increase the index with one for the next item
	$collectionHolder.data('index', index + 1);					

	var $newForm = $(newFormPrototype);
    
	addTagFormDeleteLink($newForm);
	addFunctionUpdateImagePreview($newForm);
	
	$newLink.before($newForm);					
}

function addTagFormDeleteLink($tagForm) {
	var $removeFormA = $('<a class="delete-printable-variant" href="#"><i class="icon-trash-o"></i> Delete this variant</a>');
	$tagForm.append($removeFormA);

	$tagForm.find('.delete-printable-variant').on('click', function(e) {		
		e.preventDefault();		
		$tagForm.remove();		
		updateArticlePreviewImages(this);
	});		
}

function addFunctionUpdateImagePreview($tagForm){
	$tagForm.find('input, select').on('change', function(){		
		updateArticlePreviewImages(this);
	});
}