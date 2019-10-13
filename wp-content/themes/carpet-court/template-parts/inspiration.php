<div class="section-inspiration">
    <div class="container">
        <div class="s-wrap">
            <div class="s-heading">
                <div class="s-heading__part">
                    <?php if (!empty($data['title'])) : ?>
                    <div class="h2 s-title"><?= $data['title'] ?></div>
                    <?php endif; ?>
                    <?php if (!empty($data['description'])) : ?>
                    <div class="s-text"><?= $data['description'] ?></div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($data['link'])) : ?>
                <div class="s-heading__part">
                    <a href="<?= $data['link']['url'] ?>" target="<?= $data['link']['target'] ?>" class="btn btn-index btn--grey"><?= $data['link']['title'] ?></a>
                </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($data['items'])) : ?>
            <div class="s-list js-card-wrapper">
                <?php foreach ($data['items'] as $item) : ?>
                <?php if (!empty($item['link'])) : ?>
                <div class="list-item">
                    <?php
                        $image = '';
                        if (!empty($item['image'])) {
                            $image = $item['image']['url'];
                        }
                    ?>
                    <a href="<?= $item['link']['url'] ?>" target="<?= $item['link']['target'] ?>" style="background-image: url(<?= $image ?>)" class="card">
                        <div class="card-label">
                            <div class="card-label__part">
                                <?php if (!empty($item['title'])) : ?>
                                <div class="card-title"><?= $item['title'] ?></div>
                                <?php endif; ?>
                                <?php if (!empty($item['description'])) : ?>
                                <div class="card-subtitle"><?= $item['description'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="card-label__part">
                                <div class="card-link"><?= $item['link']['title'] ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>