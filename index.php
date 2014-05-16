<?php
/**
 * Main index -- should be the only template needed.
 *
 * @package   @hobbes
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

hobbes_get_header();

hobbes_content_before();

hobbes_main_before();

hobbes_loop_before();

if ( is_singular() || is_page() ) {
	echo hobbes_part();
}
else {
	if ( have_posts() ) {
		while ( have_posts()  ) {
			the_post( );
			echo hobbes_part();
		}
	}
}

hobbes_loop_after();

hobbes_main_after();

hobbes_content_after();

hobbes_get_footer();
