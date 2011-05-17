<?php
/*
Plugin Name: Umbaugh Newsletter Generator
Plugin URI: http://merixstudio.com
Description: Enables you to create a newsletter HTML containing excerpts and thumbnails of selected posts
Author: Merix Studio
Version: 1
Author URI: http://merixstudio.com
*/

add_action('admin_menu', 'ung_menu');

function ung_menu(){
    add_posts_page('Newsletters', 'Newsletters', 'edit_posts', 'ung_list', 'ung_list');
    add_posts_page('Create a new newsletter', 'Create newsletter', 'edit_posts', 'ung-create-newsletter', 'ung_new');
    add_posts_page('', '', 'edit_posts', 'ung_edit', 'ung_edit');
}

function ung_list(){
    ?>
    <div id="wpbody-content">
        <div class="wrap">
            <h2>Existing newsletters</h2>
            <?php
            global $wpdb;
            if($_GET['del']) {
                $del = urldecode($_GET['del']);
                $posts = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_key='newsletter' and meta_value='$del'");
                if(count($posts)) foreach($posts as $post) {
                    delete_post_meta($post->post_id, "newsletter", $del);
                    delete_post_meta($post->post_id, "newsletter_order");
                }
                $nl_post = $wpdb->get_row("select * from $wpdb->posts where ID in (select post_id from $wpdb->postmeta where meta_key='nl' and meta_value='$del')");
                delete_post_meta($nl_post->ID, "nl", $del);
                $wpdb->query("delete from $wpdb->posts where ID={$nl_post->ID}");
                $wpdb->query("delete from $wpdb->term_relationships where object_id={$nl_post->ID}");
            }

            $newsletters = $wpdb->get_results("select distinct meta_value from $wpdb->postmeta where meta_key='newsletter' order by meta_value asc");
            if(count($newsletters)):?>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th>Newsletter</th>
                            <th>Post count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($newsletters as $n): $alt = !$alt; ?>
                    <tr <?php if(!$alt): echo "class='alternate'"; endif; ?>>
                        <td><?php echo $n->meta_value; ?></td>
                        <td>
                            <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->postmeta where meta_value='{$n->meta_value}' and meta_key='newsletter'")); ?>
                        </td>
                        <td><a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($n->meta_value) ?>">Edit</a> | <a href="edit.php?page=ung_list&amp;del=<?php echo urlencode($n->meta_value) ?>">Delete</a></td>
                    </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>There are no newsletters currently. Would you like to <a href="edit.php?page=ung-create-newsletter">create one</a>?</p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function ung_new(){
    ?>
    <div id="wpbody-content">
        <div class="wrap">
            <h2>Create a new newsletter</h2>
            <form action="" method="post">
                <p class="submit"><input type="submit" name="Create" class="button-primary" value="<?php esc_attr_e('Save the newsletter') ?>" /></p>
                <?php

                    if($_POST['Create']){
                        if(!$_POST['newsletter_title']) $errors[] = "The newsletter needs to have a title.";
                        if(!count($_POST['add_post'])) $errors[] = "Please choose at least one post";

                        if(!$errors){
                            foreach($_POST['add_post'] as $k=>$id) {
                                add_post_meta($id, "newsletter", strip_tags($_POST['newsletter_title']));
                                add_post_meta($id, "newsletter_order", $k+1);
                            }
                            global $current_user;
                            $user = $current_user->data;
                            global $wpdb;
                            $bad = array(" ", "  ", "!", "?", "-", ":", ";", "(", ")", "[", "]", "'", "\"");
                            $good = array("-", "-", "", "", "", "", "", "", "", "", "", "", "");
                            $ok = $wpdb->insert($wpdb->posts, array(
                                "post_author" => $user->ID,
                                //"post_date" => date("Y-m-d H:i:s"),
                                "post_title" => $_POST['newsletter_title'],
                                "post_content" => $_POST['newsletter_descr'],
                                "post_name" => str_replace($bad, $good, strtolower($_POST['newsletter_title']))
                            ));
                            if($ok){
                                $new = $wpdb->insert_id;
                                add_post_meta($new, "nl", strip_tags($_POST['newsletter_title']));
                                $wpdb->insert($wpdb->term_relationships, array(
                                    "object_id" => $new,
                                    "term_taxonomy_id" => 11
                                ));
                            }
                            ?>
                            <div class="updated below-h2">
                                <p>Newsletter has been created. Now you can <a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($_POST['newsletter_title']) ?>">edit it</a>.</p>
                            </div>
                            <?php
                        } else {
                            foreach($errors as $e) : ?>
                                <div class="error below-h2">
                                    <p><?php echo $e ?></p>
                                </div>
                            <?php endforeach;
                        }
                    }
                ?>
                <p><label for="newsletter_title">Newsletter title: </label><input name="newsletter_title" id="newsletter_title" size="50"></p>
                <p><label for="newsletter_descr">Newsletter description (shown on website only): </label><br><textarea name="newsletter_descr" id="newsletter_descr" rows="5" cols="120"></textarea></p>
                <p>Choose posts to be added to the newsletter by selecting appropriate check boxes</p>
                <?php
                global $wpdb;
                $posts = $wpdb->get_results("select * from $wpdb->posts where post_status='publish' and post_type='post' and ID not in (select post_id from $wpdb->postmeta where meta_key='nl') order by id desc");
                foreach($posts as $post){
                    $date_pieces = explode("-", substr($post->post_modified, 0, 10));
                    $time_pieces = explode(":", substr($post->post_modified, 11));
                    $post_time = mktime($time_pieces[0], $time_pieces[1], $time_pieces[2], $date_pieces[1], $date_pieces[2], $date_pieces[0]);
                    $post->post_time = $post_time;

                    $author = $wpdb->get_var($wpdb->prepare("select display_name from $wpdb->users where ID={$post->post_author}"));
                    $post->post_author_name = $author;
                }
                if(count($posts)): ?>
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
                            <?php foreach($posts as $p):
                                if($p->post_title) :
                                $alt = !$alt; ?>
                                <tr <?php if(!$alt) echo "class='alternate'"; ?>>
                                <td><input name="add_post[]" value="<?php echo $p->ID ?>" type="checkbox"></td>
                                <td><strong><a href="<?php echo get_option('home')."/".$p->post_name ?>"><?php echo $p->post_title ?></a></strong></td>
                                <td><?php echo $p->post_author_name ?></td>
                                <td><?php echo $p->post_date ?></td>
                                <td><?php echo nl2br($p->post_excerpt); ?></td>
                            </tr>
                            <?php endif; endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <p class="submit"><input type="submit" name="Create" class="button-primary" value="<?php esc_attr_e('Save the newsletter') ?>" /></p>
            </form>
        </div>
    </div>
    <?php
}

function ung_edit(){
    $title = urldecode($_GET['newsletter']);
    $newsletterTitle = $title;
    if($title){
    if($_GET['del']) {
        delete_post_meta($_GET['del'], "newsletter", $title);
        delete_post_meta($_GET['del'], "newsletter_order");
    }
    if($_GET['add']) {
        add_post_meta($_GET['add'], "newsletter", $title);
        add_post_meta($_GET['add'], "newsletter_order", $_GET['pos']);
    }

    global $wpdb;
    if($_POST['SaveDescr']){
        $wpdb->update($wpdb->posts, array("post_content" => $_POST['newsletter_descr'], "post_modified" => date("Y-m-d H:i:s")), array("ID" => $_POST['post_id']));
    }
    $nl_post = $wpdb->get_row("select * from $wpdb->posts where ID in (select post_id from $wpdb->postmeta where meta_key='nl' and meta_value='$title')");
    $posts_unsorted = $wpdb->get_results("select * from $wpdb->posts where ID in (select post_id from $wpdb->postmeta where meta_key='newsletter' and meta_value='$title')");

    //sorting posts
    $max_pos = 0;
    for($i = 0; $i < count($posts_unsorted); $i++){
        $pos = get_post_meta($posts_unsorted[$i]->ID, "newsletter_order", true);
        if(!$pos || $pos == "") {
            $positions = $wpdb->get_results("select meta_value from $wpdb->postmeta where meta_key='newsletter_order' and post_id in (select post_id from $wpdb->postmeta where meta_key='newsletter' and meta_value='$title')");
            foreach($positions as $k=>$v) $p[] = $v->meta_value;
            $pos = max($p) + 1;
            update_post_meta($posts_unsorted[$i]->ID, "newsletter_order", $pos);
        }
        $posts_unsorted[$i]->newsletter_order = $pos;
        if($pos > $max_pos) $max_pos = $pos;
    }

    if($max_pos > count($posts_unsorted)) $limit = $max_pos; else $limit = count($posts_unsorted);

    for($i = 0; $i <= $limit; $i++){
        foreach($posts_unsorted as $k=>$v) if($v->newsletter_order == $i) {
            $posts[] = $posts_unsorted[$k];
            break;
        }
    }

    //changing setting of content type to use
    if($_GET['use'] && $_GET['post']) update_post_meta($_GET['post'], "use in newsletter", $_GET['use']);

    //changing order of posts if user clicked "move up" or "move down" link
    if($_GET['up']){
        foreach($posts as $k=>$v) if($posts[$k]->ID == $_GET['up']) {
            $prev = $k - 1;
            $current = $k;
            break;
        }
        if($prev >= 0){
            $buffer = $posts[$prev]->newsletter_order;
            $posts[$prev]->newsletter_order = $posts[$current]->newsletter_order;
            $posts[$current]->newsletter_order = $buffer;
            $buffer = $posts[$prev];
            $posts[$prev] = $posts[$current];
            $posts[$current] = $buffer;
            update_post_meta($posts[$current]->ID, "newsletter_order", $posts[$current]->newsletter_order);
            update_post_meta($posts[$prev]->ID, "newsletter_order", $posts[$prev]->newsletter_order);
        }
    }
    if($_GET['down']){
        foreach($posts as $k=>$v) if($posts[$k]->ID == $_GET['down']) {
            $next = $k + 1;
            $current = $k;
            break;
        }
        if($next < count($posts)){
            $buffer = $posts[$next]->newsletter_order;
            $posts[$next]->newsletter_order = $posts[$current]->newsletter_order;
            $posts[$current]->newsletter_order = $buffer;
            $buffer = $posts[$next];
            $posts[$next] = $posts[$current];
            $posts[$current] = $buffer;
            update_post_meta($posts[$current]->ID, "newsletter_order", $posts[$current]->newsletter_order);
            update_post_meta($posts[$next]->ID, "newsletter_order", $posts[$next]->newsletter_order);
        }
    }
    if(count($posts)){

        //generating the newsletter HTML

        //read the html base
        $path = "../wp-content/plugins/umbaugh-newsletter-generator/base/";
        $file = fopen($path."main.html", "r");
        flock($file, LOCK_SH);
        $main_html = fread($file, filesize($path."main.html"));
        flock($file, LOCK_UN);
        fclose($file);

        (count($posts) > 1) ? $file = fopen($path."post.html", "r") : $file = fopen($path."post.html", "r");

        flock($file, LOCK_SH);
        (count($posts) > 1) ? $post_html = fread($file, filesize($path."post.html")) : $post_html = fread($file, filesize($path."post.html"));

        flock($file, LOCK_UN);
        fclose($file);

        //preparing the posts html
        foreach($posts as $post){

            $a = !$a;
            if(!$a) {
                $align = "left";
                $margin = "margin-right";
            } else {
                $align = "right";
                $margin = "margin-left";
            }

            $permalink = "http://".get_option('home')."/".$post->post_name;
            $post->post_modified;

            $date_pieces = explode("-", substr($post->post_modified, 0, 10));
            $time_pieces = explode(":", substr($post->post_modified, 11));
            $post_time = mktime($time_pieces[0], $time_pieces[1], $time_pieces[2], $date_pieces[1], $date_pieces[2], $date_pieces[0]);
            $post->post_time = $post_time;

            //$author = $wpdb->get_var($wpdb->prepare("select display_name from $wpdb->users where ID={$post->post_author}"));
            //$q = "select meta_value from $wpdb->postmeta where meta_key='author' and post_id={$post->ID}";
            //$author = $wpdb->get_var($wpdb->prepare($q));
            $author = get_post_meta($post->ID, "author", true);
            $post->post_author_name = $author;
            $thumbnail = get_the_post_thumbnail($post->ID, 'newsletter');
            $thumbnail = str_replace("/>", "align='$align' style='$margin: 20px;' />", $thumbnail);
            $use = get_post_meta($post->ID, "use in newsletter", true);

            //$wpdb->get_var($wpdb->prepare("select meta_value from $wpdb->postmeta where meta_key='use in newsletter' and post_id='{$post->ID}'"));
            if($use == "content") {
                $stuff = $post->post_content;
                $post->content2use = "content";
            } else {
                $stuff = $post->post_excerpt;
                $post->content2use = "excerpt";
            }
            $tags = array("<!-- title -->", "<!-- post_thumbnail -->", "<!-- author -->", "<!-- date -->", "<!-- excerpt -->", "<!-- permalink -->");
            $values = array($post->post_title, $thumbnail, $author, date("F j, Y", $post_time), $stuff, $permalink);
            
            $phtml[] = str_replace($tags, $values, $post_html);
        }
        $posts_html = implode("\n", $phtml);
        //preparing main html
        $the_post = $wpdb->get_results("select post_name from $wpdb->posts where ID in (select post_id from $wpdb->postmeta where meta_key='nl' and meta_value='$title')");
        $nl_permalink = get_option('home')."/".$the_post[0]->post_name;

        $tags = array("<!-- home_url -->", "<!-- newsletter_title -->", "<!-- posts -->", "<!-- this_url -->");
        $values = array(get_option('home'), $title, $posts_html, $nl_permalink);
        
        $main_html = str_replace($tags, $values, $main_html);

        //generating the preview file
        $preview_file = "preview_".time().".html";
        $preview_path = "../wp-content/uploads/$preview_file";
        file_put_contents($preview_path, $main_html);
    }



    //deleting old preview files
    if ($handle = opendir("../wp-content/uploads")) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && !is_dir($file)) {
                if(eregi("preview_", $file) && $file != $preview_file) unlink("../wp-content/uploads/$file");
            }
        }
        closedir($handle);
    }
    ?>

    <div id="wpbody-content">
        <div class="wrap">
            <h2>Editing newsletter: <?php echo $title ?></h2>
            <form action="" method="post">

                <p>Newsletter description (shown on site only):<br><textarea name="newsletter_descr" id="newsletter_descr" rows="5" cols="120"><?php echo $nl_post->post_content ?></textarea></p>
                <input type="hidden" name="post_id" value="<?php echo $nl_post->ID ?>">
                <p class="submit"><input type="submit" name="SaveDescr" class="button-primary" value="<?php esc_attr_e('Save description') ?>" /></p>
            </form>

            <p>This newsletter contains <?php echo count($posts) ?> posts</p>

            <h3>Manage posts</h3>
            <p>These are the posts contained in the newsletter. You can change their order or remove them from the newsletter. Removing posts from the newsletter doesn't remove them from the website.</p>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>Post title</th>
                        <th>Author</th>
                        <th>Content used</th>
                        <th>Date/Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($posts)) foreach($posts as $p): $alt = !$alt; ?>
                <tr <?php if(!$alt): echo "class='alternate'"; endif; ?>>
                    <td><a href="<?php echo get_option('home')."/".$p->post_name; ?>"><?php echo $p->post_title; ?></a></td>
                    <td><?php echo $p->post_author_name ?></td>
                    <td>
                        <?php if($p->content2use == "excerpt"): ?>
                        Excerpt (<a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($newsletterTitle) ?>&amp;post=<?php echo $p->ID; ?>&amp;use=content">Click here to use content</a>)
                        <?php else : ?>
                        Content (<a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($newsletterTitle) ?>&amp;post=<?php echo $p->ID; ?>&amp;use=excerpt">Click here to use excerpt</a>)
                        <?php endif; ?>
                    </td>
                    <td><?php echo $p->post_date ?></td>
                    <td><a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($newsletterTitle) ?>&amp;up=<?php echo $p->ID ?>">Move Up</a> | <a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($newsletterTitle) ?>&amp;down=<?php echo $p->ID ?>">Move Down</a> | <a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($newsletterTitle) ?>&amp;del=<?php echo $p->ID ?>">Remove from newsletter</a></td>
                </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <h3>Add more posts</h3>
            <p>This is a list of other posts published on the website. You can add any of them to the newsletter.</p>
            <div style="height: 300px; overflow: scroll; border: 1px solid #dfdfdf;">
                <table class="widefat">
                    <thead>
                        <tr>
                            <th>Post title</th>
                            <th>Author</th>
                            <th>Date/Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $new_posts = $wpdb->get_results("select * from $wpdb->posts where post_type='post' and post_status='publish' and ID not in (select post_id from $wpdb->postmeta where meta_key='newsletter' and meta_value='$title')");
                    foreach($new_posts as $post){
                        $author = $wpdb->get_var($wpdb->prepare("select display_name from $wpdb->users where ID={$post->post_author}"));
                        $post->post_author_name = $author;
                    }
                    if(count($new_posts)) foreach($new_posts as $p): $alt = !$alt; ?>
                    <tr <?php if(!$alt): echo "class='alternate'"; endif; ?>>
                        <td><a href="<?php echo get_option('home')."/".$p->post_name; ?>"><?php echo $p->post_title; ?></a></td>
                        <td><?php echo $p->post_author_name ?></td>
                        <td><?php echo $p->post_date ?></td>
                        <td><a href="edit.php?page=ung_edit&amp;newsletter=<?php echo urlencode($title) ?>&amp;add=<?php echo $p->ID ?>">Add to newsletter</a></td>
                    </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <h3>The newsletter HTML</h3>
            <p>Copy all the code below and paste it into your email editing software</p>
            <textarea rows="10" cols="120" name="code" id="code"><?php echo htmlentities($main_html) ?></textarea>

            <h3>Preview</h3>
            <iframe width="800" height="800" src="<?php echo get_option('home') ?>/wp-content/plugins/umbaugh-newsletter-generator/preview.php?html=<?php echo $preview_file ?>" style="border: 1px solid #dfdfdf;">
            </iframe>
        </div>
    </div>
    <?php
    } else { ?>
    <div id="wpbody-content">
        <div class="wrap">
            <p>No newsletter was chosen</p>
        </div>
    </div>
    <?php }
}