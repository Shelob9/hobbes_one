<?php
/**
 * Main index
 *
 * @package   @hobbes
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

get_header();

hobbes_content_before();

hobbes_main_before();

hobbes_loop_before();

echo hobbes_part(  );

hobbes_loop_after();

hobbes_main_after();

hobbes_content_after();


get_footer();


