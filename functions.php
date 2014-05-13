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

if ( ! function_exists( 'hobbes_sidebar' ) ) :
	/**
	 * Sidebar function
	 *
	 * @since 0.0.1
	 */
	function hobbes_sidebar( $name = null ) {
		/**
		 * Filter to override which sidebar we are using.
		 *
		 * @see https://core.trac.wordpress.org/ticket/26636
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'hobbes_get_sidebar', $name );
		$view = trailingslashit( HT_DMS_VIEW_DIR ) . $name . '.php';

		/**
		 * Filter to prevent sidebar
		 *
		 * @param bool
		 *
		 * @since 0.0.1
		 */
		if ( apply_filters( 'hobbes_no_sidebar', FALSE ) === FALSE ) {
			if ( file_exists( $view ) ) {
				pods_view( $view, $expires = DAY_IN_SECONDS, $cache_mode = 'cache' );
			}
			else {

				get_sidebar( $name );
			}
		}

	}
endif;

if ( ! function_exists( 'hobbes_header' ) ) :
	/**
	 * Header function
	 *
	 * @param 	string	$name	Name of header.
	 *
	 * @returns	string			The header.
	 *
	 * @since 0.0.1
	 */
	function hobbes_header( $name = null ) {
		/**
		 * Override which header is returned;
		 *
		 * @param string $name Name of header.
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'hobbes_header', $name );
		pods_view( get_header( $name ), $expires = DAY_IN_SECONDS, $cache_mode = 'cache' );
	}
endif;

if ( ! function_exists( 'hobbes_footer' ) ) :
	/**
	 * footer function
	 *
	 * @param 	string	$name	Name of footer.
	 *
	 * @returns	string			The footer.
	 *
	 * @since 0.0.1
	 */
	function hobbes_footer( $name = null ) {
		/**
		 * Override which footer is returned;
		 *
		 * @param string $name Name of footer.
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'hobbes_footer', $name );
		pods_view( get_footer( $name ), $expires = DAY_IN_SECONDS, $cache_mode = 'cache' );
	}
endif;


