<?php

/*

CORE VARIABLES AND CONSTANTS

http://codex.wordpress.org/Global_Variables

http://codex.wordpress.org/User:CharlesClarkson/Global_Variables

http://codex.wordpress.org/Function_Reference/wp_templating_constants

*/

/*PATH INIT*/

define('THEME_DOMAIN', 'flatnews');

define('THEME_VERSION', '');

define('THEME_NAME', 'Flat News - Easy News & Magazine Wordpress Theme');

define('THEME_URL', get_template_directory_uri());

define('COPYRIGHT_URL', 'http://themeforest.net/user/tiennguyenvan/portfolio?ref=tiennguyenvan');



/*Absolute Path*/

define('THEME_URL_IMAGES', THEME_URL.'/images/');

define('THEME_URL_INCLUDES', THEME_URL.'/includes/');

define('THEME_URL_SCRIPTS', THEME_URL_INCLUDES.'scripts/');

define('THEME_URL_SCRIPTS_COMMONS', THEME_URL_SCRIPTS.'commons/');

define('THEME_URL_PANEL', THEME_URL_INCLUDES.'panel/');

define('THEME_URL_SHORTCODES', THEME_URL_INCLUDES.'shortcodes/');

define('THEME_URL_WIDGETS', THEME_URL_INCLUDES.'widgets/');

define('THEME_URL_LIB', THEME_URL_INCLUDES.'lib/');

define('THEME_URL_POST_EDITOR', THEME_URL_INCLUDES.'post_editor/');



/*Related Path*/

define('THEME_R_INCLUDES', 'includes/');

define('THEME_R_SCRIPTS', THEME_R_INCLUDES.'scripts/');

define('THEME_R_SCRIPTS_COMMONS', THEME_R_SCRIPTS.'commons/');

define('THEME_R_PANEL', THEME_R_INCLUDES.'panel/');

define('THEME_R_SHORTCODES', THEME_R_INCLUDES.'shortcodes/');

define('THEME_R_WIDGETS', THEME_R_INCLUDES.'widgets/');

define('THEME_R_LIB', THEME_R_INCLUDES.'lib/');

define('THEME_R_CUSTOMIZE', THEME_R_INCLUDES.'customize/');

define('THEME_R_POST_EDITOR', THEME_R_INCLUDES.'post_editor/');





get_template_part(THEME_R_LIB . 'common-lib');

get_template_part(THEME_R_INCLUDES.'theme_init');

get_template_part(THEME_R_SCRIPTS.'register_scripts');

get_template_part(THEME_R_CUSTOMIZE.'register_customize');

get_template_part(THEME_R_WIDGETS.'register_widgets');

get_template_part(THEME_R_SHORTCODES.'init-shortcodes');

get_template_part(THEME_R_POST_EDITOR.'post_editor_init');

add_filter('login_errors',create_function('$a', "return null;"));

remove_action('wp_head', 'wp_generator');