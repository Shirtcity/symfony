var $collectionHolder;

var $addTagLink = $('.add-article-product-print-side');
var $newLinkLi = $('<div></div>').append($addTagLink);


// Get the ul that holds the collection of tags
$collectionHolder = $('div.variants');

// add the "add a tag" anchor and li to the tags ul
$collectionHolder.append($newLinkLi);

// count the current form inputs we have (e.g. 2), use that as the new
// index when inserting a new item (e.g. 2)
$collectionHolder.data('index', $collectionHolder.find(':input').length);

$addTagLink.on('click', function(e) {
	// prevent the link from creating a "#" on the URL
	e.preventDefault();

	// add a new tag form (see next code block)
	// Get the data-prototype explained earlier
	var prototype = $collectionHolder.data('prototype');

	// get the new index
	var index = $collectionHolder.data('index');

	// Replace '__name__' in the prototype's HTML to
	// instead be a number based on how many items we have
	var newForm = prototype.replace(/__name__/g, index);

	// increase the index with one for the next item
	$collectionHolder.data('index', index + 1);

	// Display the form in the page in an li, before the "Add a tag" link li
	var $newFormLi = $('<div></div>').append(newForm);
	$newLinkLi.before($newFormLi);
});