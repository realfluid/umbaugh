<?php while(have_posts()): the_post();
	$this_id = $post->ID;
	if(in_category(11)):

		$title = get_post_meta($post->ID, "nl", true);

		global $wpdb;
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
		//generating the newsletter HTML

        //read the html base
        $path = "wp-content/plugins/umbaugh-newsletter-generator/base/";
        $file = fopen($path."main.html", "r");
        flock($file, LOCK_SH);
        $main_html = fread($file, filesize($path."main.html"));
        flock($file, LOCK_UN);
        fclose($file);
        (count($posts_unsorted) > 1) ? $file = fopen($path."post.html", "r") : $file = fopen($path."single.html", "r");
        flock($file, LOCK_SH);
        (count($posts_unsorted) > 1) ? $post_html = fread($file, filesize($path."post.html")) : $post_html = fread($file, filesize($path."single.html"));
        flock($file, LOCK_UN);
        fclose($file);

        //preparing the posts html
        foreach($posts as $p){
			if($p->ID == $this_id) continue;
            $a = !$a;
            if(!$a) {
                $align = "left";
                $margin = "margin-right";
            } else {
                $align = "right";
                $margin = "margin-left";
            }

            $permalink = get_option('home')."/".$p->post_name;
            $p->post_modified;

            $date_pieces = explode("-", substr($p->post_modified, 0, 10));
            $time_pieces = explode(":", substr($p->post_modified, 11));
            $post_time = mktime($time_pieces[0], $time_pieces[1], $time_pieces[2], $date_pieces[1], $date_pieces[2], $date_pieces[0]);
            $p->post_time = $post_time;

            //$author = $wpdb->get_var($wpdb->prepare("select display_name from $wpdb->users where ID={$p->post_author}"));
			$author = get_post_meta($p->ID, "author", true);
            $p->post_author_name = $author;
            $thumbnail = get_the_post_thumbnail($p->ID, 'newsletter');
            $thumbnail = str_replace("/>", "align='$align' style='$margin: 20px;' />", $thumbnail);

            $tags = array("<!-- title -->", "<!-- post_thumbnail -->", "<!-- author -->", "<!-- date -->", "<!-- excerpt -->", "<!-- permalink -->");
            $values = array($p->post_title, $thumbnail, $author, date("F j, Y", $post_time), $p->post_excerpt, $permalink);
            $phtml[] = str_replace($tags, $values, $post_html);
        }
        $posts_html = implode("\n", $phtml);

		$nl_permalink = get_option('home')."/".$post->post_name;

        //preparing main html

        $tags = array("<!-- home_url -->", "<!-- newsletter_title -->", "<!-- posts -->", "<!-- this_url -->");
        $values = array(get_option('home'), $title, $posts_html, $nl_permalink);
        $main_html = str_replace($tags, $values, $main_html);

        echo $main_html;
	else : ?>
		<?php get_header(); ?>
		<div class="interior-content">
			<div id="mainColumn">
				<?php if(in_category(18)): ?>
					<h1><?php the_title(); ?></h1>
					<div id="callout">
						<h2><?php echo get_post_meta($post->ID, "box title", true); ?></h2>
						<p><?php echo get_post_meta($post->ID, "box content", true); ?></p>
						<p><a href="<?php echo get_post_meta($post->ID, "box url", true); ?>">Read More &raquo;</a></p>
					</div>
					<p><?php the_excerpt(); ?></p>
					<?php if($post->post_content) : ?>
						<div id="services-table">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>

					<?php
					$projects = get_post_meta($post->ID, "projects", true);
					if($projects): ?>
						<div class="two-col-list">
							<h3>Representative Projects</h3>
							<?php $descr = get_post_meta($post->ID, "projects description", true);
							if($descr): ?>
								<p><?php echo $descr ?></p>
							<?php endif;
							$prj = explode("\n", $projects);
							$colCount = ceil(count($prj) / 2);
							?>
							<ul class="left">
								<?php for($i = 0; $i < $colCount; $i++): ?>
									<li><?php echo $prj[$i] ?></li>
								<?php endfor; ?>
							</ul>

							<ul class="right">
								<?php for($i = $colCount; $i < count($prj); $i++): ?>
									<li><?php echo $prj[$i] ?></li>
								<?php endfor; ?>
							</ul>
						</div>
					<?php endif; ?>

					<div id="wide-callout">
						<h2>Cash Advisory Services</h2>
						<p>Umbaugh Cash Advisory Services, LLC was developed as an independent business entity to help create a structured investment program for their bond proceeds and operating funds.</p>
						<p>To Learn More <a href="mailto:cash@umbaugh.com">email Cash Advisory Services</a></p>
					</div>
				<?php else : ?>
					<h1><?php the_title(); ?></h1>
					<div id="news" class="wide">
						<div class="news-story last pxBuffer">
							<span class="date"><?php $author = get_post_meta($post->ID, "author", true); if($author) echo $author.", "; ?><?php the_time("F j, Y"); ?><br><?php the_category(", "); ?></span>
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div id="sideColumn"><?php get_sidebar(); ?></div>
		</div>
		<?php get_footer(); ?>
	<?php endif; ?>
<?php endwhile; ?>
