<div class="media-group">
<?php if (!empty($atts)) : ?>
    <?php foreach ($atts as $item) : ?>
        <div class="media-item">
            <?php
                $data = explode("~", $item);
            ?>
            <?php if (!empty($data[0])) : ?>
            <div class="media-item-img">
                <img src="<?= $data[0] ?>">
            </div>
            <?php endif; ?>
            <?php if (!empty($data[1])) : ?>
                <div class="media-item-description"><?= $data[1] ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
