<?php
/**
 * Created by PhpStorm.
 * User: Rubal
 * Date: 3/13/16
 * Time: 12:22 PM
 */

/*Display Popup Forms*/
function cc_display_wishlist_forms($icon = '', $label = '', $link_classes = '') {
    global $product;
    ?>
    <a href="#wishlist-form" data-toggle="modal" id="cpm_wishlist_popup" data-target="#wishlist-form" class="<?php echo str_replace('add_to_wishlist', '', $link_classes) ?>" data-product-id="<?php echo $product->id ?>" data-product-type="<?php echo $product->product_type?>" data-wishlist-id="0" data-wishlist-visibility="0">
        <?php echo $icon; ?>
        <?php echo $label; ?>
    </a>
    <div class="modal cc-model fade" id="wishlist-form" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="wishlist-modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                    <!-- <div class="modal-title animation-icon" id="wishlist-form">
                        <i class="fa fa-user"></i>
                    </div> -->
                </div>
                <div class="modal-body user-portal clearfix">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="user-portal-header">
                        <h2 class="user-register-heading alt-text text-uppercase text-center"><?php //_e('Register', 'carpet-court');
                            _e('Add product to favourites', 'carpet-court');
                            ?></h2>
                            <h2 class="hidden user-login-heading alt-text text-uppercase text-center"><?php _e('Login', 'carpet-court'); ?></h2>
                            <p><?php _e('Hello! We just need your email address to create a flooring favourites list for you.','carpet-court');?></p>
                        </div>
                        <div class="tab-content mt-40 mb-40">

                            <!--Login Form-->
                            <div class="wishlist-login-form hidden" id="login" >
                                <form id="wishlist-login" action="" method="POST">
                                    <div class="form-group">
                                        <label class="sr-only" for="username"><?php _e('Email or Username', 'carpet-court'); ?></label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-user"></span>
                                            </div>
                                            <input id="username" class="form-control" type="text" name="username" placeholder="Email or Username" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="sr-only" for="password"><?php _e('Password', 'carpet-court'); ?></label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-asterisk"></span>
                                            </div>
                                            <input id="password" class="form-control" type="password" name="password" placeholder="Enter your Password" required>
                                        </div>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember_me" value="yes"><?php _e('Remember me', 'carpet-court'); ?>
                                        </label>
										<label style="float:right;">
										<a href=" <?php echo wp_lostpassword_url( $redirect ); ?>"><?php echo _e("Forgot Password","carpet-court")?></a>
										</label>
                                    </div>
                                    <button class="submit_button btn btn-cc btn-block btn-cc-red" type="submit" value="Login" name="wishlist_login"><?php _e('Sign In', 'carpet-court'); ?></button>

                                    <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                                </form>
                                <div class="loading-login-img" style="display: none">
                                    <div class="cc-loader pad0">
                                        <div class="loader">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="wishlist-login-info"></div>
                            </div>
                            <!--Login Form-->

							<!---Forgot Password--->
							<!--<div class="forgot-password hidden">
							<form id="forgot_password" class="ajax-auth" action="forgot_password" method="post">   
  <fieldset class="cc-fieldset">
 <div class="form-top">
                                            <div class="form-group">  
          <label class="sr-only" for="email"><?php _e('Forgot Password', 'carpet-court'); ?></label>
    <p class="status"></p>  
   
   
	    <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-envelope"></span>
                                                    </div>
                                                    <input id="user_login" class="form-control" type="text" name="user_login" placeholder="Email" required>
													 <?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>  
                                                </div>
	   </div>
     <button type="submit" class="btn btn-cc btn-cc-red pull-right submit_button"><?php _e('Submit!','carpet-court');?></button>
	 <div class="wishlist-forgot-info"></div>
	<p><a href="#" id="flogin"><?php echo _e("Login","carpet-court")?></a></p>
	  <fieldset class="cc-fieldset">
	  </div>
</form> 
</div>-->
							<!---Forgot Password---->
							
							
                            <!--Registration Form-->
                            <div id="register">
                                <form id="wishlist-register" action="" method="POST" class="wishlist-registration-form">

                                    <fieldset class="cc-fieldset">

                                        <div class="form-top">
                                            <div class="form-group">
                                                <label class="sr-only" for="email"><?php _e('Email', 'carpet-court'); ?></label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-envelope"></span>
                                                    </div>
                                                    <input id="email" class="form-control" type="email" name="email" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="wishlist-register-email"></div>
                                            <div class="loading-login-img" style="display: none">
                                                <div class="cc-loader pad0">
                                                    <div class="loader">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-next btn-cc btn-cc-red pull-right wishlist-email">Next</button>
                                        </div>
                                        <div class="form-bottom">
                                            <div class="form-top-left">
                                                <p><?php _e('Please enter your email address','carpet-court');?></p>
                                                <p><a href="#" id="show-login"><?php echo _e("Do you already have an account?","carpet-court")?></a></p>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="cc-fieldset">
                                            <div class="form-top">
                                                <div class="form-top-left">
                                                    <p><?php _e('Choose a password so you can find your flooring favourites again:','carpet-court');?></p>
                                                </div>
                                            </div>
                                            <div class="form-bottom">
                                                <div class="form-group">
                                                    <label class="sr-only" for="password"><?php _e('Password', 'carpet-court'); ?></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-asterisk"></span>
                                                        </div>
                                                        <input id="password" class="form-control" type="password" name="password" placeholder="Password" required>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-previous btn-cc btn-cc-red pull-left">Previous</button>
                                                <input type="hidden" name="redirect_url" value="<?php echo get_permalink(); ?>" id="redirect_url">
                                                <button type="submit" class="btn btn-cc btn-cc-red pull-right"><?php _e('Sign me up!','carpet-court');?></button>
                                            </div>
                                        </fieldset>

                                <?php wp_nonce_field('ajax-register-nonce', 'security'); ?>
                            </form>
                            <div class="loading-login-img" style="display: none">
                                <div class="cc-loader pad0">
                                    <div class="loader">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="wishlist-register-info"></div>
                        </div>
                        <!--Registration Form-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}


