<?php

/*

 * Template name: Contact page

 */

get_header();

?>

<div class="interior-content">
  <div id="mainColumn">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h1>
      <?php the_title(); ?>
    </h1>
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
          <dt class="location-title">Mishawaka, Indiana</dt>
          <dt>Phone</dt>
          <dd><strong>(574) 935-5178</strong></dd>
          <dt>Fax</dt>
          <dd>(574) 935-5928</dd>
          <dt>Address</dt>
          <dd>112 IronWorks Avenue<br />
            Suite C<br />
            Mishawaka, IN 46544</dd>
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
          <dd>2150 Association Drive<br />
            Suite 100<br />
            Okemos, MI 48864</dd>
        </dl>
      </div>
    </div>
    <div id="contact-form">
      <h3>Have any questions? Contact Us.</h3>
      <p>We would like to hear from you.</p>
      <form action="/processForms.php" method="post" name="contact-us" id="contactusform">
        <input type="hidden" name="form" value="contact-us">
        <div class="submit-form">
          <input type="text" value="Your Name" name="your-name" id="your-name">
          <input type="text" value="Your Email" name="your-email" id="your-email">
          <input type="text" value="Your Phone Number" name="your-phone-number" id="your-phone-number">
          <input type="text" value="Your Organization" name="your-organization" id="your-organization">
        </div>
        <div class="submit-form_left"> Areas of Interest:
          <div class="checkbox_box">
            <div class="checkbox_left">
              <input type="checkbox" name="accounting-services">
              Accounting Services<br />
              <input type="checkbox" name="arbitrage-services">
              Arbitrage Services<br />
              <input type="checkbox" name="debt-management">
              Debt Management<br />
            </div>
            <div class="checkbox_right">
              <input type="checkbox" name="economic-development">
              Economic Development<br />
              <input type="checkbox" name="financial-management">
              Financial Management<br />
              <input type="checkbox" name="utility-services">
              Utility Services<br />
            </div>
            <div class="clear"></div>
          </div>
          <textarea rows="5" cols="30" name="your-message" id="your-message">Your Message</textarea>
          <input type="submit" value="Submit" class="submit" id="formSubmit">
          <input type="hidden" name="redirect" value="www.umbaugh.com/contact">
        </div>
      </form>
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
          
          <!--Download <a href="vcard.php?fn=<?php echo $post->post_title ?>&amp;tel=<?php echo $phone ?>&amp;email=<?php echo $email ?>&amp;title=<?php echo $who ?>">Vcard</a>--></p>
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
          
          <!--Download <a href="vcard.php?fn=<?php echo $post->post_title ?>&amp;tel=<?php echo $phone ?>&amp;email=<?php echo $email ?>&amp;title=<?php echo $who ?>">Vcard</a>--></p>
        <?php endif; $used++; endwhile; ?>
      </div>
    </div>
    <?php endfor; ?>
  </div>
  <div id="sideColumn">
    <?php get_sidebar('basic'); ?>
    <?php get_sidebar('contact-us'); ?>
  </div>
</div>
<?php get_footer(); ?>
<script src="http://code.jquery.com/jquery-1.6.1.min.js" type="text/javascript"></script> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js" type="text/javascript"></script> 
<script type="text/javascript">

$().ready(function() {

	$("#contactusform").validate({

		rules: {

			'your-name': {

				required: true,

				minlength: 2,

                notEqualTo: 'Your Name'

			},

			'your-email': {

				required: true,

				email: true,

                notEqualTo: 'Your Email'

			},

			'your-phone-number':{

				digits: true,

                notEqualTo: 'Your Phone Number'

			},

			'your-message':{

				required: true,

                notEqualTo: 'Your Message'

			}

		},

        messages: {

            'your-name': {

                required: 'This field is required',

                notEqualTo: 'Give your name'

            },

            'your-email': {

                required: 'This field is required',

                email: 'This needs to be an email address',

                notEqualTo: 'Give your email address'

            },

            'your-phone-number': {

                digits: 'Only digits please',

                notEqualTo: 'Give you phone number'

            },

            'your-message': {

                required: 'Type a message',

                notEqualTo: 'Type a message'

            }

        }

	});



    jQuery.validator.addMethod("notEqualTo", function(value, element, param) {

        return this.optional(element) || value != param;

     }, "This has to be different...");

});

</script> 
