<?php

add_action('media_buttons_context', 'add_my_custom_button');

function add_my_custom_button($context) {

  $img = get_stylesheet_directory_uri(). '/modules/cc-slider/images/post.button.png';
  $container_id = 'cc_slider';

  $title = 'Select Carpet Court Slider to insert into post';

  $context .= '<a class="button thickbox" title="Select slider to insert into post"    href="?page=cc_sliders&task=add_shortcode_post&TB_iframe=1&width=400&inlineId='.$container_id.'">
		<span class="wp-media-buttons-icon" style="background: url('.$img.'); background-repeat: no-repeat; background-position: left bottom;"></span>
	Add Slider
	</a>';

  return $context;
}

function remove_media_tab($strings) {
	//unset($strings["insertFromUrlTitle"]);
	return $strings;
}
add_filter('media_view_strings','remove_media_tab');


add_action('init', 'hugesl_do_output_buffer');

function hugesl_do_output_buffer() {
    ob_start();
}

$ident = 1;

add_action('admin_head', 'cc_ajax_func');
function cc_ajax_func() {
    ?>
    <script>
        var cc_ajax = '<?php echo admin_url("admin-ajax.php"); ?>';
    </script>
<?php
}
function cc_slider_images_list_shotrcode($atts) {
    extract(shortcode_atts(array(
        'id' => 'no cc slider',

    ), $atts));
	add_style_to_header($atts['id']);
	add_action('wp_footer', 'add_style_to_header');
    return cc_cat_images_list($atts['id']);

}

function slider_after_search_results($query) {
    global $wpdb;
    if (isset($_REQUEST['s']) && $_REQUEST['s']) {
        $serch_word = htmlspecialchars(($_REQUEST['s']));
        $query = str_replace($wpdb->prefix . "posts.post_content", gen_string_slider_search($serch_word, $wpdb->prefix . 'posts.post_content') . " " . $wpdb->prefix . "posts.post_content", $query);
    }
    return $query;
}
add_filter('posts_request', 'slider_after_search_results');

function gen_string_slider_search($serch_word, $wordpress_query_post) {
    $string_search = '';

    global $wpdb;
    if ($serch_word) {
        $rows_slider = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "slider_sliders WHERE (description LIKE %s) OR (name LIKE %s)", '%' . $serch_word . '%', "%" . $serch_word . "%"));

        $count_cat_rows = count($rows_slider);

        for ($i = 0; $i < $count_cat_rows; $i++) {
            $string_search .= $wordpress_query_post . ' LIKE \'%[cc_slider id="' . $rows_slider[$i]->id . '" details="1" %\' OR ' . $wordpress_query_post . ' LIKE \'%[cc_slider id="' . $rows_slider[$i]->id . '" details="1"%\' OR ';
        }

        $rows_slider = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "slider_sliders WHERE (name LIKE %s)","'%" . $serch_word . "%'"));
        $count_cat_rows = count($rows_slider);
        for ($i = 0; $i < $count_cat_rows; $i++) {
            $string_search .= $wordpress_query_post . ' LIKE \'%[cc_slider id="' . $rows_slider[$i]->id . '" details="0"%\' OR ' . $wordpress_query_post . ' LIKE \'%[cc_slider id="' . $rows_slider[$i]->id . '" details="0"%\' OR ';
        }

        $rows_single = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "slider_images WHERE name LIKE %s","'%" . $serch_word . "%'"));

        $count_sing_rows = count($rows_single);
        if ($count_sing_rows) {
            for ($i = 0; $i < $count_sing_rows; $i++) {
                $string_search .= $wordpress_query_post . ' LIKE \'%[cc_slider_Product id="' . $rows_single[$i]->id . '"]%\' OR ';
            }

        }
    }
    return $string_search;
}

add_shortcode('cc_slider', 'cc_slider_images_list_shotrcode');



function cc_cat_images_list($id) {
    require_once("slider_front_end.html.php");
    require_once("slider_front_end.php");
    if (isset($_GET['product_id'])) {

        if (isset($_GET['view']) && $_GET['view'] == 'ccslider' ) {
            return showPublishedimages_1($id);
        } else {
            return front_end_single_product($_GET['product_id']);
        }

    } else {
        return showPublishedimages_1($id);
    }
}

add_action('admin_menu', 'cc_slider_options_panel');
function cc_slider_options_panel() {
    $page_cat = add_menu_page(
								'Theme page title',  // title
							    'CC Slider',  // menu title
							    'delete_pages',  // capability
							    'cc_sliders',  // menu slug
							    'sliders_cc_slider', // callback fn
							    get_stylesheet_directory_uri().'/modules/cc-slider/images/sidebar.icon.png' // icon
      						);

    add_submenu_page(
    				'cc_sliders', // parent slug
    				'Sliders', // title
    				'Sliders', // menu title
    				'delete_pages',  // capability
    				'cc_sliders', // slug
    				'sliders_cc_slider' // callback
    				);

    $page_option = add_submenu_page(
							    'cc_sliders',
							    'General Options',
							    'General Options',
							    'manage_options',
							    'cc_slider_options',
							    'Options_slider_styles'
							    );

	add_action('admin_print_styles-' . $page_cat, 'cc_slider_admin_script');
    add_action('admin_print_styles-' . $page_option, 'cc_slider_option_admin_script');
}

function cc_slider_admin_script() {
		wp_enqueue_media();
		// wp_enqueue_style("jquery_ui", "http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css", FALSE);
		if ( !defined( 'ICL_SITEPRESS_VERSION' ) || ICL_PLUGIN_INACTIVE ) {
			wp_enqueue_script("jquery_new", "http://code.jquery.com/jquery-1.10.2.js", FALSE);
			// wp_enqueue_script("jquery_ui_new", "http://code.jquery.com/ui/1.10.4/jquery-ui.js", FALSE);
		}

		wp_enqueue_script("simple_slider_js",  get_stylesheet_directory_uri()."/modules/cc-slider/js/simple-slider.js", FALSE);
		wp_enqueue_style("simple_slider_css", get_stylesheet_directory_uri()."/modules/cc-slider/style/simple-slider.css", FALSE);
		wp_enqueue_style("admin_css", get_stylesheet_directory_uri()."/modules/cc-slider/style/admin.style.css", FALSE);
		wp_enqueue_script("admin_js", get_stylesheet_directory_uri()."/modules/cc-slider/js/admin.js", FALSE);
		wp_enqueue_script('param_block2', get_stylesheet_directory_uri()."/modules/cc-slider/elements/jscolor/jscolor.js");
		wp_enqueue_script("admin_image_js", get_stylesheet_directory_uri()."/modules/cc-slider/js/image_uploader.js", FALSE);


}

function cc_enque_bx_slider() {
	wp_register_script( 'bxslider',get_stylesheet_directory_uri()."/modules/cc-slider/js/jquery.bxslider.min.js" ,array ('jquery'), '1.0.0', true);
	wp_enqueue_script('bxslider');
	wp_register_script( 'bxSliderSetup',get_stylesheet_directory_uri()."/modules/cc-slider/js/bxslider.setup.js" ,array ('jquery'), '1.0.0', true);
	wp_enqueue_script('bxSliderSetup');

	wp_register_style( 'bxslider',get_stylesheet_directory_uri()."/modules/cc-slider/style/jquery.bxslider.css");
	wp_enqueue_style('bxslider');

	wp_register_style( 'cc-slider',get_stylesheet_directory_uri()."/modules/cc-slider/style/cc-slider.css");
	wp_enqueue_style('cc-slider');
}
add_action('wp_footer','cc_enque_bx_slider' );

