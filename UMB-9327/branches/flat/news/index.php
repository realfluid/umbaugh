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
					<h2><a href="Brian_Long_Receives_Award.php">Brian Long Receives the 2010 Nelson Steele Memorial Award</a></h2>
                    <span class="date">August 20, 2010 <a href="#">Press Release</a></span>
					<p>INDIANAPOLIS – Brian Long of Umbaugh received the 2010 Nelson Steele Memorial Award from the Indiana Association of Cities and Towns (IACT). Long accepted his award at the Annual Awards Luncheon at noon on Monday, October 4 during the 2010 IACT Annual Conference & Exhibition in Fort Wayne, Ind.</p>
					<a href="Brian_Long_Receives_Award.php">Read More &raquo; </a>
				</div>

				<div class="news-story">
					<h2><a href="august_2010.php">August 2010 Newsletter</a></h2>
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
				<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/category.php' ); ?>
				<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/archive.php' ); ?>

                
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