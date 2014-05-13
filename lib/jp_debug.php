<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */


if ( !function_exists( 'print_r2' ) ) :
	function print_r2($val){
		echo '<pre>';
		print_r($val);
		echo  '</pre>';
	}
endif;

if ( !function_exists( 'print_x2') ) :
	function print_x2( $val ) {
		echo '<pre>';
		var_export($val);
		echo  '</pre>';
	}
endif;

if ( !function_exists( 'print_c3' ) ) :
	function print_c3( $val, $r = true  ) {
		if ( !is_null( $val ) && $val !== false ) {
			if ( $r ) {
				print_r2( $val );
			}
			else {
				print_x2( $val );
			}

		}
		else {
			var_dump( $val );
		}
	}
endif;


if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if (  WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
