<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product, $jck_wt;

$default_variation_id = $this->get_default_variation_id();
$initial_product_id = ($default_variation_id) ? $default_variation_id : $product->id;
$initial_product_id = $this->get_selected_varaiton( $initial_product_id );

$image_ids = $this->get_all_image_ids( $initial_product_id );
$images = $this->get_all_image_sizes( $image_ids );

$default_image_ids = $this->get_all_image_ids( $product->id );
$default_images = $this->get_all_image_sizes( $default_image_ids );

function jck_check_if_empty ($var){
    return array_filter($var);
}
?>

<?php do_action('before_cc_woo_images');?>
    <?php if(array_filter($default_images,"jck_check_if_empty")):?>
	<div class="<?php echo $this->slug; ?>-all-images-wrap <?php echo $this->slug; ?>-all-images-wrap--thumbnails-<?php echo $jck_wt['thumbnailLayout']; ?>" data-showing="<?php echo $initial_product_id; ?>" data-parentid="<?php echo  $product->id; ?>" data-default="<?php echo esc_attr( json_encode( $default_images ) ); ?>" data-slide-count="<?php echo count($image_ids); ?>">
		<?php if( $jck_wt['enableNavigation'] && $jck_wt['navigationType'] !== "bullets" && ( $jck_wt['thumbnailLayout'] === "above" || $jck_wt['thumbnailLayout'] === "left" ) ) { include('loop-thumbnails.php'); } ?>
		<?php include('loop-images.php'); ?>
		<?php if( $jck_wt['enableNavigation'] && $jck_wt['navigationType'] !== "bullets" && ( $jck_wt['thumbnailLayout'] === "below" || $jck_wt['thumbnailLayout'] === "right" ) ) { include('loop-thumbnails.php'); } ?>
	</div>
    <?php endif;?>
    <?php do_action('cc_woocommerce_after_single_product_images');?>
<?php do_action('after_cc_woo_images');?>