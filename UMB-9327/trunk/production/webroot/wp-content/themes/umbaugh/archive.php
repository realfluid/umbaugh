<?php get_header(); ?>

		<div class="interior-content">
        <div id="mainColumn">

<?php if ( have_posts() ) the_post(); ?>

			<h1 class="page-title">
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date('F Y') ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date('Y') ); ?>
<?php else : ?>
				<?php _e( 'Blog Archives', 'twentyten' ); ?>
<?php endif; ?>
			</h1>

<?php rewind_posts(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	<?php endwhile; ?>

			</div>
<div id="sideColumn"><?php get_sidebar(); ?></div>

</div>
<?php get_footer(); ?>