/*add_action('wp_footer','popup_script_wishlist');
function popup_script_wishlist(){
    ?>
    <script type="text/javascript">
        (function($){
            $('#show-login').on('click',function(e){
                e.preventDefault();
                $('.user-register-heading').addClass('hidden');
                $('#register').addClass('hidden');

                $('.user-login-heading').removeClass('hidden');
                $('#login').removeClass('hidden');
            });

            $('#wishlist-form').on('hidden.bs.modal',function(){
                $('.user-register-heading').removeClass('hidden');
                $('#register').removeClass('hidden');

                $('.user-login-heading').addClass('hidden');
                $('#login').addClass('hidden');
            });

        })(jQuery);
    </script>
    <?php
}*/

if (!is_user_logged_in()) {
    add_action('init', 'cc_wishlist_action_init');
}
function cc_wishlist_action_init() {

    wp_register_script('cc-wishlist-script', get_template_directory_uri() . '/wishlist/wishlist-script.js', array('jquery'), '', true);
    wp_enqueue_script('cc-wishlist-script');
    wp_localize_script('cc-wishlist-script', 'cc_wishlist_object', array('ajaxurl' => admin_url('admin-ajax.php')));

    add_action('wp_ajax_nopriv_cc_wishlist_ajax_login', 'cc_wishlist_ajax_login');
    add_action('wp_ajax_nopriv_cc_wishlist_ajax_email_check', 'cc_wishlist_ajax_email_check');
    add_action('wp_ajax_nopriv_cc_wishlist_ajax_register', 'cc_wishlist_ajax_register');
}


