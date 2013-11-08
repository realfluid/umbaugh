<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
<meta name="content-type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s'), max( $paged, $page ) );
	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>">
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/style_ie7.css"><![endif]-->
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/style_ie8.css"><![endif]-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/style_print.css" media="print">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )	wp_enqueue_script( 'comment-reply' );
	wp_head();
?>
<meta name="google-site-verification" content="2xJ5I2d46hzdZ3yMWKF4prOcQ42jO-zHk4I-45_Kpks" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23881157-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body <?php body_class(); ?>>
<script type="text/javascript">document.body.className += ' js';</script>

		<div class="header">
        	<div>
            <a href="<?php bloginfo("home") ?>" class="logo"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/logo.png" alt="Umbaugh. It's all about experience"></a>
				<form action="<?php bloginfo("home") ?>" class="form-search">
					<p>(888) 516 9594</p>
					<p><input type="text" value="" name="s" id="s"> <input type="submit" value="Search" class="submit" id="searchsubmit"></p>
				</form>
				<?php wp_nav_menu("theme_location=primary&container="); ?>
			</div>
            <?php if(!is_front_page()): ?>
				<div id="breadcrumb">
					<?php
					if(class_exists('bcn_breadcrumb_trail')){
						$breadcrumb_trail = new bcn_breadcrumb_trail;
						$breadcrumb_trail->opt['home_title'] = "Home";
						$breadcrumb_trail->opt['current_item_prefix'] = '';
						$breadcrumb_trail->opt['current_item_suffix'] = '';
						$breadcrumb_trail->fill();
						$breadcrumb_trail->display();
					}
					?>

				</div>
			<?php endif; ?>
		</div>
	<?php
		if (is_front_page()) echo "<div class=\"home-wrapper\">";
		else echo "<div class=\"wrapper\">";
	?>