function cc_slider_option_admin_script() {
	wp_enqueue_script("jquery_old", "http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js", FALSE);

	if (!wp_script_is( 'jQuery.ui' )) {
       // wp_enqueue_script("jquery_new", "http://code.jquery.com/jquery-1.10.2.js", FALSE);
        // wp_enqueue_script("jquery_ui_new", "http://code.jquery.com/ui/1.10.4/jquery-ui.js", FALSE);
	}
		wp_enqueue_script("simple_slider_js",  get_stylesheet_directory_uri()."/modules/cc-slider/js/simple-slider.js", FALSE);

		wp_enqueue_style("simple_slider_css", get_stylesheet_directory_uri()."/modules/cc-slider/style/simple-slider.css", FALSE);
		wp_enqueue_style("admin_css", get_stylesheet_directory_uri()."/modules/cc-slider/style/admin.style.css", FALSE);
		wp_enqueue_script("admin_js", get_stylesheet_directory_uri()."/modules/cc-slider/js/admin.js", FALSE);
		wp_enqueue_script('param_block2', get_stylesheet_directory_uri()."/modules/cc-slider/elements/jscolor/jscolor.js");
}

function sliders_cc_slider() {

    require_once("sliders.php");
    require_once("sliders.html.php");
    if (!function_exists('print_html_nav'))
        require_once("slider_function/html_slider_func.php");


    $task = isset( $_GET["task"] )?$_GET["task"]:'';

	$id = isset( $_GET["id"] )?$_GET["id"]:0;



    global $wpdb;
    switch ($task) {

        case 'add_cat':
            add_slider();
            break;
		case 'add_shortcode_post':
            add_shortcode_post();
            break;
		case 'popup_posts':
            if ($id)
                popup_posts($id);
            break;
		case 'popup_video':
            if ($id)
                popup_video($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "slider_sliders");
                popup_video($id);
            }
            break;
        case 'edit_cat':
            if ($id)
                editslider($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "slider_sliders");
                editslider($id);
            }
            break;

        case 'save':
            if ($id)
                apply_cat($id);
        case 'apply':
            if ($id) {
                apply_cat($id);
                editslider($id);
            }
            break;
        case 'remove_cat':
            removeslider($id);
            showslider();
            break;

		case 'add_video':
			if ($id)
				cc_slider_save_video($id);
		break;
		case 'edit_video':
			if ($id)
				cc_slider_save_video($id,'Edit');
		break;
        default:
            showslider();
            break;
    }
}

function add_shortcode_post() {
	?>
	<script type="text/javascript">
					jQuery(document).ready(function() {
					  jQuery('#ccsliderinsert').on('click', function() {

						jQuery('#save-buttom').click();

						var id = jQuery('#cc_slider-select option:selected').val();
						if(window.parent.tinyMCE || window.parent.tinyMCE.activeEditor)
						{
							window.parent.send_to_editor('[cc_slider id="'+id+'"]');
						}
						tb_remove();
					  })
					});
	</script>
	<style>
		#wpadminbar,.auto-fold #adminmenu, .auto-fold #adminmenu li.menu-top, .auto-fold #adminmenuback, .auto-fold #adminmenuwrap {
			display: none;
		}

		#wpcontent {
			margin-top: -55px;
		}

		.wp-core-ui .button {margin:0px 0px 0px 10px !important;}

		#slider-unique-options-list li {
			clear:both;
			margin:10px 0px 5px 0px;
		}

		#slider-unique-options-list li label {width:130px;}

		#save-buttom {display:none;}

		h3 {
			margin:30px 0px 15px 0px;
		}
	</style>
	<div class="clear"></div>
	<h3>Select the Slider</h3>
	<div id="cc_slider">
	  <?php
	  	  global $wpdb;
		  $query="SELECT * FROM ".$wpdb->prefix."slider_sliders";
		  $firstrow=$wpdb->get_row($query);

		  if ( isset( $_POST["cc_slider_id"] ) ) {
		  	$id=$_POST["cc_slider_id"];
		  } else {
		  	$id=$firstrow->id;
		  }
	if( isset( $_GET["htslider_id"] ) && $_GET["htslider_id"] == $_POST["cc_slider_id"] && $_GET['cc_save'] == 1) {
        // if($_GET["cc_save"]==1){
              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  sl_width = '%s'  WHERE id = %d ", $_POST["sl_width"], $id));

				$wpdb->query($wpdb->prepare("UPDATE `".$wpdb->prefix."slider_sliders` SET `width_full_width` = '%s' WHERE `id` = %d ", (isset($_POST["width_full_width"]) && $_POST["width_full_width"] != '' )?$_POST["width_full_width"]:'', $id ) );

              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  sl_height = '%s'  WHERE id = %d ", $_POST["sl_height"], $id));
              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  pause_on_hover = '%s'  WHERE id = %d ", $_POST["pause_on_hover"], $id));
              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  slider_list_effects_s = '%s'  WHERE id = %d ", $_POST["slider_effects_list"], $id));
              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  description = '%s'  WHERE id = %d ", $_POST["sl_pausetime"], $id));
              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  param = '%s'  WHERE id = %d ", $_POST["sl_changespeed"], $id));
              $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  sl_position = '%s'  WHERE id = %d ", $_POST["sl_position"], $id));
			  $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  sl_loading_icon = '%s' WHERE id = %d ", $_POST["sl_loading_icon"], $id));
			  $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_sliders SET  show_thumb = '%s' WHERE id = %d ", $_POST["show_thumb"], $id));/*add*/

        // }
      }
	$query="SELECT * FROM ".$wpdb->prefix."slider_sliders order by id ASC";
   	$shortcodesliders=$wpdb->get_results($query);

	$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."slider_sliders WHERE id= %d", $id);
	$row=$wpdb->get_row($query);

	$container_id = 'cc_slider';	   ?>
	<form action="?page=cc_sliders&task=add_shortcode_post&TB_iframe=1&width=400&inlineId=<?php echo $container_id; ?>&cc_save=1&htslider_id=<?php echo $id; ?>" method="post" name="adminForm" id="adminForm">
	 	<?php
	 	if (count($shortcodesliders)) {
			echo "<select id='cc_slider-select' onchange='this.form.submit()' name='cc_slider_id'>";
			foreach ($shortcodesliders as $shortcodeslider) {
				$selected='';
				if($shortcodeslider->id == $_POST["cc_slider_id"]){$selected='selected="selected"';}
				echo "<option ".$selected." value='".$shortcodeslider->id."'>".$shortcodeslider->name."</option>";
			}
			echo "</select>";
			echo "<button class='button primary' id='ccsliderinsert'>Insert Slider</button>";
		} else {
			echo "No slideshows found", "cc_slider";
		}

		$container_id = 'cc_slider';
		?>

	</div>

		<div id="" class="meta-box-sortables ui-sortable">
			<div id="slider-unique-options" class="">
			<h3 class="hndle"><span>Current Slider Options</span></h3>
			<ul id="slider-unique-options-list">
				<li>
					<label for="sl_width">Width</label>
					<input type="text" name="sl_width" id="sl_width" value="<?php echo $row->sl_width; ?>" class="text_area" />
				</li>
				<li>
					<label for="sl_height">Height</label>
					<input type="text" name="sl_height" id="sl_height" value="<?php echo $row->sl_height; ?>" class="text_area" />
				</li>
				<li>
					<label for="pause_on_hover">Pause on Hover</label>
					<input type="hidden" value="off" name="pause_on_hover" />
					<input type="checkbox" name="pause_on_hover"  value="on" id="pause_on_hover"  <?php if($row->pause_on_hover  == 'on'){ echo 'checked="checked"'; } ?> />
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

			</ul>
			<input type="submit" value="Save Slider" id="save-buttom" class="button button-primary button-large">
			</div>
		</div>
	</form>
