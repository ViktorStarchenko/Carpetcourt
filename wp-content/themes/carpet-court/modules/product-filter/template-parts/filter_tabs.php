
<span id="showLeft" class="active"><i class="arrow-angle-toogle"></i></span>
<div class="breadcrumb clearfix"></div>


<?php
	$post_type = get_query_var('post_type');
?>

<?php
$args = array(
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'       => 'ASC'
	);
$tags = get_terms( 'product_tag', $args );

if( !empty( $tags ) && $post_type != 'attribute' ) {
	?>
	<div class="tab-filters">
		<ul class="tab-filters-list">
			<li><a href="#" class="tabs <?php echo ( isset($_POST['product_tag']) && $_POST['product_tag'] == "all" )?'tab-active':((!isset($_POST['product_tag']))?'tab-active':'');?>" data-tab="all" >All</a>
			</li>
			<?php
			foreach( $tags as $tag ) {
				?>
				<li><a href="#"  class="tabs <?php echo (isset($_POST['product_tag']) && $_POST['product_tag'][0] == $tag->term_id )?'tab-active':''?>" data-tab="<?php echo $tag->term_id;?>"><?php echo $tag->name?></a>
				</li>
				<?php
			}
			?>
		</ul>
		<div class="cpm-price-blurb">*pricing for m<sup>2</sup></div>
		<input type="hidden" name="tab_filters_list" id="cc_tab_filters_list" value="<?php echo ( isset( $_POST['product_tag'][0] ) && !empty( $_POST['product_tag'][0] ) ) ? $_POST['product_tag'][0] : ''; ?>"></input>

	</div>
	<?php
}