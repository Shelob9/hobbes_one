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


