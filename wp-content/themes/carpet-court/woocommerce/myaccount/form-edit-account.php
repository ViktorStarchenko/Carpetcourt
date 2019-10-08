<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
wc_print_notices();
$user_id = get_current_user_id();
$address_1 = get_user_meta( $user_id, 'billing_address_1', true );
$address_2 = get_user_meta( $user_id, 'billing_address_2', true );
$billing_city = get_user_meta( $user_id, 'billing_city', true );
$billing_postcode = get_user_meta( $user_id, 'billing_postcode', true );
$billing_phone = get_user_meta( $user_id, 'billing_phone', true );
$billing_country = get_user_meta( $user_id, 'billing_country', true );
$billing_state = get_user_meta( $user_id, 'billing_state', true );


?>

<form class="edit-account" action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
	<div class="mt-40 mb-40">

		<p class="form-row form-row-first">
			<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
		</p>
	</div>
	<hr class="thin-hr">
	<section class="mt-40 mb-40">
		<legend><?php _e( 'Password Change', 'woocommerce' ); ?></legend>

		<p class="form-row form-row-wide">
			<label for="password_current"><?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_current" id="password_current" />
		</p>
		<p class="form-row form-row-wide">
			<label for="password_1"><?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_1" id="password_1" />
		</p>
		<p class="form-row form-row-wide">
			<label for="password_2"><?php _e( 'Confirm New Password', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_2" id="password_2" />
		</p>
	</section>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="pull-right col-sm-4 pad0lr-xs pad0r-md pad0lr-sm">
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<button type="submit" class="btn btn-block btn-cc-regular-red" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"> <?php esc_attr_e( 'Save changes', 'woocommerce' ); ?> </button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>
