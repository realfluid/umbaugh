	<body>
		<script type="text/javascript">document.body.className += ' js';</script>

		<div class="header">
        	<div>
            <a href="/"><img src="/images/logo.png" alt="Umbaugh It's all about experience"></a>
				<form action="" class="form-search">
					<p>(888) 516 9594</p>
					<p><input type="text"> <input type="submit" value="Search" class="submit"></p>
				</form>

				<ul class="menu">
					<li<?php echo($currentPage == 'home') ? ' class="selected first"' : ''?>><a href="/">Home</a></li>
					<li<?php echo($currentPage == 'about') ? ' class="selected"' : ''?>><a href="/about/">About Us</a></li>
					<li<?php echo($currentPage == 'services') ? ' class="selected"' : ''?>><a href="/services/index.php">Our Services</a></li>
					<li<?php echo($currentPage == 'careers') ? ' class="selected"' : ''?>><a href="/join-our-firm/index.php">Join Our Firm</a></li>
					<li<?php echo($currentPage == 'contact') ? ' class="selected"' : ''?>><a href="/contact/">Contact Us</a></li>
					<li<?php echo($currentPage == 'news') ? ' class="selected"' : ''?>><a href="/news/index.php">Latest News</a></li>
					<li<?php echo($currentPage == 'login') ? ' class="selected"' : ''?>><a href="/login/">Login</a></li>
				</ul>
			</div>
            <?php echo ($currentPage != 'home' ) ? '
				<div id="breadcrumb">
					<a href="/">Home</a> &gt; About
				</div>' : ""
			?>
		</div><!-- end DIV .header -->
	<?php
		if ($currentPage=="home")
			echo "<div class=\"home-wrapper\">";
		else
			echo "<div class=\"wrapper\">";
	?>