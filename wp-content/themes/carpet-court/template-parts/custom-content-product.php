<li class="result clearfix" id="post-<?php echo $posts['ID']; ?>">
    <?php if( has_post_thumbnail( $posts['ID'] ) ): ?>
        <div class="result-picture">
            <a href="<?php echo esc_url( get_permalink($posts['ID']) ); ?>" rel="bookmark">
                <?php
                echo get_the_post_thumbnail( $posts['ID'], 'shop_catalog');
                ?>
            </a>
        </div>
    <?php else: ?>
        <?php
            $img = "";
            $alt = $posts['post_title'];
            $imgSwatch = get_field('swatch_image', $posts['ID']);
            $imgRoom = get_field('featured_image', $posts['ID']);

            if (!empty($imgSwatch['url'])) {
                $img = $imgSwatch['url'];
                if (!empty($imgSwatch['alt'])) {
                    $alt = $imgSwatch['alt'];
                }
            } else {
                $img = $imgRoom;
            }
        ?>
        <?php if (!empty($img)) : ?>
            <div class="result-picture">
                <a href="<?= esc_url( get_permalink($posts['ID']) ); ?>" rel="bookmark">
                    <img src="<?= $img; ?>" alt="<?= $alt ?>" />
                </a>
            </div>
        <?php endif; ?>
    <?php endif;  ?>
    <div class="result-title">
        <a href="<?= esc_url( get_permalink($posts['ID']) ); ?>" rel="bookmark"><?= $posts['post_title']; ?></a>
    </div>
    <div class="result-snippet">
        <?= cc_strip_excerpt( $posts['post_excerpt'], $posts['ID'], 20, true); ?>
    </div>
</li>