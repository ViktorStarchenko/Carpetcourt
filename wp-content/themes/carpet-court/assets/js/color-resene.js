/**
 * Created by Rubal on 3/8/16.
 */
jQuery(document).ready(function ($) {$('#color-tab').on('shown.bs.tab', function (e) {var color = $(this).find('li.active').data('color');$('.single-selected-color').html('<span>Selected Color: </span> '+ color);});$('#color-tabs').on('shown.bs.tab', function (e) {var color = $(this).find('li.active').data('color');$('.single-selected-color').html('<span>>Selected Color: </span> '+ color);});});