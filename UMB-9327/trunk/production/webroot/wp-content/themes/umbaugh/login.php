<?php
/*
 * Template name: Login page
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

        $tmpDir = uniqid('/tmp/DropboxUploader-');
        if (!mkdir($tmpDir))
            throw new Exception('Cannot create temporary directory!');

        if ($_FILES['file']['name'] === "")
            throw new Exception('File name not supplied by the browser.');

        $tmpFile = $tmpDir.'/'.str_replace("/\0", '_', $_FILES['file']['name']);
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $tmpFile))
            throw new Exception('Cannot rename uploaded file!');

        // Upload
        $uploader = new DropboxUploader('jtpatters@gmail.com','sanyo1');
        $uploader->upload($tmpFile, 'umbaugh_ups');

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
        <div id="mainColumn" class="wide">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; ?>
			<? echo $msg ?>
		</div>
        <div id="sideColumn">
		<?php get_sidebar('login'); ?>
        </div>
	</div>

<?php get_footer(); ?>
