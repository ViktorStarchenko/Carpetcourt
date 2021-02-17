<?php
$wp_tz = get_option('timezone_string');
$tz_obj = new DateTimeZone($wp_tz);
$time_now = new DateTime("now", $tz_obj);
$time_now = $time_now->format("r");
?>

<div class="section-hero">
    <?php if (!empty($data['items'])) : ?>
    <div class="carousel-wrap cursor">
        <div class="carousel-slider">
            <?php foreach ($data['items'] as $item) : ?>
            <?php
            $slideUrl = $item['link']['url'];
            if(empty($slideUrl)) {
                $slideUrl = "/manufacturers-clearance-sale/";
            }

            $tag = 'a';
            $urlHtml = 'href="'.$slideUrl.'"';
            $flag = false;
            if (!empty($item['title'])) {
                $tag = 'div';
                $flag = true;
            }

            $bg = "";
            $bgMobile = "";
            if (!empty($item['image'])) {
                $bg = $item['image']['url'];
                $bgMobile = $bg;
            }

            if (!empty($item['image_small'])) {
                $bgMobile = $item['image_small']['url'];
            }

            $start_date_set = false;
            $end_date_set = false;
            $started = false;
            $ended = false;

            if (!empty($item['active_from'])) {
                $start_date_set = true;
                $started = $item['active_from'] < $time_now;
            }

            if (!empty($item['active_till'])) {
                $end_date_set = true;
                $ended = $item['active_till'] < $time_now;
            }
            ?>
            <?php if (($start_date_set && $started) || !$start_date_set ) :?>
            <?php if (($end_date_set && !$ended) || !$end_date_set ) :?>
            <<?= $tag ?> <?= $urlHtml ?> target="<?= $item['link']['target'] ?>" class="slide">
            <div>
                <?php if (!empty($bg)) : ?>
                    <img src="<?= $bg ?>" class="slide-image hidden-xs-max">
                <?php endif; ?>
                <?php if (!empty($bgMobile)) : ?>
                    <img src="<?= $bgMobile ?>" class="slide-image hidden-sm-min">
                <?php endif; ?>
                <div class="slide-info-container">
                    <?php if (!empty($item['subtitle'])) : ?>
                        <div class="slide-subtitle-container">
                            <p class="slide-subtitle"><?= $item['subtitle'] ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($item['title'])) : ?>
                        <div class="slide-title-container">
                            <p class="slide-title"><?= $item['title'] ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($item['link']) && $flag) : ?>
                        <div class="slide-link-container">
                            <a href="<?= $item['link']['url'] ?>" class="slide-link"><?= $item['link']['title'] ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </<?= $tag ?>>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="carousel-nav">
        <button type="button" class="btn btn-prev ic-nav-prev"></button>
        <button type="button" class="btn btn-next ic-nav-next"></button>
    </div>
    <div class="carousel-dots"></div>
</div>
<?php endif; ?>
</div>
