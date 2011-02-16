<?php
/*
 * Template Name: Home page
 */
get_header(); ?>
<div class="home-content">
    <div class="banner">
        <ul class="tab-content">
            <?php
            $count = 1;
            query_posts("post_type=showcase&posts_per_page=6&orderby=ID&order=asc");
            while(have_posts()) : the_post(); ?>
                <li id="tab<?php echo $count ?>" <?php if($count == 1) echo 'class="active"'; ?>>
                    <h2><?php the_title(); ?></h2>
                    <p class="banner-image"><?php the_post_thumbnail('showcase') ?></p>
                    <?php the_excerpt() ?>
					<?php
					$link_text = get_post_meta($post->ID, "link text", true);
					$link_url = get_post_meta($post->ID, "link url", true);
					if($link_text && $link_url): ?>
                    <p class="links"><a href="<?php bloginfo('home') ?>/<?php echo $link_url ?>" class="more"><?php echo $link_text ?> »</a></p>
					<?php endif; ?>
                </li>
            <?php
            $count++;
            endwhile;
            rewind_posts(); ?>
        </ul>
    </div>
    <div class="banner-tab-labels">
        <ul>
            <?php $count = 1; while(have_posts()) : the_post(); ?>
            <li <?php if($count == 1) echo 'class="first active"'; ?>><a href="#tab<?php echo $count; ?>" class="banner-tab-label"><?php echo get_post_meta($post->ID, "tab title", true); ?></a></li>
            <?php
            $count++;
            endwhile; ?>
        </ul>
    </div><!-- end DIV .banner-tab-labels -->


    <div class="content">
        <div>
			<div class="three-columns">
<div class="column-one column">
					<h2><a href="<?php bloginfo('home'); ?>/services/our-library">Our Library</a></h2>
					<ul class="links pdf">
                        <?php
                        $links = get_bookmarks("category=4&orderby=ID&order=DESC&limit=5");
                        foreach($links as $link): ?>
                            <li>
                                <p><a href="<?php echo $link->link_url ?>"><?php echo $link->link_name; ?></a><br><em><?php echo $link->link_description; ?></em></p>
                            </li>
                        <?php endforeach; ?>
					</ul>
					<p class="links"><a href="<?php bloginfo('home'); ?>/services/our-library">Read More of Our Library »</a></p>
				</div><!-- end first column -->

				<div class="column-two column">
					<h2><a href="<?php bloginfo('home'); ?>/services/our-experience">Our Experience</a></h2>
					<ul class="links">
						<?php wp_list_pages('child_of=241&title_li='); ?>
					</ul>
					<p class="links"><a href="<?php bloginfo('home'); ?>/services/our-experience">Read More of Our Experience »</a></p>
				</div><!-- end second column -->
				<div class="column-three column">
					<h2><a href="<?php bloginfo('home'); ?>/latest-news">Latest News</a></h2>
					<ul>
                        <?php
                        query_posts("cat=3&posts_per_page=3&orderby=ID&order=desc");
                        while(have_posts()) : the_post(); ?>
                        <li><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php excerpt(12); ?></li>
                        <?php endwhile; ?>
					</ul>
				</div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
