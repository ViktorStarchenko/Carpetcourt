jQuery(document).ready( function() {jQuery('form.form-horizontal').on( 'submit', function(e) {e.preventDefault();}).validate({rules: {your_message: {required: true,},your_name: {required: true,},your_email: {required: true,email: true},},submitHandler: function(form) {var form_el = jQuery('form.form-horizontal');var to_email = jQuery(form_el).find('[name="to_email"]').val();var your_name = jQuery(form_el).find('[name="your_name"]').val();var your_email = jQuery(form_el).find('[name="your_email"]').val();var your_message = jQuery(form_el).find('[name="your_message"]').val();jQuery.ajax({
          type:"POST",
          url: yith_wcwl_plugin_ajax_web_url,
          data: {
            action: 'cpm_send_message_to_stores',
            to_email: to_email,
            your_name: your_name,
            your_email: your_email,
            your_message: your_message,
        },
        success: function(results){var data = jQuery.parseJSON(results);if ( data.status == true) {window.location.href = script_modal.base_url+'our-store-confirmation/';} else {jQuery(form_el).after('<p class="cpm-status">Smoething went wrong!!!</p>');}}});}});});