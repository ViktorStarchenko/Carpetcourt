<?php
/**
 * WooCommerce Product Reviews Pro
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Product Reviews Pro to newer
 * versions in the future. If you wish to customize WooCommerce Product Reviews Pro for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-product-reviews-pro/ for more information.
 *
 * @package   WC-Product-Reviews-Pro/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2015-2016, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Display single product reviews (comments)
 *
 * @version 1.4.0
 * @since 1.0.0
 */
global $product;

if ( ! comments_open() )
	return;

$contribution_types = wc_product_reviews_pro()->get_enabled_contribution_types();
$ratings            = array( 5, 4, 3, 2, 1 );
$total_rating_count = $product->get_rating_count();

?>
<div id="reviews">


	<?php // Product ratings ?>
	<?php if ( 'yes' == get_option( 'woocommerce_enable_review_rating' ) && $product->get_rating_count() ) : ?>

		<div class="product-rating">
			<div class="product-rating-summary">
				<h3><?php /* translators: Placeholders: %s - average rating stars count, %d - 5 stars total (e.g "4.2 out of 5 stars") */
					printf( __( '%s out of %d stars', 'woocommerce-product-reviews-pro' ), floatval( $product->get_average_rating() ), 5 ); ?></h3>

					<?php $reviews_count = wc_product_reviews_pro_get_comments_number( $product->id, 'review' ); ?>
					<p><?php printf( _nx( '%d review', '%d reviews', $reviews_count, 'noun', 'woocommerce-product-reviews-pro' ), $reviews_count ); ?></p>
				</div>
			</div>

		<?php endif; ?>

		<?php
		/**
	     * Fires before contribution list and title
	     *
	     * @since 1.0.1
		 */
		do_action( 'wc_product_reviews_pro_before_contributions' ); ?>

		<div class="contribution-type-selector">
			<?php $key = 0; ?>
			<?php foreach ( $contribution_types as $type ) : ?>

				<?php if ( 'contribution_comment' !== $type ) : $key++; ?>

					<?php $contribution_type = wc_product_reviews_pro_get_contribution_type( $type ); ?>
					<a href="#share-<?php echo esc_attr( $type ); ?>" class="js-switch-contribution-type <?php if ( $key === 1 ) : ?>active<?php endif; ?>"><?php echo $contribution_type->get_call_to_action(); ?></a>

				<?php endif; ?>

			<?php endforeach; ?>
		</div>

		<?php $key = 0; ?>
		<?php foreach ( $contribution_types as $type ) : ?>

			<?php if ( 'contribution_comment' !== $type ) : $key++; ?>

				<div id="<?php echo esc_attr( $type ); ?>_form_wrapper" class="contribution-form-wrapper <?php if ( $key === 1 ) : ?>active<?php endif; ?>">
					<?php wc_get_template( 'single-product/form-contribution.php', array( 'type' => $type ) ); ?>
				</div>

			<?php endif; ?>

		<?php endforeach; ?>

		<?php if ( ! is_user_logged_in() && get_option('comment_registration') ) : ?>

			<noscript>
				<style type="text/css">#reviews .contribution-form-wrapper { display: none; }</style>
				<p class="must-log-in"><?php printf( __( 'You must be <a href="%s">logged in</a> to join the discussion.', 'woocommerce-product-reviews-pro' ), esc_url( add_query_arg( 'redirect_to', urlencode( get_permalink( get_the_ID() ) ), wc_get_page_permalink( 'myaccount' ) . '#tab-reviews' ) ) ); ?></p>
			</noscript>

		<?php endif; ?>

		<?php // Comments list ?>
		<div id="comments">
			<div id="contributions-list">
				<?php wc_get_template( 'single-product/contributions-list.php', array( 'comments' => $comments ) ); ?>
			</div>
		</div>

		<div class="clear"></div>

		<?php if ( ! is_user_logged_in() ) : ?>

			<div id="wc-product-reviews-pro-modal">

				<a href="#" class="close">&times;</a>

				<?php wc_get_template( 'myaccount/form-login.php' ); ?>

				<div class="switcher">
					<p class="login"><?php printf( /* translators: Placeholders: %1$s - opening <a> link tag, %2$s - closing </a> link tag */
						__( 'Already have an account? %1$sLog In%2$s', 'woocommerce-product-reviews-pro' ), '<a href="#">', '</a>' ); ?></p>
					<p class="register"><?php printf( /* translators: Placeholders: %1$s - opening <a> link tag, %2$s - closing </a> link tag */
						__( 'Don\'t have an account? %1$sSign Up%2$s', 'woocommerce-product-reviews-pro' ), '<a href="#">', '</a>' ); ?></p>
					</div>

				</div>
				<div id="wc-product-reviews-pro-modal-overlay"></div>

			<?php endif; ?>

			<?php /* display all forms when no JS */ ?>
			<noscript>
				<style type="text/css">
					.contribution-form-wrapper { display: block; }
				</style>
			</noscript>

		</div>
