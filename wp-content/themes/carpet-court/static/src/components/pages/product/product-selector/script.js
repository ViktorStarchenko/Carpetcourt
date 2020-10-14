function toggleColorProduct() {
    
	var productPhotoParent = document.querySelectorAll('.js-product-parent');

	if(!productPhotoParent) return false;
	
	productPhotoParent.forEach(function(parent, parent_index) {
		var productTriggerPhoto = parent.querySelectorAll('.js-product-trigger');
		var productTargetPhoto = parent.querySelectorAll('.js-product-target');
		var productNamingEl = parent.querySelector('.js-select-color');
		var productNaming = productTriggerPhoto[0].dataset.naming;

		//productTriggerPhoto[0].classList.add('is-active');
		productTargetPhoto[0].classList.add('is-visible');
		//productNamingEl.textContent = productNaming;


		productTriggerPhoto.forEach( function(item, trigIndex) {
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
					var itemNaming = item.dataset.naming;
					productNamingEl.textContent = itemNaming;
					item.classList.add('is-active');
					productTargetPhoto[trigIndex].classList.add('is-visible');
				}

				productPhotoParent.forEach(function(other_parent, other_parent_index){
					if(parent_index !== other_parent_index){
						var changeTrig = other_parent.querySelectorAll('.js-product-trigger');
						var changeTarg = other_parent.querySelectorAll('.js-product-target');
						var changeNamingEl = other_parent.querySelector('.js-select-color');
						var changeNaming = changeTrig[trigIndex].dataset.naming;
						changeTrig.forEach(function(changeTrig_p) {
							changeTrig_p.classList.remove('is-active');
						});
						changeTarg.forEach(function(changeTarg_p) {
							changeTarg_p.classList.remove('is-visible');
						});
						changeNamingEl.textContent = changeNaming;
						changeTrig[trigIndex].classList.add('is-active');
						changeTarg[trigIndex].classList.add('is-visible');
					}
				});
				
			});
		});
	});

}

window.addEventListener('load', function() {
    toggleColorProduct();
});