<?php
get_header(); ?>

<div class="interior-content">
    <div id="mainColumn">
		<h1>Latest News</h1>
		<div class="wide" id="news">
		<?php while(have_posts()) :the_post(); ?>
			<div class="news-story">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
				<span class="date"><?php the_time('F j, Y'); ?> <?php the_category(", "); ?></span>
				<p><?php excerpt(30) ?></p>
			</div>
		<?php endwhile; ?>
		<?php wp_pagenavi() ?>
		</div>
	</div>
	<div id="sideColumn">
	<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>
