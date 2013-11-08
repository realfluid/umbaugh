<?php
/*
 *Template name: Case Study
 */
get_header(); ?>

<div class="interior-content">
    <div id="mainColumn" class="wide">
    <?php if (have_posts()) while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>

    <div id="news" class="wide">
        <div class="news-story">
            <?php $id = get_the_ID(); ?>
                <span class="date">
                        <?php $info = Array(); ?>
                        <?php if (get_post_meta($id, 'casestudy_author', true)) $info[] = get_post_meta($id, 'casestudy_author', true);?>
                        <?php if (get_post_meta($id, 'casestudy_date', true)) $info[] = mysql2date('F j, Y', get_post_meta($id, 'casestudy_date', true)); ?>
                        <?php echo implode(', ', $info); ?>
                    </span>
            <?php the_content(); ?>
        </div>

    </div>
    <?php endwhile; ?>
    </div>
    <div id="sideColumn"><?php get_sidebar('experience'); ?></div>
</div>
<?php get_footer(); ?>