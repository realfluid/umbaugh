<?php
/*
Plugin Name: Category Content
Plugin URI: http://merixstudio.com
Description: Lists posts (titles and excerpts) from a specified category and adds a link to the post's page
Author: Merix Studio
Version: 1
Author URI: http://merixstudio.com
*/

function categoryContent($cat, $post_count){
	query_posts("posts_per_page=$post_count&cat=$cat&orderby=ID"); ?>
	<ul>
	<?php while(have_posts()): the_post(); ?>
		<li><a href='<?php the_permalink() ?>'><?php the_title() ?></a><br>
		<p><?php excerpt(20); ?></p>
		</li>
	<?php endwhile; ?>
	</ul>
<?php }

function widget_categoryContent($args) {
	$data = get_option('category_content');
	extract($args);
	echo $before_widget;
	echo $before_title." ".$data['title']." ".$after_title;
	categoryContent($data['cat'], $data['post_count']);
	echo $after_widget;
}

function control(){
	$data = get_option('category_content');
	?>
	<p><label>Title:<input name="category_content_title" type="text" value="<?php echo $data['title']; ?>" /></label></p>
	<p><label>Category ID:<input name="category_content_cat" type="text" value="<?php echo $data['cat']; ?>" /></label></p>
	<p><label>Number of posts:<input name="category_content_post_count" type="text" value="<?php echo $data['post_count']; ?>" /></label></p>
  <?php
   if (isset($_POST['category_content_title'])){
    $data['title'] = attribute_escape($_POST['category_content_title']);
    $data['cat'] = attribute_escape($_POST['category_content_cat']);
	$data['post_count'] = attribute_escape($_POST['category_content_post_count']);
    update_option('category_content', $data);
  }

}

function categoryContent_init(){
  register_sidebar_widget('Category Content', 'widget_categoryContent');
  register_widget_control('Category Content', 'control');
}
add_action("plugins_loaded", "categoryContent_init");
?>
