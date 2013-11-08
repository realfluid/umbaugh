<?php
/*
 * Template Name: Home page
 */
get_header(); ?>
<div class="home-content">
    <div class="banner">
        <div class="tab-content">
			<p><span style="font-size:43px;">Investment</span><br /><span style="font-size:45px; padding-left: 35px;">advisory solutions</span><br  /><span style="font-size:37px; padding: 5px 0 0 10px;">for local governments</span></p>
        	<a href="http://www.umbaugh.com" class="Ureturn">&#171; Return to umbaugh.com</a>
        </div>
    </div>
    <div class="content">
        <div>
			<div class="three-columns">
                <p>Umbaugh Cash Advisory Services was developed as an independent business entity to assist local governments in creating structured investment programs for their bond proceeds and operating funds. Umbaugh Cash Advisory Servies is registered with the Securities and Exchange Commission which provides oversight and tough standards to which we must adhere.</p>
				<div class="column-three column">
					<h2><a href="<?php bloginfo('home'); ?>/latest-news">Latest News</a></h2>
					<ul>
                        <?php
                        query_posts("cat=3&posts_per_page=3&orderby=ID&order=desc");
                        while(have_posts()) : the_post(); ?>
                        <li><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php excerpt(25); ?></li>
                        <?php endwhile; ?>
					</ul>
				</div>

				<div class="column-one column">
					<h2><a href="/services/our-library">Our Library</a></h2>
					<ul class="links pdf">
						<li><a href="http://cashadvisory.umbaugh.com/our-library/pdf/IACT-Impact-of-State-and-Federal-Banking-Regulations.pdf" target="_blank" />IACT-Impact-of-State-and-Federal-Banking-Regulations</a></li>
						<li><a href="http://cashadvisory.umbaugh.com/our-library/pdf/ILMCT-Investment-Update.pdf" target="_blank" />ILMCT Investment Update</a></li>
						<li><a href="http://cashadvisory.umbaugh.com/our-library/pdf/Understanding-The-Credit-Crisis.pdf" target="_blank" />Understanding The Credit Crisis</a></li>
					</ul><br />
					<p class="links"><a href="/services/our-library">Read More of Our Library »</a></p>
				</div><!-- end first column -->

            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
