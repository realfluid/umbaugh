<?php
/*
 * Template name: Services
 */
get_header(); ?>

	<div class="interior-content">
        <div id="mainColumn">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
                <div id="callout">
                	<h2>Our Areas of Expertise</h2>
                    <ul class="submenu">
                        <?php wp_list_pages("child_of=9&depth=1&title_li=&link_before=»&exclude=241 "); ?>
                    </ul>
	            </div>

				<?php the_content(); ?>
			<?php endwhile; ?>
            <div id="wide-callout">
                <h2>Cash Advisory Services</h2>
                <p>Umbaugh Cash Advisory Services, LLC was developed as an independent business entity to help create a structured investment program for their bond proceeds and operating funds.</p>
                <p>To Learn More <a href="mailto:cash@umbaugh.com">email Cash Advisory Services</a></p>
            </div>

		</div>
        <div id="sideColumn">
            <?php get_sidebar('basic'); ?>
		<?php get_sidebar('our-services'); ?>
        </div>
	</div>
<?php get_footer(); ?>
