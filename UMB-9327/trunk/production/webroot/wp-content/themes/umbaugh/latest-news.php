<?php
/*
 * Template name: Latest news
 */
get_header(); ?>

<div class="interior-content">
    <div id="mainColumn">
        <h1>Latest News</h1>

        <div class="wide" id="news">
        <?php
                function fake_is_home($args) {
            // Really doesn't filter posts_results.
            // Set is_home = 1 to allow sticky posts to be honored.
            global $wp_query;
            $wp_query->is_home = 1;
            return $args;
        }
        add_filter('posts_results', 'fake_is_home');
        query_posts("cat=3,-11&posts_per_page=10&paged=&order=DESC" . get_query_var('paged'));
        while (have_posts()) :the_post(); ?>
            <div class="news-story">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
				<span class="date">
					<?php $author = get_post_meta($post->ID, "author", true); if ($author) echo $author . ", "; ?>
                    <?php the_time('F j, Y'); ?>
                        <br/>
                    <?php the_category(","); ?></span>

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
