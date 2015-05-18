<?php

/**
 * Adds a box to the main column on the Supporter edit screens.
 */
function addBoxSkype() {
	add_meta_box( 'skype-id', __('Skype ID', 'supporter'), 'addBoxSkypeCallback', 'supporter' );
}

add_action( 'add_meta_boxes', 'addBoxSkype' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function addBoxSkypeCallback( $post ) {
	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'supporter_meta', 'supporter_meta_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$skypeId = get_post_meta( $post->ID, 'skype_id', true );
	$yahooId = get_post_meta( $post->ID, 'yahoo_id', true );
	$telNumber = get_post_meta( $post->ID, 'tel_number', true );

	echo '<table><tbody>';

	echo '<tr>';
	echo '<td><label for="skype_id">';
	echo __( 'Skype ID', 'supporter' );
	echo '</label></td>';
	echo '<td><input type="text" id="skype_id" name="skype_id" value="' . esc_attr( $skypeId ) . '" size="25" /></td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td><label for="yahoo_id">';
	echo __( 'Yahoo ID', 'supporter' );
	echo '</label></td>';
	echo '<td><input type="text" id="yahoo_id" name="yahoo_id" value="' . esc_attr( $yahooId ) . '" size="25" /></td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td><label for="tel_number">';
	echo __( 'Phone Number', 'supporter' );
	echo '</label></td>';
	echo '<td><input type="text" id="tel_number" name="tel_number" value="' . esc_attr( $telNumber ) . '" size="25" /></td>';
	echo '</tr>';

	echo '</tbody></table>';
}
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function supporterSaveMetaBoxData( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['supporter_meta_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['supporter_meta_nonce'], 'supporter_meta' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Sanitize user input.
	$skypeId = sanitize_text_field( $_POST['skype_id'] );
	$yahooId = sanitize_text_field( $_POST['yahoo_id'] );
	$telNumber = sanitize_text_field( $_POST['tel_number'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'skype_id', $skypeId );
	update_post_meta( $post_id, 'yahoo_id', $yahooId );
	update_post_meta( $post_id, 'tel_number', $telNumber );
}

add_action( 'save_post', 'supporterSaveMetaBoxData' );

?>