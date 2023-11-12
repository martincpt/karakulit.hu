<?php
/**
 * Kayo hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site page hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/site.php' );

/**
 * Navigation hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/navigation.php' );

/**
 * Post hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/post.php' );

/**
 * Event hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/event.php' );
