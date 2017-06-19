<?php
/**
 * New/Edit project admin screen.
 */

/**
 * Project edit screen functionality.
 *
 * @since  1.0.0
 * @access public
 */
final class EJO_Testimonial_Edit {

	/**
	 * Sets up the needed actions.
	 */
	private function __construct() {

		add_action( 'load-post.php',     array( $this, 'load' ) );
		add_action( 'load-post-new.php', array( $this, 'load' ) );
	}

	/**
	 * Runs on the page load. Checks if we're viewing the project post type and adds
	 * the appropriate actions/filters for the page.
	 */
	public function load() {

		$screen       = get_current_screen();
		$testimonial_post_type = ejo_testimonials_get_post_type();

		// Bail if not on the projects screen.
		if ( empty( $screen->post_type ) || $testimonial_post_type !== $screen->post_type )
			return;

		// Custom action for loading the edit project screen.
		do_action( 'ejo_testimonials_load_project_edit' );

		// Add/Remove meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}

	/**
	 * Adds/Removes meta boxes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $post_type
	 * @return void
	 */
	public function add_meta_boxes( $post_type ) {

		remove_meta_box( 'postexcerpt', $post_type, 'normal' );
	}

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

EJO_Testimonial_Edit::init();
