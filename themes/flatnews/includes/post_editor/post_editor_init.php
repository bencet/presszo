<?php
function wpi_post_editor_buttonhooks() {
	// Only add hooks when the current user has permissions AND is in Rich Text editor mode
	if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
		add_filter("mce_external_plugins", "wpi_post_editor_register_tinymce_javascript");
		add_filter('mce_buttons', 'wpi_post_editor_register_buttons');
	}
}
 
function wpi_post_editor_register_buttons($buttons) {
   array_push($buttons, '|', 'contact');
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function wpi_post_editor_register_tinymce_javascript($plugin_array) {
   $plugin_array['wpi_post_editor'] = THEME_URL_SCRIPTS_COMMONS . 'post_editor_buttons.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'wpi_post_editor_buttonhooks');
