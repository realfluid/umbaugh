<?php
/*
Plugin Name: Bunny's Print CSS
Plugin URI: http://climbtothestars.org
Description: This very simple plugin adds a link to print.css in your theme header. You'll probably want to edit the print.css file supplied with the plugin.
Author: Stephanie Booth
Version: 0.95
Author URI: http://climbtothestars.org/
License: GPL

(C) 2008  Stephanie Booth  (email : steph@climbtothestars.org)    This program is free software; you can redistribute it and/or modify    it under the terms of the GNU General Public License as published by    the Free Software Foundation; either version 2 of the License, or    (at your option) any later version.    This program is distributed in the hope that it will be useful,    but WITHOUT ANY WARRANTY; without even the implied warranty of    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    GNU General Public License for more details.    You should have received a copy of the GNU General Public License    along with this program; if not, write to the Free Software    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USAINFORMATION:============Adds a print stylesheet to your blog theme. http://climbtothestars.org/archives/2008/01/07/print-css-plugin-wordpress-needs-css-guru/CHANGELOG:==========0.9  - Initial release (07.01.2008)0.95  - Added admin panel code heavily lifted from Yaosan Yeo's MyCSS plugin (http://www.channel-ai.com/blog/plugins/mycss/) (20.01.2008)
*/

// Admin panel code heavily lifted from Yaosan Yeo's MyCSS plugin (http://www.channel-ai.com/blog/plugins/mycss/), with thanks.

// Add options page under Presentation in the admin menufunction pcss_add_options() {	add_submenu_page('themes.php', 'Edit Print CSS', 'Print CSS', 8, basename(__FILE__), 'pcss_options_subpanel');}add_action('admin_menu', 'pcss_add_options');// Content of option panelfunction pcss_options_subpanel() {
	$file = 'print.css';
	$dir=basename(dirname(__FILE__));
	$css_to_edit = "../wp-content/plugins/$dir/$file";	if (isset($_POST['pcss_update'])) {		if (is_writeable($css_to_edit)) {			$f = fopen($css_to_edit, 'w+');			$pcss_new_content = stripslashes($_POST['newprintcss']);			fwrite($f, $pcss_new_content);			fclose($f);			echo '<div id="message" class="updated fade"><p>File edited successfully.</p></div>';		}		elseif (is_file($css_to_edit))			echo '<div id="message" class="error"><p>' . $file . ' is not writable! You probably need to change the file permissions.</p></div>';	}	if (!is_file($css_to_edit))		$error = 1;	if (!$error && filesize($css_to_edit) > 0) {		$f = fopen($css_to_edit,'r');		$content = fread($f, filesize($css_to_edit));		$content = htmlspecialchars($content);		fclose($f);	}	if(!$error) { ?><div class=wrap>	<form method="post" id="template">		<h2>Print CSS Editor</h2>		<fieldset class="options">			<legend>You may modify the CSS which will be used when printing your blog by editing the stylesheet below:</legend>			<textarea name="newprintcss" rows="25" tabindex="1"><?php echo $content;?></textarea>		</fieldset>	<?php if ( is_writeable($css_to_edit) ) : ?>		<p class="submit">	<?php		echo '<input type="submit" name="pcss_update" value="Update Print CSS &raquo;" tabindex="2" />';	?>		</p>	<?php else : ?>		<p><em><?php _e('If this file were writable you could edit it.'); ?></em></p>	<?php endif; ?>	</form></div>	<?php } else {		echo '<div class="error"><p>Oops, ' . $file . " cannot be found! This probably means the file isn't where the plugin expected to find it ($css_to_edit)." . '</p></div>';	}}


// This function generates the URL of the print CSS file
function pcss_css_url() {
	$dir=basename(dirname(__FILE__));
	$wpurl=get_option('siteurl');
	$file='print.css';
	$url=$wpurl . "/wp-content/plugins/" . $dir . '/' . $file;
	return $url;
	}

// Here is a function that produces the appropriate code for insertion in the header
function pcss_add_print_css() {
	
	$header_html='
	
	<link rel="stylesheet" type="text/css" media="print" href="' . pcss_css_url() . '" />

';
	echo $header_html;
}

// Now we set that function up to execute when wp_head action is called
add_filter('wp_head', 'pcss_add_print_css');
?>