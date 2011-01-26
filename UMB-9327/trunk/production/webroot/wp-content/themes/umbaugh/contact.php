<?php
/*
 * Template name: Contact page
 */
get_header();
?>
<div class="interior-content">
        <div id="mainColumn">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
                <h2>Main Phone Number: <span id="phone-number-lg"> (888)516-9594</span></h2>
				<div class="locationColumns">

					<h2>Our Locations:</h2>
						<div class="column-one">
							<dl>
	        	                <dt class="location-title">Indianapolis, Indiana</dt>
    	                        <dt>Phone</dt>
        	                    <dd><strong>(317) 465-1500</strong></dd>
            	                <dt>Fax</dt>
                	            <dd>(317) 465-1550</dd>
                    	        <dt>Address</dt>
                        	    <dd>8365 Keystone Crossing<br />
                            	Suite 300<br />
	                            Indianapolis, IN 46240</dd>
							</dl>
                        </div>
						<div class="column-two">
							<dl>
	    	                    <dt class="location-title">Plymouth, Indiana</dt>
    	                        <dt>Phone</dt>
        	                    <dd><strong>(574) 935-5178</strong></dd>
            	                <dt>Fax</dt>
                	            <dd>(574) 935-5928</dd>
                    	        <dt>Address</dt>
                        	    <dd>925 Dora Lane<br />
                            	Suite 1<br />
	                            Plymouth, IN 46563</dd>
							</dl>
                        </div>
						<div class="column-three">
							<dl>
		                        <dt class="location-title">Lansing, Michigan</dt>
    	                        <dt>Phone</dt>
        	                    <dd><strong>(517) 321-0110</strong></dd>
            	                <dt>Fax</dt>
                	            <dd>(517) 321-8866</dd>
                    	        <dt>Address</dt>
                        	    <dd>6639 Centurion Drive<br />
                            	Suite 100<br />
	                            Lansing, MI 48917</dd>
							</dl>
    					</div>
                </div>

                <div id="contact-form">
                    <?php the_content(); ?>
                </div>
			<?php endwhile; ?>

            <h2><strong>Client Service Leaders Contact Information</strong></h2>
            <?php for($team = 1; $team <= 3; $team++): ?>
            <div class="professional-quickInfo <?php if($team % 2 == 0) echo "right"; ?>">
                <?php
                query_posts("posts_per_page=-1&post_type=partner&orderby=post_date&order=asc&meta_key=team&meta_value={$team}");
                $used = 0; ?>

                <div class="quickInfoColumn left">
                    <?php while(have_posts()): the_post();
                        if($used % 2 == 0):
                            if(strpos($post->post_title, ",")) $fn = substr($post->post_title, 0, strpos($post->post_title, ","));
                            else $fn = $post->post_title;
                            $who = get_post_meta($post->ID, "who where", true); ?>
                            <p><span><?php echo $fn ?></span><br>
                            <?php $phone = get_post_meta($post->ID, "phone", true); if($phone) echo $phone."<br>"; ?>
                            <?php $email = get_post_meta($post->ID, "email", true); if($email) : ?>
                                <a href="mailto:<?php echo $email ?>">Email</a><br>
                            <?php endif; ?>
                            Download <a href="vcard.php?fn=<?php echo $post->post_title ?>&amp;tel=<?php echo $phone ?>&amp;email=<?php echo $email ?>&amp;title=<?php echo $who ?>">Vcard</a></p>
                    <?php endif; $used++; endwhile; ?>
                </div>

                <div class="quickInfoColumn right">
                    <?php
                    rewind_posts();
                    $used = 0;
                    while(have_posts()): the_post();
                        if($used % 2 != 0):
                            if(strpos($post->post_title, ",")) $fn = substr($post->post_title, 0, strpos($post->post_title, ","));
                            else $fn = $post->post_title;
                            $who = get_post_meta($post->ID, "who where", true); ?>
                            <p><span><?php echo $fn ?></span><br>
                            <?php $phone = get_post_meta($post->ID, "phone", true); if($phone) echo $phone."<br>"; ?>
                            <?php $email = get_post_meta($post->ID, "email", true); if($email) : ?>
                                <a href="mailto:<?php echo $email ?>">Email</a><br />
                            <?php endif; ?>
                            Download <a href="vcard.php?fn=<?php echo $post->post_title ?>&amp;tel=<?php echo $phone ?>&amp;email=<?php echo $email ?>&amp;title=<?php echo $who ?>">Vcard</a></p>
                    <?php endif; $used++; endwhile; ?>
                </div>
            </div>
            <?php endfor; ?>
		</div>
        <div id="sideColumn"><?php get_sidebar('basic'); ?><?php get_sidebar('contact-us'); ?></div>
    </div>
<?php get_footer(); ?>
