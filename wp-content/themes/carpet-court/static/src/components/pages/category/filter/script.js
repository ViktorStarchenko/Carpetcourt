function accordeon() {

	// var contents = $('.js-accordeon-content');
	var titles = $('.js-accordeon-title');

	if(!titles.length) return false;

	var contents_all = $('.js-accordeon-content');

	if(contents_all.is(':visible')) {
		contents_all.filter(':visible').prev('.js-accordeon-title').addClass('is-opened');
	}

	titles.on('click',function() {
		var t_title = $(this);
		var t_parent = t_title.closest('.js-accordeon-wrap');
		var contents = t_parent.find('.js-accordeon-content');

		var t_content = t_title.next('.js-accordeon-content'); 

		if (!t_content.is(':visible')) {
			if(contents.is(':visible')) {
				contents.filter(':visible').slideUp( function() {
					$(this).prev('.js-accordeon-title').removeClass('is-opened');
					t_title.addClass('is-opened');
					t_content.slideDown();
				});
			} else {
				t_title.addClass('is-opened');
				t_content.slideDown();
			}
		} else {
			t_content.slideUp(function() {
				t_title.removeClass('is-opened');
			});
		}
	});

}

function toggleColorProduct() {
    
	var productPhotoParent = document.querySelectorAll('.js-product-parent');

	if(!productPhotoParent.length) return false;
		
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
	accordeon();
});