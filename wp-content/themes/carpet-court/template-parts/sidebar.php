<?php $footer = get_field('footer', 'option'); ?>
<div class="assistance-box">
<?php if (!empty($footer['contact_title'])) : ?>
    <div class="assistance-box__title"><?= $footer['contact_title'] ?></div>
<?php endif; ?>
<?php if (!empty($footer['side_bar_description'])) : ?>
    <div class="assistance-box__text"><?= $footer['side_bar_description'] ?></div>
<?php endif; ?>
<?php if (!empty($footer['contacts'])) : ?>
    <div class="assistance-box__list">
        <?php foreach ($footer['contacts'] as $contact) : ?>
            <div class="list-item">
                <?php
                    $url = '';
                    if (!empty($contact['url'])) {
                        $url = ' href="'.$contact['url'].'"  ';
                    }
                ?>
                <a <?= $url ?> class="<?= $contact['type'] ?>"><?= $contact['title'] ?></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>