<?php
}


function Options_slider_styles() {
    require_once("slider_Options.php");

    if ( isset( $_POST['task'] ) && $_POST['task'] == 'save' ) {
        // save_styles_options();
        cc_slider_save_general_options();
    }
    require_once("slider_Options.html.php");
	showStyles();
}

/**
 * CC Widget
 */
class CC_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'CC_Widget',
			'CC Slider',
			array( 'description' => __( 'CC Slider', 'cc_slider' ), )
		);
	}

	public function widget( $args, $instance ) {

		extract($args);

		if (isset($instance['slider_id'])) {
			$slider_id = $instance['slider_id'];

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;

			echo do_shortcode("[cc_slider id={$slider_id}]");
			echo $after_widget;
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['slider_id'] = strip_tags( $new_instance['slider_id'] );
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	public function form( $instance ) {
		$selected_slider = 0;
		$title = "";
		$sliders = false;

		if (isset($instance['slider_id'])) {
			$selected_slider = $instance['slider_id'];
		}

		if (isset($instance['title'])) {
			$title = $instance['title'];
		}
		?>
		<p>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<label for="<?php echo $this->get_field_id('slider_id'); ?>"><?php _e('Select Slider:', 'cc_slider'); ?></label>
			<select id="<?php echo $this->get_field_id('slider_id'); ?>" name="<?php echo $this->get_field_name('slider_id'); ?>">

			<?php
			global $wpdb;
			$query="SELECT * FROM ".$wpdb->prefix."slider_sliders ";
			$rowwidget=$wpdb->get_results($query);
			foreach($rowwidget as $rowwidgetecho){
			?>
				<option <?php selected( $rowwidgetecho->id, $instance['slider_id']); ?> value="<?php echo $rowwidgetecho->id; ?>"><?php echo $rowwidgetecho->name; ?></option>
			<?php } ?>
			</select>

		</p>

		<?php
	}
}
add_action('widgets_init', 'register_CC_Widget');
function register_CC_Widget() {
    register_widget('CC_Widget');
}

/***<add>***/



function add_style_to_header($id) {
	global $wpdb;
 	$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."slider_images where slider_id = '%d' order by ordering ASC",$id);
	$images=$wpdb->get_results($query);
	$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."slider_sliders where id = '%d' order by id ASC",$id);
	$slider=$wpdb->get_results($query);
	$query="SELECT * FROM ".$wpdb->prefix."slider_params";
    $rowspar = $wpdb->get_results($query);
    $paramssld = array();

    foreach ($rowspar as $rowpar) {
        $key = $rowpar->name;
        $value = $rowpar->value;
        $paramssld[$key] = $value;
    }

	$sliderID=isset($slider[0]->id)?$slider[0]->id:'';

 	$slidertitle=isset($slider[0]->name)?$slider[0]->name:'';

	$sliderheight=isset($slider[0]->sl_height)?$slider[0]->sl_height:'';
    $sliderwidth=isset($slider[0]->sl_width)?$slider[0]->sl_width:'';


	$slidereffect=isset($slider[0]->slider_list_effects_s)?$slider[0]->slider_list_effects_s:'';


	$slidepausetime=isset($slidepausetime)?($slider[0]->description+$slider[0]->param):'';

	$sliderpauseonhover=isset($slider[0]->pause_on_hover)?$slider[0]->pause_on_hover:'';

	$sliderposition=isset($slider[0]->sl_position)?$slider[0]->sl_position:'';

	$slidechangespeed=isset($slider[0]->param)?$slider[0]->param:'';

	$sliderloadingicon=isset($slider[0]->sl_loading_icon)?$slider[0]->sl_loading_icon:'';

	$sliderthumbslider=isset($slider[0]->show_thumb)?$slider[0]->show_thumb:'';

	$slideshow_title_position = explode('-', trim($paramssld['slider_title_position']));
	$slideshow_description_position = explode('-', trim($paramssld['slider_description_position']));
	?>

	<style>
	/***<add>***/
	  #cc_loading_image_<?php echo $sliderID; ?> {
		height:<?php echo $sliderheight; ?>px;
		width:<?php  echo $sliderwidth; ?>px;
		display: table-cell;
		text-align: center;
		vertical-align: middle;
	 }
	  #cc_loading_image_<?php echo $sliderID; ?>.display {
		display: table-cell;
	 }
	  #cc_loading_image_<?php echo $sliderID; ?>.nodisplay {
		display: none;
	 }
	 #cc_loading_image_<?php echo $sliderID; ?> img {
		margin: auto 0;
		width: 20% !important;

	 }

	 .cc_slideshow_image_wrap_<?php echo $sliderID; ?> {
		height:<?php echo $sliderheight ; ?>px;
		width:<?php  echo $sliderwidth ; ?>px;

		position:relative;
		display: block;
		text-align: center;
		/*HEIGHT FROM HEADER.PHP*/
		clear:both;

		<?php if($sliderposition=="left"){ $position='float:left;';}elseif($sliderposition=="right"){$position='float:right;';}else{$position='float:none; margin:0px auto;';} ?>
		<?php echo $position;  ?>

		border-style:solid;
		border-left:0px !important;
		border-right:0px !important;
	}
	 .cc_slideshow_image_wrap1_<?php echo $sliderID; ?>.display {
		 width: 100%;
		 height:100%;
	 }
	 .cc_slideshow_image_wrap1_<?php echo $sliderID; ?>.display {
		 display:block;
	 }
	 .cc_slideshow_image_wrap1_<?php echo $sliderID; ?>.nodisplay {
		 display:none;
	 }
	.cc_slideshow_image_wrap_<?php echo $sliderID; ?> * {
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}


  	.cc_slideshow_image_<?php echo $sliderID; ?> {
			/*width:100%;*/
	}

	  #cc_slideshow_left_<?php echo $sliderID; ?>,
	  #cc_slideshow_right_<?php echo $sliderID; ?> {
		cursor: pointer;
		display:none;
		display: block;

		height: 100%;
		outline: medium none;
		position: absolute;

		/*z-index: 10130;*/
		z-index: 13;
		bottom:25px;
		top:50%;
	  }


	  #cc_slideshow_left-ico_<?php echo $sliderID; ?>,
	  #cc_slideshow_right-ico_<?php echo $sliderID; ?> {
		z-index: 13;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
		cursor: pointer;
		display: table;
		left: -9999px;
		line-height: 0;
		margin-top: -15px;
		position: absolute;
		top: 50%;
		/*z-index: 10135;*/
	  }
	  #cc_slideshow_left-ico_<?php echo $sliderID; ?>:hover,
	  #cc_slideshow_right-ico_<?php echo $sliderID; ?>:hover {
		cursor: pointer;
	  }

	  .cc_slideshow_image_container_<?php echo $sliderID; ?> {
		display: table;
		position: relative;
		top:0px;
		left:0px;
		text-align: center;
		vertical-align: middle;
		width:100%;
	  }

	  .cc_slideshow_title_text_<?php echo $sliderID; ?> {
		text-decoration: none;
		position: relative;
		z-index: 11;
		display: inline-block;
		<?php  if($paramssld['slider_title_has_margin']=='on'){
				$slider_title_width=($paramssld['slider_title_width']-6);
				$slider_title_height=($paramssld['slider_title_height']-6);
				$slider_title_margin="3";
			}else{
				$slider_title_width=($paramssld['slider_title_width']);
				$slider_title_height=($paramssld['slider_title_height']);
				$slider_title_margin="0";
			}  ?>

		/*width:*/<?php //echo $slider_title_width; ?>/*%;*/
		/*height:<?php echo $slider_title_height; ?>%;*/

		<?php
			if($slideshow_title_position[0]=="left"){echo 'left:'.$slider_title_margin.'%;';}
			elseif($slideshow_title_position[0]=="center"){echo 'left:50%;';}
			elseif($slideshow_title_position[0]=="right"){echo 'right:'.$slider_title_margin.'%;';}

			if($slideshow_title_position[1]=="top"){echo 'top:'.$slider_title_margin.'%;';}
			elseif($slideshow_title_position[1]=="middle"){echo 'top:50%;';}
			elseif($slideshow_title_position[1]=="bottom"){echo 'bottom:'.$slider_title_margin.'%;';}
		 ?>
		padding:2%;
		text-align:<?php echo $paramssld['slider_title_text_align']; ?>;
		color:#<?php echo $paramssld['slider_title_color']; ?>;

		background:<?php
				list($r,$g,$b) = array_map('hexdec',str_split($paramssld['slider_title_background_color'],2));
				$titleopacity=$paramssld["slider_title_background_transparency"]/100;
				echo 'rgba('.$r.','.$g.','.$b.','.$titleopacity.')  !important';
		?>;
		border-style:solid;
		font-size:<?php echo $paramssld['slider_title_font_size']; ?>px;
		border-width:<?php echo $paramssld['slider_title_border_size']; ?>px;
		border-color:#<?php echo $paramssld['slider_title_border_color']; ?>;
		border-radius:<?php echo $paramssld['slider_title_border_radius']; ?>px;
	  }

	  .cc_slideshow_description_text_<?php echo $sliderID; ?> {
		text-decoration: none;
		z-index: 11;
		border-style:solid;
		display: inline-block;
		<?php  if($paramssld['slider_description_has_margin']=='on'){
				$slider_description_width=($paramssld['slider_description_width']-6);
				$slider_description_height=($paramssld['slider_description_height']-6);
				$slider_description_margin="3";
			}else{
				$slider_description_width=($paramssld['slider_description_width']);
				$slider_descriptione_height=($paramssld['slider_description_height']);
				$slider_description_margin="0";
			}  ?>
		width: 100%;
		/*width:*/<?php //echo $slider_description_width; ?>/*%;*/
		/*height:<?php echo $slider_description_height; ?>%;*/
		<?php
			if($slideshow_description_position[0]=="left"){echo 'left:'.$slider_description_margin.'%;';}
			elseif($slideshow_description_position[0]=="center"){echo 'left:50%;';}
			elseif($slideshow_description_position[0]=="right"){echo 'right:'.$slider_description_margin.'%;';}

			if($slideshow_description_position[1]=="top"){echo 'top:'.$slider_description_margin.'%;';}
			elseif($slideshow_description_position[1]=="middle"){echo 'top:50%;';}
			elseif($slideshow_description_position[1]=="bottom"){echo 'bottom:'.$slider_description_margin.'%;';}
		 ?>
		text-align:<?php echo $paramssld['slider_description_text_align']; ?>;
		color:#<?php echo $paramssld['slider_description_color']; ?>;

		background:<?php
			list($r,$g,$b) = array_map('hexdec',str_split($paramssld['slider_description_background_color'],2));
			$descriptionopacity=$paramssld["slider_description_background_transparency"]/100;
			echo 'rgba('.$r.','.$g.','.$b.','.$descriptionopacity.') !important';
		?>;
		border-style:solid;
		font-size:<?php echo $paramssld['slider_description_font_size']; ?>px;
		border-width:<?php echo $paramssld['slider_description_border_size']; ?>px;
		border-color:#<?php echo $paramssld['slider_description_border_color']; ?>;
		border-radius:<?php echo $paramssld['slider_description_border_radius']; ?>px;
	  }

	   .cc_slideshow_title_text_<?php echo $sliderID; ?>.none, .cc_slideshow_description_text_<?php echo $sliderID; ?>.none,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?>.hidden, .cc_slideshow_description_text_<?php echo $sliderID; ?>.hidden	   {display:none;}

	   .cc_slideshow_title_text_<?php echo $sliderID; ?> h1, .cc_slideshow_description_text_<?php echo $sliderID; ?> h1,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> h2, .cc_slideshow_title_text_<?php echo $sliderID; ?> h2,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> h3, .cc_slideshow_title_text_<?php echo $sliderID; ?> h3,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> h4, .cc_slideshow_title_text_<?php echo $sliderID; ?> h4,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> p, .cc_slideshow_title_text_<?php echo $sliderID; ?> p,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> strong,  .cc_slideshow_title_text_<?php echo $sliderID; ?> strong,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> span, .cc_slideshow_title_text_<?php echo $sliderID; ?> span,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> ul, .cc_slideshow_title_text_<?php echo $sliderID; ?> ul,
	   .cc_slideshow_title_text_<?php echo $sliderID; ?> li, .cc_slideshow_title_text_<?php echo $sliderID; ?> li {
			padding:2px;
			margin:0px;
	   }

	  .cc_slide_container_<?php echo $sliderID; ?> {
		display: table-cell;
		margin: 0 auto;
		position: relative;
		vertical-align: middle;
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
	  }
	  .cc_slide_bg_<?php echo $sliderID; ?> {
		margin: 0 auto;
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
	  }
	  .cc_slider_<?php echo $sliderID; ?> {
		width:100%;
		height:100%;
		display:table !important;
		padding:0px !important;
		margin:0px !important;

	  }
	  .cc_slideshow_image_item_<?php echo $sliderID; ?> {
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
		display: table-cell;
		filter: Alpha(opacity=100);
		opacity: 1;
		position: absolute;
		top:0px !important;
		left:0px !important;
		vertical-align: middle;
		z-index: 1;
		margin:0px !important;
		padding:0px  !important;
		overflow: hidden !important;
		border-radius: <?php echo $paramssld['slider_slideshow_border_radius']; ?>px !important;
	  }
	  .cc_slideshow_image_second_item_<?php echo $sliderID; ?> {
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
		display: table-cell;
		filter: Alpha(opacity=0);
		opacity: 0;
		position: absolute;
		top:0px !important;
		left:0px !important;
		vertical-align: middle;
		overflow:hidden;
		margin:0px !important;
		visibility:visible !important;
		padding:0px  !important;
		border-radius: <?php echo $paramssld['slider_slideshow_border_radius']; ?>px !important;
	  }
	   .cc_slideshow_image_second_item_<?php echo $sliderID; ?> a, .cc_slideshow_image_item_<?php echo $sliderID; ?> a {
			display:block;
			width:100%;
			height:100%;
	   }

	  .cc_grid_<?php echo $sliderID; ?> {
		display: none;
		height: 100%;
		overflow: hidden;
		position: absolute;
		width: 100%;
	  }
	  .cc_gridlet_<?php echo $sliderID; ?> {
		opacity: 1;
		filter: Alpha(opacity=100);
		position: absolute;
	  }


	  .cc_slideshow_dots_container_<?php echo $sliderID; ?> {
		display: table;
		position: absolute;
		width:100% !important;
		height:100% !important;
	  }
	  .cc_slideshow_dots_thumbnails_<?php echo $sliderID; ?> {
		margin: 0 auto;
		overflow: hidden;
		position: absolute;
		width:100%;
		height:30px;
	  }

	  .cc_slideshow_dots_<?php echo $sliderID; ?> {
		display: inline-block;
		position: relative;
		cursor: pointer;
		box-shadow: 1px 1px 1px rgba(0,0,0,0.1) inset, 1px 1px 1px rgba(255,255,255,0.1);
		width:10px;
		height: 10px;
		border-radius: 10px;
		background: #00f;
		margin: 10px;
		overflow: hidden;
		z-index: 17;
	  }

	  .cc_slideshow_dots_active_<?php echo $sliderID; ?> {
		opacity: 1;
		filter: Alpha(opacity=100);
	  }
	  .cc_slideshow_dots_deactive_<?php echo $sliderID; ?> {

	  }



		.cc_slideshow_image_wrap_<?php echo $sliderID; ?> {
			background:#<?php echo $paramssld['slider_slider_background_color']; ?>;
			border-width:<?php echo $paramssld['slider_slideshow_border_size']; ?>px;
			border-color:#<?php echo $paramssld['slider_slideshow_border_color']; ?>;
			border-radius:<?php echo $paramssld['slider_slideshow_border_radius']; ?>px;
		}
		.cc_slideshow_image_wrap_<?php echo $sliderID; ?>.nocolor {
			background: transparent;
		}

		.cc_slideshow_dots_thumbnails_<?php echo $sliderID; ?> {
			<?php if($sliderthumbslider == "dotstop" && $sliderthumbslider != "thumbnails" && $paramssld['slider_dots_position_new']=='dotsbottom'){?>
			bottom:0px;
			<?php }else if($sliderthumbslider == "thumbnails" || $sliderthumbslider=="nonav"){?>
			display:none;
			<?php
			}else if($sliderthumbslider == "dotstop"){ ?>
			top:0px; <?php } ?>
		}

		.cc_slideshow_dots_<?php echo $sliderID; ?> {
			background:#<?php echo $paramssld['slider_dots_color']; ?>;
		}

		.cc_slideshow_dots_active_<?php echo $sliderID; ?> {
			background:#<?php echo $paramssld['slider_active_dot_color']; ?>;
		}
					<?php
	require_once(dirname(__FILE__) . '/slider_front_end.html.php');
	$width_huge = isset( $GLOBALS['thumbnail_width'] )?$GLOBALS['thumbnail_width']: '';
	?>
		/*//////////////////////slider thunbnail styles start///////////////////////////*/


		.bx-viewport {
		  height: <?php echo $paramssld['slider_thumb_height']; ?>px !important;
		  -webkit-transform: translatez(0);
		}

		.bx-wrapper {
		  position: relative;
		  margin: 0 auto 0 auto;
		  padding: 0;
		  max-width: <?php echo $width_huge; ?>px !important;
		  *zoom: 1;
		  -ms-touch-action: pan-y;
		  touch-action: pan-y;
		}
		.cc_slideshow_thumbs_container_<?php echo $sliderID; ?>{
				<?php if($sliderthumbslider == "dotstop" || $sliderthumbslider == "dotsbottom" || $sliderthumbslider == "nonav"){?>
			display: none;
			<?php }?>
		}
		.cc_slideshow_thumbs_<?php echo $sliderID; ?>{


		}
		.cc_slideshow_thumbs_<?php echo $sliderID; ?> li{
			display: inline-block;

		    height: <?php echo $paramssld['slider_thumb_height']; ?>px ;



		}
		.cc_slideshow_thumbnails_<?php echo $sliderID; ?> {
		    display: inline-block;
		    position: relative;
		    cursor: pointer;
		    background: #<?php echo $paramssld['slider_thumb_back_color']; ?>;
		    z-index: 17;
		}
		.sl_thumb_img{
		    width: 100% !important;
		    height: 100% !important;
		    display: block;
		    margin: 0 auto;
		}
		.sl_thumb_img2{
		    height: 100% !important;
		    display: block;
		    margin: 0 auto;
		}
		.trans_back{
			width: 100%;
			height: 100%;
			top:0;
			position: absolute;
			background:<?php
				list($ri,$gi,$bi) = array_map('hexdec',str_split($paramssld['slider_thumb_passive_color'],2));
				$titleopacity2=$paramssld["slider_thumb_passive_color_trans"]/100;
				echo 'rgba('.$ri.','.$gi.','.$bi.','.$titleopacity2.')';
		?>;
			transition: 0.3s ease;
		}
		.trans_back:hover{
			background:none !important;
		}
		.play-icon.youtube {background:url(<?php echo get_stylesheet_directory_uri()."/modules/cc-slider/images/play.youtube.png"?>) center center no-repeat;
			width: 100%;
			height: 100%;
			top:0;
			position: absolute;}

		.play-icon.vimeo {background:url(<?php echo get_stylesheet_directory_uri()."/modules/cc-slider/images/play.vimeo.png"?>) center center no-repeat;
			width: 100%;
			height: 100%;
			top:0;
			position: absolute;
		}
		.bx-wrapper {

		  border: 0px solid #fff;
		  background: #fff;
		}

		/*////////////slider thunbnail styles end//////////////*/

		<?php

		$arrowfolder=get_stylesheet_directory_uri().'/modules/cc-slider/Front_images/arrows';
		switch ($paramssld['slider_navigation_type']) {
			case 1:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-21px;
						height:43px;
						width:29px;
						background:url(<?php echo $arrowfolder;?>/arrows.simple.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-21px;
						height:43px;
						width:29px;
						background:url(<?php echo $arrowfolder;?>/arrows.simple.png) right top no-repeat;
						background-size: 200%;

					}
				<?php
				break;
			case 2:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -50px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -50px;
					}
				<?php
				break;
			case 3:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-22px;
						height:44px;
						width:44px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-22px;
						height:44px;
						width:44px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -44px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -44px;
					}
				<?php
				break;
			case 4:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-33px;
						height:65px;
						width:59px;
						background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-33px;
						height:65px;
						width:59px;
						background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -66px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -66px;
					}
				<?php
				break;
			case 5:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-18px;
						height:37px;
						width:40px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-18px;
						height:37px;
						width:40px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) right top no-repeat;
						background-size: 200%;
					}

				<?php
				break;
			case 6:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -50px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -50px;
					}
				<?php
				break;
			case 7:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						right:0px;
						margin-top:-19px;
						height:38px;
						width:38px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-19px;
						height:38px;
						width:38px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 8:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 9:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 10:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-24px;
						height:48px;
						width:48px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-24px;
						height:48px;
						width:48px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -48px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -48px;
					}
				<?php
				break;
			case 11:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-29px;
						height:58px;
						width:55px;
						background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-29px;
						height:58px;
						width:55px;
						background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 12:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-37px;
						height:74px;
						width:74px;
						background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-37px;
						height:74px;
						width:74px;
						background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 13:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-16px;
						height:33px;
						width:33px;
						background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-16px;
						height:33px;
						width:33px;
						background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 14:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-51px;
						height:102px;
						width:52px;
						background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-51px;
						height:102px;
						width:52px;
						background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 15:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-19px;
						height:39px;
						width:70px;
						background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-19px;
						height:39px;
						width:70px;
						background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 16:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:-21px;
						margin-top:-20px;
						height:40px;
						width:37px;
						background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:-21px;
						margin-top:-20px;
						height:40px;
						width:37px;
						background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
		}

		/***<For Responsive slider>***/
		if((int)$sliderwidth != 0){
		    $titleValue = (int)$paramssld['slider_title_font_size']/(int)$sliderwidth;
		    $descValue = (int)$paramssld['slider_description_font_size']/(int)$sliderwidth;
		    $dotsValue = 10/(int)$sliderwidth;
		}


