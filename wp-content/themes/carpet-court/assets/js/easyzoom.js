/*
 * 	Easy Zoom 1.0 - jQuery plugin
 *	written by Alen Grakalic
 *	http://cssglobe.com/post/9711/jquery-plugin-easy-image-zoom
 *
 *	Copyright (c) 2011 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */

 /*

 Required markup sample

 <a href="large.jpg"><img src="small.jpg" alt=""></a>

 */

(function($) {

	$.fn.easyZoom = function(options){

		var defaults = {
			id: 'easy_zoom',
			parent: 'body',
			append: true,
			preload: 'Loading...',
			error: 'There has been a problem with loading the image.'
		};

		var obj;
		var img = new Image();
		var loaded = false;
		var found = true;
		var timeout;
		var w1,w2,h1,h2,rw,rh;
		var over = false;
		var term_name;
		var offset_left;
		var c_id;
		var listItem;

		var options = $.extend(defaults, options);

		this.each(function(){

			obj = this;
			// works only for anchors
			var tagName = this.tagName.toLowerCase();
			if(tagName == 'a'){

				var href = $(this).data('href');
				c_id = $(this).data('cid');
				img.src = href + '?' + (new Date()).getTime() + ' =' + (new Date()).getTime();
				$(img).error(function(){ found = false; })
				img.onload = function(){
					loaded = true;
					img.onload=function(){};
				};
				term_name = $(this).data('term');
				listItem = document.getElementById( 'color-i-'+c_id );
				// offset_left = $('ul#color-tab li a').index(listItem).parent();


				$(this)
					.css('cursor','crosshair')
					.click(function(e){ e.preventDefault(); return true; })
					.mouseover(function(e){ start(e); })
					.mouseout(function(){ hide(); })
					.mousemove(function(e){ move(e); })
			};

		});

		function start(e){
			hide();
			offset_left = $(listItem).parent().index();
			var pos = $('ul#color-tab li').eq(offset_left).position();

			var zoom = $('<div id="'+ options.id +'">'+ options.preload +'</div>');
			if(options.append) { zoom.appendTo($('div#collapse-color')) } else { zoom.prependTo($('div#collapse-color')) };
			if(!found){
				error();
			} else {
				if(loaded){
					show(e);
				} else {
					loop(e);
				};
			};
		};

		function loop(e){
			if(loaded){
				show(e);
				clearTimeout(timeout);
			} else {
				timeout = setTimeout(function(){loop(e)},200);
			};
		};

		function show(e){
			over = true;
			$(img).css({'position':'absolute','top':'0','left':'0'});
			$('#'+ options.id).html('').append(img);
			$('#'+ options.id).append('<div class="color-i-term vert-wrap"><div class="vert-middle">'+term_name+'</div></div>');
			// $('#'+ options.id).css('left', offset_left-100);
			// $(window).trigger('resize');
			w1 = $('img', obj).width();
			h1 = $('img', obj).height();
			w2 = $('#'+ options.id).width();
			h2 = $('#'+ options.id).height();
			w3 = $(img).width();
			h3 = $(img).height();
			w4 = $(img).width() - w2;
			h4 = $(img).height() - h2;
			rw = w4/w1;
			rh = h4/h1;
			// var offset_top = jQuery('.cc-product-color.desktop-view').offset().top;
			// $('#easy_zoom').css('top', offset_top);
			move(e);
		};

		function hide(){
			over = false;
			$('#'+ options.id).remove();
		};

		function error(){
			$('#'+ options.id).html(options.error);
		};

		function move(e){
			if(over){
				// target image movement
				var p = $('img',obj).offset();
				var pl = e.pageX - p.left;
				var pt = e.pageY - p.top;
				var xl = pl*rw;
				var xt = pt*rh;
				xl = (xl>w4) ? w4 : xl;
				xt = (xt>h4) ? h4 : xt;
				$('#'+ options.id + ' img').css({'left':xl*(-1),'top':xt*(-1)});
			};
		};

	};

})(jQuery);


(function($) {

	$.fn.cceasyZoom = function(options){

		var defaults = {
			id: 'cceasy_zoom',
			parent: 'body',
			append: true,
			preload: 'Loading...',
			error: 'There has been a problem with loading the image.'
		};

		var obj;
		var img = new Image();
		var loaded = false;
		var found = true;
		var timeout;
		var w1,w2,h1,h2,rw,rh;
		var over = false;
		var term_name;
		var offset_left;
		var c_id;
		var listItem;

		var options = $.extend(defaults, options);

		this.each(function(){

			obj = this;
			// works only for anchors
			var tagName = this.tagName.toLowerCase();
			if(tagName == 'img'){

				var href = $(this).data('href');
				c_id = $(this).data('cid');
				img.src = href + '?' + (new Date()).getTime() + ' =' + (new Date()).getTime();
				$(img).error(function(){ found = false; })
				img.onload = function(){
					loaded = true;
					img.onload=function(){};
				};
				term_name = $(this).data('term');
				listItem = document.getElementById( 'color-i-'+c_id );
				// offset_left = $('ul#color-tab li a').index(listItem).parent();


				$(this)
					.css('cursor','crosshair')
					.click(function(e){ e.preventDefault(); return true; })
					.mouseover(function(e){ start(e); })
					.mouseout(function(){ hide(); })
					.mousemove(function(e){ move(e); })
			};

		});

		function start(e){
			hide();
			offset_left = $(listItem).parent().index();
			var pos = $('ul#color-tab li').eq(offset_left).position();

			var zoom = $('<div id="'+ options.id +'">'+ options.preload +'</div>');

			if(options.append) { zoom.appendTo($(obj).parent()) } else { zoom.prependTo($(obj).parent()) };
			if(!found){
				error();
			} else {
				if(loaded){
					show(e);
				} else {
					loop(e);
				};
			};
		};

		function loop(e){
			if(loaded){
				show(e);
				clearTimeout(timeout);
			} else {
				timeout = setTimeout(function(){loop(e)},200);
			};
		};

		function show(e){
			over = true;
			$(img).css({'position':'absolute','top':'0','left':'0'});
			$('#'+ options.id).html('').append(img);
			$('#'+ options.id).append('<div class="color-i-term vert-wrap"><div class="vert-middle">'+term_name+'</div></div>');
			// $('#'+ options.id).css('left', offset_left-100);
			// $(window).trigger('resize');
			w1 = $('img', obj).width();
			h1 = $('img', obj).height();
			w2 = $('#'+ options.id).width();
			h2 = $('#'+ options.id).height();
			w3 = $(img).width();
			h3 = $(img).height();
			w4 = $(img).width() - w2;
			h4 = $(img).height() - h2;
			rw = w4/w1;
			rh = h4/h1;
			// var offset_top = jQuery('.cc-product-color.desktop-view').offset().top;
			// $('#easy_zoom').css('top', offset_top);
			move(e);
		};

		function hide(){
			over = false;
			$('#'+ options.id).remove();
		};

		function error(){
			$('#'+ options.id).html(options.error);
		};

		function move(e){
			if(over){
				// target image movement
				var p = $(obj).offset();
				var pl = e.pageX - p.left;
				var pt = e.pageY - p.top;
				var xl = pl*rw;
				var xt = pt*rh;
				xl = (xl>w4) ? w4 : xl;
				xt = (xt>h4) ? h4 : xt;
				$('#'+ options.id + ' img').css({'left':xl*(-1),'top':xt*(-1)});
			};
		};

	};

})(jQuery);
