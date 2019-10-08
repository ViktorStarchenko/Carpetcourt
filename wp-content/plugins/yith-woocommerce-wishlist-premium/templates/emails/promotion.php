<?php
/**
 * Customer promotional email
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.13
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php
$mail_type = "yith-wcwl-promotion-mail";

if( function_exists( 'YITH_WCET_Premium' ) ){
	do_action( 'yith_wcet_email_header', $email_heading, $mail_type);
}
else{
	do_action('woocommerce_email_header', $email_heading );
}
?>

	<p><?php echo $email_content ?></p>

<?php
if( function_exists( 'YITH_WCET_Premium' ) ){
	do_action( 'yith_wcet_email_footer', $mail_type);
}
else{
	do_action( 'woocommerce_email_footer' );
}
?>