<?php
function html_popup_video($id){
	global $wpdb;

	?>
	<style>
		html.wp-toolbar {
			padding:0px !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0px;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function($) {	
			jQuery('#video-save-buttom').on('submit', function() {				
				var ID1 = jQuery('#cc_add_video_input').val();
				if( ID1 == "") { 
					alert("Please copy and past url from Youtube or media library.");
					return false;
				}
			    
				jQuery(this).submit();
				jQuery("#closepopup").click();
				
			});			
			

		<?php if(isset($_GET["closepop"]) && $_GET["closepop"] == 1){ ?>
			jQuery("#closepopup").click();
			self.parent.location.reload();
		<?php	} ?>
		
		});
		
	</script>
	<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>

	<div id="cc_slider_add_videos">
		
		<div id="cc_slider_add_videos_wrap">
			<h2>Add Video URL From Youtube or Media Library</h2>
			<div class="control-panel">
				<form action="admin.php?page=cc_sliders&id=<?php echo $id; ?>&task=add_video" target="_parent" method="POST" name="adminForm" id="adminForm">
						<input type="text" id="cc_add_video_input" name="cc_add_video_input" />
						<div id="add-video-popup-option">
							<label for=""></label>Is is Youtube Link</label>
							<input type="radio" name="sl_is_youtube" value="yes" /> Yes
							<input type="radio" name="sl_is_youtube" value="no" /> No
						</div>
						<input type="hidden" name="sl_video" value="1" />								
					
					<!-- <button type="submit" class='save-slider-options button-primary cc-insert-video-button' id='cc-insert-video-button'>Insert Video Slide</button> -->
					<input type="submit" value="Add Video" id="video-save-buttom" class="button button-primary button-large">
				
				</form>
			</div>
		</div>	
	</div>
<?php
}



function cc_slider_save_video($slider_id,$action = 'Add') {
	global $wpdb;
	$is_youtube = ( isset($_POST['sl_is_youtube']) && $_POST['sl_is_youtube']=="yes" )?'yes':'no';
	$table_name = $wpdb->prefix . 'slider_images';

	$query = sprintf("INSERT INTO `" . $table_name . "` ( `slider_id`, `image_url`, `sl_type`,`sl_is_youtube`, `ordering`) VALUES ( '%d', '%s', '%s', '%s', '' )", $slider_id, $_POST['cc_add_video_input'],'video',$is_youtube  );
	
	if($action == "Edit") {
		$item_no = '';
		$query = sprintf("UPDATE `" . $table_name . "` SET  `image_url` = '%s', `sl_type` = '%s',`sl_is_youtube`='%s WHERE `slider_id` = '%d' AND `id` = '%d',' ",$_POST['cc_add_video_input'],'video', $is_youtube, $slider_id, $item_no );
	} 
	$result = $wpdb->query( $wpdb->prepare( $query) );
	
	wp_redirect( admin_url('?page=cc_sliders&task=edit_cat&id='.$slider_id ) ); 
	exit;
}