	<?php
/*
 * Template name: Join Our Company
 */
get_header();
?>
<div class="interior-content">
    <div id="mainColumn">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <h1>You + Umbaugh = Opportunity</h1>
            <div id="callout">
                <h2>Have questions about career opportunities at Umbaugh?</h2>
                <p>Feel free to <a href="mailto:careers@umbaugh.com">contact us</a> with any questions you may have.</p>
            </div>
            <?php the_content(); ?>
        <?php endwhile; ?>

        <div class="career-types">
            <?php
            query_posts("cat=17&posts_per_page=2&orderby=ID&order=desc");
            while(have_posts()): the_post(); ?>
                <h3><?php the_title(); ?></h3>
                <?php the_content();
            endwhile; ?>
        </div>
        <div class="careers">
            <p>Umbaugh provides onsite training, an excellent compensation plan, a mentoring program, and career advancement opportunities. Please send resume and cover letter.</p>
            <h3>Umbaugh is an Equal Opportunity Employer</h3>
            <?php
            query_posts("cat=16&posts_per_page=-1&orderby=ID&order=desc");
            if(have_posts()):
                $zebra = false;
                while(have_posts()): the_post(); ?>
                    <div class="job <?php if($zebra) echo 'color-one'; else echo 'color-two'; ?>">
						<h4><?php the_title(); ?></h4>
                        <?php the_content(); ?>
					</div>
                <?php endwhile;
            else : ?>
            <p>No jobs are currently open at Umbaugh</p>
            <?php endif; ?>
        </div>

        <div id="career-form">
            <h3>Interested in joining our firm? Contact Us.</h3>
            <p>Please send resume and cover letter.</p>
            <form action="/processForms.php" method="post">
                <input type="hidden" name="form" value="join-us">
                <div class="submit-form">
                   <input type="text" value="Your Name" name="your-name">
                   <input type="text" value="Your Email" name="your-email">
                   <input type="text" value="Your Phone Number" name="your-phone-number">
                </div>
                <div class="submit-form_left">
                    <textarea rows="7" cols="30" name="your-message">Your Message</textarea>
                    <input type="submit" value="Submit" class="submit">
                    <input type="hidden" name="redirect" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">
               </div>
            </form>
        </div>
    </div>
    <div id="sideColumn">
        <?php get_sidebar('basic'); ?>
    <?php get_sidebar('join-our-firm'); ?>
    </div>
</div>
<?php get_footer(); ?>
