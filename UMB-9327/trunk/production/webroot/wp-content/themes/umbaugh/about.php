<?php
/*
 * Template name: About
 */
get_header();
?>

<div class="interior-content">
<div id="mainColumn">
    <?php if(have_posts()): the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
    <?php endif; ?>

    <div id="professionals-list">
        <h2>Client Service Leaders</h2>
        <hr  />
        <div class="three-column">
            <ul>
                <?php
                query_posts("posts_per_page=-1&post_type=partner&orderby=ID&order=asc&meta_key=team&meta_value=1");
                while(have_posts()): the_post(); ?>
                    <li><a href="#<?php echo $post->post_name ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="three-column">
            <ul>
                <?php
                query_posts("posts_per_page=-1&post_type=partner&orderby=ID&order=asc&meta_key=team&meta_value=2");
                while(have_posts()): the_post(); ?>
                    <li><a href="#<?php echo $post->post_name ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="three-column">
            <ul>
                <?php
                query_posts("posts_per_page=-1&post_type=partner&orderby=ID&order=asc&meta_key=team&meta_value=3");
                while(have_posts()): the_post(); ?>
                    <li><a href="#<?php echo $post->post_name ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <div id="professionals-table">
        <h2>Partners</h2>
        <?php
        query_posts("posts_per_page=-1&post_type=partner&orderby=DATE&sort=asc");
        while(have_posts()): the_post(); ?>
        <div class="professional" id="<?php echo $post->post_name; ?>">
            <?php if(has_post_thumbnail()) the_post_thumbnail('partner'); ?>
            <div class="bio-info">
                <h3><?php the_title();
                $postfix = get_post_meta($post->ID, "postfix", true);
                if($postfix) echo ", $postfix"; ?>
                </h3>
                <span class="professional-role"><?php $who = get_post_meta($post->ID, "who where", true); echo $who; ?></span>
                <div class="two-col">
                    <div class="contact-info">
                        <h4>Contact Information</h4>
                        <ul>
                            <?php $phone = get_post_meta($post->ID, "phone", true);
                            if($phone) : ?><li><?php echo $phone ?></li><?php endif; ?>
                            <?php $email = get_post_meta($post->ID, "email", true);
                            if($email) : ?><li><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li><?php endif; ?>
                            <li>Download <a href="vcard.php?fn=<?php echo $post->post_title ?>&tel=<?php echo $phone ?>&email=<?php echo $email ?>&title=<?php echo $who ?>">Vcard</a></li>
                        </ul>
                    </div>
                </div>
                <h4>Experience</h4>
                <?php the_content(); ?>
                <p><a href="#professionals-list">Back to top</a></p>
            </div>
            <div class="dashed"><!-- --></div>
        </div>
        <?php endwhile; ?>
    </div>

</div>
<div id="sideColumn"><?php get_sidebar('basic'); ?><?php get_sidebar('about'); ?></div>
</div>
<?php get_footer(); ?>
