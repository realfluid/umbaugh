<?php
/*
Plugin Name: Content and Excerpt Word Limit
Plugin URI: http://bavotasan.com/wordpress/free-wordpress-plugins/excerpt-and-content-word-limit-wordpress-plugin/
Description: Allows users to set a word limit when displaying the post content or excerpt.
Author: c.bavota
Version: 1.0
Author URI: http://bavotasan.com
*/

//Initialization
add_action('admin_menu', 'word_limit_init');


//add page to admin 
function word_limit_init() {
	add_options_page('Content and Excerpt Word Limit', 'Content and Excerpt Word Limit', 10, __FILE__, 'word_limit_plugin_options');
}

//set default options
function set_word_limit_options() {	
	add_option('wl_excerpt_ending','...','What do you want to  appear after your excerpt?');
	add_option('wl_content_ending','...','What do you want to  appear after your content?');	
	add_option('wl_readmore_link','Read More &raquo;','What do you want your read more link to be?');	
}

//delete options upon plugin deactivation
function unset_word_limit_options() {
	delete_option('wl_excerpt_ending');
	delete_option('wl_content_ending');
	delete_option('wl_readmore_link');
}

register_activation_hook(__FILE__,'set_word_limit_options');
register_deactivation_hook(__FILE__,'unset_word_limit_options');

// Excerpt Word Limit
function excerpt($num) {
	$link = get_permalink();
	$ending = get_option('wl_excerpt_ending');
	$limit = $num+1;
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).$ending;
	echo $excerpt;
	$readmore = get_option('wl_readmore_link');
	if($readmore!="") {
		$readmore = '<p class="readmore"><a href="'.$link.'">'.$readmore.'</a></p>';
		echo $readmore;
	}
}

// Content Word Limit
function content($num) {
	$link = get_permalink();
	$ending = get_option('wl_content_ending');
	$theContent = get_the_content();
	$output = preg_replace('/<img[^>]+./','', $theContent);
	$limit = $num+1;
	$content = explode(' ', $output, $limit);
	array_pop($content);
	$content = implode(" ",$content).$ending;
	$imgBeg = strpos($theContent, '<img');
	$post = substr($theContent, $imgBeg);
	$imgEnd = strpos($post, '>');
	$postOutput = substr($post, 0, $imgEnd+1);
	$result = preg_match('/width="([0-9]*)" height="([0-9]*)"/', $postOutput, $matches);
	if ($result) {
		$pagestring = $matches[0];
		$postOutput = str_replace($pagestring, "", $postOutput);
	}
	if(stristr($postOutput,'<img src=')) { echo '<a href="'.$link.'">'.$postOutput."</a>".$content; } else {
		echo $content;
	}
	$readmore = get_option('wl_readmore_link');
	if($readmore!="") {
		$readmore = '<p class="readmore"><a href="'.$link.'">'.$readmore.'</a></p>';
		echo $readmore;
	}
}

$theContent = get_the_content();


//creating the admin page
function word_limit_plugin_options() {
?>
  <div class="wrap">
  <h2>Content and Excerpt Word Limit</h2>
  <?php
	if($_REQUEST['submit']) {
	update_word_limit_options();
	}
	print_word_limit_form();
	?>
 </div>
<?php
}

//updating the options
function update_word_limit_options() {
	$ok = false;
	
	if($_REQUEST['wl_excerpt_ending']) {
		update_option('wl_excerpt_ending',$_REQUEST['wl_excerpt_ending']);
		$ok = true;
	}
	
	if($_REQUEST['wl_content_ending']) {
		update_option('wl_content_ending',$_REQUEST['wl_content_ending']);
		$ok = true;
	}	
	
	if($_REQUEST['wl_readmore_link']) {
		update_option('wl_readmore_link',$_REQUEST['wl_readmore_link']);
		$ok = true;
	}
	
	if($ok) {
		echo'<div id="message" class="updated fade">';
		echo '<p>Options saved.</p>';
		echo '</div>';
	} else {
		echo'<div id="message" class="error fade">';
		echo '<p>Failed to save options.</p>';
		echo '</div>';	
	}
}

//the actual admin page
function print_word_limit_form() {
	$default_excerpt = get_option('wl_excerpt_ending');
	$default_content = get_option('wl_content_ending');
	$default_readmore = get_option('wl_readmore_link');
	?>
    <!-- Content and Excerpt Word Limit box begin-->
	<form method="post">
    <table class="form-table">
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="wl_excerpt_ending">What do you want to  appear after your excerpt?</label>
	</th>
    <td>
    	<input type="text" name="wl_excerpt_ending" value="<?=$default_excerpt?>" />
    </td>
     </tr>   
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="wl_content_ending">What do you want to  appear after your content?</label>
    </th>
    <td>
    	<input type="text" name="wl_content_ending" value="<?=$default_content?>" />

    </td>
    </tr>
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="wl_readmore_link">What do you want your read more link to be?</label>
    </th>
    <td>
    	<input type="text" name="wl_readmore_link" value="<?=$default_readmore?>" />

    </td>
    </tr>
    </table>   
	<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="Save Changes" />
	</p>
    </form>
    <p>Instead of the_excerpt() or the_content(), use <code>&lt;? php excerpt('word-limit'); ?&gt;</code> or <code>&lt;? php content('word-limit'); ?&gt;</code> within your loop to limit the words for each.</p><p> Example: <code>&lt;? php excerpt('25'); ?&gt;</code>.</p>
    <p>Add the following to your style.css file to style the read more link.</p>
    <p><code>
    p.readmore {
	text-align: right;
	}
	
	p.readmore a {
	color: #ff0000;
	font-size: 11px;
	}
    </code>
    </p>
    <!-- Content and Excerpt Word Limit box end-->
<?php 
}
?>