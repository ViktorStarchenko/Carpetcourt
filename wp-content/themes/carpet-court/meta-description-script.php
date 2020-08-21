<?php /* Template Name: Meta description change */ ?>
<?php get_header()?>
<?php
for($page=1; $page < 20; $page++) {
	$args = [
		'status' => 'published',
		'limit' => '100',
		'page' => $page
	];
	$products = wc_get_products($args);
	if (!empty($products)) {
			foreach ($products as $product) {
				$format = 'View %s online at Carpet Court. Find the perfect floor for your next project. Free measure & quote available.';
				$new_meta_description = sprintf($format, $product->name);
				update_post_meta($product->id, '_yoast_wpseo_metadesc', $new_meta_description);
			}
	}
}
?>
<?php get_footer(); ?>