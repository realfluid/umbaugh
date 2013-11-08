<?php
/*
Plugin Name: Co-Authors
Plugin URI: http://wordpress.org/extend/plugins/co-authors/
Description: Allows multiple authors to be assigned to a post. Co-authored posts appear on a co-author's posts page and feed. New template tags allow listing of co-authors. Editors may assign co-authors to a post via the 'Post Author' box.  <em>This plugin is developed at <a href="http://www.shepherd-interactive.com/" title="Shepherd Interactive specializes in web design and development in Portland, Oregon">Shepherd Interactive</a> for the benefit of the community.</em>
Version: 1.0 (beta 6)
Author: Weston Ruter
Author URI: http://weston.ruter.net/
Copyright: 2008, Weston Ruter, Shepherd Interactive

Inspired by 'Multiple Authors' plugin by Mark Jaquith (2005).

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define('COAUTHORS_DEFAULT_BEFORE', '');
define('COAUTHORS_DEFAULT_BETWEEN', ', ');
define('COAUTHORS_DEFAULT_BETWEEN_LAST', ' and ');
define('COAUTHORS_DEFAULT_AFTER', '');
define('COAUTHORS_VERSION', '1.0beta2');

if(floatval(get_option('coauthors_version')) < 1.0)
	coauthors_updatedb();

add_option('coauthors_version', COAUTHORS_VERSION);

function coauthors_updatedb(){
	global $wpdb;
	//Update old versions of plugin to use new hidden meta key
	$wpdb->query("UPDATE $wpdb->postmeta SET meta_key = '_coauthor' WHERE meta_key = 'coauthor';");
}
register_activation_hook(__FILE__, 'coauthors_updatedb');

# Load up the localization file if we're using WordPress in a different language
# Place l10n files named like "co-authors-[value in wp-config].mo" in the "localization" folder
load_plugin_textdomain('co-authors', PLUGINDIR . '/co-authors/localization');

function coauthors_user_has_cap($allcaps, $caps, $args){
	$current_user = wp_get_current_user();
	
	$relatedCaps = array(
		'edit_post',
		'edit_others_posts',
		'publish_posts',
		'edit_page',
		'edit_others_pages',
		'publish_pages',
		'edit_pages',
		'edit_posts',
		'edit_published_pages',
		'edit_published_posts',
		//delete_post
		//delete_page
		//moderate_comments
	);
	
	foreach($caps as $cap){
		if(!in_array($cap, $relatedCaps))
			return $allcaps;
	}
	
	//Get the post in question
	$postID = $args[2] ? $args[2] : $_POST['ID'];
	$post = get_post($postID);
	$post_status = $_POST['post_status'] ? $_POST['post_status'] : $post->post_status;
	
	//Disallow if post is published and they are a contributor
	if(!in_array($post_status, array('draft','pending')) && (($post->post_type == 'post' && !$allcaps['edit_published_posts']) || ($post->post_type == 'page' && !$allcaps['edit_published_pages']))){
		return $allcaps;
	}
	
	$coauthors = get_post_custom_values('_coauthor', $postID);
	if(!empty($coauthors) && in_array($current_user->ID, $coauthors)){
		foreach($relatedCaps as $cap){
			$allcaps[$cap] = true;
		}
	}
	
	return $allcaps;
}
add_filter('user_has_cap', 'coauthors_user_has_cap', 10, 3);


//Modify the author query posts SQL to include posts co-authored
function coauthors_posts_join_filter($join){
	global $wpdb,$wp_query;
	if(is_author()){
		$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.id "
		       . "AND $wpdb->postmeta.meta_key = '_coauthor' "
			   . "AND $wpdb->postmeta.meta_value = '" . $wp_query->query_vars['author'] . "' "; //this condition removes need for DISTINCT
	}
	return $join;
}
add_filter('posts_join', 'coauthors_posts_join_filter');
function coauthors_posts_where_filter($where){
	global $wpdb;
	if(is_author())
		$where = preg_replace('/(\b(?:' . $wpdb->posts . '\.)?post_author\s*=\s*(\d+))/', '($1 OR (' . $wpdb->postmeta . '.meta_value = \'$2\'))', $where, 1); #' . $wpdb->postmeta . '.meta_id IS NOT NULL AND 
	return $where;
}
add_filter('posts_where', 'coauthors_posts_where_filter');

//function coauthors_posts_query_filter($sql){ //this was needed when meta_value = query_vars[author] was not tested in the LEFT JOIN ON clause
//	return preg_replace("{^(\s*SELECT\b(?!\s*DISTINCT))}i", '$1 DISTINCT', $sql);
//}
//add_filter('posts_request', 'coauthors_posts_query_filter');


class CoAuthorsIterator {
	var $position = -1;
	var $original_authordata;
	var $authordata_array;
	var $count;
	
	function CoAuthorsIterator($postID = 0){
		global $post, $authordata, $wpdb;
		$postID = (int)$postID;
		if(!$postID && $post)
			$postID = (int)$post->ID;
		if(!$postID)
			trigger_error(__('No post ID provided for CoAuthorsIterator constructor. Are you not in a loop or is $post not set?', 'co-authors')); //return null;
		if(empty($authordata))
			$authordata = get_userdata($wpdb->get_var("SELECT post_author FROM $wpdb->posts WHERE ID = $postID;"));
		
		//Gather all of the co-authors
		$this->authordata_array = array($authordata);
		$userids = get_post_meta($post->ID, '_coauthor', false);
		if(!empty($userids)){
			if(!is_array($userids))
				$userids = array($userids);
			foreach($userids as $user_id){
				$a = get_userdata($user_id);
				if(!empty($a)) //in case the user has been deleted while plugin was deactivated
					$this->authordata_array[] = $a;
			}
		}
		$this->count = count($this->authordata_array);
	}
	
	function iterate(){
		global $authordata;
		$this->position++;
		
		//At the end of the loop
		if($this->position > $this->count-1){
			$authordata = $this->original_authordata;
			$this->position = -1;
			return false;
		}
		
		//At the beginning of the loop
		if($this->position == 0 && !empty($authordata))
			$this->original_authordata = $authordata;
		
		$authordata = $this->authordata_array[$this->position];
		
		return true;
	}
	
	function get_position(){
		if($this->position === -1)
			return false;
		return $this->position;
	}
	function is_last(){
		return  $this->position === $this->count-1;
	}
	function is_first(){
		return $this->position === 0;
	}
	function count(){
		return $this->count;
	}
	function get_all(){
		return $this->authordata_array;
	}
}

//Helper function for the following new template tags
function coauthors__echo($tag, $between, $betweenLast, $before, $after){
	$i = new CoAuthorsIterator();
	echo $before;
	if($i->iterate())
		$tag();
	while($i->iterate()){
		echo $i->is_last() ? $betweenLast : $between;
		$tag();
	}
	echo $after;
}

//Provide co-author equivalents to the existing author template tags
function coauthors($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author', $between, $betweenLast, $before, $after);
}
function coauthors_posts_links($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author_posts_link', $between, $betweenLast, $before, $after);
}
function coauthors_firstnames($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author_firstname', $between, $betweenLast, $before, $after);
}
function coauthors_lastnames($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author_lastname', $between, $betweenLast, $before, $after);
}
function coauthors_nicknames($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author_nickname', $between, $betweenLast, $before, $after);
}
function coauthors_links($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author_link', $between, $betweenLast, $before, $after);
}
function coauthors_IDs($between = null, $betweenLast = null, $before = null, $after = null){
	if($between === NULL)
		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
	if($betweenLast === NULL)
		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
	if($before === NULL)
		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
	if($after === NULL)
		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
	coauthors__echo('the_author_ID', $between, $betweenLast, $before, $after);
}
//function coauthors_emails($between = null, $betweenLast = null, $before = null, $after = null){
//	if($between === NULL)
//		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
//	if($betweenLast === NULL)
//		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
//	if($before === NULL)
//		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
//	if($after === NULL)
//		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
//	coauthors__echo('the_author_email', $between, $betweenLast, $before, $after);
//}
//function coauthors_urls($between = null, $betweenLast = null, $before = null, $after = null){
//	if($between === NULL)
//		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
//	if($betweenLast === NULL)
//		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
//	if($before === NULL)
//		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
//	if($after === NULL)
//		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
//	coauthors__echo('the_author_url', $between, $betweenLast, $before, $after);
//}
//function coauthors_icq($between = null, $betweenLast = null, $before = null, $after = null){
//	if($between === NULL)
//		$between = __(COAUTHORS_DEFAULT_BETWEEN, 'co-authors');
//	if($betweenLast === NULL)
//		$betweenLast = __(COAUTHORS_DEFAULT_BETWEEN_LAST, 'co-authors');
//	if($before === NULL)
//		$before = COAUTHORS_DEFAULT_BEFORE; //__(COAUTHORS_DEFAULT_BEFORE, 'co-authors');
//	if($after === NULL)
//		$after = COAUTHORS_DEFAULT_AFTER; //__(COAUTHORS_DEFAULT_AFTER, 'co-authors');
//	coauthors__echo('the_author_icq', $between, $betweenLast, $before, $after);
//}


function coauthors_init(){
	if(is_admin())
		wp_enqueue_script( 'jquery' );
}
add_action('init', 'coauthors_init');

function coauthors_add_stylesheet() {
    global $current_user;
    print '<link rel="stylesheet" type="text/css" href="../' . PLUGINDIR . '/co-authors/admin.css" />';
}
add_action('admin_print_scripts', 'coauthors_add_stylesheet');

function coauthors_modify_post_sidebar(){
	global $current_user;
	//if($current_user->has_cap('edit_others_posts')){
		print '<script type="text/javascript">';
		print 'var coauthors_can_edit_others_posts = ' . ($current_user->has_cap('edit_others_posts') ? 'true' : 'false') . "\n";
		print 'var coauthors_dbx_post_title = "' . __('Post Author(s)', 'co-authors') . '";';
		print 'var coauthors_dbx_page_title = "' . __('Page Author(s)', 'co-authors') . '";';
		print 'var coauthors_add_author_label = "' . __('+ Add author', 'co-authors') . '";';
		print 'var coauthors_confirm_delete_label = "' . __('Are you sure you want to remove the user \u201C%s\u201D as an author?', 'co-authors') . '";';
		#print 'var coauthors_moveUp_author_label = "' . __('+ Add author', 'co-authors') . '";';
		#print 'var coauthors_moveDown_author_label = "' . __('+ Add author', 'co-authors') . '";';
		#print 'var coauthors_delete_author_label = "' . __('+ Add author', 'co-authors') . '";';
		print '</script>';
		
		//<script type='text/javascript' src='http://new-wineskins.org-beta/wp-includes/js/jquery/jquery.js?ver=1.1.4'></script>

		
		print '<script type="text/javascript" src="../' . PLUGINDIR . '/co-authors/admin.js"></script>';
	//}
}
add_action('admin_footer', 'coauthors_modify_post_sidebar'); //dbx_post_sidebar,edit_form_advanced

//Update a post's co-authors
function coauthors_update_post($postID){
	global $wpdb;
	$current_user = wp_get_current_user();
	if(!empty($current_user) && $current_user->has_cap('edit_others_posts') && @$_POST['coauthors_plugin_is_active']){
		//Delete all existing co-authors from a post
		delete_post_meta($postID, '_coauthor');
		
		//Newly add each co-author to the post meta
		if(is_array($_POST['coauthors'])){
			foreach(array_unique($_POST['coauthors']) as $authorID){
				if(is_numeric($authorID) && $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE ID = $authorID")){
					add_post_meta($postID, '_coauthor', (int)$authorID, false);
				}
			}
		}
	}
}
add_action('edit_post', 'coauthors_update_post');
add_action('save_post', 'coauthors_update_post');

function coauthors_delete_user_action($userID){
	global $wpdb;
	//$reassign = null;
	////Get $reassign parameter from calling wp_delete_user function
	//if(function_exists('debug_backtrace')){
	//	$callstack = debug_backtrace();
	//	foreach($callstack as $caller){
	//		if($caller['function'] == 'wp_delete_user'){
	//			if(is_numeric($caller['args'][1/*reassign*/]))
	//				$reassign = (int)$caller['args'][1/*reassign*/];
	//			break;
	//		}
	//	}
	//}
	////Otherwise, try to get the reassign user from POST data
	//else if(@$_POST['delete_option'] == 'reassign' && is_numeric(@$_POST['reassign_user'])) {
	//	$reassign = (int)$_POST['reassign_user'];
	//}
	
	//Reassign all co-author post meta
	//if($reassign){
	//	$postIDs = $wpdb->get_col("SELECT ID FROM $wpdb->posts p LEFT JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND p.post_type != 'revision' AND pm.meta_key = '_coauthor' AND pm.meta_value = '$reassign';");
	//	foreach($postIDs as $postID){
	//		//if the post's post_author != $reassign and there isn't a post meta coauthor which is $reassign
	//		if($wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts p
	//						                   LEFT JOIN $wpdb->postmeta pm
	//										        ON p.ID = pm.post_id AND pm.meta_key = '_coauthor' AND pm.meta_value = '$reassign'
	//										   WHERE p.ID = $postID AND p.post_type != 'revision' AND (p.post_author = '$reassign' OR pm.meta_value = '$reassign')") == 0)
	//		{
	//			update_post_meta($postID, '_coauthor', $reassign, $userID);
	//		}
	//		//the reassign author already exists for this post, so just delete the post meta
	//		else {
	//			delete_post_meta($postID, '_coauthor', $userID);
	//		}
	//	}
	//}
	////Delete all co-author post meta
	//else
		$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_coauthor' AND meta_value = '$userID';");
}
add_action('delete_user', 'coauthors_delete_user_action');


