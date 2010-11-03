<?php
	$currentPage = 'services';
	$title = 'Our Services';
?>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/xhtml.php' ); ?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php' ); ?>
		<div class="interior-content">
			<h1>Our Services</h1>
			<img src="../images/title-seperator.png" width="657" height="4" />

            
            
            <div id="mainColumn" class="services">
			  <div id="callout">
                	<h2>Our Areas of Expertise</h2>
						<img src="../images/dotted-seperator.png" />            
		                <ul>
                	        <li>&raquo; <a href="government.php">Local Governments</a></li>
							<li>»&nbsp; <a href="utilities.html">Utilities</a></li>
							<li>»&nbsp; <a href="development.html">Economic Development</a></li>
							<li>»&nbsp; <a href="schools.php">Schools</a></li>
							<li>»&nbsp; <a href="libraries.html">Libraries</a></li>
						</ul>
	            </div>
					<p>Aenean non enim vestibulum mauris cursus venenatis a vel nulla! Quisque adipiscing arcu vitae ligula viverra molestie. Aliquam urna justo; ullamcorper non fermentum ut, elementum eu purus. Donec rutrum fermentum dui, nec tincidunt diam elementum a. Quisque vehicula porta leo in varius. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
					<p>Liquam urna justo; ullamcorper non fermentum ut, elementum eu purus. Donec rutrum fermentum dui, nec tincidunt diam elementum a. Quisque vehicula porta leo in varius. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.Aenean non enim vestibulum mauris cursus venenatis a vel nulla! Quisque adipiscing arcu vitae ligula viverra molestie. Aliquam urna justo; ullamcorper non fermentum.</p>

				<div id="wide-callout">
					<h2>Cash Advisory Services</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet orci odio, vitae commodo lorem. Phasellus vitae felis leo, ac tincidunt odio.</p>
					<p>To Learn More <a href="mailto:#">email Cash Advisory Services</a></p>
                </div>
			</div><!-- end div #mainColumn -->
            <div id="sideColumn">
				<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/sideBtn.php' ); ?>
            
				<img src="../images/dotted-seperator.png" />            
                
                <div id="news">
                	<h2>Latest News</h2>
						<div class="news-story">
							<h3>Some Title Here</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet orci odio, vitae commodo.</p>
							<a href="#">Read More &raquo; </a>
						</div>

						<div class="news-story">
							<h3>Some Title Here</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet orci odio, vitae commodo.</p>
							<a href="#">Read More &raquo; </a>
						</div>
				</div><!-- end DIV #news -->

				<img src="../images/dotted-seperator.png" />

				<div id="testimonial">
					<h2>Testimonial</h2>
    	                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet orci odio, vitae commodo lorem. Phasellus vitae felis leo, ac tincidunt odio.</p>
        	            <span id="author">FirstName</span>
				</div><!-- end DIV #testimonial -->
			</div><!-- end DIV #sideColumn -->
		</div><!-- end div .interior-content -->
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ); ?>