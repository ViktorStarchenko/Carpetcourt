<li class=" neeraj2cpm-parent " data-slug="<?php echo $single->slug; ?>">
    <div class="ms-checkbox cpm-checkbox">

    <input type="checkbox" name="<?php echo $taxonomy.'[]'; ?>"  class="filter-checkbox-btn <?php echo $taxonomy ?> cpm_hide" id="term_<?php echo $single->term_id ?>" data-taxonomy="<?php echo $taxonomy ?>" value="<?php echo $single->term_id ?>" data-term="<?php echo $single->slug; ?>" <?php echo $checked;?> />
    <span class="box"></span>
    <label for="term_<?php echo $single->term_id ?>" class="checkbox-custom-label"><span><?php echo $single->name ?></span></label>
    </div>

</li>