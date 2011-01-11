<?php
/*
 * Template name: Our experience
 */
get_header(); ?>

	<div class="interior-content">
        <div id="mainColumn" class="wide">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
			<?php endwhile; ?>


            <?php
            query_posts("cat=5&posts_per_page=10&paged=".get_query_var('paged'));
            while(have_posts()) :the_post(); ?>
                <div class="news-story">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                    <span class="date"><?php the_time('F j, Y'); ?> <?php the_category(", "); ?></span>
                    <p><?php excerpt(30) ?></p>
                </div>
            <?php endwhile; ?>
            <?php wp_pagenavi() ?>
		</div>
        <div id="sideColumn"><?php get_sidebar('experience'); ?></div>
	</div>
<?php get_footer(); ?>
