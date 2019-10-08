<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Carpet_Court
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- <meta name="viewport" content="width=device-width" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--<meta name="p:domain_verify" content="1328c894199a0a8cdb10af1f3ef7ce2e"/>-->
    
    <?php wp_head(); ?>
    <?php global $cc_options; global $post;

    ?>
    <?php if ( ( !empty( $post ) ) && ( $post->ID == 10935 || $post->ID == 10929 ) ) { echo '<meta name="robots" content="noindex,nofollow">'; } ?>
  <?php if ($_SERVER['REQUEST_URI'] == '/products/page/25' || $_SERVER['REQUEST_URI'] == '/products/page/43' || $_SERVER['REQUEST_URI'] == '/products/page/2' || $_SERVER['REQUEST_URI'] == '/products/page/46' || $_SERVER['REQUEST_URI'] == '/products/page/42' || $_SERVER['REQUEST_URI'] == '/products/page/38' || $_SERVER['REQUEST_URI'] == '/products/page/36' || $_SERVER['REQUEST_URI'] == '/design-centre/rooms-gallery/master-bedrooms/feed/' || $_SERVER['REQUEST_URI'] == '/products/page/37' || $_SERVER['REQUEST_URI'] == '/products/page/45' || $_SERVER['REQUEST_URI'] == '/products/page/47') {
      echo '<link rel="canonical" href="https://carpetcourt.nz/product-page/" />';
  } 

  ?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '268676176963977'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=268676176963977&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '268676176963977', {
em: 'insert_email_variable'
});
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=268676176963977&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>

    <style type="text/css">

        .color-term-name {
            position: absolute;
            z-index: 9999;
            top: 0;
            left: 0;
            text-align: center;
            color: white;
            margin: 0px auto;
            right: 0;
            font-size: 30px;
            font-weight: 600;
            width: 100%;
            height: 100%;
            display: none;
        }
        .color-term-name span {
            width: 100%;
            display: table-cell;
            vertical-align: middle;
            height: 100%;
        }
        #easy_zoom{
            width:300px;
            height:300px;
            border:5px solid #eee;
            background:#fff;
            color:#ffffff;
            font-size: 24px;
            font-weight: 500;
            position:absolute;
            overflow:hidden;
            -moz-box-shadow:0 0 10px #777;
            -webkit-box-shadow:0 0 10px #777;
            box-shadow:0 0 10px #777;
            line-height:300px;
            text-align:center;
            z-index: 9999;
            top: -250px;
        }
        #easy_zoom img{
            width: 100%;
            height: 100%;
        }
        div#collapse-color {
            position: relative;
        }

        #easy_zoom .color-i-term{
            position: relative;
        }
        #cceasy_zoom{
            width:300px;
            height:300px;
            border:5px solid #eee;
            background:#fff;
            color:#ffffff;
            font-size: 24px;
            font-weight: 500;
            position:absolute;
            overflow:hidden;
            -moz-box-shadow:0 0 10px #777;
            -webkit-box-shadow:0 0 10px #777;
            box-shadow:0 0 10px #777;
            line-height:300px;
            text-align:center;
            z-index: 9999;
            bottom: 40px;
            left: 0px;
        }
        #cceasy_zoom img{
            width: 100%;
            height: 100%;
        }
        div#collapse-color {
            position: relative;
        }

        #cceasy_zoom .color-i-term{
            position: relative;
        }
        .list-color-available ul li {
            position: relative;
        }
    </style>
    <?php
    $pagename = get_query_var('pagename');

    if(is_front_page()){

        ?>
    <script>
     window.dataLayer = window.dataLayer || [];
     window.dataLayer.push({
      'pageType':'home'
  });
</script>
<?php }
elseif(is_product()){
 global $post, $product;
 $terms = get_the_terms( $product->id, 'product_cat' );
 foreach ($terms as $term) {
     $categ = $term->slug;
     break;
 }


   // $categ = $product->get_categories();

 ?>
 <script>
     window.dataLayer = window.dataLayer || [];
     window.dataLayer.push({
      'pageType':'product',
      'productCategory':'<?php echo $categ; ?>'
  });
</script>
<?php }
elseif(is_search()){ ?>
<script>
 window.dataLayer = window.dataLayer || [];
 window.dataLayer.push({
  'pageType':'searchresults'
});
</script>
<?php }
elseif($pagename == 'measure-and-quote'){ ?>
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        'pageType':'contactus'
    });
