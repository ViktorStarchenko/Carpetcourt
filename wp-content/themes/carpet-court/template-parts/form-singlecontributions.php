
<div class="contribution-comment-form">

	<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" enctype="multipart/form-data" novalidate>

		<?php foreach ( wc_product_reviews_pro()->frontend->get_contribution_fields( 'contribution_comment' ) as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field ); ?>

		<?php endforeach; ?>

		<input type="hidden" name="comment_type" value="contribution_comment" />
		<input type="hidden" name="comment_post_ID" value="<?php the_ID(); ?>">
		<input type="hidden" name="comment_parent" value="<?php echo esc_attr( $comment->comment_ID ); ?>">
		<?php wp_comment_form_unfiltered_html_nonce(); ?>

		<p class="form-row">
			<button type="submit" class="button"><?php esc_html_e( 'Save Comment', 'woocommerce-product-reviews-pro' ); ?></button>
		</p>

	</form>

</div>
