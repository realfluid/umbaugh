<?php get_header(); ?>

	<div class="interior-content">
        <div id="mainColumn">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<?php if ( is_front_page() ) { ?>
					<h2><?php the_title(); ?></h2>
				<?php } else { ?>
					<h1><?php the_title(); ?></h1>
				<?php } ?>
				<?php the_content(); ?>
			<?php endwhile; ?>

		</div>
		<div id="sideColumn">
		<?php get_sidebar(); ?>
		</div>
	</div>
<?php get_footer(); ?>
