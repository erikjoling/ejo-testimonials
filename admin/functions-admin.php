<?php
/**
 * Admin-related functions and filters.
 */

# Registers testimonial details box sections, controls, and settings.
add_action( 'butterbean_register', 'ejo_testimonial_details_register', 5, 2 );


/**
 * Registers the default cap groups.
 */
function ejo_testimonial_details_register( $butterbean, $post_type ) {

	if ( $post_type !== ejo_testimonials_get_post_type() )
		return;

	$butterbean->register_manager( 'testimonial',
		array(
			'post_type' => $post_type,
			'context'   => 'normal',
			'priority'  => 'high',
			'label'     => esc_html__( 'Testimonial Details:', 'ejo-testimonials' )
		)
	);

	$manager = $butterbean->get_manager( 'testimonial' );

	/* === Register Sections === */

	// General section.
	$manager->register_section( 'general',
		array(
			'label' => esc_html__( 'General', 'ejo-testimonials' ),
			'icon'  => 'dashicons-admin-generic'
		)
	);

	/* === Register Fields === */

	$author_description_args = array(
		'type'        => 'text',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Owner of Company & Co', 'ejo-testimonials' ) ),
		'label'       => esc_html__( 'Author description', 'ejo-testimonials' ),
		'description' => esc_html__( 'Enter a description of the testimonial author.', 'ejo-testimonials' )
	);

	$author_url_args = array(
		'type'        => 'url',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'https://www.ejoweb.nl' ),
		'label'       => esc_html__( 'Author URL', 'ejo-testimonials' ),
		'description' => esc_html__( 'Enter the URL of the testimonial author.', 'ejo-testimonials' )
	);

	$author_email_args = array(
		'type'        => 'text',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Email', 'ejo-testimonials' ) ),
		'label'       => esc_html__( 'Author email', 'ejo-testimonials' ),
		'description' => esc_html__( 'Enter the email of the testimonial author (for gravatar).', 'ejo-testimonials' )
	);

	// $rating_args = array(
	// 	'type'        => 'select',
	// 	'section'     => 'general',
	// 	'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Highland Home, AL', 'ejo-testimonials' ) ),
	// 	'label'       => esc_html__( 'Rating', 'ejo-testimonials' ),
	// 	'description' => esc_html__( 'Select a rating from 1 to 5.', 'ejo-testimonials' )
	// );

	$manager->register_field( 'description', $author_description_args, array( 'sanitize_callback' => 'wp_strip_all_tags' ) );
	$manager->register_field( 'url',      	 $author_url_args,         array( 'sanitize_callback' => 'esc_url_raw'       ) );
	$manager->register_field( 'email',   	 $author_email_args,       array( 'sanitize_callback' => 'sanitize_email'    ) );
}