for($i=$sliderwidth; $i>148; $i = $i-28) {
?>

	@media screen and (max-width: <?php echo $i;?>px) {

		.cc_slideshow_title_text_<?php echo $sliderID; ?> {

			font-size: <?php echo  $titleValue*$i;?>px !important;

		 }
	    .cc_slideshow_description_text_<?php echo $sliderID; ?> {

			font-size: <?php echo  $descValue*$i;?>px !important;

		}
	   .cc_slideshow_dots_thumbnails_<?php echo $sliderID; ?> .cc_slideshow_dots_<?php echo $sliderID; ?> {

			width:<?php echo $dotsValue*$i; ?>px;
			height:<?php echo $dotsValue*$i; ?>px;
			border-radius:<?php echo $dotsValue*$i; ?>px;
			margin: <?php echo $dotsValue*$i; ?>px;

	   }
<?php

		$arrowfolder=get_stylesheet_directory_uri().'/modules/cc-slider/Front_images/arrows';
		$arrowValue = $i/$sliderwidth;
		switch ($paramssld['slider_navigation_type']) {
			case 1:
				?>
				#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -21*$arrowValue;?>px;
						height:<?php echo 43*$arrowValue;?>43px;
						width:<?php echo 29*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.simple.png) left  top no-repeat;
						background-size: 200%;
					}

				#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -21*$arrowValue;?>px;
						height:<?php echo 43*$arrowValue;?>px;
						width:<?php echo 29*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.simple.png) right top no-repeat;
						background-size: 200%;

					}
				<?php
				break;
			case 2:
				?>
				#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -25*$arrowValue;?>px;
						height:<?php echo 50*$arrowValue;?>px;
						width:<?php echo 50*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) left  top no-repeat;
						background-size: 200%;
					}

				#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -25*$arrowValue;?>px;
						height:<?php echo 50*$arrowValue;?>px;
						width:<?php echo 50*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left <?php echo -50*$arrowValue;?>px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right <?php echo -50*$arrowValue;?>px;
					}
				<?php
				break;
			case 3:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -22*$arrowValue;?>px;
						height:<?php echo 44*$arrowValue;?>px;
						width:<?php echo 44*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -22*$arrowValue;?>px;
						height:<?php echo 44*$arrowValue;?>px;
						width:<?php echo 44*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left <?php echo -44*$arrowValue;?>px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right <?php echo -44*$arrowValue;?>px;
					}
				<?php
				break;
			case 4:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -33*$arrowValue;?>px;
						height:<?php echo 65*$arrowValue;?>px;
						width:<?php echo 59*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -33*$arrowValue;?>px;
						height:<?php echo 65*$arrowValue;?>px;
						width:<?php echo 59*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left <?php echo 66*$arrowValue;?>px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right <?php echo 66*$arrowValue;?>px;
					}
				<?php
				break;
			case 5:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -18*$arrowValue;?>px;
						height:<?php echo 37*$arrowValue;?>px;
						width:<?php echo 40*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -18*$arrowValue;?>px;
						height:<?php echo 37*$arrowValue;?>px;
						width:<?php echo 40*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) right top no-repeat;
						background-size: 200%;
					}

				<?php
				break;
			case 6:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -25*$arrowValue;?>px;
						height:<?php echo 50*$arrowValue;?>px;
						width:<?php echo 50*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -25*$arrowValue;?>px;
						height:<?php echo 50*$arrowValue;?>px;
						width:<?php echo 50*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left <?php echo -50*$arrowValue;?>px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right <?php echo -50*$arrowValue;?>px;
					}
				<?php
				break;
			case 7:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						right:0px;
						margin-top:<?php echo -19*$arrowValue;?>px;
						height:<?php echo 38*$arrowValue;?>px;
						width:<?php echo 38*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -19*$arrowValue;?>px;
						height:<?php echo 38*$arrowValue;?>px;
						width:<?php echo 38*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 8:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo -22*$arrowValue;?>px;
						height:<?php echo 45*$arrowValue;?>px;
						width:<?php echo 45*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:<?php echo -22*$arrowValue;?>px;
						height:<?php echo 45*$arrowValue;?>px;
						width:<?php echo 45*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 9:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-<?php echo 22*$arrowValue;?>px;
						height:<?php echo 45*$arrowValue;?>px;
						width:<?php echo 45*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 22*$arrowValue;?>px;
						height:<?php echo 45*$arrowValue;?>px;
						width:<?php echo 45*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 10:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-<?php echo 24*$arrowValue;?>px;
						height:<?php echo 48*$arrowValue;?>px;
						width:<?php echo 48*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 24*$arrowValue;?>px;
						height:<?php echo 48*$arrowValue;?>px;
						width:<?php echo 48*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) right top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -<?php echo 48*$arrowValue;?>px;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -<?php echo 48*$arrowValue;?>px;
					}
				<?php
				break;
			case 11:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-<?php echo 29*$arrowValue;?>px;
						height:<?php echo 58*$arrowValue;?>px;
						width:<?php echo 55*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 29*$arrowValue;?>px;
						height:<?php echo 58*$arrowValue;?>px;
						width:<?php echo 55*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 12:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:<?php echo (-37*$arrowValue);?>px;
						height:<?php echo (74*$arrowValue);?>px;
						width:<?php echo (74*$arrowValue);?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 37*$arrowValue;?>px;
						height:<?php echo 74*$arrowValue;?>px;
						width:<?php echo 74*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 13:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-<?php echo 16*$arrowValue;?>px;
						height:<?php echo 33*$arrowValue;?>px;
						width:<?php echo 33*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 16*$arrowValue;?>px;
						height:<?php echo 33*$arrowValue;?>px;
						width:<?php echo 33*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 14:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-<?php echo 51*$arrowValue;?>px;
						height:<?php echo 102*$arrowValue;?>px;
						width:<?php echo 52*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 51*$arrowValue;?>px;
						height:<?php echo 102*$arrowValue;?>px;
						width:<?php echo 52*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 15:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:0px;
						margin-top:-<?php echo 19*$arrowValue;?>px;
						height:<?php echo 39*$arrowValue;?>px;
						width:<?php echo 70*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-<?php echo 19*$arrowValue;?>px;
						height:<?php echo 39*$arrowValue;?>px;
						width:<?php echo 70*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
			case 16:
				?>
					#cc_slideshow_left_<?php echo $sliderID; ?> {
						left:-<?php echo 21*$arrowValue;?>px;
						margin-top:-<?php echo 20*$arrowValue;?>px;
						height:<?php echo 40*$arrowValue;?>px;
						width:<?php echo 37*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) left  top no-repeat;
						background-size: 200%;
					}

					#cc_slideshow_right_<?php echo $sliderID; ?> {
						right:-<?php echo 21*$arrowValue;?>px;
						margin-top:-<?php echo 20*$arrowValue;?>px;
						height:<?php echo 40*$arrowValue;?>px;
						width:<?php echo 37*$arrowValue;?>px;
						background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) right top no-repeat;
						background-size: 200%;
					}
				<?php
				break;
		}
		?>
	}

