<?php
/**
 * Plugin Name: EJO Testimonials
 * Plugin URI:  https://www.ejoweb.nl/
 * Description: A Testimonials WordPress plugin based on Tadlock's Content Type Standards
 * Version:     0.1.1
 * Author:      Erik Joling
 * Author URI:  https://www.ejoweb.nl/
 * Text Domain: ejo-testimonials
 * Domain Path: /languages
 */

/**
 * Singleton class that sets up and initializes the plugin.
 */
final class EJO_Testimonials_Plugin {

	/**
	 * Version number of this plugin 
	 */
    public static $version = '0.1.1';

	/**
	 * Directory path to the plugin folder.
	 */
	public static $dir_path = '';

	/**
	 * Directory URI to the plugin folder.
	 */
	public static $dir_uri = '';

	/**
	 * JavaScript directory URI.
	 */
	public static $js_uri = '';

	/**
	 * CSS directory URI.
	 */
	public static $css_uri = '';

	/**
	 * Returns the instance.
	 */
	public static function init() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 */
	private function __construct() {}

	/**
	 * Magic method to keep the object from being cloned.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Whoah, partner!', 'ejo-testimonials' ), '1.0.0' );
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Whoah, partner!', 'ejo-testimonials' ), '1.0.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "EJO_Testimonials::{$method}", __( 'Method does not exist.', 'ejo-testimonials' ), '1.0.0' );
		unset( $method, $args );
		return null;
	}

	/**
	 * Initial plugin setup.
	 */
	private function setup() {

		self::$dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		self::$dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );

		self::$js_uri  = trailingslashit( self::$dir_uri . 'js'  );
		self::$css_uri = trailingslashit( self::$dir_uri . 'css' );
	}

	/**
	 * Loads include and admin files for the plugin.
	 */
	private function includes() {

		// Load functions files.
		require_once( self::$dir_path . 'inc/functions-options.php'    );
		require_once( self::$dir_path . 'inc/functions-meta.php'       );
		require_once( self::$dir_path . 'inc/functions-post-types.php' );
		require_once( self::$dir_path . 'inc/functions-deprecated.php' );

		// Load admin files.
		if ( is_admin() ) {
			require_once( self::$dir_path . 'admin/butterbean/butterbean.php'     );
			require_once( self::$dir_path . 'admin/functions-admin.php'           );
			require_once( self::$dir_path . 'admin/class-manage-testimonials.php' );
			require_once( self::$dir_path . 'admin/class-testimonial-edit.php'    );
			require_once( self::$dir_path . 'admin/class-settings.php'            );
		}
	}

	/**
	 * Sets up initial actions.
	 */
	private function setup_actions() {

		// Internationalize the text strings used.
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		// Register activation hook.
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Loads the translation files.
	 */
	public function i18n() {

		load_plugin_textdomain( 'ejo-testimonials', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages' );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 */
	public function activation() {

		// Get the administrator role.
		$role = get_role( 'administrator' );

		// If the administrator role exists, add required capabilities for the plugin.
		if ( ! is_null( $role ) ) {

			// Post type caps.
			$role->add_cap( 'create_testimonials'           );
			$role->add_cap( 'edit_testimonials'             );
			$role->add_cap( 'edit_others_testimonials'      );
			$role->add_cap( 'publish_testimonials'          );
			$role->add_cap( 'read_private_testimonials'     );
			$role->add_cap( 'delete_testimonials'           );
			$role->add_cap( 'delete_private_testimonials'   );
			$role->add_cap( 'delete_published_testimonials' );
			$role->add_cap( 'delete_others_testimonials'    );
			$role->add_cap( 'edit_private_testimonials'     );
			$role->add_cap( 'edit_published_testimonials'   );
		}
	}
}


// Let's get this party started!
EJO_Testimonials_Plugin::init();
