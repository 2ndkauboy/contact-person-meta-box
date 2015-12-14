<?php
/*
 * Plugin Name: Contact Person Meta Box
 * Plugin URI: https://github.com/2ndkauboy/contact-person-meta-box
 * Description: Adds a meta box to chose a user as a contact person for a page (or other post types)
 * Version: 1.0.0
 * Author: Bernhard Kau
 * Author URI: http://kau-boys.de
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */

namespace contact_person_meta_box;

add_action(
	'plugins_loaded',
	array( Example_Plugin::get_instance(), 'plugin_setup' )
);

class Example_Plugin {

	/**
	 * Plugin instance.
	 *
	 * @see   get_instance()
	 * @type  object
	 */
	protected static $instance = null;

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 */
	public static function get_instance() {

		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook  plugins_loaded
	 * @return   void
	 */
	public function plugin_setup() {
		// load the translation for this plugin
		$this->load_language( 'contact-person-meta-box' );

		// register autoloader
		spl_autoload_register( array( $this, 'autoload' ) );

		// init the meta boxes
		add_action( 'init', array( $this, 'init_meta_boxes' ) );
	}

	/**
	 * Constructor.
	 * Intentionally left empty and public.
	 *
	 * @see    plugin_setup()
	 */
	public function __construct() {
	}

	/**
	 * The autoloader for this plugin
	 *
	 * @param string $class The class name to autoload
	 *
	 * @return void
	 */
	public function autoload( $class ) {

		// check if class is in same namespace, if not return
		if ( strpos( $class, 'contact_person_meta_box' ) !== 0 ) {
			return;
		}

		// remove namespace from class name
		$class = str_replace( 'contact_person_meta_box' . '\\', '', $class );

		// make the class name lowercase and replace underscores with dashes
		$class = strtolower( str_replace( '_', '-', $class ) );

		// build path to class file
		$path = __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class-' . $class . '.php';

		// include file if it exists
		if ( file_exists( $path ) ) {
			include( $path );
		}
	}

	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 *
	 * @param   string $domain
	 *
	 * @return  void
	 */
	public function load_language( $domain ) {

		load_plugin_textdomain(
			$domain,
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Callback function to register the meta boxes.
	 * Init boxes in the order of their default appearance.
	 *
	 * @return  void
	 */
	public function init_meta_boxes() {
		/**
		 * Filter the post types, for which the meta box should be available
		 *
		 * The meta box will by default only be shown for pages. But it can be added to
		 * other (custom) post types by the filter `contact_person_meta_box_post_types`.
		 *
		 * @since 1.0.0
		 *
		 * @param array $post_types An array with the post types
		 */
		$contact_person_meta_boy_post_types = apply_filters( 'contact_person_meta_box_post_types', array( 'page' ) );
		// add meta box to all given post types
		foreach($contact_person_meta_boy_post_types as $contact_person_meta_boy_post_type){
			new Contact_Person_Meta_Box( $contact_person_meta_boy_post_type );
		}
	}

} // end class