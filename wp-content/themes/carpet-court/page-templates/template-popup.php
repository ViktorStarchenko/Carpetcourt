<?php 
/*Template Name: Popup Page*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
    <?php global $cc_options; ?>
</head>
<body <?php body_class(); ?>>
<div class="site-content">
    <div id="primary" class="content-area container">
    <main id="main" class="site-main" role="main">
        <?php while ( have_posts() ) : the_post();?>
            <div>
                <?php if( has_post_thumbnail( get_the_id() ) ) {
                    the_post_thumbnail('large');
                }
                ?>
            </div>
            <?php the_content(); ?>
        <?php endwhile; wp_reset_postdata();?>
    </main><!-- #main -->
    </div><!-- #primary -->
</div>
<?php wp_footer(); ?>
</body>
</html>
