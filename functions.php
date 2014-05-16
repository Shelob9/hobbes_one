<?php
/**
 * Main functions file
 *
 * @package   hobbes
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

/**
 * Switch to default theme if Pods is not active
 *
 * @since 0.0.1
 */
add_action( 'init', 'hobbes_pods_check', 1  );
function hobbes_pods_check() {
	if ( ! defined( 'PODS_VERSION' ) ) {

		switch_theme( WP_DEFAULT_THEME );

	}

}

/**
 * Include core functions/ classes
 *
 * @since 0.0.1
 */
add_action( 'init', 'hobbes_core' );
function hobbes_core() {

	$files = array(

		'default_model',
		'contextual_hooks',
		'default_markup',
		//'customizer_css',
		'classes',
	);


	$files = apply_filters( 'hobbes_core_files', $files );
	foreach ( $files as $file ) {
		include_once( 'lib/'.$file.'.php' );
	}

	//@TODO AUTOLOADER! The filter will bust this bad.
	if ( !is_admin() ) {

		$GLOBALS[ 'default_markup' ] = \hobbes\default_markup::init();
	}

	//Stargazer_Custom_Colors::get_instance();
}

/**
 * Set "s_mode" to true, if not defined and include theme setup/ template tags form _s if it is true
 *
 * @since 0.0.1
 */
if ( ! defined( 'HOBBES_S_MODE' ) ) {
	define( 'HOBBES_S_MODE', true );
}

//@TODO Think this through a bit.
if ( ! defined( 'HOBBES_S_SCRIPTS' ) ) {
	define( 'HOBBES_S_SCRIPTS', false );
}

if ( HOBBES_S_MODE ) {
	include_once( 'lib/theme_setup/setup.php' );
}

/**
 * Josh's debug stuff
 *
 * @since 0.0.1
 */
if ( defined( 'JP_DEBUG' ) && JP_DEBUG )  {
	include_once( 'lib/jp_debug.php' );
}

if ( ! function_exists( 'hobbes_get_sidebar' ) ) :
	/**
	 * Sidebar function
	 *
	 * @since 0.0.1
	 */
	function hobbes_get_sidebar( $name = null ) {
		/**
		 * Filter to override which sidebar we are using.
		 *
		 * @see https://core.trac.wordpress.org/ticket/26636
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'hobbes_get_sidebar', $name );
		$view = trailingslashit( hobbes_default_model()->primary_view_dir() ) . $name . '.php';

		/**
		 * Filter to prevent sidebar
		 *
		 * @param bool
		 *
		 * @since 0.0.1
		 */
		if ( apply_filters( 'hobbes_no_sidebar', FALSE ) === FALSE ) {

			if (!  file_exists( $view ) ) {
				$view = get_sidebar( $name );
			}

			pods_view( $view, DAY_IN_SECONDS, 'transient'  );

		}

	}
endif;

if ( ! function_exists( 'hobbes_get_header' ) ) :
	/**
	 * Header function
	 *
	 * @param 	string	$name	Name of header.
	 *
	 * @return	string			The header.
	 *
	 * @since 	0.0.1
	 */
	function hobbes_get_header( $name = null ) {
		/**
		 * Override which header is returned;
		 *
		 * @param string $name Name of header.
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'hobbes_get_header', $name );
		pods_view( get_header( $name ), DAY_IN_SECONDS, 'transient' );
	}
endif;

if ( ! function_exists( 'hobbes_get_footer' ) ) :
	/**
	 * footer function
	 *
	 * @param 	string	$name	Name of footer.
	 *
	 * @return	string			The footer.
	 *
	 * @since 	0.0.1
	 */
	function hobbes_get_footer( $name = null ) {
		/**
		 * Override which footer is returned;
		 *
		 * @param string $name Name of footer.
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'hobbes_get_footer', $name );
		pods_view( get_footer( $name ), DAY_IN_SECONDS, 'transient' );
	}
endif;

/**
 * Delete all transients set by theme
 *
 * @since 0.0.1
 */
if ( WP_DEBUG ) {
	add_action( 'init', 'hobbes_cache_clear' );
}
function hobbes_cache_clear() {
	$modes = array( 'transient', 'site_transient', 'cache' );
	foreach ( $modes as $cache_mode  ) {
		pods_view_clear( TRUE, $cache_mode, 'hobbes' );
	}
}

/**
 * Add admin bar link to reset cache
 *
 * @since 0.0.1
 */
add_action( 'admin_bar_menu', array( $this, 'hobbes_toolbar_cache_reset')  );
function hobbes_toolbar_cache_reset( $wp_admin_bar ) {
	$message = 'Clear '.apply_filters( 'hobbes_theme_name', 'Hobbes' ).' Cache';
	$args = array(
		'id'    => 'hobbes_cache_clear',
		'title' => __( $message, 'hobbes'),
		'href'  => site_url( '?hobbes-clear-cache' ),
		'meta'  => ''
	);
	$wp_admin_bar->add_node( $args );
}

/**
 * Action to clear cache, when clear cache link is clicked.
 *
 * @since 0.0.1
 */
add_action( 'init', 'hobbes_cache_Clear_action' );
function hobbes_cache_clear_action() {
	$action = pods_v( 'hobbes-clear-cache', 'get', false, true );
	if ( $action ) {
		hobbes_cache_clear();

	}

}