</script>
<?php }
elseif($pagename == 'thanks-for-your-email'){ ?>
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        'event':'quoteSubmitted'
    });
</script>
<?php }
elseif($pagename == 'my-account'){ ?>
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        'event':'accountCreated'
    });
</script>
<?php }
elseif($pagename == 'search'){ ?>
<script>
	window.dataLayer = window.dataLayer || [];
     window.dataLayer.push({
      'pageType':'searchresults'
    });
</script>
<?php }

elseif($pagename == 'store-finder'){ ?>
<script>
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push({
		'pageType':'storefinder'
	});
</script>
<?php }
elseif($pagename == 'advice'){ ?>
<script>
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push({
		'pageType':'advice'
	});
</script>
<?php }
?>


<?php 
if ( $pagename == 'style-guide' ) { ?>
<div class="modal grow" id="style-guide-modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg modal-xlg" role="document">

    <div class="modal-content">
      <div class="modalbox-header pull-right">
        <form>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        </form>
    </div>
    <div class="modal-body" id="post-popup-style-guide-cc">

    </div>
</div>
</div>
</div>
<?php

} ?>
<div class="modal cc-model fade cc-masonry-popup" id="pop-up-video" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
          aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body clearfix">
          <div class="col-sm-12">
          </div>
      </div>
  </div>
</div>
</div>
<?php

if( is_product() ){ ?>
<div class="modal fade" id="like-img-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
          aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body img-modal-body clearfix">

      </div>
  </div>
</div>
</div>
<?php

}
?>