//customized wp_list_authors() from WP core
/**
 * List all the *co-authors* of the blog, with several options available.
 * optioncount (boolean) (false): Show the count in parenthesis next to the author's name.
 * exclude_admin (boolean) (true): Exclude the 'admin' user that is installed by default.
 * show_fullname (boolean) (false): Show their full names.
 * hide_empty (boolean) (true): Don't show authors without any posts.
 * feed (string) (''): If isn't empty, show links to author's feeds.
 * feed_image (string) (''): If isn't empty, use this image to link to feeds.
 * echo (boolean) (true): Set to false to return the output, instead of echoing.
 * @param array $args The argument array.
 * @return null|string The output, if echo is set to false.
 */
function coauthors_wp_list_authors($args = ''){
	global $wpdb;

	$defaults = array(
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'echo' => true
	);

	$r = wp_parse_args( $args, $defaults );
	extract($r, EXTR_SKIP);

	$return = '';

	// TODO:  Move select to get_authors().
	$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users " . ($exclude_admin ? "WHERE user_login <> 'admin' " : '') . "ORDER BY display_name");

	$author_count = array();
	$sql = "SELECT DISTINCT
					p1.post_author,
					(COUNT(ID)+(SELECT COUNT(*)
								FROM $wpdb->posts p2, $wpdb->postmeta pm
								WHERE p2.ID = pm.post_id
									AND pm.meta_key = '_coauthor'
									AND pm.meta_value = p1.post_author)
								) AS count
			FROM $wpdb->posts p1
			WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . "
			GROUP BY post_author";
	
	foreach ((array)  $wpdb->get_results($sql) as $row) {
		$author_count[$row->post_author] = $row->count;
	}

	foreach ( (array) $authors as $author ) {
		$author = get_userdata( $author->ID );
		$posts = (isset($author_count[$author->ID])) ? $author_count[$author->ID] : 0;
		$name = $author->display_name;

		if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') )
			$name = "$author->first_name $author->last_name";

		if ( !($posts == 0 && $hide_empty) )
			$return .= '<li>';
		if ( $posts == 0 ) {
			if ( !$hide_empty )
				$link = $name;
		} else {
			$link = '<a href="' . get_author_posts_url($author->ID, $author->user_nicename) . '" title="' . sprintf(__("Posts by %s"), attribute_escape($author->display_name)) . '">' . $name . '</a>';

			if ( (! empty($feed_image)) || (! empty($feed)) ) {
				$link .= ' ';
				if (empty($feed_image))
					$link .= '(';
				$link .= '<a href="' . get_author_rss_link(0, $author->ID, $author->user_nicename) . '"';

				if ( !empty($feed) ) {
					$title = ' title="' . $feed . '"';
					$alt = ' alt="' . $feed . '"';
					$name = $feed;
					$link .= $title;
				}

				$link .= '>';

				if ( !empty($feed_image) )
					$link .= "<img src=\"$feed_image\" border=\"0\"$alt$title" . ' />';
				else
					$link .= $name;

				$link .= '</a>';

				if ( empty($feed_image) )
					$link .= ')';
			}

			if ( $optioncount )
				$link .= ' ('. $posts . ')';

		}

		if ( !($posts == 0 && $hide_empty) )
			$return .= $link . '</li>';
	}
	if ( !$echo )
		return $return;
	echo $return;
}


?>
