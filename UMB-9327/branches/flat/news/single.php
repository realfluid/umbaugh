<?php
	$currentPage = 'news';
	$title = 'News Title Here';
?>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/xhtml.php' ); ?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php' ); ?>

		<div class="interior-content">
			<h1>Some Title Here</h1>
			<img src="../images/title-seperator.png" width="657" height="4" />
            <div id="mainColumn">
            <div id="news" class="wide">
				<div class="news-story last pxBuffer">
                    <span class="date">August 20, 2010 <a href="#">Articles and Speeches</a></span>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sed leo dui, eget pulvinar felis. Integer id nunc sed risus condimentum volutpat id nec risus. Vestibulum ac massa ut nulla lacinia tristique. Nulla vehicula dictum dolor, vitae rutrum ligula dapibus quis. Donec nunc tortor, dignissim ac dapibus ac, accumsan sit amet eros. Mauris pellentesque vulputate dolor, sed porta nibh pulvinar non. Pellentesque ornare est nibh. Duis mattis erat at felis hendrerit at fringilla velit viverra. Nullam tincidunt arcu vel lectus tempus pellentesque. Suspendisse nec lorem tortor. Proin a magna in risus porttitor sodales quis at ante. Nunc et quam sit amet est posuere bibendum non eu nisi. Pellentesque at nisi non est tristique accumsan at vitae erat.</p>
						<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus in ipsum dolor. Quisque lorem mi, tempor sollicitudin tincidunt eget, pretium ac dui. Mauris non erat sem. Duis iaculis ornare metus. Vivamus mollis bibendum ipsum, sed blandit leo mattis eget. In est elit, vehicula eget tempus eu, egestas sed dolor. Phasellus euismod lobortis iaculis. Nulla nisl odio, lacinia ac aliquet in, luctus consequat lectus. Cras vehicula vestibulum ligula, et fermentum metus dapibus eu. Donec in leo leo, nec dictum velit. Vivamus varius consectetur eros, at interdum diam varius mollis. Fusce egestas lobortis dui, vitae pharetra lorem elementum ut. Proin vel lacus nec lectus accumsan auctor. Suspendisse dapibus, lectus eu placerat aliquet, felis justo porttitor leo, id ullamcorper dui massa eu dolor. Etiam vulputate pretium nunc, ac elementum velit aliquet molestie. Etiam porta lacus et orci malesuada a cursus neque sagittis. Curabitur sit amet est risus.</p>
						<p>Aliquam erat volutpat. Integer eros lorem, iaculis a varius id, dapibus et massa. Phasellus gravida tincidunt sem non pulvinar. Mauris iaculis venenatis arcu, nec pulvinar neque ornare vel. Donec laoreet, ligula id sagittis ultrices, lacus ligula pretium leo, quis aliquet nibh nibh ac turpis. Aliquam pellentesque ligula eget risus gravida laoreet. Etiam congue velit nunc. Cras egestas bibendum convallis. Integer tellus orci, vulputate quis porttitor a, fringilla eu arcu. Sed vel metus ligula, quis hendrerit mauris. Mauris tempor magna ut erat faucibus imperdiet. Morbi dignissim laoreet turpis rutrum vestibulum. Praesent tempus ultrices tortor, non dapibus risus sollicitudin elementum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In in congue orci. Nam non ante sem, elementum porta augue. Nam ac ante eros, in faucibus dolor. Cras in odio tellus, id fringilla urna. Nunc ut lacus nunc. Quisque eu diam augue. </p>

				</div>
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