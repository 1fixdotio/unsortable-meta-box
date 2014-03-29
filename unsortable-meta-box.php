<?php
/**
 * Unsortable Meta Box.
 *
 * Disable dragging of meta boxes and reset their positions.
 *
 * @package   Unsortable_Meta_Box
 * @author    1fixdotio <1fixdotio@gmail.com>
 * @license   GPL-2.0+
 * @link      http://1fix.io/unsortable-meta-box
 * @copyright 2014 1Fix.io
 *
 * @wordpress-plugin
 * Plugin Name:       Unsortable Meta Box
 * Plugin URI:        http://1fix.io/unsortable-meta-box
 * Description:       Disable dragging of meta boxes and reset their positions
 * Version:           0.9.0
 * Author:            1fixdotio
 * Author URI:        http://1fix.io
 * Text Domain:       unsortable-meta-box
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/1fixdotio/unsortable-meta-box
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-unsortable-meta-box.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Unsortable_Meta_Box', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Unsortable_Meta_Box', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Unsortable_Meta_Box', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-unsortable-meta-box-admin.php' );
	add_action( 'plugins_loaded', array( 'Unsortable_Meta_Box_Admin', 'get_instance' ) );

}
