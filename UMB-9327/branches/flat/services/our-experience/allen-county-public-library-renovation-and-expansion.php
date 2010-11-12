<?php
	$currentPage = 'services';
	$title = 'Allen County Public Library Renovation and Expansion';
?>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/xhtml.php' ); ?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php' ); ?>
		<div class="interior-content">
			<h1>Allen County Public Library Renovation and Expansion</h1>
			<img src="../images/title-seperator.png" width="657" height="4" />
            <div id="mainColumn" class="services">
				content from our-experience.txt goes here
			</div><!-- end div #mainColumn -->
            <div id="sideColumn">
				<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/sideBtn.php' ); ?>
				<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/latestNews.php' ); ?>

				<img src="../images/dotted-seperator.png" />

				<div id="testimonial">
					<h2>Testimonial</h2>
    	                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet orci odio, vitae commodo lorem. Phasellus vitae felis leo, ac tincidunt odio.</p>
        	            <span id="author">FirstName</span>
				</div><!-- end DIV #testimonial -->
			</div><!-- end DIV #sideColumn -->
		</div><!-- end div .interior-content -->
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ); ?>