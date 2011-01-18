<?php
/*
 * Template name: Services details
 */
get_header(); ?>

	<div class="interior-content">
        <div id="mainColumn">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
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
            <?php endwhile; ?>
		</div>
        <div id="sideColumn">
            <?php get_sidebar('basic'); ?>
		<?php get_sidebar('our-services'); ?>
        </div>
	</div>
<?php get_footer(); ?>
