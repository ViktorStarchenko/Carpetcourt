jQuery(window).load(function() {
    var container = document.querySelector('#masonry-loop');
    var msnry;
    imagesLoaded( container, function() {
        msnry = new Masonry( container, {
            itemSelector: '.masonry-entry',
            columnWidth: '.masonry-entry'
        });
    });
});