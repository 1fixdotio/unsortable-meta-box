<?php
/**
 * Unsortable Meta Box.
 *
 * @package   Unsortable_Meta_Box_Admin
 * @author    1fixdotio <1fixdotio@gmail.com>
 * @license   GPL-2.0+
 * @link      http://1fix.io/unsortable-meta-box
 * @copyright 2014 1Fix.io
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-unsortable-meta-box.php`
 *
 * @package Unsortable_Meta_Box_Admin
 * @author  1fixdotio <1fixdotio@gmail.com>
 */
class Unsortable_Meta_Box_Admin {

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * Call $plugin_slug from public plugin class later.
	 *
	 * @since    0.8.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = null;

	/**
	 * Instance of this class.
	 *
	 * @since    0.0.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.0.1
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Plugin options
	 *
	 * @since 0.4
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     0.0.1
	 */
	private function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 */
		$plugin = Unsortable_Meta_Box::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		// Add the options page and menu item.
		require_once( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'disable_sortable' ) );
		add_action( 'admin_action_update', array( $this, 'reset_positions' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.0.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     0.1.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		$options = $this->get_options();
		$pages = ( isset( $options['pages_unsortable'] ) ) ? $options['pages_unsortable'] : array();

		$screen = get_current_screen();
		foreach ( $pages as $page ) {
			if ( $screen->id == $page )
				wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Unsortable_Meta_Box::VERSION );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    0.0.1
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Unsortable Meta Box Settings', $this->plugin_slug ),
			__( 'Unsortable Meta Box', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    0.0.1
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    0.0.1
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings' ) . '</a>'
			),
			$links
		);

	}

	/**
	 * Disable meta box sortable script
	 *
	 * @since    0.1.0
	 */
	public function disable_sortable() {

		$options = $this->get_options();
		$pages = ( isset( $options['pages_unsortable'] ) ) ? $options['pages_unsortable'] : array();

		$screen = get_current_screen();
		foreach ( $pages as $page ) {
			if ( $screen->id == $page ) {
				wp_deregister_script( 'postbox' );
				if ( 'dashboard' != $screen->id )
					wp_register_script( 'postbox', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery-ui-sortable' ), Unsortable_Meta_Box::VERSION );
			}
		}

	}

	/**
	 * Reset positions of meta boxes on checked pages
	 *
	 * @since 0.3.0
	 *
	 * @return void
	 */
	public function reset_positions() {

		global $wpdb;

		if ( 'unsortable-meta-box' == $_POST['option_page'] ) {
			$options = $_POST['unsortable-meta-box'];
			foreach( $options['pages_reset_positions'] as $page ) {
				$query = $wpdb->prepare("
					DELETE
					FROM  $wpdb->usermeta
					WHERE meta_key LIKE %s
					", 'meta-box-order_' . $page );

				$wpdb->query( $query );
			}
		}
	}

	/**
	 * Get plugin options
	 *
	 * @since 0.4
	 *
	 * @return array|string The option settings
	 */
	public function get_options() {

		$this->options = get_option( $this->plugin_slug );

		if ( empty( $this->options ) )
			$this->options = array(
				'pages_unsortable' => array(),
				'pages_reset_positions' => array()
				);

		return $this->options;
	}

}