<header class="site-header">

    <?php
    $sticky = '';
    $wishlist_url = '';
    $count_items = '';
    if( function_exists( 'YITH_WCWL' ) ){
        $wishlist_url = YITH_WCWL()->get_wishlist_url();
        $count_items = yith_wcwl_count_all_products();
        if(0 == $count_items){
            $count_items = '';
        }
    }
    if (1 == $cc_options['sticky-header']) {
        $sticky = 'navbar-fixed-top';
    }
    ?>

    <nav id="cc-navbar" class="navbar navbar-default <?php echo $sticky; ?>">

        <div id="cc-top-bar">
            <div class="container-fluid">
                <div class="cc-wrap pull-right">
                    <!-- <ul class="top-menu">
                        <li><a href="#">Carpet Court madness sale!</a></li>
                        <li><a href="#">News</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul> -->

                    <?php
                    if ( has_nav_menu( 'notification' ) ) {
                        $args_top = array(
                            'theme_location' => 'notification',
                            'container' => '',
                            'container_class'   => '',
                            'menu_id'   => 'top-notification'
                                // 'walker' => new wp_bootstrap_navwalker(),
                            ); ?>


                        <?php
                        //wp_nav_menu($args_top);
                        ?>
                        <?php
                        if(function_exists('ditty_news_ticker')){
                            $custom_fields = get_post_meta( 11948, '_mtphr_dnt_ticks', true );

                            if ( !empty( $custom_fields[0]['tick'] ) ) {

                                ?>
                                <div id="top-notification-carousel">
                                    <?php
                                    ditty_news_ticker(11948);
                                    ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <?php

                        if ( has_nav_menu( 'top_navv' ) ) {
                            $args_topp = array(
                                'theme_location' => 'top_navv',
                                'menu_class' => 'top-menu',
                                'container' => '',
                                    // 'walker' => new wp_bootstrap_navwalker(),
                                );
                            wp_nav_menu($args_topp);
                        }
                    }
                    ?>
                    <ul class="nav navbar-nav navbar-right nav-icons">
                        <li class="round-icon wishlist-icon"><a href="<?php echo $wishlist_url;?>"><span class="fa fa-heart-o"><?php if ($count_items > 0 ) { ?><super><?php echo $count_items;?></super><?php } ?></span></a></li>
                        <?php
                        if ( is_user_logged_in() ) {

                            ?>
                            <!-- <li class="round-icon account-icon"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><span class="fa fa-user"></span></a></li> -->
                            <?php } ?>
                            <li class="search-icon"><a href="#search"><span class="fa fa-search"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="cc-bottom-bar">
                <div class="container-fluid">
                    <?php
                    if (1 == $cc_options['menu-opt-switch']) {
                        if (function_exists('ubermenu')) {
                            ?>
                            <div class="navbar-two">
                                <div class="navbar-header">
                                    <a itemprop="url" class="navbar-brand" href="<?php echo home_url('/'); ?>">
                                        <img itemprop="logo" src="<?php echo $cc_options['logo']['url']; ?>" width="155" height="23">
                                    </a>
                                </div>
                                <nav class="navbar-left">
                                    <?php ubermenu('main', array('theme_location' => 'primary')); ?>
                                </nav>
                                <div class="navbar-mobile">
                                    <?php ubermenu( 'main' , array( 'menu' => 297 ) ); ?>
                                </div>
                                <div class="navbar-header cc-small-devices">
                                    <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
                                        <img src="<?php echo $cc_options['logo']['url']; ?>" width="155" height="23">
                                    </a>
                                </div>
<div class="search-icons">
<a href="#search"><span class="fa fa-search"></span></a>
</div>
                                <div class="mobile_phone"><a href="tel: 0800787777"><i class="fa fa-phone" aria-hidden="true"></i></a></div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-one">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#cc-navbar-collapse" aria-expanded="false">
                                <span class="burger">
                                    <span>Menu</span>
                                </span>
                            </button>
                            <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
                                <img src="<?php echo $cc_options['logo']['url']; ?>">
                            </a>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="cc-navbar-collapse">
                            <?php
                            $args = array(
                                'theme_location' => 'primary',
                                'menu_class' => 'nav navbar-nav',
                                'walker' => new wp_bootstrap_navwalker(),
                                );
                            wp_nav_menu($args);

                            ?>
                            <!-- <ul class="nav navbar-nav navbar-right nav-icons">
                                <li class="round-icon wishlist-icon"><a href="<?php echo $wishlist_url;?>"><span class="fa fa-heart-o"><?php if ($count_items > 0 ) { ?><super><?php echo $count_items;?></super><?php } ?></span></a></li>
                                <li class="round-icon account-icon"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><span class="fa fa-user"></span></a></li>
                                <li class="search-icon"><a href="#search"><span class="fa fa-search"></span></a></li>
                            </ul> -->
                        </div><!-- /.navbar-collapse -->
                    </div>
                    <?php
                }
                ?>
            </div><!-- /.container-fluid -->
        </div>
    </nav>
</header>
<!-- this is for new slide menu  -->
<script type="text/javascript">
    var disable_f = 0;
</script>
<?php
    if ( get_field('disable_page_refresh', get_the_ID() ) ) {
        ?>
        <script type="text/javascript">
            disable_f = 1;
        </script>
        <?php
    }
?>
<?php if( is_singular() && get_field('enable_one_page_scroller', get_the_ID()) ){?>


<div class="cpm-preloader"><div class="loader-icon"></div></div>
<div class="slider-menu-section">
    <ul class="slier-menu-right">
        <?php
        $menu_title = "Banner";
        if( get_field('banner_menu_title', get_the_ID()) ){
            $menu_title = get_field('banner_menu_title', get_the_ID());
        }
        if( get_field('add_slider_shortcode', get_the_ID()) ){
            ?>
            <li><a class="active" href="#section-0"><span></span></a><div class="tooltip"><span><?php echo get_field('banner_menu_title', get_the_ID()); ?></span></div></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <!-- end of slide menu  -->
    <div id="search">
        <button type="button" class="close">×</button>
        <?php get_search_form();?>
    </div>
    <div class="site-content">