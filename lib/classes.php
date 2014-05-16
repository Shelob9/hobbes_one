<?php


function hobbes_part( $view = null, $data = null, $magic = true, $obj = null, $post_entry = true, $return = true, $cache_mode = 'transient', $expires = false, $key = null ) {

	require_once( 'default_model.php' );
	$default_model = hobbes\default_model::init();

	$part = $default_model->default_model( $view, $data, $magic, $obj, $post_entry, $return, $cache_mode, $expires, $key);

	return $part;

}

function hobbes_do_template( $file, $obj ) {
	if ( class_exists( 'Pods_Frontier' ) ) {
		//@TODO Pods Frontier compatibility
		//$template = ??;
		wp_die( 'Pods Frontier is activated, but Josh didn\'t build compatibility with it yet. Sadly, You must disable Pods Frontier.' );
	}
	if ( file_exists( $file ) ) {
		$view = file_get_contents( $file );
		return Pods_Templates::do_template( $view, $obj );
	}
	else {
		wp_die( $file );
	}
}
