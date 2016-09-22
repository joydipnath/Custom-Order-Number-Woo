<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}
/*
* Adding suffix and prefix to the order number
*/
function customize_order( $order_number, $post ) {
	global $wpdb,$post;
	$c_suffix_A =  get_option('suf_order_A');
	$c_prefix_A =  get_option('pre_order_A');
        $order_number = $c_prefix_A.$order_number.$c_suffix_A ;
	return $order_number;
}
/*
* Maintaining the order number in a sequence
*/
function maintain_sequence_order_number( $post_id, $post ) {
		global $wpdb,$post;

		if ( 'shop_order' === $post->post_type && 'auto-draft' !== $post->post_status ) {

			$order_number = get_post_meta( $post_id, '_order_number', true );

			if ( '' === $order_number ) {
				$success = false;				
				for ( $i = 0; $i < 2 && ! $success; $i++ ) {
					$query = $wpdb->prepare( "
INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) 
SELECT %d, '_order_number', IF( MAX( CAST( meta_value as UNSIGNED ) ) IS NULL, 1, MAX( CAST( meta_value as UNSIGNED ) ) + 1 )
							FROM {$wpdb->postmeta} WHERE meta_key='_order_number'",$post_id );

					$success = $wpdb->query( $query );
				}
			}
		}
		else 
		{
		write_log('Something went wrong near line number: '.__LINE__ );
		}
	}
// write_log('Something went wrong near line number: '.__LINE__ );
?>
