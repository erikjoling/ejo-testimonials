<?php
/**
 * Manage Testimonials admin screen.
 */

/**
 * Adds additional columns and features to the testimonials admin screen.
 */
final class EJO_Manage_Testimonials {

	/**
	 * Sets up the needed actions.
	 */
	private function __construct() {

		add_action( 'load-edit.php', array( $this, 'load' ) );
	}

	/**
	 * Runs on the page load. Checks if we're viewing the testimonial post type and adds
	 * the appropriate actions/filters for the page.
	 */
	public function load() {

		$screen       = get_current_screen();
		$testimonial_post_type = ejo_testimonials_get_post_type();

		// Bail if not on the testimonials screen.
		if ( empty( $screen->post_type ) || $testimonial_post_type !== $screen->post_type )
			return;

		// Custom action for loading the manage testimonials screen.
		do_action( 'ejo_load_manage_testimonials' );

		// Custom columns on the edit testimonials screen.
		add_filter( "manage_edit-{$testimonial_post_type}_columns",        array( $this, 'columns' )              );
		add_action( "manage_{$testimonial_post_type}_posts_custom_column", array( $this, 'custom_column' ), 10, 2 );

		// Print custom styles.
		add_action( 'admin_head', array( $this, 'print_styles' ) );
	}

	/**
	 * Print styles.
	 */
	public function print_styles() { ?>

		<style type="text/css">@media only screen and (min-width: 783px) {
			.fixed .column-thumbnail { width: 100px; }
		}</style>
	<?php }

	/**
	 * Sets up custom columns on the testimonials edit screen.
	 */
	public function columns( $columns ) {

		$new_columns = array(
			'cb'    => $columns['cb'],
			'title' => __( 'Testimonial', 'ejo-testimonials' )
		);

		if ( current_theme_supports( 'post-thumbnails' ) )
			$new_columns['thumbnail'] = __( 'Thumbnail', 'ejo-testimonials' );

		$columns = array_merge( $new_columns, $columns );

		$columns['title'] = $new_columns['title'];

		return $columns;
	}

	/**
	 * Displays the content of custom testimonial columns on the edit screen.
	 */
	public function custom_column( $column, $post_id ) {

		if ( 'thumbnail' === $column ) {

			if ( has_post_thumbnail() )
				the_post_thumbnail( array( 75, 75 ) );

			elseif ( function_exists( 'get_the_image' ) )
				get_the_image( array( 'scan' => true, 'width' => 75, 'link' => false ) );
		}
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

EJO_Manage_Testimonials::init();
