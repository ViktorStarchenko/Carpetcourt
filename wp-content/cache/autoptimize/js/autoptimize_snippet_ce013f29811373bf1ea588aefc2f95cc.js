jQuery(document).ready(function($){var flooring_finder_subpages=$('fieldset.cpm-pa_rent, fieldset.cpm-pa_sell, fieldset.cpm-pa_floor');if(flooring_finder_subpages.length>0){$('figcaption.fig-hover-one').each(function(){var current_figure=$(this);var default_controls=$('a.cpm_filter_tax, a.product_color, a.filter_tax',current_figure);if(default_controls.length>0){current_figure.unbind('click').on('click',function(e){default_controls.click()});default_controls.on('click',function(e){if(!e.isPropagationStopped()){e.stopPropagation()}})}
var popup_controls=$('a.filter_tax',current_figure);if(popup_controls.length>0){current_figure.unbind('click').on('click',function(e){popup_controls.click()});popup_controls.on('click',function(e){e.stopPropagation()})}})}
var pa_style_subpages=$('fieldset.click-pa_style');if(pa_style_subpages.length>0){$('fieldset.click-pa_style figcaption.fig-hover-one').each(function(){var current_figuree=$(this);var popup_controlss=$('a.view-btn',current_figuree);if(popup_controlss.length>0){current_figuree.unbind('click touchend').on('click touchend',function(e){popup_controlss.click()});popup_controlss.on('click touchend',function(e){e.stopPropagation()})}})}
$('.navbar-mobile li.ubermenu-item-has-children').not('li#menu-item-8937').on('click touchstart',function(){$(this).toggleClass('ubermenu-active')})});