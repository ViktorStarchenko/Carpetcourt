/**
 * Created by Rubal on 2/12/16.
 */
 jQuery(document).ready(function($){$( ".cc-hover-block" ).hover(function() {var is_active = $( this ).data('active');if(!is_active){var background_color_hover = $( this ).data('backgroundcolor-hover');var text_color_hover = $(this).find( '.cc-hover-info' ).data('textcolor-hover');if('' != background_color_hover){$(this).css('background-color',background_color_hover);$(this).find('.pg-link-hover-text').css('background-color',background_color_hover);}if('' != text_color_hover){$(this).find('.cc-page-title').css('color',text_color_hover);$(this).find('.cc-page-content').css('color',text_color_hover);$(this).find('.pg-link-hover-text h3').css('color',text_color_hover);}}}, function() {var is_active = $( this ).data('active');if(!is_active){$(this).css({color:'',backgroundColor:''});$(this).find('.cc-page-title').css('color','');$(this).find('.cc-page-content').css('color','');$(this).find('.pg-link-hover-text h3').css('color','');}});$( "body" ).on( 'touchstart', '.cc-hover-block', function() {var is_active = $( this ).data('active');if(!is_active){var background_color_hover = $( this ).data('backgroundcolor-hover');var text_color_hover = $(this).find( '.cc-hover-info' ).data('textcolor-hover');if('' != background_color_hover){$(this).css('background-color',background_color_hover);$(this).find('.pg-link-hover-text').css('background-color',background_color_hover);}if('' != text_color_hover){$(this).find('.cc-page-title').css('color',text_color_hover);$(this).find('.cc-page-content').css('color',text_color_hover);$(this).find('.pg-link-hover-text h3').css('color',text_color_hover);}}});
    $( "body" ).on( 'touchend', '.cc-hover-block', function() {var is_active = $( this ).data('active');if(!is_active){$(this).css({color:'',backgroundColor:''});$(this).find('.cc-page-title').css('color','');$(this).find('.cc-page-content').css('color','');$(this).find('.pg-link-hover-text h3').css('color','#fff');}});
    $('.cc-designer-tips').bxSlider({minSlides: 2,maxSlides: 4,slideWidth: 280,slideMargin: 10,nextText: '<span class="fa fa-angle-right" aria-hidden="true"></span>',prevText: '<span class="fa fa-angle-left" aria-hidden="true"></span>',pager: false});$("a[rel^='prettyPhoto']").prettyPhoto({autoplay: true,social_tools: false,deeplinking: false});$("a.cpm-prettyPhoto").prettyPhoto({autoplay: false,social_tools: false,deeplinking: false,keyboard_shortcuts: false,changepicturecallback: function(){$('.pp_content').height('267px');$.prettyPhoto.changePage = function(){};submit_mailchimp_subscribe_form();},
    });$("a.cpm-mailchimp-prettyPhoto").prettyPhoto({autoplay: false,social_tools: false,deeplinking: false,keyboard_shortcuts: false,changepicturecallback: function(){$('.pp_content').height('267px');$.prettyPhoto.changePage = function(){};submit_mailchimp_subscribe_list_form();},});function submit_mailchimp_subscribe_list_form() {$('.button-submit').on( 'click', function(e) {e.preventDefault();var mailchimp_list_id = $(this).parent('form').find('[name="mailchimp_list_id"]').val();var user_email = $(this).parent('form').find('.mailchimp_email').val();var send_email = false;var send_list = false;var _this = $(this);if ( mailchimp_list_id.length == 0 || mailchimp_list_id == '' ) {$(this).closest('form.mailchimp-form').find('.submit-list-err').html('Please select a list.');send_list = false;} else {send_list = true;}if ( user_email.length == 0 || user_email == '' ) {$(this).closest('form.mailchimp-form').find('.submit-err').html('Please enter your email.');send_email = false;} else if(  ! isValidEmailAddress( user_email ) ) {$(this).closest('form.mailchimp-form').find('.submit-err').html('Please enter valide email.');send_email = false;} else {send_email = true;}if ( send_email == true && send_list == true ) {$(this).closest('form.mailchimp-form').find('img.ajax-loader-chimp').show();$(this).closest('form.mailchimp-form').find('.submit-err').html('');$(this).closest('form.mailchimp-form').find('.submit-list-err').html('');$.ajax({type:"POST",url: filter_modal.ajax_url,data: {action: 'cpm_mailchimp_list_subscribe',user_email: user_email,list_id: mailchimp_list_id},success: function(response) {_this.closest('form.mailchimp-form').find('img.ajax-loader-chimp').hide();var json = $.parseJSON(response);var err_srt = json.err;if ( err_srt == false) {err_srt = 'test';}var exists = err_srt.indexOf("already");if ( ( json.status == true && json.err == false && json.res === 'subscribed' ) || ( json.status == true && exists > 8 && json.res == 400 ) ) {_this.closest('form.mailchimp-form').find('.submit-err').html( json.message );setTimeout(function() {$.prettyPhoto.close();}, 1500);} else {_this.closest('form.mailchimp-form').find('.submit-err').html( json.message );}}
            });}});}function submit_mailchimp_subscribe_form() {$('form.mailchimp-form').on( 'submit', function(e) {e.preventDefault();return false;});$('.button-submit').on( 'click', function(e) {e.preventDefault();var doc_id = $(this).parent('form').find('[name="doc_id"]').val();var user_email = $(this).parent('form').find('.mailchimp_email').val();var send_email = false;var _this = $(this);if ( user_email.length == 0 || user_email == '' ) {$(this).closest('form.mailchimp-form').find('.submit-err').html('Please enter your email.');send_email = false;} else if(  ! isValidEmailAddress( user_email ) ) {$(this).closest('form.mailchimp-form').find('.submit-err').html('Please enter valide email.');send_email = false;} else {send_email = true;}if ( send_email ) {$(this).closest('form.mailchimp-form').find('img.ajax-loader-chimp').show();$(this).closest('form.mailchimp-form').find('.submit-err').html('');$.ajax({type:"POST",url: filter_modal.ajax_url,data: {action: 'cpm_mailchimp_subscribe',user_email: user_email,doc_id: doc_id},success: function(response) {_this.closest('form.mailchimp-form').find('img.ajax-loader-chimp').hide();var json = $.parseJSON(response);var err_srt = json.err;if ( err_srt == false) {err_srt = 'test';}var exists = err_srt.indexOf("already");if ( ( json.status == true && json.err == false && json.res === 'subscribed' ) || ( json.status == true && exists > 8 && json.res == 400 ) ) {_this.closest('form.mailchimp-form').find('.submit-err').html( json.message );setTimeout(function() {$.prettyPhoto.close();
                }, 1500);if ( json.url.length > 0) {setTimeout(function() {var yourstring = json.url;var fileNameIndex = yourstring.lastIndexOf("/") + 1;var filename = yourstring.substr(fileNameIndex);var anchor_t = '<a href="'+json.url+'" class="dwn_link hidden" download="'+filename+'">click</a>';$('body').append(anchor_t);$('body a.dwn_link').get(0).click();$('body').find('a.dwn_link').remove();}, 2000);}} else {_this.closest('form.mailchimp-form').find('.submit-err').html( json.message );}}});}return false;});}
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};$(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({autoplay: false,social_tools: false,deeplinking: false});$( ".cc-gallery-img .figure-cross" ).hover(function() {var background_color_hover = $( this ).data('backgroundcolor-hover');if('' != background_color_hover){$(this).css('background-color',background_color_hover);}}, function() {$(this).removeAttr('style');});$( ".isotop-content" ).hover(function() {var background_color_hover = $( this ).data('backgroundcolor-hover');if('' != background_color_hover){$(this).css('background-color',background_color_hover);}}, function() {$(this).removeAttr('style');});$( ".cc-designer-tips .tips-overlay" ).hover(function() {var background_color_hover = $( this ).data('backgroundcolor-hover');if('' != background_color_hover){$(this).css('background-color',background_color_hover);}}, function() {$(this).removeAttr('style');});var btn_color;var btn_bg_color;$( ".cc-call-to-action a" ).hover(function() {btn_color = $(this).css('color');btn_bg_color = $(this).css('background-color');var btn_hover_color = $( this ).data('color-hover');var btn_hover_bg_color = $( this ).data('bgcolor-hover');$(this).css('color',btn_hover_color);$(this).css('background-color',btn_hover_bg_color);}, function() {$(this).css('color',btn_color);$(this).css('background-color',btn_bg_color);});
    $(".cc-page-fancy-box").fancybox({maxWidth    : 800,maxHeight   : 600,fitToView   : false,width       : '70%',height      : '70%',autoSize    : false,closeClick  : false,openEffect  : 'none',closeEffect : 'none'});$(".cc-fancy-box").on('click', function(e) {e.preventDefault();var _this = $(this);var vid_id = _this.data('videoid');$('#pop-up-video').modal('show');$.ajax({type:"POST",url: filter_modal.ajax_url,data: {action: 'show_popup_video',video_id: vid_id},beforeSend : function(){var text = "loading",new_text = text,prefix = '<div class="cpm-preloader"> <div class="loader-icon">',suffix = '</div></div>';$('#pop-up-video .modal-body .col-sm-12').html(prefix+suffix);},success: function(response) {$('#pop-up-video .modal-body .col-sm-12').html(response);$('.cpm-preloader').remove();}});});$('a.diagnostics-popup-btn').on('click', function(e) {e.preventDefault();var title = $(this).data('title');var desc = $(this).data('desc');var img = $(this).data('img');$('#diagnostics-rollover-pupup-modal main h3').html(title);$('#diagnostics-rollover-pupup-modal main .popup-banner-image').html('<img src="'+img+'">');$('#diagnostics-rollover-pupup-modal main .cpm-content').html(desc);$('#diagnostics-rollover-pupup-modal').modal('show');});});