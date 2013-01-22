<?php

// Remove Dashboard Meta Boxes
function mb_remove_dashboard_widgets() {
	global $wp_meta_boxes;
	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'mb_remove_dashboard_widgets' );


// Hide Admin Areas that are not used
function mb_remove_menu_pages() {
	remove_menu_page('link-manager.php');
	// remove_menu_page('edit-comments.php');
}
add_action( 'admin_menu', 'mb_remove_menu_pages' );


// Change Admin Menu Order
// function mb_custom_menu_order($menu_ord) {
// 	if (!$menu_ord) return true;
// 	return array(
// 		'index.php', // Dashboard
// 		'separator1', // First separator
// 		'edit.php?post_type=page', // Pages
// 		'edit.php', // Posts
// 		'upload.php', // Media
// 		'gf_edit_forms', // Gravity Forms
// 		'genesis', // Genesis
// 		'edit-comments.php', // Comments
// 		'separator2', // Second separator
// 		'themes.php', // Appearance
// 		'plugins.php', // Plugins
// 		'users.php', // Users
// 		'tools.php', // Tools
// 		'options-general.php', // Settings
// 		'separator-last', // Last separator
// 	);
// }
// add_filter('custom_menu_order', 'mb_custom_menu_order');
// add_filter('menu_order', 'mb_custom_menu_order');


// Remove default link for images
function mb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'mb_imagelink_setup', 10);


// Remove Query Strings From Static Resources
function mb_remove_script_version($src){
	$parts = explode('?', $src);
	return $parts[0];
}
add_filter('script_loader_src', 'mb_remove_script_version', 15, 1);
add_filter('style_loader_src', 'mb_remove_script_version', 15, 1);


// Remove Read More Jump
function mb_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'mb_remove_more_jump_link');


// Show Kitchen Sink in WYSIWYG Editor
function mb_unhide_kitchensink($args) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}
add_filter( 'tiny_mce_before_init', 'mb_unhide_kitchensink' );

?>
