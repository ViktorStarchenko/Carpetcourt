<div class="section-hero">
    <?php if (!empty($data['items'])) : ?>
    <div class="carousel-wrap cursor">
        <div class="carousel-slider">
            <?php foreach ($data['items'] as $item) : ?>
            <a href="<?= $item['link']['url'] ?>" target="<?= $item['link']['target'] ?>" class="slide">
                <?php if (!empty($item['image'])) : ?>
                <img src="<?= $item['image']['url'] ?>" class="slide-image hidden-xs-max">
                <?php endif; ?>
                <?php if (!empty($item['image_small'])) : ?>
                <img src="<?= $item['image_small']['url'] ?>" class="slide-image hidden-sm-min">
                <?php endif; ?>
            </a>
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