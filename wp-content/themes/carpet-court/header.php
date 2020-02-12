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
?>
<?php /** new design */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    $hostUrl = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if(is_search() || strpos($hostUrl , 'search/?search') !== false){
        echo '<meta name="robots" content="noindex" />' ;
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
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=268676176963977&ev=PageView&noscript=1"/></noscript>
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
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=268676176963977&ev=PageView&noscript=1"/></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
    <?php
    $pagename = get_query_var('pagename');
    if ($pagename == 'measure-and-quote') { ?>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php } ?>
    <?php wp_head(); ?>
</head>
<?php
    $logo = get_field('logo', 'option');
    $topBar = get_field('top_bar', 'option');
    $header = get_field('header', 'option');
?>
<body <?php body_class(); ?>>
    <div class="g-wrap <?php if (newDesign()) : ?> js-check-padding <?php endif; ?>">
        <header class="g-header">
        <div class="h-bar js-check-padding">
            <div class="container">
                <div class="h-bar__inner">
                    <?php if (!empty($topBar['text'])) : ?>
                    <div class="bar-text">
                        <?= $topBar['text'] ?>
                    </div>
                    <?php endif; ?>
                    <div class="bar-menu">
                        <?php if (is_user_logged_in()) : ?>
                            <?php if (!empty($topBar['wishlist_logened'])) : ?>
                                <div class="menu-item"><a href="<?= $topBar['wishlist_logened']['url'] ?>" class="ic-bar-heart"><?= $topBar['wishlist_logened']['title'] ?></a></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (!empty($topBar['wishlist_guest'])) : ?>
                                <div class="menu-item"><a href="<?= $topBar['wishlist_guest']['url'] ?>" class="ic-bar-heart"><?= $topBar['wishlist_guest']['title'] ?></a></div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($topBar['phone'])) : ?>
                        <div class="menu-item"><a href="<?= $topBar['phone']['url'] ?>" class="ic-bar-phone"><?= $topBar['phone']['title'] ?></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-wrap js-check-padding">
            <div class="container">
                <div class="h-wrap__inner">
                    <div class="h-burger">
                        <button type="button" data-target="#mobileMenu" class="btn-burger mm-opener"><span class="icon"></span></button>
                    </div>
                    <div class="h-search"><a href="#" class="ic-nav-search search-opener"></a></div>
                    <?php if (!empty($logo['dark'])) : ?>
                    <div class="h-logo">
                        <a href="<?= get_option( 'home' ); ?>">
                            <img src="<?= $logo['dark']['url'] ?>" alt="<?= get_option( 'blogname' ); ?>">
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="h-nav">
                        <?php if (!empty($header['navigation'])) : ?>
                            <?php foreach ($header['navigation'] as $key => $item) : ?>
                                <?php if (!empty($item['link'])) : ?>
                                    <?php
                                        $dropdown = '';
                                        if (!empty($item['sub_items'])) {
                                            $dropdown = ' data-dropdown="#nav-' . $key . '" ';
                                        }

                                        $isPromotions = '';
                                        if (!empty($item['isPromotions'])) {
                                            $isPromotions = ' nav-item--promo ';
                                        }
                                    ?>
                                    <div class="nav-item <?= $isPromotions ?>">
                                        <a href="<?= $item['link']['url'] ?>" target="<?= $item['link']['target'] ?>" <?= $dropdown ?> ><?= $item['link']['title'] ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="nav-item nav-item--right"><a href="#" class="ic-nav-search search-opener">search</a></div>
                        <?php if (!empty($header['location'])) : ?>
                            <div class="nav-item nav-item--right"><a href="<?= $header['location']['url'] ?>" class="ic-nav-location"><?= $header['location']['title'] ?></a></div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($header['button'])) : ?>
                    <div class="h-button">
                        <a href="<?= $header['button']['url'] ?>" class="btn btn-index"><?= $header['button']['title'] ?></a>
                    </div>
                    <?php endif; ?>
                    <?php if (is_user_logged_in()) : ?>
                        <?php if (!empty($topBar['wishlist_logened'])) : ?>
                            <div class="h-favorite"><a href="<?= $topBar['wishlist_logened']['url'] ?>" class="ic-bar-heart"></a></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if (!empty($topBar['wishlist_guest'])) : ?>
                            <div class="h-favorite"><a href="<?= $topBar['wishlist_guest']['url'] ?>" class="ic-bar-heart"></a></div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($header['location'])) : ?>
                        <div class="h-location"><a href="<?= $header['location']['url'] ?>" class="ic-nav-location"></a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="h-drop js-check-padding">
            <div class="container">
                <?php if (!empty($header['navigation'])) : ?>
                    <?php foreach ($header['navigation'] as $key => $item) : ?>
                        <?php if (!empty($item['link'])) : ?>
                            <?php if (!empty($item['sub_items'])) : ?>
                            <div id="nav-<?= $key ?>" class="drop-menu js-card-wrapper">
                                <?php foreach ($item['sub_items'] as $dropdown) : ?>
                                <?php if (!empty($dropdown['sub_item'])) : ?>
                                <?php
                                    $image = '';
                                    if ($dropdown['image']) {
                                        $image = $dropdown['image']['url'];
                                    }
                                ?>
                                <div class="menu-item">
                                    <a href="<?= $dropdown['sub_item']['url'] ?>" style="background-image: url(<?= $image ?>)" class="card card--small">
                                        <div class="card-label">
                                            <div class="card-title"><?= $dropdown['sub_item']['title'] ?></div>
                                        </div>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <div class="g-main">
<?php if (!newDesign()) : ?>
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
<?php /** old design */ ?>


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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript">
    jQuery(document).ready(function() {

        // clientID value, i.e. let cid = $.cookie('cid');
        let cid = '12345';

        // URL to redirect the customer to after submitting the form.
        // default is to return to the current form location
        //let returnURL = window.location.href;
        let returnURL = 'https://carpetcourt.staging.overdose.digital/measure-and-quote/';

        // CSS selector of the target element that will receive the form.
        let formTarget = '#crmFormContainer';

        // The URL to get the form
        let formURL = 'https://scoreboard.carpetcourt.nz/crm/lead-form/web/getLeadForm.php';

        jQuery.ajax({
            url: formURL,
            data: {
                cid: cid,
                returnURL: returnURL
            },
            dataType: "html",
            cache: false,
            success: function (response) {
                jQuery(formTarget).html(response);
            }
        });
    });
    </script>

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
<?php endif; ?>
<?php /*
<!DOCTYPE html>
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
<?php */ ?>