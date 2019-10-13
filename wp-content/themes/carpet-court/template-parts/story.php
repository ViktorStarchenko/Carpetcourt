<div class="section-story">
    <div class="container">
        <div class="row">
            <?php if (!empty($data['title'])) : ?>
            <div class="col-md-4 col-lg-3">
                <div class="s-title"><?= $data['title'] ?></div>
            </div>
            <?php endif; ?>
            <?php if (!empty($data['description'])) : ?>
            <div class="col-md-8 col-lg-9">
                <?= $data['description'] ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>