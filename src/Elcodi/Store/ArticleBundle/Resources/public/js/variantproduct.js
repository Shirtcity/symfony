/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

(function() {

    /* Ask for the chosen option variant name and price  */
    var recalculateVariantPrice = function() {

        var selectedOptions = [];
        $("option:selected").each(function() {
            selectedOptions.push(this.value);
        } );

        $.ajax({
            url: $("#article-info").data("variant-info-url"),
            data: {
                'variant-option-for-attribute': selectedOptions
            }
        }).done(function(data) {
            $(".box-article-name").html(data.parentName);
            $(".box-article-price").html(data.price);
        })
    };

    /* Associating variant recalculation at variant option change */
    $(".variant-option-select").change(recalculateVariantPrice);

    /* Firing variant recalculation at page load */
    recalculateVariantPrice();

})();
