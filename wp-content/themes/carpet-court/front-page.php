<?php get_header() ?>
<?php
/*
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        the_content();
    }
}
*/
?>
<?php
    $arg = [
        'id' => get_the_ID()
    ];

    // hero section
    $hero = get_field('hero', $arg['id']);
    if (!empty($hero)) {
        if (!empty($hero['enable'])) {
            echo template_part('hero', $hero);
        }
    }

    // category section
    $categories = get_field('categories', $arg['id']);
    if (!empty($categories)) {
        if (!empty($categories['enable'])) {
            echo template_part('categories', $categories);
        }
    }

    // go to action section
    $goToAction = get_field('go_to_action', $arg['id']);
    if (!empty($goToAction)) {
        if (!empty($goToAction['enable'])) {
            echo template_part('goToAction', $goToAction);
        }
    }

    // blog section
    $blog = get_field('blog', $arg['id']);
    if (!empty($blog)) {
        if (!empty($blog['enable'])) {
            echo template_part('inspiration', $blog);
        }
    }

    // badges section
    $badges = get_field('badges', $arg['id']);
    if (!empty($badges)) {
        if (!empty($badges['enable'])) {
            echo template_part('badges', $badges);
        }
    }

    // story section
    $story = get_field('story', $arg['id']);
    if (!empty($story)) {
        if (!empty($story['enable'])) {
            echo template_part('story', $story);
        }
    }
?>
<?php get_footer() ?>