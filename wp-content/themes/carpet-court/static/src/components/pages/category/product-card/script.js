function showMobileCategoryImg() {

	var photoParent = document.querySelectorAll('.js-show-photo-parent');
	var mql = window.matchMedia('(max-width: 900px)');
		
	photoParent.forEach( function(parent) {
		var triggerPhoto = parent.querySelectorAll('.js-show-photo-trigger');
		var targetPhoto = parent.querySelectorAll('.js-show-photo-target');

		triggerPhoto.forEach( function(item, index) {
			item.addEventListener('click', function() {
				if(mql.matches) {

					if(item.classList.contains('is-active')) {
						item.classList.remove('is-active');
						targetPhoto[index].classList.remove('is-visible');
					} else {
						triggerPhoto.forEach(function(trig_p) {
							trig_p.classList.remove('is-active');
						});
						targetPhoto.forEach(function(targ_p){
							targ_p.classList.remove('is-visible');
						});
						item.classList.add('is-active');
						targetPhoto[index].classList.add('is-visible');
					}

				}
			});
		});

		window.addEventListener('resize', function() {
			if(!mql.matches) {
				triggerPhoto.forEach(function(trig_p) {
					trig_p.classList.remove('is-active');
				});
				targetPhoto.forEach(function(targ_p) {
					targ_p.classList.remove('is-visible');
				});
			}
		});

	});


}

window.addEventListener('load', function() {
    showMobileCategoryImg();
});