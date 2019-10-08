jQuery(document).on( 'click' , '#import_csvv', function(){

    var file = document.getElementById("import_product_csv");

    var file_val = file.files[0];

    var formData = new FormData();
    formData.append("action", "upload_product_csv");
    formData.append( 'file[]', file_val );

    jQuery.ajax({
        url : translate.admin_ajax,
        data : formData,
        contentType: false,
        processData: false,
        type : 'POST',
        beforeSend : function(){
            jQuery('.spinner_loader').show();
        },
        success : function(){
            jQuery('.spinner_loader').hide();
            alert( 'CSV Imported Successfully' );
        }
    });

});

jQuery(document).on( 'click' , '#color_import', function(){

	var file = document.getElementById("import_color_csv");

	var file_val = file.files[0];

	var formData = new FormData();
	formData.append("action", "upload_color_csv");
    formData.append( 'file[]', file_val );

    jQuery.ajax({
    	url : translate.admin_ajax,
    	data : formData,
    	contentType: false,
    	processData: false,
    	type : 'POST',
    	beforeSend : function(){
    		jQuery('.spinner_loader').show();
    	},
    	success : function(){
    		jQuery('.spinner_loader').hide();
    		alert( 'CSV Imported Successfully' );
    	}
    });

});