/*Register email check*/
function cc_wishlist_ajax_email_check() {

    $email = $_POST['email'];
    $errors = array();

    if (email_exists($email)) {
        $errors[] = '<div class="alert alert-warning alert-dismissible fade in" role="alert"><i class="alerticon"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></i><strong>Email Already Exist.</strong></div>';
    }

    if (!is_email($email)) {
        $errors[] = '<div class="alert alert-warning alert-dismissible fade in" role="alert"><i class="alerticon"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></i><strong>Email is not Valid.</strong></div>';
    }

    if (!empty($errors)) {
        echo json_encode(array('status' => false, 'error' => $errors));
    } else {
        echo json_encode(array('status' => true));
    }
    die();
}

function cc_wishlist_ajax_register() {

    check_ajax_referer('ajax-register-nonce', 'security');
    $errors = array();
    $values = $_POST['info'];

    $email = $values['email'];
    $password = $values['password'];
    $first_name = $values['first_name'];
    $last_name = $values['last_name'];
    $tel = $values['tel'];
    $location = $values['location'];
    $redirect_url = $values['redirect_url'];

    $user_login = sanitize_user( current( explode( '@', $email ) ), true );
    /*Ensure username is unique*/
    $append     = 1;
    $o_username = $user_login;

    while ( username_exists( $user_login ) ) {
        $user_login = $o_username . $append;
        $append ++;
    }

    $userdata = array(
        'user_login' => $user_login,
        'user_pass' => $password,
        'user_email' => $email,
        'role' => 'customer',
        );

    if (!empty($errors)) {
        echo json_encode(array('status' => false, 'error' => $errors));
    }
    else{
        $user_id = wp_insert_user($userdata);
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            update_user_meta($user_id, 'billing_phone', $tel);
            update_user_meta($user_id, 'billing_address_1', $location);
            $info['user_login'] = $user_login;
            $info['user_password'] = $password;
            $user_signon = wp_signon($info, false);
            $new_wishlist = new YITH_WCWL();
            $new_wishlist->details['add_to_wishlist'] = $_POST['add_to_wishlist'];
            $new_wishlist->details['wishlist_id'] = $_POST['wishlist_id'];
            $new_wishlist->details['user_id'] = $user_id;

            $return = $new_wishlist->add();
            $wishlists = $new_wishlist->get_wishlists( array( 'user_id' => $user_id ) );
            if( $return == 'true' ){
              $message = apply_filters( 'yith_wcwl_product_added_to_wishlist_message', get_option( 'yith_wcwl_product_added_text' ) );
            }
            elseif( $return == 'exists' ){
              $message = apply_filters( 'yith_wcwl_product_already_in_wishlist_message', get_option( 'yith_wcwl_already_in_wishlist_text' ) );
            }
            elseif( count( $new_wishlist->errors ) > 0 ){
              $message = apply_filters( 'yith_wcwl_error_adding_to_wishlist_message', $new_wishlist->get_errors() );
            }
            echo json_encode(array('status' => true, 'redirect_url'=> $redirect_url ));
        }else{
            echo json_encode(array('status' => false, 'error' => '<div class="alert alert-warning alert-dismissible fade in" role="alert"><i class="alerticon"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></i><strong>Some error occurred. Please Try again</strong></div>'));
        }
    }
    die();
}

/*login*/
function cc_wishlist_ajax_login() {

    check_ajax_referer('ajax-login-nonce', 'security');
    $values = $_POST['info'];

    $info = array();
    $username= '';
    if(is_email($values['username'])){
        $user = get_user_by('email',$values['username']);
        if(!empty($user->user_login)){
            $username = $user->user_login;
        }
    }
    else{
        $username = $values['username'];
    }

    $info['user_login'] = $username;
    $info['user_password'] = $values['password'];
    if (isset($values['remember_me']) && 'yes' == $values['remember_me']) {
        $info['remember'] = true;
    }

    $user_signon = wp_signon($info, false);
    if (is_wp_error($user_signon)) {
        echo json_encode(array('status' => false));
    } else {
        echo json_encode(array('status' => true));
    }
    die();
}

