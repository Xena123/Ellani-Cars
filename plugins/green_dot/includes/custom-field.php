<?php

/* ADDING EMBED ID BOX */

add_action('add_meta_boxes', 'gd_meta_box_init');

function gd_meta_box_init() {
	/* Get all public custom post types */
	$post_types = get_post_types( array('public'=>'true','_builtin'=> false) );
	/* Add embed detail metabox */
	add_meta_box( 'gd_embed' , 'Embed Id' , 'gd_embed_box' , $post_types , 'side' , 'default' );

}




function gd_embed_box() {
	global $post;

	if ( isset( $_GET['embed_id'] ) ) {
		$current_embed_id = $_GET['embed_id'];
	} else {
		$current_embed_id = get_post_meta( $post->ID , '_gd_embed' , true );
	}

	if ( WP_DEBUG ) {
		$type = "text";
	} else {
		$type = "hidden";
	}

	wp_nonce_field( plugin_basename( __FILE__ ) , 'gd_save_meta' );

	echo "<p>Embed ID <input name='gd_embed' type='" . $type . "' value='". $current_embed_id ."' /></p>";

}

/* SAVING EMBED BOX */

add_action( 'save_post' , 'gd_save_embed' );

function gd_save_embed($post_id) {

	if ( isset( $_POST['gd_embed'] ) ) {

		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {return;}

		wp_verify_nonce( plugin_basename( __FILE__ ) , 'gd_save_meta' );

		update_post_meta( $post_id , '_gd_embed' , sanitize_text_field( $_POST['gd_embed'] ) );

	}

}
