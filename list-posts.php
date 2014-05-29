<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h1>
	</header><!-- .entry-header -->

	<div class="entry-meta">
		<h5><?php the_time('d. F Y'); ?></h5>
	</div><!-- .entry-meta -->

	<div class="entry-summary">
		<?php if(has_post_thumbnail()) smart_img('', 'type=thumbnail&class=alignleft&width=250&height=180'); ?>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<div class="entry-readmore">
		<a href="<?php the_permalink(); ?>"><?php _e('Read more...', 'smart'); ?></a>
		<?php smart_clear(); ?>
	</div>
	<hr />
</article><!-- #post-## -->