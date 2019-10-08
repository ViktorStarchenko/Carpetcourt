!function($) {
    var file_frame;
    var attachment;

    if ( ! $('.edit_form_line .my_param_block').find('input.upload_document').val() ) {
        $( '.remove_image_button' ).hide();
        $( 'img.placeholder-img' ).hide();
    }

    $('.upload_image_button').click(function(e){
        e.preventDefault();
        var wrap = $( this ).closest( '.my_param_block' );
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: 'Choose an image',
            button: {
                text: "Use image"
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            attachment = file_frame.state().get( 'selection' ).first().toJSON();

            $('.edit_form_line .my_param_block').find('input.upload_document').val( attachment.id );
            $( 'img.placeholder-img' ).show();
            $( '.remove_image_button' ).show();
        });

        // Finally, open the modal.
        file_frame.open();
    });

    $( document ).on( 'click', '.remove_image_button', function(e) {
        e.preventDefault();
        $('.edit_form_line .my_param_block').find('input.upload_document').val('');
        $( 'img.placeholder-img' ).hide();
        $( this ).hide();
        return false;
    });
}(window.jQuery);