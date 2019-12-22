function toggleColorProduct() {
    
	var productPhotoParent = document.querySelectorAll('.js-product-parent');
		
	productPhotoParent.forEach(function(parent) {
		var productTriggerPhoto = parent.querySelectorAll('.js-product-trigger');
		var productTargetPhoto = parent.querySelectorAll('.js-product-target');

		productTriggerPhoto[0].classList.add('is-active');
		productTargetPhoto[0].classList.add('is-visible');

		productTriggerPhoto.forEach( function(item, index) {
			item.addEventListener('click', function() {

				if(item.classList.contains('is-active')) {
					return false;
				} else {
					productTriggerPhoto.forEach(function(trig_p) {
						trig_p.classList.remove('is-active');
					});
					productTargetPhoto.forEach(function(targ_p) {
						targ_p.classList.remove('is-visible');
					});
					item.classList.add('is-active');
					productTargetPhoto[index].classList.add('is-visible');
				}

				
			});
		});
	});

}

window.addEventListener('load', function() {
    toggleColorProduct();
});