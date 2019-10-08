<?php 
function html_popup_posts($ord_elem, $count_ord, $images, $row,$cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat){
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
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function() {
				
					jQuery('#slider-posts-tabs li a').click(function(){
						jQuery('#slider-posts-tabs li').removeClass('active');
						jQuery(this).parent().addClass('active');
						jQuery('#slider-posts-tabs-contents li').removeClass('active');
						var liID=jQuery(this).attr('href');
						jQuery(liID).addClass('active');
						return false;
					});
					
					/*jQuery('.cc-insert-post-button').on('click', function() {
						alert("Add Post Slide feature");
						return false;
					});*/
			

					jQuery('#slider-posts-tabs-content-0 .cc-insert-post-button').on('click', function() {
						var ID1 = jQuery('#cc-add-posts-params').val();
						if(ID1==""){return false;}
						window.parent.uploadID.val(ID1);
						tb_remove();
						jQuery("#save-buttom").click();
						
					});
				
					jQuery('.cc-post-checked').change(function(){
						if(jQuery(this).is(':checked')){
							jQuery(this).addClass('active');
							jQuery(this).parent().addClass('active');
						}else {
							jQuery(this).removeClass('active');
							jQuery(this).parent().removeClass('active');
						}
						
						var inputval="";
						jQuery('#cc-add-posts-params').val("");
						jQuery('.cc-post-checked').each(function(){
							if(jQuery(this).is(':checked')){
								inputval+=jQuery(this).val()+";";
							}
						});
						jQuery('#cc-add-posts-params').val(inputval);
					});
											
					jQuery('#cc_slider_add_posts_wrap .view-type-block a').click(function(){
						jQuery('#cc_slider_add_posts_wrap .view-type-block a').removeClass('active');
						jQuery(this).addClass('active');
						var strtype=jQuery(this).attr('href').replace('#','');
						jQuery('#cc-posts-list').removeClass('list').removeClass('thumbs');
						jQuery('#cc-posts-list').addClass(strtype);
						return false;
					});

					jQuery('.updated').css({"display":"none"});
				<?php	if(isset($_GET["closepop"]) && $_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
				<?php	} ?>
				});
				
			</script>
			<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>
	
	
	<div id="cc_slider_add_posts">
		<div id="cc_slider_add_posts_wrap">
			
			<ul id="slider-posts-tabs">
				<li  class="active"><a href="#slider-posts-tabs-content-0">Static posts</a></li>
				<li><a href="#slider-posts-tabs-content-1">Last posts</a></li>
			</ul>
			<ul id="slider-posts-tabs-contents">
				<li id="slider-posts-tabs-content-0"  class="active">
					<!-- STATIC POSTS -->
					<div class="control-panel">
	
						<label for="cc-categories-list">Select Category <select id="cc-categories-list" name="iframecatid" onchange="this.form.submit()">
						<?php $categories = get_categories(  ); ?>
						<?php	 foreach ($categories as $strcategories){
							if(isset($_POST["iframecatid"])){
							?>
								 <option value="<?php echo $strcategories->cat_ID; ?>" <?php if($strcategories->cat_ID == $_POST["iframecatid"]){echo 'selected="selected"';} ?>><?php echo $strcategories->cat_name; ?></option>';
								
							<?php }
							else
							{
							?>
								<option value="<?php echo $strcategories->cat_ID; ?>"><?php echo $strcategories->cat_name; ?></option>';
							<?php
							}
						}
						?> 
						</select></label>
				
				
						<button class='save-slider-options button-primary cc-insert-post-button' id='cc-insert-post-button-top'>Insert Posts</button>
						<label for="cc-description-length">Description Length <input id="cc-description-length" type="text" name="postcc-description-length" value="<?php echo $row->published; ?>" placeholder="Description length" /></label>
						<div class="view-type-block">
							<a class="view-type list active" href="#list">View List</a>
							<a class="view-type thumbs" href="#thumbs">View List</a>
						</div>
					</div>
					<div style="clear:both;"></div>
					<ul id="cc-posts-list" class="list">
						<li id="cc-posts-list-heading" class="hascolor">
							<div class="cc-posts-list-image">Image</div>
							<div class="cc-posts-list-title">Title</div>
							<div class="cc-posts-list-description">
								Description
							</div>
							<div class="cc-posts-list-link">Link</div>
							<div class="cc-posts-list-category">Category</div>
							<div class="help-message">Please make sure that category you selected has posts with inserted featured image. Only posts with featured images will be shown on slides.</div>
						</li>
						<?php 

						$strx=1;
						foreach($rowsposts8 as $rowspostspop1){
							 $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts where post_type = 'post' and post_status = 'publish' and ID = %d  order by ID ASC", $rowspostspop1->object_id);
						$rowspostspop=$wpdb->get_results($query);
						//print_r($rowspostspop);
						if(isset($rowspostspop[0]->ID)) {
							$post_categories =  wp_get_post_categories( $rowspostspop[0]->ID, $rowspostspop[0]->ID ); 
							$cats = array();
							
							foreach($post_categories as $c){
								$cat = get_category( $c );
								$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug, 'id' => $cat->term_id );
								//echo	$cat->slug;
							}
							if(get_the_post_thumbnail($rowspostspop[0]->ID, 'thumbnail') != ''){
								$strx++;
								$hascolor="";
								if($strx%2==0){$hascolor='class="hascolor"';}
						?>
							
							<li <?php echo $hascolor; ?>>
								<input type="checkbox" class="cc-post-checked"  value="<?php echo $rowspostspop[0]->ID; ?>">
								<div class="cc-posts-list-image"><?php echo get_the_post_thumbnail($rowspostspop[0]->ID, 'thumbnail'); ?></div>
								<div class="cc-posts-list-title"><?php echo $rowspostspop[0]->post_title;	?></div>
								<div class="cc-posts-list-description"><?php echo	$rowspostspop[0]->post_content;	?></div>
								<div class="cc-posts-list-link"><?php echo	$rowspostspop[0]->guid; ?></div>
								<div class="cc-posts-list-category"><?php echo	$cat->slug;	?></div>
							</li>
						<?php }
							}
						}							?>
					</ul>
					<input id="cc-add-posts-params" type="hidden" name="popupposts" value="" />
					<div class="clear"></div>
					<button class='save-slider-options button-primary cc-insert-post-button' id='cc-insert-post-button-bottom'>Insert Posts</button>
			
				</li>
				<li id="slider-posts-tabs-content-1" class="recent-post-options">
					<!-- RECENT POSTS -->
				
								<div>
									<div class="left less-margin height">
										<?php $categories = get_categories(); ?>
										<label for="titleimage">Show Posts From:</label>
										<select name="titleimage" class="categories-list">
											<option <?php if(isset($rowimages->name) && $rowimages->name == 0){echo 'selected="selected"';} ?> value="0">All Categories</option>
										<?php foreach ($categories as $strcategories){ ?>
											<option <?php if($rowimages->name == $strcategories->cat_name){echo 'selected="selected"';} ?> value="<?php echo $strcategories->cat_name; ?>"><?php echo $strcategories->cat_name; ?></option>
										<?php	}	?> 
										</select>
									</div>
									<div  class="left height">
										<label for="sl_url">Showing Posts Count:</label>
										<input class="text_area url-input number" type="number" name="sl_url" value="5" >
									</div>
								</div>
	
								<div>
									<label class="long" for="sl_stitle">Show Title:</label>
									<input type="hidden" name="sl_stitle" value="" />
									<input class="link_target" checked="checked" type="checkbox" name="sl_stitle" value="1" />
								</div>
								<div>
									<div class="left margin">
										<label class="long" for="sl_sdesc">Show Description:</label>
										<input type="hidden" name="sl_sdesc" value="" />
										<input checked="checked" class="link_target" type="checkbox" name="sl_sdesc" value="1" />
									</div>
									<div class="left top ">
										<label for="im_description">Description Symbols Number:</label>
										<input value="300" class="text_area url-input number" type="number" name="im_description" />
									</div>
								</div>
								<div>
									<div class="left margin">
										<label class="long" for="sl_postlink">Use Post Link:</label>
										<input type="hidden" name="sl_postlink" value="" />
										<input  checked="checked" class="link_target" type="checkbox" name="sl_postlink" value="1" />
									</div>
									<div  class="left">	
										<label class="long" for="sl_link_target">Open Link In New Tab:</label>
										<input type="hidden" name="sl_link_target" value="" />
										<input checked="checked" class="link_target" type="checkbox" name="sl_link_target" />
										<!--<input type="checkbox" name="pause_on_hover" id="pause_on_hover"  <?php if($row->pause_on_hover == 'on'){ echo 'checked="checked"'; } ?>  class="link_target"/>-->
									</div>
								</div>
						<input id="cc-add-posts-params" type="hidden" name="popupposts" value="" />
						<input id="cc-add-posts-params" type="hidden" name="addlastposts" value="addlastposts" />
						<div class="clear"></div>
						<button class='save-slider-options button-primary cc-insert-post-button' id='cc-insert-post-button-bottom'>Insert Posts</button>
		
				</li>
			</ul>		
		</div>
	</div>		
	<?php
}