<?php
 }
 /***</For Responsive slider>***/

 ?>

/***</add>***/
	</style>
	<?php
	$time_huge=isset($GLOBALS['pause_time'])?$GLOBALS['pause_time']:'';
	$speed_huge=isset($GLOBALS['changespeed'])?$GLOBALS['changespeed']:'';
	$paramssld['slider_thumb_count_slides']=isset($paramssld['slider_thumb_count_slides'])?$paramssld['slider_thumb_count_slides']:'';

	$width_of_thumbs=$width_huge/$paramssld['slider_thumb_count_slides'];
	$res_width_of_thumbs=intval($width_of_thumbs);

	$translation_array = array(
		 'slideCount' => $paramssld['slider_thumb_count_slides'],
		 'pauseTime' => $time_huge,
		 'width_thumbs' => $res_width_of_thumbs,
		 'speed' => $speed_huge
	);
	wp_localize_script( 'bxSliderSetup', 'cc_obj', $translation_array );

}
/***</add>***/
function cc_slider_activate() {}
function cc_slider_activate1() {
	global $wpdb;
    $sql_slider_params = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "slider_params`(
    							`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    							`name` varchar(50) CHARACTER SET utf8 NOT NULL,
    							`title` varchar(200) CHARACTER SET utf8 NOT NULL,
    							`description` text CHARACTER SET utf8 NOT NULL,
    							`value` varchar(200) CHARACTER SET utf8 NOT NULL,
    							PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ";

    $sql_slider_images = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "slider_images` (
							    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
							    `name` varchar(100) DEFAULT NULL,
							    `slider_id` varchar(200) ,
							    `description` text,
							    `image_url` text,
							    `sl_url` varchar(128) DEFAULT NULL,
							    `ordering` int(11) NOT NULL,
							    `published` tinyint(4) unsigned DEFAULT NULL,
							    `published_in_sl_width` tinyint(4) unsigned DEFAULT NULL,
							    PRIMARY KEY (`id`),
							    UNIQUE KEY `id` (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5";

    $sql_slider_sliders = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "slider_sliders` (
						    	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						    	`name` varchar(200) NOT NULL,
						    	`sl_height` int(11) unsigned DEFAULT NULL,
						    	`sl_width` int(11) unsigned DEFAULT NULL,
						    	`pause_on_hover` text,
						    	`slider_list_effects_s` text,
						    	`description` text,
						    	`param` text,
						    	`ordering` int(11) NOT NULL,
						    	`published` text,
						    	PRIMARY KEY (`id`),
								UNIQUE KEY `id` (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ";

    $table_name = $wpdb->prefix . "slider_params";
    $sql_1 = "
		INSERT INTO `$table_name` (`name`, `title`,`description`, `value`) VALUES
		( 'slider_crop_image', 'Slider crop image', 'Slider crop image', 'resize'),
		( 'slider_title_color', 'Slider title color', 'Slider title color', '000000'),
		( 'slider_title_font_size', 'Slider title font size', 'Slider title font size', '13'),
		( 'slider_description_color', 'Slider description color', 'Slider description color', 'ffffff'),
		( 'slider_description_font_size', 'Slider description font size', 'Slider description font size', '13'),
		( 'slider_title_position', 'Slider title position', 'Slider title position', 'right-top'),
		( 'slider_description_position', 'Slider description position', 'Slider description position', 'right-bottom'),
		( 'slider_title_border_size', 'Slider Title border size', 'Slider Title border size', '0'),
		( 'slider_title_border_color', 'Slider title border color', 'Slider title border color', 'ffffff'),
		( 'slider_title_border_radius', 'Slider title border radius', 'Slider title border radius', '4'),
		( 'slider_description_border_size', 'Slider description border size', 'Slider description border size', '0'),
		( 'slider_description_border_color', 'Slider description border color', 'Slider description border color', 'ffffff'),
		( 'slider_description_border_radius', 'Slider description border radius', 'Slider description border radius', '0'),
		( 'slider_slideshow_border_size', 'Slider border size', 'Slider border size', '0'),
		( 'slider_slideshow_border_color', 'Slider border color', 'Slider border color', 'ffffff'),
		( 'slider_slideshow_border_radius', 'Slider border radius', 'Slider border radius', '0'),
		( 'slider_navigation_type', 'Slider navigation type', 'Slider navigation type', '1'),
		( 'slider_navigation_position', 'Slider navigation position', 'Slider navigation position', 'bottom'),
		( 'slider_title_background_color', 'Slider title background color', 'Slider title background color', 'ffffff'),
		( 'slider_description_background_color', 'Slider description background color', 'Slider description background color', '000000'),
		( 'slider_title_transparent', 'Slider title has background', 'Slider title has background', 'on'),
		( 'slider_description_transparent', 'Slider description has background', 'Slider description has background', 'on'),
		( 'slider_slider_background_color', 'Slider slider background color', 'Slider slider background color', 'ffffff'),
		( 'slider_dots_position', 'slider dots position', 'slider dots position', 'top'),
		( 'slider_active_dot_color', 'slider active dot color', '', 'ffffff'),
		( 'slider_dots_color', 'slider dots color', '', '000000');";

    $table_name = $wpdb->prefix . "slider_images";

    $sql_2 = "INSERT INTO `" . $table_name . "` (`id`, `slider_id`, `name`, `description`, `image_url`, `sl_url`, `ordering`, `published`) VALUES
(1, '1', '',  '', '" . get_stylesheet_directory_uri()."/modules/cc-slider/Front_images/slides/slide1.jpg" . "', '',  1, 1),
(2, '1', 'Simple Usage',  '', '" . get_stylesheet_directory_uri()."/modules/cc-slider/Front_images/slides/slide2.jpg" . "', '',  2, 1),
(3, '1', 'CC Slider',  'The slider allows having unlimited amount of images with their titles and descriptions. The slider uses autogenerated shortcodes making it easier for the users to add it to the custom location.', '" . get_stylesheet_directory_uri()."/modules/cc-slider/Front_images/slides/slide3.jpg" . "', '',  3, 1)";


    $table_name = $wpdb->prefix . "slider_sliders";


    $sql_3 = "
INSERT INTO `$table_name` (`id`, `name`, `sl_height`, `sl_width`, `pause_on_hover`, `slider_list_effects_s`, `description`, `param`, `ordering`, `published`) VALUES
(1, 'My First Slider', '375', '600', 'on', 'random', '4000', '1000', '1', '300')";

    $wpdb->query($sql_slider_params);
    $wpdb->query($sql_slider_images);
    $wpdb->query($sql_slider_sliders);

    if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "slider_params")) {
        $wpdb->query($sql_1);
    }
    if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "slider_images")) {
      $wpdb->query($sql_2);
    }
    if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "slider_sliders")) {
      $wpdb->query($sql_3);
    }

		$product = $wpdb->get_results("DESCRIBE " . $wpdb->prefix . "slider_sliders", ARRAY_A);
    $isUpdate = 0;
	foreach ($product as $prod) {
        if ($prod['Field'] == 'published' && $prod['Type'] == 'tinyint(4) unsigned') {
            $isUpdate = 1;
            break;
        }
    }
	if ($isUpdate) {
	$wpdb->query("ALTER TABLE ".$wpdb->prefix."slider_sliders MODIFY `published` text");
	$wpdb->query("UPDATE ".$wpdb->prefix."slider_sliders SET published = '300' WHERE id = 1 ");
	}

	$product2 = $wpdb->get_results("DESCRIBE " . $wpdb->prefix . "slider_images", ARRAY_A);
    $isUpdate2 = 0;
	foreach ($product2 as $prod2) {

			if($product2[6]['Field'] == 'sl_type') {
			echo '';
			} else {
				$query="SELECT * FROM ".$wpdb->prefix."slider_images order by id ASC";
			   	$rowim=$wpdb->get_results($query);
			  	foreach ($rowim as $key=>$rowimages){
	             	 $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."slider_images SET  ordering = '%s'  WHERE id = %d ", $rowimages->id,$rowimages->id));
			  	}
			}
    }

		if($product2[6]['Field'] == 'sl_type') {
			echo '';
			} else {
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."slider_images ADD  `sl_type` TEXT NOT NULL AFTER  `sl_url`");
			$wpdb->query("UPDATE ".$wpdb->prefix."slider_images SET sl_type = 'image' ");
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."slider_images ADD  `link_target` TEXT NOT NULL AFTER  `sl_type`");
			$wpdb->query("UPDATE ".$wpdb->prefix."slider_images SET link_target = 'on' ");

		    $table_name = $wpdb->prefix . "slider_params";
    $sql_update2 = <<<query1
