<?php

namespace contact_person_meta_box;

class Contact_Person_Meta_Box extends Meta_Box implements Meta_Box_Interface {

	/**
	 * Constructor
	 */
	public function __construct( $post_type = 'page' ) {
		parent::__construct( 'contact_person_meta_box', __( 'Contact Person', 'contact-person-meta-box' ), $post_type, 'side', 'low' );
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param \WP_Post $post The post object.
	 */
	function render( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->nonce_validator->get_action(), $this->nonce_validator->get_name() );

		$contact_person_id = get_post_meta( $post->ID, '_contact_person_id', true );

		echo '<label class="screen-reader-text" for="contact_person_id">' . esc_html__('Contact Person', 'contact-person-meta-box' ) .'</label>';

		wp_dropdown_users( array(
			'name' => 'contact_person_id',
			'selected' => $contact_person_id,
			'include_selected' => true,
			'show_option_none' => __( '&mdash; Select &mdash;' ),
		) );


	}

	/**
	 * Save the meta box date when the post is saved.
	 *
	 * @param   int $post_id The ID of the post being saved.
	 *
	 * @return  void
	 */
	public function save( $post_id ) {

		// check if the values should be saved
		if ( ! self::check() ) {
			return;
		}

		// Sanitize the user input.
		$contact_person_id = intval( $_POST[ 'contact_person_id' ] );

		update_post_meta( $post_id, '_contact_person_id', $contact_person_id );
	}
}