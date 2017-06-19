<?php
/**
 * Plugin settings screen.
 */

/**
 * Sets up and handles the plugin settings screen.
 */
final class EJO_Testimonials_Settings_Page {

	/**
	 * Settings page name.
	 */
	public $settings_page = '';

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Sets up custom admin menus.
	 */
	public function admin_menu() {

		$ejo_testimonials_settings_capability = apply_filters( 'ejo_testimonials_settings_capability', 'manage_options' );

		// Create the settings page.
		$this->settings_page = add_submenu_page(
			'edit.php?post_type=' . ejo_testimonials_get_post_type(),
			esc_html__( 'Testimonials Settings', 'ejo-testimonials' ),
			esc_html__( 'Settings',              'ejo-testimonials' ),
			$ejo_testimonials_settings_capability,
			'ejo-testimonials-settings', 
			array( $this, 'settings_page' ) 
		);

		if ( $this->settings_page ) {

			// Register settings.
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}
	}

	/**
	 * Registers the plugin settings.
	 */
	function register_settings() {

		// Register the setting.
		register_setting( 'ejo_testimonials_settings', 'ejo_testimonials_settings', array( $this, 'validate_settings' ) );

		/* === Settings Sections === */

		add_settings_section( 'general',    esc_html__( 'General Settings', 'ejo-testimonials' ), array( $this, 'section_general'    ), $this->settings_page );
		add_settings_section( 'permalinks', esc_html__( 'Permalinks',       'ejo-testimonials' ), array( $this, 'section_permalinks' ), $this->settings_page );

		/* === Settings Fields === */

		// General section fields
		add_settings_field( 'testimonials_title',       esc_html__( 'Title',       'ejo-testimonials' ), array( $this, 'field_testimonials_title'       ), $this->settings_page, 'general' );
		add_settings_field( 'testimonials_description', esc_html__( 'Description', 'ejo-testimonials' ), array( $this, 'field_testimonials_description' ), $this->settings_page, 'general' );

		// Permalinks section fields.
		add_settings_field( 'testimonials_rewrite_base', esc_html__( 'Testimonials Base', 'ejo-testimonials' ), array( $this, 'field_testimonials_rewrite_base' ), $this->settings_page, 'permalinks' );
	}

	/**
	 * Validates the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validate_settings( $settings ) {

		// Text boxes.
		$settings['testimonials_rewrite_base'] = $settings['testimonials_rewrite_base'] ? trim( strip_tags( $settings['testimonials_rewrite_base'] ), '/' ) : 'testimonials';
		$settings['testimonials_title']        = $settings['testimonials_title']        ? strip_tags( $settings['testimonials_title'] )                     : esc_html__( 'Testimonials', 'ejo-testimonials' );

		// Kill evil scripts.
		$settings['testimonials_description'] = stripslashes( wp_filter_post_kses( addslashes( $settings['testimonials_description'] ) ) );

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * General section callback.
	 */
	public function section_general() { ?>

		<p class="description">
			<?php esc_html_e( 'General testimonials settings for your site.', 'ejo-testimonials' ); ?>
		</p>
	<?php }

	/**
	 * Testimonials title field callback.
	 */
	public function field_testimonials_title() { ?>

		<label>
			<input type="text" class="regular-text" name="ejo_testimonials_settings[testimonials_title]" value="<?php echo esc_attr( ejo_testimonials_get_title() ); ?>" />
			<br />
			<span class="description"><?php esc_html_e( 'The name of your testimonials. May be used for the testimonials page title and other places, depending on your theme.', 'ejo-testimonials' ); ?></span>
		</label>
	<?php }

	/**
	 * Testimonials description field callback.
	 */
	public function field_testimonials_description() {

		wp_editor(
			ejo_testimonials_get_description(),
			'ejo_testimonials_testimonials_description',
			array(
				'textarea_name'    => 'ejo_testimonials_settings[testimonials_description]',
				'drag_drop_upload' => true,
				'editor_height'    => 150
			)
		); ?>

		<p>
			<span class="description"><?php esc_html_e( 'Your testimonials description. This may be shown by your theme on the testimonials page.', 'ejo-testimonials' ); ?></span>
		</p>
	<?php }

	/**
	 * Permalinks section callback.
	 */
	public function section_permalinks() { ?>

		<p class="description">
			<?php esc_html_e( 'Set up custom permalinks for the testimonials section on your site.', 'ejo-testimonials' ); ?>
		</p>
	<?php }

	/**
	 * Testimonials rewrite base field callback.
	 */
	public function field_testimonials_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="ejo_testimonials_settings[testimonials_rewrite_base]" value="<?php echo esc_attr( ejo_testimonials_get_rewrite_base() ); ?>" />
		</label>
	<?php }

	
	/**
	 * Renders the settings page.
	 */
	public function settings_page() {

		// Flush the rewrite rules if the settings were updated.
		if ( isset( $_GET['settings-updated'] ) )
			flush_rewrite_rules(); ?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Testimonials Settings', 'ejo-testimonials' ); ?></h1>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'ejo_testimonials_settings' ); ?>
				<?php do_settings_sections( $this->settings_page ); ?>
				<?php submit_button( esc_attr__( 'Update Settings', 'ejo-testimonials' ), 'primary' ); ?>
			</form>

		</div><!-- wrap -->
	<?php }

	/**
	 * Returns the instance.
	 */
	public static function init() {

		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new self;

		return $instance;
	}
}

EJO_Testimonials_Settings_Page::init();
