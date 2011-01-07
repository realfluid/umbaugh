<?php get_header(); ?>
	<div class="interior-content">
        <div id="mainColumn">
			<h1><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<div class="wide" id="news">
				<?php if(have_posts()) : ?>
					<?php while(have_posts()) :the_post(); ?>
						<div class="news-story">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
							<span class="date"><?php the_time('F j, Y'); ?> <?php the_category(", "); ?></span>
							<p><?php excerpt(30) ?></p>
						</div>
					<?php endwhile; ?>
					<?php wp_pagenavi() ?>
				<?php else : ?>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<div id="sideColumn">
		<?php get_sidebar(); ?>
		</div>
	</div>
<?php get_footer(); ?>
