<?php
class Woo_Custom_Heads {

	private static $instance;

	public static function get_instance() {
		if( null == self::$instance ) {
			self::$instance = new Woo_Custom_Heads();
		}

		return self::$instance;
	}


	private function __construct() {

		/*add_filter( 'manage_product_posts_columns', array($this, 'add_custom_columns') );

		add_action('manage_product_posts_custom_column', array($this, 'custom_column_show_data'), 10, 2 );*/
		
	}


	function add_custom_columns($columns) {	    

	    $columns['delivery'] = __( 'Delivery Type', 'cc_product_filter' );
	    $columns['brand'] = __( 'Brands', 'cc_product_filter' );
	    $columns['feature'] = __( 'Features', 'cc_product_filter' );
	    return $columns;
	}


	public function custom_column_show_data( $column, $post_id) {
		global $post;
		switch( $column ) {
			case 'delivery':
					$terms = get_the_terms( $post_id, 'product_delivery' );
					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'product_delivery' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'product_delivery', 'display' ) )
						);
					}
					echo join( ', ', $out );
				break;
			case 'brand':
					$terms = get_the_terms( $post_id, 'product_brand' );
					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'product_brand' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'product_brand', 'display' ) )
						);
					}
					echo join( ', ', $out );
				break;
			case 'feaure':
					$terms = get_the_terms( $post_id, 'product_feature' );
					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'product_feature' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'product_feature', 'display' ) )
						);
					}
					echo join( ', ', $out );
				break;
		}
	}
}