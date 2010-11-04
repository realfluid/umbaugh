<?php
	$currentPage = 'news';
	$title = 'Latest News';
?>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/xhtml.php' ); ?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php' ); ?>
		<div class="interior-content">
			<h1>Latest News</h1>
			<img src="../images/title-seperator.png" width="657" height="4" />

            
            
            <div id="mainColumn">
            <div id="news" class="wide">
				<div class="news-story">
					<h2><a href="single.php">Some Title Here</a></h2>
                    <span class="date">August 20, 2010 <a href="#">Articles and Speeches</a></span>
					<p>DLorem ipsum dolor sit amet, consectetur adipiscing elit. In consectetur, erat eget sollicitudin auctor, sem lacus viverra eros, non feugiat elit sem id nibh. Fusce vitae justo ut nunc tempus tincidunt. Nulla eu odio sed nisl pellentesque tempor quis ut velit. Curabitur vehicula auctor diam, id commodo est porta vitae.</p>
					<a href="single.php">Read More &raquo; </a>
				</div>

				<div class="news-story">
					<h2><a href="single.php">Some Title Here</a></h2>
                    <span class="date">August 20, 2010 <a href="#">Articles and Speeches</a></span>
					<p>DLorem ipsum dolor sit amet, consectetur adipiscing elit. In consectetur, erat eget sollicitudin auctor, sem lacus viverra eros, non feugiat elit sem id nibh. Fusce vitae justo ut nunc tempus tincidunt. Nulla eu odio sed nisl pellentesque tempor quis ut velit. Curabitur vehicula auctor diam, id commodo est porta vitae.</p>
					<a href="single.php">Read More &raquo; </a>
				</div>

				<div class="news-story last">
					<h2><a href="#">Morbi sed leo dui, eget pulvinar felis. Integer id nunc sed risus condimentum volutpat id nec risus.</a></h2>
                    <span class="date">August 20, 2010 <a href="#">Articles and Speeches</a></span>
					<p>DLorem ipsum dolor sit amet, consectetur adipiscing elit. In consectetur, erat eget sollicitudin auctor, sem lacus viverra eros, non feugiat elit sem id nibh. Fusce vitae justo ut nunc tempus tincidunt. Nulla eu odio sed nisl pellentesque tempor quis ut velit. Curabitur vehicula auctor diam, id commodo est porta vitae.</p>
					<a href="single.php">Read More &raquo; </a>
				</div>
                
			<div id="news-nav" class="pxBuffer">
            	<div id="btn-container">
					<div id="previous">Previous</div>
						<div class="btn-page-num">1</div>
                        <div class="btn-page-num">2</div>
                        <div class="btn-page-num">3</div>
    				<div id="next">Next</div>
	            </div><!-- end DIV #btn-container -->
			</div><!-- end DIV #news-nav -->
		</div><!-- end DIV #news -->
            
            
			</div><!-- end div #mainColumn -->
            
            <div id="sideColumn">
				<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/sideBtn.php' ); ?>
            
				<img src="../images/dotted-seperator.png" />            

				<div class="resources">
					<h2>Categories</h2>
					<ul>
                    	<li><a href="#">Whats New</a></li>
                        <li><a href="#">Articles</a></li>
                        <li><a href="#">News letter</a></li>
                    </ul>
				</div><!-- end DIV #resources -->
                
				<img src="../images/dotted-seperator.png" />

				<div class="resources">
					<h2>News Archive</h2>
					<ul>
                    	<li><a href="#">2010</a></li>
                        <li><a href="#">2009</a></li>
                    </ul>
				</div><!-- end DIV #resources -->
                
				<img src="../images/dotted-seperator.png" />
				
                <div class="resources">
					<h2>Newsletter Sign-Up</h2>
					<p>Nam rutrum lectus quis nunc sagittis eu vulputate quam tincidunt. Ut accumsan tincidunt libero sed blandit.</p>
						<form action="" class="newsletter">
							<p><input type="text"> <input type="submit" value="Submit" class="submit"></p>
						</form>
				</div><!-- end DIV #resources -->
                
			</div><!-- end DIV #sideColumn -->
		</div><!-- end div .interior-content -->
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ); ?>