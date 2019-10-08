<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices();

/**
 * My Account navigation.
 * @since 2.6.0
 */
?>

<div class="myaccount-user">
	<?php

	echo '<span class="col-sm-4 pad0r-sm pull-right user-settings primary-bg-color">';

    printf(__( '<a href="%1$s" class="btn btn-block btn-cc-regular-red"><i class="fa fa-sign-out primary-icon-color"></i> Sign out</a>', 'woocommerce' ) . ' ',wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ));


	echo '</span>';
	?>
</div>

<?php //do_action( 'woocommerce_before_my_account' ); ?>


<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php //do_action( 'woocommerce_after_my_account' );

// do_action( 'woocommerce_account_navigation' ); ?>

<!-- <div class="woocommerce-MyAccount-content"> -->
    <?php
        /**
         * My Account content.
         * @since 2.6.0
         */
        do_action( 'woocommerce_account_content' );
    ?>
<!-- </div> -->

