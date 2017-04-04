var $collectionHolder;

// setup an "add a area" link
var $addAreaLink = $('<a href="#" class="add_area_link">Add a Print Area</a>');

jQuery(document).ready(function() {
    // Get the ul that holds the collection of areas
    $collectionHolder = $('div.areas');

    // add the "add a area" anchor and li to the areas ul
    $collectionHolder.append($addAreaLink);

    // add a delete link to all of the existing area form li elements
    $collectionHolder.find('ol.area').each(function() {
        addAreaFormDeleteLink($(this));
    });

    $('.add_area_link').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        $currentLink = $(this);
        $collectionHolder = $currentLink.closest('div.areas');

        // add a new area form (see next code block)
        addAreaForm($collectionHolder, $currentLink);                
    });                 
    
    $('ol.area input').change(function() { 
        
        var $input = $(this);
        var $areaId = $input.closest('ol.area').attr('id');

        var $value = parseInt($input.val());
        var $cssRule = $input.data('css-rule-for-preview');

        changeAreaPreview($areaId, $value, $cssRule);
    });
});

function addAreaForm($collectionHolder, $newLink) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.find('ol.area').length;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a area" link li
    var $newForm = $('<ol class="grid area"></div>').append(newForm);
    $newLink.before($newForm);

    addAreaFormDeleteLink($newForm);
}

function addAreaFormDeleteLink($areaForm) {
    var $removeFormA = $('<li class="col-1-5 pb-n""><a href="#">delete</a></li>');
    $areaForm.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the area form
        $areaForm.remove();
    });
}

function changeAreaPreview(areaId, value, cssRule) {
    $('#area-preview-' + areaId).css(cssRule, value);
}