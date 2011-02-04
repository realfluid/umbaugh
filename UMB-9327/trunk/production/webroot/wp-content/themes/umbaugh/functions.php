<?php
	register_sidebar( array(
		'name' => __( 'Default sidebar'),
		'id' => 'default-sidebar',
		'description' => __( 'The default sidebar'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Basic sidebar',
		'id' => 'basic',
		'description' => __( 'Basic sidebar used in most of the templates, meant to contain common widgets'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'About Us',
		'id' => 'about',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Our Services',
		'id' => 'our-services',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Join Our Firm',
		'id' => 'join-our-firm',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Contact Us',
		'id' => 'contact-us',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Login',
		'id' => 'login',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Our Experience',
		'id' => 'experience',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Our Library',
		'id' => 'library',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );



add_theme_support('menus');
register_nav_menus( array(
	'primary' => __( 'Primary Navigation'),
	'footer' => __( 'Footer links')
) );
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 50, 50, true );
add_image_size('showcase', 407, 320, true);
add_image_size('partner', 100, 500);
add_image_size('newsletter', 106, 126, true);


add_action( 'init', 'create_post_types' );
function create_post_types() {
  register_post_type( 'showcase',
    array(
      'labels' => array(
        'name' => __( 'Showcase' ),
        'singular_name' => __( 'Showcase' )
      ),
      'public' => true,
	  'exclude_from_search' => true,
	  'menu_position' => 4,
	  'supports' => array('thumbnail', 'custom-fields', 'title', 'editor', 'excerpt')
    )
  );

  register_post_type( 'partner',
    array(
      'labels' => array(
        'name' => __( 'Partners' ),
        'singular_name' => __( 'Partner' )
      ),
      'public' => true,
	  'exclude_from_search' => true,
	  'menu_position' => 5,
	  'supports' => array('thumbnail', 'custom-fields', 'title', 'editor', 'excerpt')
    )
  );
}

function loadValidation() {
    if(!is_admin()) {
        wp_register_script(
            'jquery-validate',
            get_bloginfo('template_directory') . '/js/jquery-validate/jquery-validate.min.js',
            array('jquery')
        );
		wp_enqueue_script('jquery-validate');
    }
}

function getTestimonial($content, $i)
{
    $parts = explode('[[TESTIMONIAL]]', $content);
    return $parts[$i];
}


add_action('init', 'loadValidation');