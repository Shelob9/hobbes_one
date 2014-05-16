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

namespace hobbes;

class default_model {


	/**
	 * Initializes the class
	 *
	 *
	 * @since 0.0.1
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new default_model();
		}

		return $instance;
	}

	function default_model( $view = null, $data = null, $magic = true, $obj = null, $post_entry = true, $return = true, $cache_mode = 'transient', $expires = DAY_IN_SECONDS, $key = null ) {

		global $post;

		//@TODO Better way of handling this.
		$id = 0;
		if ( is_object( $post ) ) {
			$id = $post->ID;
		}

		if ( is_null( $view ) ) {

			$view = $this->view_loader( $view );

		}

		//build Pods Object
		if ( is_null( $obj ) && $obj !== false ) {
			$obj = pods( get_post_type( $id ), $id );
		}

		//if $magic try and returned cached value else do magic and cache
		if ( $magic ) {

			if ( is_null( $key ) ) {
				$key = str_replace( '.php', '', $view ) . '_' . $id;
				$key = 'hobbes_part_'.$key;
			}

			$before = apply_filters( 'foo_before_part', '', $obj, $key );
			$before .= apply_filters( 'foo_before_magic_part', '', $obj, $key );
			if ( $post_entry ) {
				$before .= hobbes_post_before();
			}

			//should be theme_slug
			$group = 'hobbes_parts';


			if ( $cache_mode !== false ) {
				$part = pods_view_get( $key, $cache_mode, $group, NULL );
				//if we have a cached value, return.
				if ( is_string( $part ) && $part != '' ) {
					return $part;
				}
			}


			$value = hobbes_do_template(  $view  , $obj );

			pods_view_set( $key, $value, $expires, $cache_mode, $group );

			$after = apply_filters( 'foo_after_part', '', $obj, $key );
			$after .= apply_filters( 'foo_after_magic_part', '', $obj, $key );
			if ( $post_entry ) {
				$after .= hobbes_post_after();
			}

			$part = $before.$value.$after;

			return $part;
		}
		else {
			if ( is_null( $data ) ) {
				$data = compact( array_keys( get_defined_vars() ) );
			}

			$before = apply_filters( 'foo_before_part', '', $obj, $key );

			$part = pods_view( $this->view_loader( $view ),  $data, $expires, $cache_mode, $return );

			$after = apply_filters( 'foo_after_part', '', $obj, $key );

			$part = $before.$part.$after;

			return $part;
		}


	}


	function context() {
		return hobbes_get_query_context();
	}

	function primary_view_dir() {
		$view_dir = apply_filters( 'hobbes_primary_view_dir', trailingslashit( get_stylesheet_directory() ) .'views/' );

		return $view_dir;
	}

	function view_loader( $file_name ) {
		$contexts = $this->context();

		foreach ( $contexts as $context  ) {
			$context = $context.'.php';
			if ( file_exists( trailingslashit( $this->primary_view_dir() ) . $context ) ) {
				return trailingslashit( $this->primary_view_dir() ) . $context;
			}
			elseif ( file_exists( trailingslashit( get_stylesheet_directory() ) ) . 'views/' . $context ) {
				return  trailingslashit( get_stylesheet_directory() )  . 'views/' . $context;
			}
			elseif ( file_exists( trailingslashit( $this->primary_view_dir() ) . 'loop.php' ) ) {
				return trailingslashit( $this->primary_view_dir() ) . 'loop.php';
			}
			elseif ( file_exists( trailingslashit( get_stylesheet_directory() ) ) . 'view/loop.php' ) {
				return  trailingslashit( get_stylesheet_directory() ) . 'views/loop.php';
			}
			else {

			}
		}

		$view = trailingslashit( $this->primary_view_dir() ) .'loop.php';

		return $view;



	}

} 
