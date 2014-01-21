<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Unsortable_Meta_Box
 * @author    1fixdotio <1fixdotio@gmail.com>
 * @license   GPL-2.0+
 * @link      http://1fix.dio/unsortable-meta-box
 * @copyright 2014 1Fix.io
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

require_once( plugin_dir_path( __FILE__ ) . 'public/class-unsortable-meta-box.php' );

$plugin = Unsortable_Meta_Box::get_instance();
delete_option( $plugin->get_plugin_slug() );
delete_option( 'umb-display-activation-message' );
/**
 * @todo Delete options in whole network
 */