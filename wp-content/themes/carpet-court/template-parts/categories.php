<div class="section-category">
    <div class="container">
        <div class="s-heading">
            <div class="s-heading__part">
                <?php if (!empty($data['title'])) : ?>
                <div class="h2 s-title"><?= $data['title'] ?></div>
                <?php endif; ?>
            </div>
            <?php if (!empty($data['link'])) : ?>
            <div class="s-heading__part">
                <a href="<?= $data['link']['url'] ?>" class="btn btn-index btn--grey" target="<?= $data['link']['target'] ?>"><?= $data['link']['title'] ?></a>
            </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($data['items'])) : ?>
        <div class="s-list js-card-wrapper">
            <?php foreach ( $data['items'] as $item ) : ?>
            <?php if (!empty($item['category'])) : ?>
                <div class="list-item">
                    <?php
                        $image = '';
                        if (!empty($item['image'])) {
                            $image = $item['image']['url'];
                        }
                    ?>
                    <a href="<?= $item['category']['url'] ?>" style="background-image: url(<?= $image ?>)" class="card">
                        <div class="card-label">
                            <div class="card-label__part">
                                <div class="card-title"><?= $item['category']['title'] ?></div>
                            </div>
                            <?php if (!empty($item['cta'])) : ?>
                            <div class="card-label__part">
                                <div class="card-link"><?= $item['cta'] ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="s-list-simple">
            <?php foreach ( $data['items'] as $item ) : ?>
                <?php if (!empty($item['category'])) : ?>
                    <div class="list-item"><a href="<?= $item['category']['url'] ?>"><?= $item['category']['title'] ?></a></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>