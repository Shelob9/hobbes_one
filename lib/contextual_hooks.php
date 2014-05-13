<?php

// header.php
function hobbes_head() { hobbes_do_atomic( 'hobbes_head' ); }					
function hobbes_top() { hobbes_do_atomic( 'hobbes_top' ); }					
function hobbes_header_before() { hobbes_do_atomic( 'hobbes_header_before' ); }			
function hobbes_header_inside() { hobbes_do_atomic( 'hobbes_header_inside' ); }				
function hobbes_header_after() { hobbes_do_atomic( 'hobbes_header_after' ); }			
function hobbes_nav_before() { hobbes_do_atomic( 'hobbes_nav_before' ); }					
function hobbes_nav_inside() { hobbes_do_atomic( 'hobbes_nav_inside' ); }					
function hobbes_nav_after() { hobbes_do_atomic( 'hobbes_nav_after' ); }		

// Template files: 404, archive, single, page, sidebar, index, search
function hobbes_content_before() { hobbes_do_atomic( 'hobbes_content_before' ); }					
function hobbes_content_after() { hobbes_do_atomic( 'hobbes_content_after' ); }					
function hobbes_main_before() { hobbes_do_atomic( 'hobbes_main_before' ); }					
function hobbes_main_after() { hobbes_do_atomic( 'hobbes_main_after' ); }					
function hobbes_post_before() { hobbes_do_atomic( 'hobbes_post_before' ); }					
function hobbes_post_after() { hobbes_do_atomic( 'hobbes_post_after' ); }					
function hobbes_post_inside_before() { hobbes_do_atomic( 'hobbes_post_inside_before' ); }					
function hobbes_post_inside_after() { hobbes_do_atomic( 'hobbes_post_inside_after' ); }	
function hobbes_loop_before() { hobbes_do_atomic( 'hobbes_loop_before' ); }	
function hobbes_loop_after() { hobbes_do_atomic( 'hobbes_loop_after' ); }	

// Sidebar
function hobbes_sidebar_before() { hobbes_do_atomic( 'hobbes_sidebar_before' ); }					
function hobbes_sidebar_inside_before() { hobbes_do_atomic( 'hobbes_sidebar_inside_before' ); }					
function hobbes_sidebar_inside_after() { hobbes_do_atomic( 'hobbes_sidebar_inside_after' ); }					
function hobbes_sidebar_after() { hobbes_do_atomic( 'hobbes_sidebar_after' ); }					

// footer.php
function hobbes_footer_top() { hobbes_do_atomic( 'hobbes_footer_top' ); }					
function hobbes_footer_before() { hobbes_do_atomic( 'hobbes_footer_before' ); }					
function hobbes_footer_inside() { hobbes_do_atomic( 'hobbes_footer_inside' ); }					
function hobbes_footer_after() { hobbes_do_atomic( 'hobbes_footer_after' ); }	
function hobbes_foot() { hobbes_do_atomic( 'hobbes_foot' ); }					

if ( ! function_exists( 'hobbes_do_atomic' ) ) {
	/**
	 * hobbes_do_atomic()
	 *
	 * Adds contextual action hooks to the theme.  This allows users to easily add context-based content
	 * without having to know how to use WordPress conditional tags.  The theme handles the logic.
	 *
	 * An example of a basic hook would be 'hobbes_head'.  The hobbes_do_atomic() function extends that to
	 * give extra hooks such as 'hobbes_head_home', 'hobbes_head_singular', and 'hobbes_head_singular-page'.
	 *
	 * Major props to Ptah Dunbar for the do_atomic() function.
	 * @link http://ptahdunbar.com/wordpress/smarter-hooks-context-sensitive-hooks
	 *
	 * @since 0.0.1
	 * @uses hobbes_get_query_context() Gets the context of the current page.
	 * @param string $tag Usually the location of the hook but defines what the base hook is.
	 */
	function hobbes_do_atomic( $tag = '', $args = '' ) {
		if ( !$tag ) return false;

		/* Do actions on the basic hook. */
		do_action( $tag, $args );
		/* Loop through context array and fire actions on a contextual scale. */
		foreach ( (array) hobbes_get_query_context() as $context )
			do_action( "{$tag}_{$context}", $args );
	} // End hobbes_do_atomic()
}

