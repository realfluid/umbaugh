<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="http://www.isocra.com/js/tablednd.js" type="text/javascript"></script>
<?php
/*
Plugin Name: Newsletter Creator
Plugin URI:
Description: Create a newsletter from posts that are available in this Wordpress-installation
Version: 0.1
Author: Koen Huybrechts
Author URI: http://www.go-online.be
License:
*/


//Initialization
add_action('admin_menu', 'menu');

function menu(){
    add_posts_page('Newsletter Creator', 'Newsletter Creator', 'edit_posts', 'newsletter-creator', 'overview');
    add_posts_page('', '', 'edit_posts', 'newsletter-create', 'create');
    add_posts_page('', '', 'edit_posts', 'newsletter-htmlcode', 'html');
    add_posts_page('', '', 'edit_posts', 'newsletter-edit', 'edit');
    add_posts_page('', '', 'edit_posts', 'newsletter-delete', 'delete');
}

function overview()
{
	?>
	<div class="wrap">
	<h2>Newsletter Creator</h2>
		<?php
				if(isset($_POST['Create'])) {
					save($_POST);
				} elseif(isset($_POST['Update'])) {
					update($_POST);
				} else {
					show_newsletter_list();
				}
			?>
		</div>
	<?php
}

function show_newsletter_list()
{
	?>
	<a href="/wp-admin/edit.php?page=newsletter-create">Create Newsletter</a>
	<?php

	query_posts('cat=11&order=DESC&posts_per_page=-1');
    ?>
    	<table class="widefat">
    		<thead>
				<tr>
				    <th>Newsletter</th>
					<th>Date</th>
				    <th>Actions</th>
				</tr>
    		</thead>
    		<tbody>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    			<?php $alt = !$alt; ?>
    			<tr <?php if(!$alt): echo "class='alternate'"; endif; ?>>
					<td><?php the_title() ?></td>
    				<td><?php echo the_time("F j, Y"); ?></td>
					<td><a href="edit.php?page=newsletter-edit&amp;id=<?php the_ID(); ?>">Edit</a> | <a href="edit.php?page=newsletter-delete&amp;id=<?php the_ID(); ?>">Delete</a> | <a href="<?php the_permalink(); ?>">View newsletter</a></td>
    			</tr>

            <?php endwhile; else: ?>
				<p>There are no newsletters currently. Would you like to <a href="edit.php?page=ung-create-newsletter">create one</a>?</p>
		    <?php endif; ?>
    		</tbody>
		</table>
    <?php


}

