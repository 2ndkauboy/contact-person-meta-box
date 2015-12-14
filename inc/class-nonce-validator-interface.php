<?php
/**
 * Provide nonces, and handle their validation.
 */

namespace contact_person_meta_box;

interface Nonce_Validator_Interface {

	/**
	 * Get nonce field name
	 *
	 * @return string
	 */
	public function get_name();

	/**
	 * Get nonce action
	 *
	 * @return string
	 */
	public function get_action();

	/**
	 * Check if the nonce is valid
	 *
	 * @return bool
	 */
	public function is_valid();
}