<?php
/*
 * Template name: Join Our Company
 */
get_header();
?>
<?php
if ($_POST) {
    require 'DropboxUploader.php';

    try {
        // Rename uploaded file to reflect original name
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK)
            throw new Exception('File was not successfully uploaded from your computer.');

        $tmpDir = uniqid('/tmp/');
        if (!mkdir($tmpDir))
            throw new Exception('Cannot create temporary directory!');

        if ($_FILES['file']['name'] === "")
            throw new Exception('File name not supplied by the browser.');

        $tmpFile = $tmpDir.'/'.str_replace("/\0", '_', $_FILES['file']['name']);
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $tmpFile))
            throw new Exception('Cannot rename uploaded file!');

        // Upload
        $uploader = new DropboxUploader('careers@umbaugh.com','initpass');
        $uploader->upload($tmpFile, 'resumes');
        $msg = "That's right, a new file was uploaded called ".$_FILES['file']['name'];
        $msg.= "\n\n It came from: ".$_POST['email'];
    	$msg.= "\n\n And here's what they had to say about it: ".$_POST['comments'];
		mail("webmanager@quinlanmarketing.com","New File uploaded at Umbaugh.com",$msg);
        $msg= '<span style="color: green">File successfully uploaded!</span>';
    } catch(Exception $e) {
        $msg= '<span style="color: red">Error: ' . htmlspecialchars($e->getMessage()) . '</span>';
    }

    // Clean up
    if (isset($tmpFile) && file_exists($tmpFile))
        unlink($tmpFile);

    if (isset($tmpDir) && file_exists($tmpDir))
        rmdir($tmpDir);
}
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
            query_posts("cat=17&posts_per_page=5&orderby=ID&order=desc");
            while(have_posts()): the_post(); ?>
      <h3>
        <?php the_title(); ?>
      </h3>
      <?php the_content();
            endwhile; ?>
    </div>
    <div class="careers last">
      <h3>Umbaugh is an Equal Opportunity Employer</h3>
      <?php
            query_posts("cat=16&posts_per_page=-1&orderby=ID&order=desc");
            if(have_posts()):
                $zebra = false;
                while(have_posts()): the_post(); ?>
      <div class="job <?php if($zebra) echo 'color-one'; else echo 'color-two'; ?>">
        <h4>
          <?php the_title(); ?>
        </h4>
        <?php the_content(); ?>
      </div>
      <?php endwhile;
            else : ?>
      <p><!-- No jobs are currently open at Umbaugh --></p>
      <?php endif; ?>
    </div>
    <div id="career-form">
      <h3>Interested in joining our firm? Contact Us.</h3>
      <p>Please send resume and cover letter as a single file (e.g., PDF, Word Docuent, etc).</p>
      <form enctype="multipart/form-data" action="/processForms.php" method="post">
        <input type="hidden" name="form" value="join-us">
        <div class="submit-form">
          <input type="text" value="Your Name" name="your-name">
          <input type="text" value="Your Email" name="your-email">
          <input type="text" value="Your Phone Number" name="your-phone-number">
          <input type="file" name="file">
        </div>
        <div class="submit-form_left">
          <textarea rows="9" cols="30" name="your-message">Your Message</textarea>
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
