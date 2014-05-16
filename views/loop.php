
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<a href="<?php echo get_permalink( $obj->id() ); ?>">{@post_title}</a>

		
			<div class="entry-meta">
				
			</div><!-- .entry-meta -->
		
	</header><!-- .entry-header -->

	
		<div class="entry-content">
			{@post_excerpt}
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'hobbes' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'hoobbes' ), __( '1 Comment', 'hoobbes' ), __( '% Comments', 'hoobbes' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'hoobbes' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
