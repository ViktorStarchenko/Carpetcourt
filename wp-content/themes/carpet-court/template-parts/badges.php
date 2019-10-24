<div class="section-badges">
    <div class="container">
        <?php if (!empty($data['items'])) : ?>
        <div class="s-list">
            <?php foreach ($data['items'] as $item) : ?>
            <?php $href = ''; ?>
            <?php if (!empty($item['link'])) : ?>
            <?php $href = ' href="'.$item['link']['url'].'" style="text-decoration: none"'; ?>
            <?php endif; ?>
            <a <?= $href; ?> class="list-item">
                <?php if (!empty($item['image'])) : ?>
                <div class="item-image">
                    <img src="<?= $item['image']['url'] ?>">
                </div>
                <?php endif; ?>
                <?php if (!empty($item['title'])) : ?>
                <div class="item-text"><?= $item['title'] ?></div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>