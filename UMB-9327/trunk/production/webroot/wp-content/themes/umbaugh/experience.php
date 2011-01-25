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
    <?php $id = get_the_ID(); ?>
    <?php endwhile; ?>
        <p></p>
    <?php if ($id == 241) { ?>
        <div class="wide" id="news">
            <?php $pages = get_pages('child_of=241&sort_column=post_date&sort_order=desc'); ?>
            <?php foreach ($pages as $page): ?>
                <div class="news-story">
                    <h2><a href="<?php echo get_permalink($page->ID); ?>"><?php echo $page->post_title; ?></a></h2>
                    <span class="date">
                        <?php $info = Array(); ?>
                        <?php if(get_post_meta($page->ID, 'casestudy_author', true)) $info[] =  get_post_meta($page->ID, 'casestudy_author', true);?>
                        <?php if (get_post_meta($page->ID, 'casestudy_date', true)) $info[] = mysql2date('F j, Y', get_post_meta($page->ID, 'casestudy_date', true)); ?>
                        <?php echo implode(', ', $info); ?>
                    </span>
                    <p>
                        <?php echo $page->post_excerpt; ?>
                    </p>
                    <p class="readmore">
                        <a href="<?php echo get_permalink($page->ID); ?>">
                            Read More &raquo;
                        </a>
                        <br/>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } ?>
    <?php wp_pagenavi() ?>
    </div>
    <div id="sideColumn"><?php get_sidebar('experience'); ?></div>
</div>
<?php get_footer(); ?>
