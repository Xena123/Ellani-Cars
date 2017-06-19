<?php

/*------------------------------------*
* Useful Wordpress Functions
*------------------------------------*/


// hide the admin bar from users
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action( 'after_setup_theme', 'remove_admin_bar' );

// block users from accessing wp-admin
function blockusers_init() {
	if ( is_admin() && ! current_user_can( 'administrator' ) &&
	     ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( site_url('/dashboard/') );
		exit;
	}
}
add_action( 'init', 'blockusers_init' );

// Get excerpt of custom length
function get_excerpt($count){
	global $post;
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = $excerpt.'...';
	return $excerpt;
}

// View All Options during pagination
if (isset($_GET['viewall'])) {
	function view_allposts( $query ) {
		$query->set( 'posts_per_page', -1 );
	}

	add_action( 'pre_get_posts', 'view_allposts' );
}

// Return value of "redirect_link" custom field if exists, otherwise return permalink.
function get_custom_link() {
	global $post;
	if(the_field('redirect_link')) {
		return the_field('redirect_link');
	} else {
		get_permalink();
	}
}

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more_text) {
	global $post;
	return '... <a href="'. get_permalink($post->ID) . '">' . $more_text . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

//Get meta data for archive single posts
function get_meta($field) {
	global $post;
	if (get_post_meta($post->ID, $field, true)) {
		return get_post_meta($post->ID, $field, true);
	}
}

//Remove image caption width
add_filter('img_caption_shortcode', 'my_img_caption_shortcode_filter',10,3);

//Add active class to selected menu item
function special_nav_class($classes, $item){
	if( in_array('current-menu-item', $classes) ){
		$classes[] = 'active ';
	}
	return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

// Google Analytics
function add_googleanalytics() {
	// Paste your Google Analytics code from Step 6 here
}
add_action('wp_footer', 'add_googleanalytics');

// add a favicon to your site
function blog_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'http://cdn3.wpbeginner.com/favicon.ico" />';
}
add_action('wp_head', 'blog_favicon');

// Replace admin header logo
function my_custom_logo() {
	echo '
		<style type="text/css">
		#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/custom-logo.gif) !important; }
		</style>
		';
	}
add_action('admin_head', 'my_custom_logo');

// Replace Wordpress login logo
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/custom-login-logo.gif) !important; }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');


// Change wordpress admin footer text
function remove_footer_admin ($name, $link) {
	echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="'. $link . '" target="_blank">' . $name . '</a></p>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Pagination
	//Add numeric pagination to archive pages
	function numeric_pagination() {
		if( is_singular() )
			return;
		global $wp_query;
		/** Stop execution if there's only 1 page */
		if( $wp_query->max_num_pages <= 1 )
			return;
		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );
		/**	Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;
		/**	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}
		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		echo '<div class="o-archive-pagination clearfix"><ul>' . "\n";

		/**	Previous Post Link */
		if ( get_previous_posts_link() )
			printf( '<li class="pag-prev">%s</li>' . "\n", get_previous_posts_link( '< Previous ') );

		/**	Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( ! in_array( 2, $links ) )
				echo '<li>…</li>';
		}

		/**	Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		/**	Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) )
				echo '<li>…</li>' . "\n";

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		/*	Next Post Link */
		if ( get_next_posts_link() )
			printf( '<li class="pag-next">%s</li>' . "\n", get_next_posts_link('Next >') );
		echo '</ul></div>' . "\n";
	}


// Allow for custom single templates for specific posts. Format: single-post_type-slug.png

function get_custom_template( $template ) {
    global $post;
    if ( $post->post_type === '[post_type]' ) {
        $locate_template = locate_template( "single-[post_type]-{$post->post_name}.php" );
        if ( ! empty( $locate_template ) ) {
            $template = $locate_template;
        }
    }
    return $template;
}
add_filter( 'single_template', 'get_custom_template' );



// Display published jobs by default, hide drafts
function custom_post_publish_filter() {
    global $submenu;
    $post_types = array( 'heat_job' );
    foreach( $post_types as $p ) {
        foreach( $submenu[ 'edit.php?post_type=' . $p ] as $key => $value ) {
            if( in_array( 'edit.php?post_type=' . $p, $value ) )  {
					$submenu[ 'edit.php?post_type='.$p ][ $key ][2] = 'edit.php?post_status=publish&post_type=' . $p;
            }
        }
    }
}
add_action( 'admin_menu', 'custom_post_publish_filter' );
