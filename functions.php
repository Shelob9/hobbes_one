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


add_action( 'init', 'hobbes_pods_check', 1  );
function hobbes_pods_check() {
	if ( ! defined( 'PODS_VERSION' ) ) {

		switch_theme( WP_DEFAULT_THEME );

	}

}

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

if ( defined( 'JP_DEBUG' ) && JP_DEBUG )  {
	include_once( 'lib/jp_debug.php' );
}


