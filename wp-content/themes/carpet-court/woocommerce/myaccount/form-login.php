<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if(isset($_GET['action'])=='register'){
    wc_print_notices();
    wc_get_template( 'myaccount/form-register.php' );
}
else{
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="row" id="customer_login">

	<div class="col-sm-6">

<?php endif; ?>

		<h2 class="alt-text text-uppercase"><?php _e( 'Login', 'woocommerce' ); ?></h2>

        <h4><?php _e( 'Registered customers', 'woocommerce' ); ?></h4>
        <p><?php _e( 'If you\'ve already registered on our website, please login.', 'woocommerce' ); ?></p>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>
            <div class="form-group">
                <label class="sr-only" for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="fa fa-user"></span>
                    </div>
                    <input type="text" class="input-text form-control" name="username" id="username" placeholder="<?php _e( 'Username or email address', 'woocommerce' ); ?>" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                </div>
            </div>

            <div class="form-group">
				<label class="sr-only" for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="fa fa-key"></span>
                    </div>
                    <input class="input-text form-control" type="password" name="password" id="password" placeholder="<?php _e( 'Password', 'woocommerce' ); ?>" />
                </div>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

            <div class="form-group">
                <p class="form-row">
                    <label for="rememberme" class="inline">
                        <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Keep Me Logged In', 'woocommerce' ); ?>
                    </label>
                    <?php wp_nonce_field( 'woocommerce-login' ); ?>
                    <button type="submit" class="btn btn-cc btn-block btn-ltr btn-cc-empty" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"> <?php _e( 'Login', 'woocommerce' ); ?></button>
                </p>
            </div>

            <div class="form-group">
			<p class="lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
            </div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-sm-5 col-sm-offset-1 mt-sm-90">

		<h2 class="alt-text text-uppercase"><?php _e( 'New Customers', 'woocommerce' ); ?></h2>

        <a href="<?php echo get_permalink(wc_get_page_id('myaccount'))?>?action=register" class="btn btn-cc btn-block btn-ltr btn-cc-empty"><?php _e('Create New account','carpet-court')?></a>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); }?>
