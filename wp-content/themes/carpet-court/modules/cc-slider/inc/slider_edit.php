<?php 
/**
 * [Html_editslider function to list sliders image listing]
 * 
 */
function Html_editslider($ord_elem, $count_ord, $images, $row,$cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat) {
	global $wpdb;
	
	if ( isset( $_GET["addslide"] ) && 1 == esc_html( $_GET["addslide"] ) ) {		
		header('Location: admin.php?page=cc_sliders&id='.$row->id.'&task=apply');
	}
	?>
	<script type="text/javascript">
		function submitbutton(pressbutton) {
			if(!document.getElementById('name').value){
				alert("Name is required.");
				return;	
			}
			
			document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
			document.getElementById("adminForm").submit();
			
		}

		function change_select() {
			submitbutton('apply');
		}
	</script>

	<!-- GENERAL PAGE, ADD IMAGES PAGE -->

	<div>	
		<div style="clear:both;"></div>
		<form action="admin.php?page=cc_sliders&id=<?php echo $row->id; ?>" method="POST" name="adminForm" id="adminForm">
			<div id="poststuff" >
				<div id="slider-header">
					<ul id="sliders-list">
						<?php
						foreach($rowsld as $rowsldires) {
							if($rowsldires->id != $row->id) {
							?>
								<li>
									<a href="#" onclick="window.location.href='admin.php?page=cc_sliders&task=edit_cat&id=<?php echo $rowsldires->id; ?>'" ><?php echo $rowsldires->name; ?></a>
								</li>
							<?php
							} else { ?>
								<li class="active" onclick="this.firstElementChild.style.width = ((this.firstElementChild.value.length + 1) * 8) + 'px';" style="background-image:url(<?php echo get_stylesheet_directory_uri(). '/modules/cc-slider/images/edit.png';?>);cursor: pointer;">
									<input class="text_area" onfocus="this.style.width = ((this.value.length + 1) * 8) + 'px'" type="text" name="name" id="name" maxlength="250" value="<?php echo esc_html(stripslashes($row->name));?>" />
								</li>
							<?php	
							}
						}
						?>
						<li class="add-new">
							<a onclick="window.location.href='admin.php?page=cc_sliders&amp;task=add_cat'">+</a>
						</li>
					</ul>
				</div>
				<div id="post-body" class="metabox-holder columns-2">
					<!-- Content -->
					<div id="post-body-content">
						<?php add_thickbox(); ?>
						<div id="post-body">
							<div id="post-body-heading">
								<h3>Slides</h3>
									<script>
											jQuery(document).ready(function($) {
											  var _custom_media = true,
											      _orig_send_attachment = wp.media.editor.send.attachment;
												 

											  jQuery('.cc-newuploader .button').click(function(e) {
											    var send_attachment_bkp = wp.media.editor.send.attachment,
											    	button = jQuery(this),
											    	id = button.attr('id').replace('_button', '');

											    	console.log(id);
											    _custom_media = true;

												jQuery("#"+id).val('');
												wp.media.editor.send.attachment = function(props, attachment){
											      if ( _custom_media ) {
												     jQuery("#"+id).val(attachment.url+';;;'+jQuery("#"+id).val());
													 jQuery("#save-buttom").click();
											      } else {
											        return _orig_send_attachment.apply( this, [props, attachment] );
											      };
											    }
											  
											    wp.media.editor.open(button);
												 
											    return false;
											  });

											  jQuery('.add_media').on('click', function(){
											    _custom_media = false;
												
											  });
											});
									</script>
								<input type="hidden" name="imagess" id="_unique_name" />
								<span class="wp-media-buttons-icon"></span>
								<div class="cc-newuploader uploader button button-primary add-new-image">
								<input type="button" class="button wp-media-buttons-icon" name="_unique_name_button" id="_unique_name_button" value="Add Image Slide" />
								</div>
								<?php /*<a href="admin.php?page=cc_sliders&task=popup_posts&id=<?php echo esc_html($_GET['id']); ?>&TB_iframe=1" class="button button-primary add-post-slide thickbox"  id="slideup2s" value="iframepop">
								<input  title="Add Post" class="thickbox" type="button" value="Add Post" />
								<span class="wp-media-buttons-icon"></span>Add Post Slide
								</a> */ ?>
								<a href="admin.php?page=cc_sliders&task=popup_video&id=<?php echo esc_html($_GET['id']); ?>&TB_iframe=1" class="button button-primary add-video-slide thickbox"  id="slideup3s" value="iframepop">
									<span class="wp-media-buttons-icon"></span>Add Video Slide
								</a>
								<script>
										jQuery(document).ready(function ($) {
												jQuery("#slideup").click(function () {
													window.parent.uploadID = jQuery(this).prev('input');
													formfield = jQuery('.upload').attr('name');
													tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
													return false;
												});
												window.send_to_editor = function (html) {
													imgurl = jQuery('img', html).attr('src');
													if(imgurl) {
														window.parent.uploadID.val(imgurl);
															tb_remove();
															jQuery("#save-buttom").click();
													}
													else {
														imgurl = jQuery('#embed-url-field').val();
														if(imgurl) {

															window.parent.jQuery("#_unique_name").val(imgurl+';;;');				
															jQuery("#save-buttom").click();												

															tb_remove();
														}
													}
												};
											});
								</script>				
							</div>
							<ul id="images-list">
								<?php
								$i=2;
								foreach ($rowim as $key=>$rowimages) { ?>
									<?php if ( $rowimages->sl_type == '') { 
										$rowimages->sl_type = 'image';
									}
										switch($rowimages->sl_type){
											case 'image':											
											?>
												<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>>
													<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
														<div class="image-container" >
															<img src="<?php echo $rowimages->image_url; ?>" />
															<div>
																<script>
																	jQuery(document).ready(function($){
																	  var _custom_media = true,
																		  _orig_send_attachment = wp.media.editor.send.attachment;

																	  jQuery('.cc-editnewuploader .button<?php echo $rowimages->id; ?>').click(function(e) {
																		var send_attachment_bkp = wp.media.editor.send.attachment;
																		var button = jQuery(this);
																		var id = button.attr('id').replace('_button', '');
																		_custom_media = true;
																		wp.media.editor.send.attachment = function(props, attachment){
																		  if ( _custom_media ) {
																			jQuery("#"+id).val(attachment.url);
																			jQuery("#save-buttom").click();
																		  } else {
																			return _orig_send_attachment.apply( this, [props, attachment] );
																		  };
																		}

																		wp.media.editor.open(button);
																		return false;
																	  });

																	  jQuery('.add_media').on('click', function(){
																		_custom_media = false;
																	  });
																		
																	});
																</script>
																<input type="hidden" name="imagess<?php echo $rowimages->id; ?>" id="_unique_name<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
																<span class="wp-media-buttons-icon"></span>
																<div class="cc-editnewuploader uploader button<?php echo $rowimages->id; ?> add-new-image">
																<input type="button" class="button<?php echo $rowimages->id; ?> wp-media-buttons-icon editimageicon" name="_unique_name_button<?php echo $rowimages->id; ?>" id="_unique_name_button<?php echo $rowimages->id; ?>" value="Edit image" />
																</div>
															</div>
														</div>
														<div class="image-options">															
															<div>
																<label for="titleimage<?php echo $rowimages->id; ?>">Title:</label>
																<input  class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>">
															</div>
															<div class="description-block">
																<label for="im_description<?php echo $rowimages->id; ?>">Description:</label>
																<textarea id="im_description<?php echo $rowimages->id; ?>" name="im_description<?php echo $rowimages->id; ?>" ><?php echo stripslashes( $rowimages->description ); ?></textarea>
															</div>
															<div class="link-block">
																<label for="sl_is_shortcode<?php echo $rowimages->id; ?>">Add Shortcode:</label>
																<input <?php checked($rowimages->sl_is_shortcode,'on');?>  class="link_target" type="checkbox" id="sl_is_shortcode<?php echo $rowimages->id; ?>" value="on" name="sl_is_shortcode<?php echo $rowimages->id; ?>" />
																<textarea  id="sl_add_shortcode<?php echo $rowimages->id; ?>" class="text_area" name="sl_add_shortcode<?php echo $rowimages->id; ?>" ><?php echo stripslashes($rowimages->sl_add_shortcode); ?></textarea>
																<p>Example:[number_count label="your_label" number="1000" ]</p>															
															</div>
															<div class="link-block">
																<label for="sl_url<?php echo $rowimages->id; ?>">URL:</label>
																<input class="text_area url-input" type="text" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_url; ?>" >
																<label class="long" for="sl_link_target<?php echo $rowimages->id; ?>">Open in new tab</label>
																<!-- <input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" /> -->
																<input <?php checked($rowimages->link_target,'on');?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />
															</div>
															<div class="link-block">
																<label for="sl_button_text_<?php echo $rowimages->id; ?>">Button Text:</label>
																<input class="text_area url-input" type="text" id="sl_button_text_<?php echo $rowimages->id; ?>" name="sl_button_text<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_button_text; ?>" >
															</div>
															<div class="link-block">	
																<label for="sl_button_url_<?php echo $rowimages->id; ?>">Button URL:</label>																
																<input class="text_area url-input" type="text" id="sl_button_url_<?php echo $rowimages->id; ?>" name="sl_button_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_button_url; ?>" >
																
																
																<label class="long" for="sl_button_attr_<?php echo $rowimages->id; ?>">Open in new tab</label>
																<input <?php checked($rowimages->sl_button_attr,'on');?>  class="link_target" type="checkbox" id="sl_button_attr_<?php echo $rowimages->id; ?>" name="sl_button_attr<?php echo $rowimages->id; ?>" />
															</div>
																
																
															<div class="remove-image-container">
																<a class="button remove-image" href="admin.php?page=cc_sliders&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Image</a>
															</div>
														</div>
														
													<div class="clear"></div>
												</  li>
											<?php
											break;
											case 'last_posts':	?>
												<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>  >
													<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
														<div class="image-container">
															<img width='100' height='100' src="<?php echo get_stylesheet_directory_uri(). '/modules/cc-slider/images/pin.png'; ?>" />
														</div>
														<div class="recent-post-options image-options">
															<div>
																<div class="left">
																	<?php $categories = get_categories(); ?>
																	<label for="titleimage<?php echo $rowimages->id; ?>">Show Posts From:</label>
																	<select name="titleimage<?php echo $rowimages->id; ?>" class="categories-list">
																		<option <?php if($rowimages->name == 0){echo 'selected="selected"';} ?> value="0">All Categories</option>
																	<?php foreach ($categories as $strcategories){ ?>
																		<option <?php if($rowimages->name == $strcategories->cat_name){echo 'selected="selected"';} ?> value="<?php echo $strcategories->cat_name; ?>"><?php echo $strcategories->cat_name; ?></option>
																	<?php	}	?> 
																	</select>
																</div>
																<div  class="left">
																	<label for="sl_url<?php echo $rowimages->id; ?>">Showing Posts Count:</label>
																	<input class="text_area url-input number" type="number" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_url; ?>" >
																</div>
															</div>
								
															<div>
																<label class="long" for="sl_stitle<?php echo $rowimages->id; ?>">Show Title:</label>
																<input type="hidden" name="sl_stitle<?php echo $rowimages->id; ?>" value="" />
																<input  <?php if($rowimages->sl_stitle == '1'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" name="sl_stitle<?php echo $rowimages->id; ?>" value="1" />
															</div>
															<div>
																<div class="left margin">
																	<label class="long" for="sl_sdesc<?php echo $rowimages->id; ?>">Show Description:</label>
																	<input type="hidden" name="sl_sdesc<?php echo $rowimages->id; ?>" value="" />
																	<input  <?php if($rowimages->sl_sdesc == '1'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" name="sl_sdesc<?php echo $rowimages->id; ?>" value="1" />
																</div>
																<div class="left">
																	<label for="im_description<?php echo $rowimages->id; ?>">Description Symbols Number:</label>
																	<input value="<?php echo $rowimages->description; ?>" class="text_area url-input number" id="im_description<?php echo $rowimages->id; ?>" type="number" name="im_description<?php echo $rowimages->id; ?>" />
																</div>
															</div>
															<div>
																<div class="left margin">
																	<label class="long" for="sl_postlink<?php echo $rowimages->id; ?>">Use Post Link:</label>
																	<input type="hidden" name="sl_postlink<?php echo $rowimages->id; ?>" value="" />
																	<input  <?php if($rowimages->sl_postlink == '1'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" name="sl_postlink<?php echo $rowimages->id; ?>" value="1" />
																</div>
																<div  class="left">	
																	<label class="long" for="sl_link_target<?php echo $rowimages->id; ?>">Open Link In New Tab:</label>
																	<input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" />
																	<input  <?php if($rowimages->link_target == 'on'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />
																	<!--<input type="checkbox" name="pause_on_hover" id="pause_on_hover"  <?php if($row->pause_on_hover == 'on'){ echo 'checked="checked"'; } ?>  class="link_target"/>-->
																</div>
															</div>
															<div class="remove-image-container">
																<a class="button remove-image" href="admin.php?page=cc_sliders&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Last posts</a>
															</div>
														</div>
														
													<div class="clear"></div>
												</li>
												<?php
											break;
											case 'video':
												?>
												<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>  >
													<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
														<?php 	
														if(strpos($rowimages->image_url,'youtube') !== false || strpos($rowimages->image_url,'youtu') !== false) {
															$liclass="youtube";
															$youtube_video_id = get_youtube_id_from_url($rowimages->image_url);

															$thumburl='<img src="http://img.youtube.com/vi/'.$youtube_video_id.'/mqdefault.jpg" alt="" />';
														} else if (strpos($rowimages->image_url,'vimeo') !== false) {	
															$liclass="vimeo";
															$vimeo = $rowimages->image_url;
															$imgid =  end(explode( "/", $vimeo ));
															$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$imgid.".php"));
															$imgsrc=esc_html($hash[0]['thumbnail_large']);
															$thumburl ='<img src="'.$imgsrc.'" alt="" />';
														}
														?> 
															<div class="image-container" >	
																<?php echo $thumburl; ?>
																<div class="play-icon <?php echo $liclass; ?>"></div>
																
																<div>
																	<script>
																			jQuery(document).ready(function ($) {
																					
																					jQuery("#slideup<?php echo $key; ?>").click(function () {
																						window.parent.uploadID = jQuery(this).prev('input');
																						formfield = jQuery('.upload').attr('name');
																						tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
																						
																						return false;
																					});
																			window.send_to_editor = function (html) {
																				imgurl = jQuery('img', html).attr('src');
																				if(imgurl) {
																					window.parent.uploadID.val(imgurl);
																						tb_remove();
																						jQuery("#save-buttom").click();
																				}
																				else {
																					imgurl = jQuery('#embed-url-field').val();
																					if(imgurl) {


																						window.parent.jQuery("#_unique_name").val(imgurl+';;;');				
																						jQuery("#save-buttom").click();												

																						tb_remove();
																					}
																				}
																			};
																				});
																					
																	</script>
																	<input type="hidden" name="imagess<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
																</div>
															</div>
															<div class="image-options">
																<div class="link-block">
																	<label for="sl_image_url_<?php echo $rowimages->id; ?>">Change URL:</label>
																	<input class="text_area url-input" type="text" id="sl_image_url_<?php echo $rowimages->id; ?>" name="sl_image_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->image_url; ?>" >
																</div>
																<div class="link-block">
																	<label for=""></label>Is is Youtube Link</label>
																	<input type="radio" name="sl_is_youtube" value="yes" <?php checked($rowimages->sl_is_youtube, "yes");?> /> Yes
																	<input type="radio" name="sl_is_youtube" value="no" <?php checked($rowimages->sl_is_youtube, "no");?> /> No
																</div>	
																<div class="remove-image-container">
																	<a class="button remove-image" href="admin.php?page=cc_sliders&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Link</a>
																</div>
															</div>
													<div class="clear"></div>
												</li>
												<?php break; 
										} ?>
								<?php }  // end foreach?>
							</ul>
						</div>
					</div>
						
					<!-- SIDEBAR -->
					<div id="postbox-container-1" class="postbox-container">
						<div id="side-sortables" class="meta-box-sortables ui-sortable">
							<div id="slider-unique-options" class="postbox">
							<h3 class="hndle"><span>Current Slider Options</span></h3>
							<ul id="slider-unique-options-list">
								
								<li>
									<label for="sl_width">Width</label>
									<input type="text" name="sl_width" id="sl_width" value="<?php echo $row->sl_width; ?>" class="text_area" />
									
								</li>
								<li>
									<label for="width_full_width">Full Width</label>
									<input type="checkbox" name="width_full_width"  value="on" id="width_full_width"  <?php checked($row->width_full_width,'on'); ?> />
								</li>
								<li>
									<label for="sl_height">Height</label>
									<input type="text" name="sl_height" id="sl_height" value="<?php echo $row->sl_height; ?>" class="text_area" />
								</li>
								
								<li>
									<label for="slider_effects_list">Effects</label>
									<select name="slider_effects_list" id="slider_effects_list">
										<?php				
											$slider_effects_array = array(
														'none'         => "None",
														'cubeH'        => "Cube Horizontal",
														'cubeV'        => "Cube Vertical",
														'fade'         => "Fade",
														'sliceH'       => "Slice Horizontal",
														'sliceV'       => "Slice Vertical",
														'slideH'       => "Slide Horizontal",
														'slideV'       => "Slide Vertical",
														'scaleOut'     => "Scale Out",
														'scaleIn'      => "Scale In",
														'blockScale'   => "Block Scale",
														'kaleidoscope' => "Kaleidoscope",
														'fan'          => "Fan",
														'blindH'       => "Blind Horizontal",
														'blindV'       => "Blind Vertical",
														'random'       => "Random"
													);
											foreach($slider_effects_array as $key => $value) { ?>
												<option  value="<?php echo $key?>" <?php selected( $key, $row->slider_list_effects_s )?> ><?php echo $value?></option>
											<?php } ?>
									</select>
								</li>

								<li>
									<label for="sl_pausetime">Pause Time</label>
									<input type="text" name="sl_pausetime" id="sl_pausetime" value="<?php echo $row->description; ?>" class="text_area" />
								</li>
								<li>
									<label for="sl_changespeed">Change Speed</label>
									<input type="text" name="sl_changespeed" id="sl_changespeed" value="<?php echo $row->param; ?>" class="text_area" />
								</li>
								<li>
									<label for="slider_position">Slider Position</label>
									<select name="sl_position" id="slider_position">
										<?php $sl_position_array = array(
																		'left'   => 'Left',
																		'right'  => 'Right',
																		'center' => 'Center'
																		);
										foreach($sl_position_array as $key => $value) { ?>
												<option  value="<?php echo $key?>" <?php selected( $key, $row->sl_position )?> ><?php echo $value?></option>
										<?php } ?>																	
									</select>
								</li>
								<li>
									<label for="sl_loading_icon">Loading Icon</label>
									<select id="sl_loading_icon" name="sl_loading_icon">
										<?php $sl_loading_icon_array = array(
																		'on'   => 'On',
																		'off'  => 'Off'
																		);
										foreach($sl_loading_icon_array as $key => $value) { ?>
												<option  value="<?php echo $key?>" <?php selected( $key, $row->sl_loading_icon )?> ><?php echo $value?></option>
										<?php } ?>									 
									</select>
								</li>
								<li>
									<label for="show_thumb">Navigate By</label>
									<input type="hidden" value="off" name="show_thumb" />					
									<select id="show_thumb" name="show_thumb">
									<?php $show_thumb_array = array(
																		'dotstop'    => 'Dots',
																		'thumbnails' => 'Thumbnails',
																		'nonav'      => 'No Navigation'
																		);
										foreach($show_thumb_array as $key => $value) { ?>
												<option  value="<?php echo $key?>" <?php selected( $key, $row->show_thumb )?> ><?php echo $value?></option>
										<?php } ?>									  
									</select>
								</li>
								<li>
									<label for="pause_on_hover">Pause on Hover</label>
									<!-- <input type="hidden" value="off" name="pause_on_hover" /> -->					
									<input type="checkbox" name="pause_on_hover"  value="on" id="pause_on_hover"  <?php checked($row->pause_on_hover,'on'); ?> />
								</li>

								<!-- 10 Feb 2016 -->
								<?php
								 /**
								 * new added functionalities
								 */
								?>
								<li>
									<label for="sl_overlay">Overlay</label>
									<input type="checkbox" name="sl_overlay" value="on" id="sl_overlay" <?php checked($row->sl_overlay,'on'); ?> />
								</li>

								<li>
									<label for="sl_overlay_color">Overlay Color</label>
									<input type="text" name="overlay_color" class="color" id="sl_overlay_color" <?php echo ($row->sl_overlay != 'on')?'disabled="disabled"':''?> value="<?php echo $row->overlay_color; ?>" />
								</li>

								<li>
									<label for="sl_overlay_image">Overlay Image</label>
									<input type="text" name="overlay_image" id=" "<?php echo ($row->sl_overlay != 'on')?'disabled="disabled"':''?> value="<?php echo $row->overlay_image; ?>" />
								    <input type="button" name="upload-btn" id="upload-btn"<?php echo ($row->sl_overlay != 'on')?'disabled="disabled"':''?> class="button-secondary" value="Upload Image">
								</li>
							
								<li>
									<label for="sl_is_mobile">Is Mobile</label>
									<input type="checkbox" name="sl_is_mobile" value="on" id="sl_is_mobile" <?php checked($row->sl_is_mobile,'on'); ?> />
								</li>
								
								<li>
									<label for="sl_mobile_text">Mobile Text</label>
									<input type="text" name="sl_mobile_text" id="sl_mobile_text" value="<?php echo $row->sl_mobile_text; ?>" />
								</li>


								<li>
									<label for="sl_mobile_image">Mobile Image</label>
										<input type="text" name="sl_mobile_image" id="sl_mobile_image" value="<?php echo $row->sl_mobile_image; ?>" />
									    <input type="button" name="mobile-upload-btn" id="mobile-upload-btn" class="button-secondary" value="Upload Mobile Image">
								</li>
							
							</ul>
								<div id="major-publishing-actions">
									<div id="publishing-action">
										<input type="button" onclick="submitbutton('apply')" value="Save Slider" id="save-buttom" class="button button-primary button-large">
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						<div id="slider-shortcode-box" class="postbox shortcode ms-toggle">
							<h3 class="hndle"><span>Usage</span></h3>
							<div class="inside">
								<ul>
									<li rel="tab-1" class="selected">
										<h4>Shortcode</h4>
										<p>Copy &amp; paste the shortcode directly into any WordPress post or page.</p>
										<textarea class="full" readonly="readonly">[cc_slider id="<?php echo $row->id; ?>"]</textarea>
									</li>
									<li rel="tab-2">
										<h4>Template Include</h4>
										<p>Copy &amp; paste this code into a template file to include the slideshow within your theme.</p>
										<textarea class="full" readonly="readonly">&lt;?php echo do_shortcode("[cc_slider id='<?php echo $row->id; ?>']"); ?&gt;</textarea>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="task" value="" />
			 <input type="hidden" name="csrf_token_cc_1752" value="csrf_token_cc_1752" />
				<?php $_SESSION['csrf_token_cc_1752'] = 'csrf_token_cc_1752'; ?>
		</form>
	</div>

	<?php

}