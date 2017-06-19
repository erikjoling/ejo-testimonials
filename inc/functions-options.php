<?php
/**
 * Plugin options functions.
 */

/**
 * Returns the testimonials title.
 */
function ejo_testimonials_get_title() {
	return apply_filters( 'ejo_testimonials_get_title', ejo_testimonials_get_setting( 'testimonials_title' ) );
}

/**
 * Returns the testimonials description.
 */
function ejo_testimonials_get_description() {
	return apply_filters( 'ejo_testimonials_get_description', ejo_testimonials_get_setting( 'testimonials_description' ) );
}

/**
 * Returns the testimonials rewrite base. Used for the project archive and as a prefix for taxonomy,
 * author, and any other slugs.
 */
function ejo_testimonials_get_rewrite_base() {
	return apply_filters( 'ejo_testimonials_get_rewrite_base', ejo_testimonials_get_setting( 'testimonials_rewrite_base' ) );
}

/**
 * Returns a plugin setting.
 */
function ejo_testimonials_get_setting( $setting ) {

	$defaults = ejo_testimonials_get_default_settings();
	$settings = wp_parse_args( get_option( 'ejo_testimonials_settings', $defaults ), $defaults );

	return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
}

/**
 * Returns the default settings for the plugin.
 */
function ejo_testimonials_get_default_settings() {

	$settings = array(
		'testimonials_title'        => __( 'Testimonials', 'ejo-testimonials' ),
		'testimonials_description'  => '',
		'testimonials_rewrite_base' => 'testimonials',
	);

	return $settings;
}