/*Show wishlist created by user plus print wishlist*/
add_action('yith_wcwl_before_wishlist_form','cc_show_wishlist_links');
function cc_show_wishlist_links(){
    $users_wishlists = YITH_WCWL()->get_wishlists();
    if(!empty($users_wishlists)):
        ?>
    <div class="btn-group noprint">
        <button type="button" class="btn btn-cc btn-cc-empty dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php _e('Other Wishlists', 'carpet-court'); ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?php foreach( $users_wishlists as $wishlist ):
            if( $wishlist['is_default'] == 1) {
                $wishlist['wishlist_name'] = __("My Wishlist","carpet-court");
                $wishlist['wishlist_token'] = '';
            }
            ?>
            <li>
                <a title="<?php echo $wishlist['wishlist_name'] ?>" class="wishlist-anchor" href="<?php echo YITH_WCWL()->get_wishlist_url( 'view' . '/' . $wishlist['wishlist_token'] ) ?>">
                    <?php echo $wishlist['wishlist_name'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif;?>
<button type="button" class="btn btn-cc btn-cc-empty noprint" value="" onClick="window.print()"><i class="fa fa-print"></i> <?php _e('Print this Wishlist', 'carpet-court'); ?></button>
<a class="btn btn-cc btn-cc-empty sent-to-me" href="javascript:void(0);">Send to Store</a>
<a href="#wishlist-sent-modal" data-toggle="modal" data-target="#wishlist-sent-modal" class="cpm-sent-wishlist"></a>
<div class="modal cc-model fade" id="wishlist-sent-modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body clearfix">
                    <div class="wishlist-cc-loader" style="display: none;">
                        <div class="cpm-loader">
                        </div>
                    </div>
                    <div class="col-m-6 first-step">
                    <?php

                        $all_posts = array();
                        $idea_args = array(
                            'post_type'=>'wpsl_stores',
                            'post_status'=>'publish',
                            'posts_per_page'=> -1,
                            );
                        $posts = get_posts( $idea_args );
                        foreach ($posts as $post_value) {
                            $wpsl_email  = get_post_meta( $post_value->ID, 'wpsl_email', true );
                            $all_posts[html_entity_decode(utf8_decode($post_value->post_title))] = $wpsl_email;
                        }
                        wp_reset_postdata();
                        wp_reset_query();
                    ?>
                    <span class="nobr">Select Store To Send Your Wishlist</span>
                        <select name="nearest_store" class="form-control wpcf7-select wpcf7-validates-as-required selectize" aria-required="true" aria-invalid="false">
                            <option value="">---</option>
                            <?php
                                if ( !empty($all_posts)) {
                                    ksort($all_posts);
                                    foreach ($all_posts as $keyss => $post_value) { ?>

                                        <option value="<?php echo $post_value; ?>"><?php echo $keyss; ?></option>
                                        <?php
                                    }
                                }
                            ?>

                        </select>
                        <button type="button" class="select-store btn-cc-regular-red">Select</button>
                    </div>
                    <div class="col-sm-12 second-step hidden">
                        <?php _e('Thanks! We have emailed your wishlist.', 'carpet-court'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}


/*Update wishlist counter*/
function update_wishlist_count(){
    if( function_exists( 'YITH_WCWL' ) ){
        wp_send_json( YITH_WCWL()->count_all_products() );
    }
    die();
}
add_action( 'wp_ajax_update_wishlist_count', 'update_wishlist_count' );
add_action( 'wp_ajax_nopriv_update_wishlist_count', 'update_wishlist_count' );

function enqueue_custom_wishlist_js(){
    wp_enqueue_script( 'yith-wcwl-custom-js', get_template_directory_uri() . '/wishlist/item-counter.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_wishlist_js' );

/**/
add_action('yith_wcwl_action_links','cc_hide_search');
function cc_hide_search($action_links){
    $new_actions_links = array();
    $new_actions_links[] = $action_links[0];
    $new_actions_links[] = $action_links[1];
    return $new_actions_links;
}