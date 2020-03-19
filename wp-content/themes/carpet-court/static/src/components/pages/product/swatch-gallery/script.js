function toggleSwatch(){
    var swatchButton = document.querySelectorAll('.js-show-swatch');

    if(!swatchButton.length) return false;

    var swatchParent = document.querySelector('.js-swatch-parent');

    swatchButton.forEach(function(sw_button){
        sw_button.addEventListener('click', function(e){
            e.preventDefault();
            if(swatchParent.classList.contains('is-visible')){
                swatchParent.classList.remove('is-visible');
            } else {
                swatchParent.classList.add('is-visible');
            }
        });
    })


}

window.addEventListener('load', function() {
    toggleSwatch();
});