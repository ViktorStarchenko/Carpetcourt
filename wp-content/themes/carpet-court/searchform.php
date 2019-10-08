<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/search/' ) ); ?>">
    <div>
        <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
        <input type="search" value="<?php echo get_search_query(); ?>" name="search" id="s"  placeholder="type keyword(s) here" autocomplete="off" />
        <button type="submit" id="searchsubmit" class="btn-cc btn-cc-red " value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>"><?php echo esc_attr_x( 'Search', 'submit button' ); ?></button>
    </div>
</form>