if ( ! function_exists( 'hobbes_apply_atomic' ) ) {
	/**
	 * hobbes_apply_atomic()
	 *
	 * Adds contextual filter hooks to the theme.  This allows users to easily filter context-based content
	 * without having to know how to use WordPress conditional tags. The theme handles the logic.
	 *
	 * An example of a basic hook would be 'hobbes_entry_meta'.  The hobbes_apply_atomic() function extends
	 * that to give extra hooks such as 'hobbes_entry_meta_home', 'hobbes_entry_meta_singular' and 'hobbes_entry_meta_singular-page'.
	 *
	 * @since 0.0.1
	 * @uses hobbes_get_query_context() Gets the context of the current page.
	 * @param string $tag Usually the location of the hook but defines what the base hook is.
	 * @param mixed $value The value to be filtered.
	 * @return mixed $value The value after it has been filtered.
	 */
	function hobbes_apply_atomic( $tag = '', $value = '' ) {
		if ( ! $tag ) return false;
		/* Get theme prefix. */
		$pre = 'hobbes';
		/* Apply filters on the basic hook. */
		$value = apply_filters( "{$pre}_{$tag}", $value );
		/* Loop through context array and apply filters on a contextual scale. */
		foreach ( (array)hobbes_get_query_context() as $context )
			$value = apply_filters( "{$pre}_{$context}_{$tag}", $value );
		/* Return the final value once all filters have been applied. */
		return $value;
	} // End hobbes_apply_atomic()
}

if ( ! function_exists( 'hobbes_get_query_context' ) ) {
	/**
	 * hobbes_get_query_context()
	 *
	 * Retrieve the context of the queried template.
	 *
	 * @since 0.0.1
	 * @return array $query_context
	 */
	function hobbes_get_query_context() {
		global $wp_query, $query_context;

		/* If $query_context->context has been set, don't run through the conditionals again. Just return the variable. */
		if ( is_object( $query_context ) && isset( $query_context->context ) && is_array( $query_context->context ) ) {
			return $query_context->context;
		}

		unset( $query_context );
		$query_context = new stdClass();
		$query_context->context = array();

		/* Front page of the site. */
		if ( is_front_page() ) {
			$query_context->context[] = 'home';
		}

		/* Blog page. */
		if ( is_home() && ! is_front_page() ) {
			$query_context->context[] = 'blog';

			/* Singular views. */
		} elseif ( is_singular() ) {
			$query_context->context[] = 'singular';
			$query_context->context[] = "singular-{$wp_query->post->post_type}";

			/* Page Templates. */
			if ( is_page_template() ) {
				$to_skip = array( 'page', 'post' );

				$page_template = basename( get_page_template() );
				$page_template = str_replace( '.php', '', $page_template );
				$page_template = str_replace( '.', '-', $page_template );

				if ( $page_template && ! in_array( $page_template, $to_skip ) ) {
					$query_context->context[] = $page_template;
				}
			}

			$query_context->context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";
		}

		/* Archive views. */
		elseif ( is_archive() ) {
			$query_context->context[] = 'archive';

			/* Taxonomy archives. */
			if ( is_tax() || is_category() || is_tag() ) {
				$term = $wp_query->get_queried_object();
				$query_context->context[] = 'taxonomy';
				$query_context->context[] = $term->taxonomy;
				$query_context->context[] = "{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
			}

			/* User/author archives. */
			elseif ( is_author() ) {
				$query_context->context[] = 'user';
				$query_context->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
			}

			/* Time/Date archives. */
			else {
				if ( is_date() ) {
					$query_context->context[] = 'date';
					if ( is_year() )
						$query_context->context[] = 'year';
					if ( is_month() )
						$query_context->context[] = 'month';
					if ( get_query_var( 'w' ) )
						$query_context->context[] = 'week';
					if ( is_day() )
						$query_context->context[] = 'day';
				}
				if ( is_time() ) {
					$query_context->context[] = 'time';
					if ( get_query_var( 'hour' ) )
						$query_context->context[] = 'hour';
					if ( get_query_var( 'minute' ) )
						$query_context->context[] = 'minute';
				}
			}
		}

		/* Search results. */
		elseif ( is_search() ) {
			$query_context->context[] = 'search';
			/* Error 404 pages. */
		} elseif ( is_404() ) {
			$query_context->context[] = 'error-404';
		}

		return $query_context->context;
	} // End hobbes_get_query_context()
}
?>