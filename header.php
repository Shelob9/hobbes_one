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

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
	<title><?php //hobbes_title(); ?></title>
	<?php //hobbes_meta(); ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
	<?php wp_head(); ?>
	<?php hobbes_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	hobbes_top();

		hobbes_header_before();

			hobbes_header_inside();

		hobbes_header_after();
?>
