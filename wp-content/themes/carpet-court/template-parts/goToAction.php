<div class="section-come">
    <div class="container">
        <div class="s-wrap">
            <?php if (!empty($data['title'])) : ?>
            <div class="h2 s-title"><?= $data['title'] ?></div>
            <?php endif; ?>
            <?php if (!empty($data['description'])) : ?>
            <div class="s-text"><?= $data['description'] ?></div>
            <?php endif; ?>
            <?php if (!empty($data['buttons'])) : ?>
            <div class="s-buttons">
                <?php foreach ($data['buttons'] as $button) : ?>
                    <?php if (!empty($button['link']['url'])) : ?>
                    <a href="<?= $button['link']['url'] ?>" target="<?= $button['link']['target'] ?>" class="btn"><?= $button['link']['title'] ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>