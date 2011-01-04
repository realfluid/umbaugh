<?php
	$currentPage = 'services';
	$title = 'Our Services';
?>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/xhtml.php' ); ?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php' ); ?>
		<div class="interior-content">
            <div id="mainColumn" class="services">
			<h1>Our Services</h1>
			<img src="/images/title-seperator.png" width="657" height="4" id="solid-seperator" />            
			  <div id="callout">
                	<h2>Our Areas of Expertise</h2>
						<img src="../images/dotted-seperator.png" />            
		                <ul>
                	        <li>&raquo; <a href="government.php">Local Government</a></li>
							<li>&raquo; <a href="utilities.php">Utilities</a></li>
							<li>&raquo; <a href="development.php">Economic Development</a></li>
							<li>&raquo; <a href="schools.php">Schools</a></li>
							<li>&raquo; <a href="libraries.php">Libraries</a></li>
						</ul>
	            </div>
                    <p>Our comprehensive services are tailored to each client's special needs, offering guidance and assistance from inception to project completion, financial analysis and long-term planning. Because we are independent advisors, we are objective in analyzing, planning and structuring creative solutions for many types of projects.</p>
				<div id="wide-callout">
					<h2>Cash Advisory Services</h2>
					<p>Umbaugh Cash Advisory Services, LLC was developed as an independent business entity to help create a structured investment program for their bond proceeds and operating funds.</p>
					<p>To Learn More <a href="mailto:cas@umbaugh.com">email Cash Advisory Services</a></p>
                </div>
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