function create()
{

    if (function_exists('wp_tiny_mce')) {

      add_filter('teeny_mce_before_init', create_function('$a', '
        $a["theme"] = "advanced";
        $a["skin"] = "wp_theme";
        $a["height"] = "200";
        $a["width"] = "800";
        $a["onpageload"] = "";
        $a["mode"] = "exact";
        $a["elements"] = "newsletter_descr";
        $a["editor_selector"] = "mceEditor";
        $a["plugins"] = "safari,inlinepopups,spellchecker";

        $a["forced_root_block"] = false;
        $a["force_br_newlines"] = true;
        $a["force_p_newlines"] = false;
        $a["convert_newlines_to_brs"] = true;

        return $a;'));

     wp_tiny_mce(true);
    }
	?>
	<script>
		 $(document).ready(function(){
		 	$("#posts td").removeClass("alternate");
		 	$("#posts tr:even").addClass("alternate");
			$(function() {
			   $(".checkboxColumn").change(function() {
			   	if ($(this).is(":checked")){
			   		var check = $("#posts input:checked").parent().parent();
			   		var time = $(this).val();
			   		$(check).prepend("<td class=\"sortbuttons\"><span class=\"up\">Up</span></br><span class=\"down\">Down</span></td>").removeClass("alternate");
			   		$(check).children(".excerpt").before("<td class=\"contenttype\"><input type=\"radio\" name=\"contentType"+time+"\" value=\"excerpt\" CHECKED/> Excerpt<br /><input type=\"radio\" name=\"contentType"+time+"\" value=\"content\" /> Content</td>");
			   		$("#addPosts").append(check);
			   		$(".sortbuttons").width(85);
			   		$(".sortbuttons a").width(80);
			   		$(".contenttype").width(80);
			   		$(".up").click(function () {
			   			var row = $(this).parent().parent();
			   			var previous = row.prev();
			   			previous.before(row);
			   			$("#addPosts tr").removeClass("alternate");
			   			$("#addPosts tr:even").addClass("alternate");
			   		});
			   		$(".down").click(function () {
			   			var row = $(this).parent().parent();
			   			var next = row.next();
			   			next.after(row);
			   			$("#addPosts tr").removeClass("alternate");
			   			$("#addPosts tr:even").addClass("alternate");
			   		});
			   		$("#addPosts tr:even").addClass("alternate");
			   	}else {
			   		var uncheck =$(this).parent().parent();
			   		$("#posts").append(uncheck);
			   		$("#posts .sortbuttons").remove();
			   		$("#posts .contenttype").remove()
			   		$("#posts td").removeClass("alternate");
			   		$("#posts tr:even").addClass("alternate");
			   	}	
			   });
			});
		});
	</script>
	<div class="wrap">
		<h2>Newsletter Creator</h2>
		<form method="post" action="/wp-admin/edit.php?page=newsletter-creator" >
			<p class="submit">
				<input type="submit" name="Create" class="button-primary" value="<?php esc_attr_e ( 'Save the newsletter') ?>" />
			</p>
			<p>
				<label for="newsletter_title">Newsletter title: </label>
				<input name="newsletter_title" id="newsletter_title" size="50">
			</p>
			<p>
				<label for="newsletter_descr">Newsletter description (shown on website only): </label><br>
				<textarea id='newsletter_descr' name='newsletter_descr'></textarea>
			</p>
			<p>
				<input type="checkbox" name="publish" value="1" /> Publish on save
			</p>
			<p>
				Chosen posts:
				<table class="widefat" id="postTable">
					<thead>
						<tr>
							<th>Sort</th>
							<th></th>
							<th>Post title</th>
							<th>Author</th>
							<th>Date/Time</th>
							<th>Content type</th>
							<th>Excerpt</th>
						</tr>
					</thead>
					<tbody id="addPosts">
					</tbody>
				</table>
			</p>
			<p>
				Choose posts to be added to the newsletter by selecting appropriate check boxes
			</p>
		<?php
	        	global $wpdb;
	            $posts = $wpdb->get_results("select * from $wpdb->posts where (post_status='publish' OR post_status='future')  and post_type='post' and ID not in (select post_id from $wpdb->postmeta where meta_key='nl') and  post_date > '".date('Y-m-d', strtotime('-90 days'))."' order by id desc");
	            foreach($posts as $post){
	                $date_pieces = explode("-", substr($post->post_modified, 0, 10));
	                $time_pieces = explode(":", substr($post->post_modified, 11));
	                $post_time = mktime($time_pieces[0], $time_pieces[1], $time_pieces[2], $date_pieces[1], $date_pieces[2], $date_pieces[0]);
	                $post->post_time = $post_time;

	                $author = $wpdb->get_var($wpdb->prepare("select display_name from $wpdb->users where ID={$post->post_author}"));
	                $post->post_author_name = $author;
	            }
	            if(count($posts)): ?>
		<table class="widefat" id="table">
			<thead>
				<tr>
					<th></th>
					<th>Post title</th>
					<th>Author</th>
					<th>Date/Time</th>
					<th>Excerpt</th>
				</tr>
			</thead>
			<tbody id="posts">
		        <?php foreach($posts as $p):
		        $cats = wp_get_post_categories($p->ID);
		        if(!in_array(11, $cats)) {
					if ($p->post_title) : $alt = ! $alt; ?>
    		        <tr>
    					<td><input name="add_post[]" value="<?php echo $p->ID ?>" type="checkbox" class="checkboxColumn"></td>
    					<td><strong><a href="<?php	echo get_option ( 'home' ) . "/" . $p->post_name?>"><?php echo $p->post_title?></a></strong></td>
    					<td><?php echo $p->post_author_name?></td>
    					<td><?php echo $p->post_date?></td>
    					<td class="excerpt"><?php echo nl2br ( $p->post_excerpt ); ?></td>
    				</tr>

    				<?php endif;
		        }
				endforeach;
				?>
			</tbody>
		</table>

		<?php endif; ?>
		<p class="submit"><input type="submit" name="Create" class="button-primary" value="<?php esc_attr_e ( 'Save the newsletter') ?>" /></p>
	<form action=""></form>
	</div>
	<?php
}

function save($data)
{
	$published = ($data['publish'] == 1 ? 'publish' : 'draft');
	$current_user = wp_get_current_user();
	// Create post object
    $my_post = array(
        'post_title' => $data['newsletter_title'],
        'post_content' => $data['newsletter_descr'],
        'post_status' => $published,
        'post_author' => $current_user->ID,
        'post_category' => array(11),
    	'post_name' => $data['newsletter_title']
    );

    foreach ($data['add_post'] as $id)
    {
    	$metaArray = array();
    	$metaArray['id'] = $id;
    	$metaArray['content'] = 'content';
    	$postData[] = $metaArray;
    }
    // Insert the post into the database
    $postId = wp_insert_post( $my_post );
    if(add_post_meta($postId, 'newsletter_items', $postData, true)) {
    	html($postId);
    }
}

function html($postId)
{
	$post = get_post($postId);
	$postItems = get_post_meta($postId, 'newsletter_items', true);

	$path = WP_PLUGIN_DIR .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . '/' . 'base';
	$postHtml = file_get_contents($path . '/post.html');
	$mainHtml = file_get_contents($path . '/main.html');
	foreach ($postItems as $item)
	{
        $a = !$a;
        if(!$a) {
            $align = "right";
            $margin = "margin-left";
        } else {
           $align = "right";
           $margin = "margin-left";
        }

		$itemData = get_post($item['id']);


		if($use == "content") {
            $content = $itemData->post_content;
        } else {
            $content = $itemData->post_excerpt;
        }
        $thumbnail = get_the_post_thumbnail($itemData->ID, 'newsletter');
        $thumbnail = str_replace("/>", "align='$align' />", $thumbnail);
	    $tags = array("<!-- title -->", "<!-- post_thumbnail -->", "<!-- author -->", "<!-- date -->", "<!-- excerpt -->", "<!-- permalink -->");
	    $values = array($itemData->post_title, $thumbnail, get_post_meta($itemData->ID, "author", true), date("F j, Y", $post_time), $content, get_permalink($itemData->ID));
	    $phtml[] = str_replace($tags, $values, $postHtml);

	}
	$postsHtml = implode('', $phtml);

    $tags = array("<!-- home_url -->", "<!-- newsletter_title -->", "<!-- posts -->", "<!-- this_url -->");
    $values = array(get_option('home'), $title, $postsHtml, get_permalink($postId));
    $mainHtml = str_replace($tags, $values, $mainHtml);
    echo '<p>' . $mainHtml . '</p>';
}

function delete()
{
	$postId = $_GET['id'];
	wp_delete_post($postId);
	overview();

}

function edit()
{
	$postId = $_GET['id'];

	$post = get_post($postId);
	//var_dump($post); die;
	$postItems = get_post_meta($postId, 'newsletter_items', true);

	foreach ($postItems as $item)
	{
		$postIds[] = $item['id'];
	}

	?>
	<div class="wrap">
	<h2>Newsletter Creator: Edit Newsletter</h2>
	<form method="post" action="/wp-admin/edit.php?page=newsletter-creator" >
	<input type="hidden" name="id" value="<?php echo $post->ID;?>" />
	<p class="submit"><input type="submit" name="Update" class="button-primary" value="<?php esc_attr_e ( 'Update the newsletter') ?>" /></p>

	<p><label for="newsletter_title">Newsletter title: </label><input name="newsletter_title" id="newsletter_title" size="50" value="<?php echo $post->post_title; ?>"></p>
	<p><label for="newsletter_descr">Newsletter description (shown on
	website only): </label><br>
	<textarea name="newsletter_descr" id="newsletter_descr" rows="5" cols="120"><?php echo $post->post_content; ?></textarea></p>
	<p><input type="checkbox" name="publish" value="1" /> Publish on save
	<p>Choose posts to be added to the newsletter by selecting appropriate
	check boxes</p>
		<table class="widefat">
			<thead>
				<tr>
					<th></th>
					<th>Post title</th>
					<th>Author</th>
					<th>Date/Time</th>
					<th>Excerpt</th>
				</tr>
			</thead>
			<tbody>
		        <?php
		        	global $wpdb;
	            	$posts = $wpdb->get_results("select * from $wpdb->posts where post_status='publish' and post_type='post' and ID not in (select post_id from $wpdb->postmeta where meta_key='nl') and  post_date > '".date('Y-m-d', strtotime('-90 days'))."' order by id desc");

		        	foreach($posts as $p):
		        	$cats = wp_get_post_categories($p->ID);
		        	if(!in_array(11, $cats)) {
        				if ($p->post_title) : $alt = ! $alt; ?>
        		        <tr <?php if (! $alt) echo "class='alternate'"; ?>>
        					<td><input name="add_post[]" value="<?php echo $p->ID ?>" type="checkbox" <?php echo (in_array($p->ID, $postIds) ? 'checked' : ''); ?>></td>
        					<td><strong><a href="<?php	echo get_option ( 'home' ) . "/" . $p->post_name?>"><?php echo $p->post_title?></a></strong></td>
        					<td><?php echo $p->post_author_name?></td>
        					<td><?php echo $p->post_date?></td>
        					<td><?php echo nl2br ( $p->post_excerpt ); ?></td>
        				</tr>

        				<?php endif;
		        	}
				endforeach;
				?>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="Update" class="button-primary" value="<?php esc_attr_e ( 'Update the newsletter') ?>" /></p>

	<form action=""></form>
	</div>
	<?php
}

function update($data)
{
	//var_dump($data); die;
	$published = ($data['publish'] == 1 ? 'publish' : 'draft');
	$current_user = wp_get_current_user();
	// Create post object
    $my_post = array(
    	'ID' => $data['id'],
        'post_title' => $data['newsletter_title'],
        'post_content' => $data['newsletter_descr'],
        'post_status' => $published,
        'post_author' => $current_user->ID,
        'post_category' => array(11),
    	'post_name' => $data['newsletter_title']
    );
    if(count($data['add_post']) > 0) {
	    foreach ($data['add_post'] as $id)
	    {
	    	$metaArray = array();
	    	$metaArray['id'] = $id;
	    	$metaArray['content'] = 'content';
	    	$postData[] = $metaArray;
	    }
    }
    // Insert the post into the database
    $postId = wp_update_post( $my_post );
    if(update_post_meta($postId, 'newsletter_items', $postData)) {
    	html($postId);
    } else {
    	show_newsletter_list();
    }
}