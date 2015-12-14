<?php
/**
 * Validate a request
 */

namespace contact_person_meta_box;

interface Request_Validator_Interface {

	/**
	 * Check if the request is valid
	 *
	 * @return bool
	 */
	public function is_valid();
}