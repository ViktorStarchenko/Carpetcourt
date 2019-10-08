<li class="result clearfix" id="post-<?php echo $posts['ID']; ?>">
    <?php
    if( has_post_thumbnail( $posts['ID'] ) ):
        ?>
    <div class="result-picture">
        <a href="<?php echo esc_url( get_permalink($posts['ID']) ); ?>" rel="bookmark">
            <?php
            echo get_the_post_thumbnail( $posts['ID'], 'shop_catalog');
            ?>
        </a>
    </div>
    <?php
    endif;
    ?>
    <div class="result-title">
        <a href="<?php echo esc_url( get_permalink($posts['ID']) ); ?>" rel="bookmark"><?php echo $posts['post_title']; ?></a>
    </div>
    <div class="result-snippet">
        <?php echo cc_strip_excerpt( $posts['post_excerpt'], $posts['ID'], 20, true); ?>
    </div>
</li>