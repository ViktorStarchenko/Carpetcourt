jQuery(function ($) {var $container = jQuery('.cpm-isotope-list');
var $gridd = $container.isotope({ //Isotope options, 'item' matches the class in the PHP
    itemSelector : '.isotope-item',
    resizable: false,
    masonry: {
        gutterWidth: 20,
        columnWidth: 1
    }
});
$gridd.imagesLoaded().progress( function() {
  $gridd.isotope('layout');
});
//Add the class selected to the item that is clicked, and remove from the others
var $optionSets = $('#filters'),
    $optionLinks = $optionSets.find('a');
    $optionLinks.click(function(){var $this = $(this);if ( $this.hasClass('selected') ) {return false;}var $optionSet = $this.parents('#filters');$optionSets.find('.selected').removeClass('selected');$this.addClass('selected');var selector = $(this).attr('data-filter');$container.isotope({ filter: selector });return false;});
    $("a[rel^='prettyPhoto']").prettyPhoto({
        autoplay: false,
        social_tools: false,
        deeplinking: false
    });
    $(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
        autoplay: false,
        social_tools: false,
        deeplinking: false
    });
});