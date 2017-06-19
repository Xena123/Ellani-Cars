<?php

/*
Plugin Name: Fanatic
Plugin URI: http://www.fanaticdesign.co.uk/
Description: Essentials for functionality of the website
Author: the Fanatic team
Author URI: http://www.fanaticdesign.co.uk/
*/

if ( !function_exists('do_action') ) {
	exit();
}

require_once('post_and_taxonomy.php');


function addFanaticBlock($type="block",$embed=null) {
	if ( $embed == null ) {
		global $post;
		if ( !$post ) {return;}
		$embed = $post->ID;
	}

	if ( !current_user_can( 'manage_options' ) ) {return;}
	echo "<div class='fanatic_add'><a href='/wp-admin/post-new.php?post_type=".$type."&embed_id=".$embed."' class='post-edit-link'>+</a></div>";
}

/*
	Fanatic Building block
	@params
		$embed (string)	Unique identification for connecting content to a area on a page (e.g. $post->ID . "random_string")
		$style (string)	Style of displayed blocks(required)
		$count (int)	Number of blocks to be returned
		$type  (string)	Post type
*/
function fanaticBlock($embed,$style="",$count=1,$type="block") {
	$args = array(
		'post_type'		=> $type,
		'posts_per_page'	=> $count ,
		'orderby'=> 'menu_order',
		'order'=>'ASC',
		'meta_query' => array(
			array(
			  'key'  => '_gd_embed',
			  'value'   => $embed,
			  'meta_compare'   => '='
			),
		),
	);

	$custom = new WP_Query( $args );
	$i = 0;
	while ( $custom->have_posts() ): $custom->the_post();
		switch($style) {
			case "video-nugget":
				edit_post_link();
				echo '<iframe width="100%" height="auto" src="'. the_content() . '" frameborder="0" allowfullscreen></iframe>';
				break;
			case "front-page-banner-text":
				echo '<div class="c-banner__text-block o-wrap js-note-wrap">';
					edit_post_link();
					echo '<h2>';
						the_title();
					echo '</h2>';
					echo '<p>';
						the_content();
					echo '</p>';
				echo '</div>';
				break;
			case "content-title":
				edit_post_link();
				echo '<div class="o-content-title">';
					echo '<h2>';
						the_title();
					echo '</h2>';
					echo '<span class="o-content-title__subtitle">';
						the_content();
				echo '</span></div>';
				break;
			case "link-block":			
				echo '<div class="o-column--third u-relative">';
					edit_post_link();
					echo '<a href="';
					echo get_custom_link();
					echo '">';					
					echo '<div class="o-notice-dot"><span>';
					the_title();
					echo '</span></div>';
					the_post_thumbnail('full', array('class' => 'o-column--image'));
					echo '</a>';					
				echo '</div>';
				break;
			case "footer-block":
				echo '<div class="c-footer__text-block">';
					edit_post_link();
					echo '<span class="c-footer__title">';
						the_title();
					echo '</span>';
					the_content();
				echo '</div>';
				break;
			case "team-link":
				echo '<div class="o-character-row__text-details u-relative">';
				edit_post_link();
				the_content();
				echo '<a href="'; 
				echo get_custom_link();
				echo '" class="o-character-row__button u-zi-999">';
				the_post_thumbnail('full', array('class' => 'u-zi-998'));
				echo '</a>';
				echo '</div>';
				break;
			case "main-featured-story":
					echo '<div class="o-content-row--image u-relative">';
						the_post_thumbnail('full', array('class' => 'o-full-width-image'));
						echo '<div class="o-content-row__text-overlay">';
							echo '<span class="o-content-row__title">';
								edit_post_link();
								echo '<a href="';
								echo get_custom_link();
								echo '">';
								the_title();
								echo '</a>';
								echo '<img src="';
								echo get_template_directory_uri(); 
								echo '/img/break-white.png" alt="text break" class="o-content-row__break">';
							echo '</span>';
							echo '<span class="o-content-row__subtitle">';
								the_content();
					echo '</span></div></div>';
				break;
			case "af_app":
				echo '<div class="o-app__text">';
				edit_post_link();
				echo '<h2>';
				the_title();
				echo '</h2>';
				echo '<p>' . the_content() . '</p>';
				echo '</div>';
				break;
			case "app_text":
				echo '<div class="o-app__text">';
				edit_post_link();
				echo '<h2>';
				the_title();
				echo '</h2>';
				echo '<p>' . the_content() . '</p>';
				echo '</div>';
				echo '<div class="o-app__phone">';
					echo '<img src="';
					echo get_template_directory_uri();
					echo '/img/phone.png" alt="Iphone displaying Animal Fu app"/>';
				echo '</div>';
				break;				
			case "profile_skills":
				echo '<li>';
					edit_post_link();
					echo '<p>';
					the_title();
					echo '</p>';
				echo '</li>';
				break;
			case "team_profile":
				edit_post_link();
				the_content();
				break;
			case "celebrate_text":
					echo '<div class="o-birthday__speech-bubble-text">';
						echo '<h2>';
						the_title();
						edit_post_link();	
						echo '</h2>';
						echo '<p>';
						the_content();
						echo '</p>';
					echo '</div>';
				break;
			case "featured-story":				
				echo '<div class="o-content-story__image">';
				echo '<img src="' . the_post_thumbnail('full') . '" />';		
				echo '</div>';
				echo '<div class="o-content-story__text">';
				echo '<h3>';
				the_title();
				edit_post_link();	
				echo '</h3>';
				the_content();
				echo '<a href="';
				echo get_custom_link();
				echo '"><img src="';
				echo get_template_directory_uri(); 
				echo '/img/button-full-story.png" alt="Full Story Button" class="o-stories__button o-sprite--hover"/></a>';
				echo '</div></div>';
			break;
			default:
				edit_post_link();
				the_content();
		}
		$i++;
    endwhile;
    wp_reset_postdata();
    addFanaticBlock($type, $embed);
}