INSERT INTO `$table_name` (`name`, `title`,`description`, `value`) VALUES
( 'slider_description_width', 'Slider description width', 'Slider description width', '70'),
( 'slider_description_height', 'Slider description height', 'Slider description height', '50'),
( 'slider_description_background_transparency', 'slider description background transparency', 'slider description background transparency', '70'),
( 'slider_description_text_align', 'description text-align', 'description text-align', 'justify'),
( 'slider_title_width', 'slider title width', 'slider title width', '30'),
( 'slider_title_height', 'slider title height', 'slider title height', '50'),
( 'slider_title_background_transparency', 'slider title background transparency', 'slider title background transparency', '70'),
( 'slider_title_text_align', 'title text-align', 'title text-align', 'right');

query1;
			 $wpdb->query($sql_update2);
	}
	$product3 = $wpdb->get_results("DESCRIBE " . $wpdb->prefix . "slider_sliders", ARRAY_A);
	if($product3[8]['Field'] == 'sl_position'){
		echo '';
	}
	else
	{
	$wpdb->query("ALTER TABLE  ".$wpdb->prefix."slider_sliders ADD  `sl_position` TEXT NOT NULL AFTER  `param`");
	$wpdb->query("UPDATE ".$wpdb->prefix."slider_sliders SET `sl_position` = 'center' ");
	$table_name = $wpdb->prefix . "slider_params";
    $sql_update3 = <<<query1
INSERT INTO `$table_name` (`name`, `title`,`description`, `value`) VALUES
( 'slider_title_has_margin', 'title has margin', 'title has margin', 'on'),
( 'slider_description_has_margin', 'description has margin', 'description has margin', 'on'),
( 'slider_show_arrows', 'Slider show left right arrows', 'Slider show left right arrows', 'on');

query1;
	 $wpdb->query($sql_update3);
	}
	$productSliders = $wpdb->get_results("DESCRIBE " . $wpdb->prefix . "slider_sliders", ARRAY_A);//get table fields
   $isUpdate1 = 0;
	foreach ($productSliders as $PSlider) {
        if ($PSlider['Field'] == 'sl_loading_icon') {
            $isUpdate1 = 1;
			break;
		}
	}
	if ($isUpdate1 == 0) {
            $wpdb->query("ALTER TABLE "  .$wpdb->prefix . "slider_sliders ADD `sl_loading_icon` text NOT NULL AFTER `published`");
            $wpdb->query("UPDATE " . $wpdb->prefix ."slider_sliders SET `sl_loading_icon` = 'off' ");
	}

	$product4 = $wpdb->get_results("DESCRIBE " . $wpdb->prefix . "slider_images", ARRAY_A);
	if($product4[8]['Field'] == 'sl_stitle'){
	}
	else
	{
	echo '';
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."slider_images ADD  `sl_stitle` TEXT NOT NULL AFTER  `link_target`");
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."slider_images ADD  `sl_sdesc` TEXT NOT NULL AFTER  `sl_stitle`");
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."slider_images ADD  `sl_postlink` TEXT NOT NULL AFTER  `sl_sdesc`");
	}


