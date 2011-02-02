<?php get_header(); ?>
	<div class="interior-content">
        <div id="mainColumn" class="news-archive">


    <?php if (have_posts()) the_post(); ?>

        <h1 class="page-title">
            <?php if (is_day()) : ?>
            <?php printf(__('Daily Archives: <span>%s</span>', 'twentyten'), get_the_date()); ?>
            <?php elseif (is_month()) : ?>
            <?php printf(__('Monthly Archives: <span>%s</span>', 'twentyten'), get_the_date('F Y')); ?>
            <?php  elseif (is_year()) : ?>
            <?php printf(__('Yearly Archives: <span>%s</span>', 'twentyten'), get_the_date('Y')); ?>
            <?php  else : ?>
            <?php _e('Blog Archives', 'twentyten'); ?>
            <?php endif; ?>
        </h1>
        <div class="wide" id="news">
            <?php rewind_posts(); ?>
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                <div class="news-story">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                    <span class="date">
                        <?php $author = get_post_meta($post->ID, "author", true); if ($author) echo $author . ", "; ?>
                        <?php the_time('F j, Y'); ?>
                        <br/>
                    <?php the_category(","); ?></span>
                    <p><?php excerpt(30) ?></p>
                </div>
            <?php //the_content(); ?>
            <?php endwhile; ?>
            <div class="navigation">
              <div class="alignleft"><?php previous_posts_link('&laquo; Previous') ?></div>
              <div class="alignright"><?php next_posts_link('More &raquo;') ?></div>
            </div>
        </div>

    </div>
		<div id="sideColumn">
			<?php get_sidebar(); ?>
		</div>
	</div><!-- end DIV #interior-content -->
<?php get_footer(); ?>
