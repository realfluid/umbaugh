<?php
	$currentPage = 'news';
	$title = 'What\'s New';
?>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/xhtml.php' ); ?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php' ); ?>
		<div class="interior-content">
			<h1>Category: Newsletters</h1>
			<img src="/images/title-seperator.png" width="657" height="4" />            
			<div id="mainColumn" class="wide">
				<div class="newsletter-item">
					<h2><a href="/news/august_2010.php">August 4, 2010</a></h2>
				</div>

				<div class="newsletter-item">
					<h2><a href="/news/august_2010.php">August 10, 2010</a></h2>
				</div>
                
				<div class="newsletter-item">
					<h2><a href="/news/august_2010.php">August 15, 2010</a></h2>
				</div>
           
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