<?php
/*
 *Template name: Case Study
 */
get_header(); ?>

	<div class="interior-content">
        <div id="mainColumn" class="wide">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
	howdy
    			<?php the_content(); ?>

			<?php endwhile; ?>
		</div>
        <div id="sideColumn"><?php get_sidebar('experience'); ?></div>
	</div>
<?php get_footer(); ?>