<?php
/*
 * Template name: Our Library
 */
get_header();
?>
<div class="interior-content">
<div id="mainColumn" class="wide">
    <?php if(have_posts()): the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
    <?php endif; ?>

    <ul class="links">
    <?php
        $links = get_bookmarks("orderby=ID&order=desc&category=4&categorize=0&title_li=");
        foreach($links as $link) : ?>
            <li>
                <a href="<?php echo $link->link_url ?>"><?php echo $link->link_name; ?></a><br>
                <span><?php echo $link->link_description ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div id="sideColumn">
<?php get_sidebar('library'); ?>
</div>
</div>
<?php get_footer(); ?>
