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


class default_markup {


	function __construct() {

		add_action( 'init', array( $this->filtered() ), 1 );

		$hooks = $this->filtered();

		foreach ( $hooks as $hook => $value  ) {
			if ( ! has_action( "hobbes_{$hook}" ) ) {
				add_action( "hobbes_{$hook}", array ( $this, "{$hook}" ) );
			}
		}

		add_action( 'hobbes_main_after', array( $this, 'sidebar' ) );
		add_action( 'hobbes_sidebar_inside_before', array( $this, 'widgets' ) );

	}

	/**
	 * Dynamically create methods
	 *
	 * @param $func
	 * @param $params
	 *
	 * @since 0.0.1
	 */
	function __call( $func, $params){
		if( in_array( $func, array_keys( $this->markup() ) ) ) {
			$out = $this->markup();
			echo $out[ $func ];
		}
	}


	public $top = '<div id="page" class="hfeed site">';
	public $header_before = '<header id="masthead" class="site-header" role="banner">';
	public $header_inside = '';
	public $header_after = '</header><!--#masthead--><div id="content" class="site-content">';
	public $content_before = '<div id="primary" class="content-area">';
	public $main_before = '<main id="main" class="site-main" role="main">';
	public $loop_before = '';
	public $post_before = '<div class="post-entry">';
	public $post_after = '</div><!--.post-entry-->';
	public $loop_after = '';
	public $main_after = '</div><!--#main-->';
	public $sidebar_before = '<div id="secondary" class="widget-area" role="complementary">';
	public $sidebar_inside_before = '';
	public $sidebar_inside_after = '';
	public $sidebar_after = '</div><!--#secondary-->';
	public $content_after = '</div><!--#primary-->';
	public $footer_top = '</div><!--#content-->';
	public $footer_before = '<footer id="colophon" class="site-footer" role="contentinfo">';
	public $footer_inside = '<div class="site-info">';
	public $footer_after = '</div><!--.site-info--></footer><!-- #colophon --></div><!-- #page -->';
	public $foot = '';

	/**
	 * Put all variables in an array
	 *
	 * @return array
	 */
	function markup() {

		return (array) $this;

	}

	/**
	 * Run $this->markup() Through filter and return.
	 *
	 * @return array
	 *
	 * @since 0.0.1
	 */
	public function filtered() {
		/**
		 * Filter to override default markup.
		 *
		 * Use this filter to change default markup, or extend this class to change variables, or hook any action that this class uses.
		 *
		 * @since 0.0.1
		 */
		$markup = apply_filters( 'hobbes_default_markup', $this->markup() );

		return $markup;

	}

	public function sidebar() {

		echo hobbes_get_sidebar();

	}

	public function widgets() {

		echo dynamic_sidebar( 'sidebar-1' );

	}
	
	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.0.1
	 * @access private
	 * @var    object
	 */
	private static $instance;

	
	/**
	 * Returns the instance.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return object
	 */
	public static function init() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

} 
