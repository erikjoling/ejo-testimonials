<?php
/**
 * Plugin uninstall file.
 */

// Make sure we're actually uninstalling the plugin.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	wp_die( sprintf( __( '%s should only be called when uninstalling the plugin.', 'ejo-testimonials' ), '<code>' . __FILE__ . '</code>' ) );

/* === Delete plugin options. === */

// Remove options.
delete_option( 'ejo_testimonials_settings'        );

/* === Remove capabilities added by the plugin. === */

// Get the administrator role.
$role = get_role( 'administrator' );

// If the administrator role exists, remove added capabilities for the plugin.
if ( ! is_null( $role ) ) {

	// Post type caps.
	$role->remove_cap( 'create_testimonials'           );
	$role->remove_cap( 'edit_testimonials'             );
	$role->remove_cap( 'edit_others_testimonials'      );
	$role->remove_cap( 'publish_testimonials'          );
	$role->remove_cap( 'read_private_testimonials'     );
	$role->remove_cap( 'delete_testimonials'           );
	$role->remove_cap( 'delete_private_testimonials'   );
	$role->remove_cap( 'delete_published_testimonials' );
	$role->remove_cap( 'delete_others_testimonials'    );
	$role->remove_cap( 'edit_private_testimonials'     );
	$role->remove_cap( 'edit_published_testimonials'   );
}