$table_name = $wpdb->prefix . "slider_params";
$sql_update4 = <<<query2
INSERT INTO `$table_name` (`name`, `title`,`description`, `value`) VALUES
('loading_icon_type', 'Slider loading icon type', 'Slider loading icon type', '1');
query2;
        $query3="SELECT name FROM ".$table_name;
	$update_p3=$wpdb->get_results($query3);
	if(end($update_p3)->name=='slider_show_arrows'){
		$wpdb->query($sql_update4);
	}


	///////////////
	$table_name = $wpdb->prefix . "slider_params";
        $sql_update_g6 = <<<query6
INSERT INTO `$table_name` (`name`, `title`,`description`, `value`) VALUES
('slider_thumb_count_slides', 'Slide thumbs count', 'Slide thumbs count', '3'),
('slider_dots_position_new', 'Slide Dots Position', 'Slide Dots Position', 'dotstop'),
('slider_thumb_back_color','Thumbnail Background Color','Thumbnail Background Color','FFFFFF'),
('slider_thumb_passive_color','Passive Thumbnail Color','Passive Thumbnail Color','FFFFFF'),
('slider_thumb_passive_color_trans','Passive Thumbnail Color Transparency','Passive Thumbnail Color Transparency','50'),
('slider_thumb_height', 'Slider Thumb Height', 'Slider Thumb Height', '100');
query6;


        $query6="SELECT name FROM ".$wpdb->prefix."slider_params";
    $update_p6=$wpdb->get_results($query6);
    if(end($update_p6)->name=='loading_icon_type'){
        $wpdb->query($sql_update_g6);
    }

///////////////////////////////////////////////////////////////////////
        $imagesAllFieldsInArray3 = $wpdb->get_results("DESCRIBE " . $wpdb->prefix . "slider_sliders", ARRAY_A);
        $fornewUpdate2 = 0;
        foreach ($imagesAllFieldsInArray3 as $portfoliosField3) {

            if ($portfoliosField3['Field'] == 'show_thumb') {
               $fornewUpdate2=1;
            }
        }
        if($fornewUpdate2 != 1){
            $wpdb->query("ALTER TABLE `".$wpdb->prefix."slider_sliders` ADD `show_thumb` VARCHAR(255) NOT NULL DEFAULT 'dotstop' AFTER `sl_loading_icon`");

        }
/****<change image table url type>****/

$table_name =  $wpdb->prefix."slider_images";

$sql_slider_images_change_column_type = "ALTER TABLE `$table_name` MODIFY COLUMN `sl_url` text ";

$wpdb->query($sql_slider_images_change_column_type);

/****</change image table url type>****/


}
register_activation_hook(__FILE__, 'cc_slider_activate');

	cc_slider_activate();
