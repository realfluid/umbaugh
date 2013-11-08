<?php
/*
Plugin Name: Highlight Search Terms
Plugin URI: http://4visions.nl/en/wordpress-plugins/highlight-search-terms
Description: Highlights search terms when referer is a search engine or within wp search results using jQuery. No options to set, just add a CSS rule for class "hilite" to your stylesheet to make the highlights show up any way you want them to. Example: ".hilite { background-color:yellow }" Read <a href="http://wordpress.org/extend/plugins/highlight-search-terms/other_notes/">Other Notes</a> for instructions and more examples. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=Highlight%20Search%20Terms&item_number=0%2e6&no_shipping=0&tax=0&bn=PP%2dDonationsBF&charset=UTF%2d8&lc=us" title="Thank you!">Tip jar</a>.
Version: 0.6
Author: RavanH
Author URI: http://4visions.nl/
*/

/*  Copyright 2010  RavanH  (email : ravanhagen@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, <http://www.gnu.org/licenses/> or
    write to the Free Software Foundation Inc., 59 Temple Place, 
    Suite 330, Boston, MA  02111-1307  USA.

    The GNU General Public License does not permit incorporating this
    program into proprietary programs.
*/

/*
    For Installation instructions, usage, revision history and other info: see readme.txt included in this package
*/

// -- GLOBALS -- //
define('HLST_VERSION','0.6');

// -- FUNCTIONS -- //

// Get search term
function hlst_get_search_query() {
	$referer = urldecode($_SERVER['HTTP_REFERER']);
	$query_array = array();

	if ( preg_match('@^http://(.*)?\.?(google|yahoo|lycos|bing|ask|baidu|youdao).*@i', $referer) ) {
		$query =  preg_replace('/^.*(&q|query|p|wd)=([^&]+)&?.*$/i','$2', $referer);
	} else {
		$query = get_search_query();
	}
	preg_match_all('/([^\s"\']+)|"([^"]*)"|\'([^\']*)\'/', $query, $query_array);

	return $query_array[0];
}

// Get query variables 
function hlst_query() {
	global $hlst_do_extend;

	$areas = array(		// Change or extend this to match themes content div ID or classes.
		'div.hentry',	// The hilite script will test div ids/classes and use the first one it
		'#content',	// finds so put the most common one first, then follow with the less
		'#main',	// used or common outer wrapper div ids.
		'div.content',	// When referencing an *ID name*, just be sure to begin with a '#'.
		'#middle',	// When referencing a *class name*, try to put the tag in front,
		'#container',	// followed by a '.' and then the class name to *improve script speed*.
		'#wrapper',	// Example: div.hentry instead of just .hentry
		);		// Using the tag 'body' is known to cause conflicts.
			
	// js >> var hlst_ids = new Array("'.$id'","#main","#wrapper");
	//$bgclr = '#D3E18A';	// default moss background 
				// dark orange:#9CD4FF; lightblue:#9CD4FF; light orange:#FFCA61

	$terms = hlst_get_search_query();
	$filtered = array();
	foreach($terms as $term){
		$term = attribute_escape(trim(str_replace(array('"','\'','%22'), '', $term)));
		if ( !empty($term) ){
			$filtered[] = '"'.$term.'"';
		}
	}	
	if (count($filtered) > 0) { 
		$hlst_do_extend = true;
		echo '
<!-- Highlight Search Terms ' . HLST_VERSION . ' ( RavanH - http://4visions.nl/en/wordpress-plugins/highlight-search-terms/ ) -->
<script type="text/javascript">
var hlst_query = new Array(' . implode(',',$filtered) . ');
var hlst_areas = new Array("' . implode('","',$areas) . '");
</script>
';
	}
} 

// Extend jQ 
function hlst_extend() {
	global $hlst_do_extend;

	if ($hlst_do_extend) {
		wp_register_script('hlst-extend', plugins_url('hlst-extend.js', __FILE__), array('jquery'), HLST_VERSION, true);

		wp_print_scripts('hlst-extend');
	}
}

// -- HOOKING INTO WP -- //

// Set query string as js variable in header
add_action('wp_head', 'hlst_query', 5);

// Extend jQ in footer
add_action('wp_footer', 'hlst_extend');

