	<body>
		<div class="header">
        	<div>
            <a href="/"><img src="/images/logo.png" alt="Umbaugh It's all about experience"></a>
				<form action="" class="form-search">
					<p>(888) 516 9594</p>
					<p><input type="text"> <input type="submit" value="Search" class="submit"></p>
				</form>

				<ul class="menu">
					<li><a href="/">Home</a></li>
					<li><a href="/about/">About Us</a></li>
					<li><a href="/services/index.php">Our Services</a></li>
					<li><a href="/join-our-firm/index.php">Join Our Firm</a></li>
					<li><a href="/contact/">Contact Us</a></li>
					<li><a href="/news/index.php">Latest News</a></li>
					<li><a href="/login/">Login</a></li>
				</ul>
			</div>
				breadcrumb here
		</div><!-- end DIV .header -->
	<?php
		if ($currentPage=="home")
			echo "<div class=\"home-wrapper\">";
		else
			echo "<div class=\"wrapper\">";
	?>