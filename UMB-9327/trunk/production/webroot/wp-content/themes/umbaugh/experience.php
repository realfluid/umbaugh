<?php
/*
 * Template name: Our experience
 */
get_header(); ?>

<div class="interior-content">
    <div id="mainColumn" class="wide">
    <?php if (have_posts()) while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
    <?php endwhile; ?>

        <ul>
        <?php $pages = get_pages('child_of=241&sort_column=post_date&sort_order=desc'); ?>
        <?php foreach ($pages as $page): ?>
            <li>
                <div><h2><a href="<?php echo get_permalink($page->ID); ?>"><?php echo $page->post_title; ?></a></h2></div>
                <div><?php $author = get_userdata($page->post_author);?> <?php if ($author->last_name != '' || $author->last_name != '') {
                    echo $author->last_name . ' ' . substr($author->first_name, 0, 1) . ', ';
                } ?><span class="date"><?php echo mysql2date('F j, Y', $page->post_date); ?></span></div>
                <div>
                    <p>
                    <?php echo $page->post_excerpt; ?>
                    </p>

                    <p class="readmore"><a href="<?php echo get_permalink($page->ID); ?>">Read More &raquo;</a></p>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php wp_pagenavi() ?>
    </div>
    <div id="sideColumn"><?php get_sidebar('experience'); ?></div>
</div>
<?php get_footer(); ?>
