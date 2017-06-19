<?php
/**
 * Registers metadata and related functions for the plugin.
 */

# Register meta on the 'init' hook.
add_action( 'init', 'ejo_testimonials_register_meta' );

/**
 * Registers custom metadata for the plugin.
 */
function ejo_testimonials_register_meta() {

	register_meta(
		'post',
		'url',
		array(
			'sanitize_callback' => 'esc_url_raw',
			'auth_callback'     => '__return_false',
			'single'            => true,
			'show_in_rest'      => true
		)
	);

	register_meta(
		'post',
		'email',
		array(
			'sanitize_callback' => 'sanitize_email',
			'auth_callback'     => '__return_false',
			'single'            => true,
			'show_in_rest'      => true
		)
	);
}
