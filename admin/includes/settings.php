<?php

class Unsortable_Meta_Box_Settings {

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
	 * @since    0.8.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     0.8.0
	 */
	private function __construct() {

		$plugin = Unsortable_Meta_Box::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		add_action( 'admin_init', array( $this, 'admin_init' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.8.0
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
	 * Registering the Sections, Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function admin_init() {

		if( false == get_option( $this->plugin_slug ) ) {
			add_option( $this->plugin_slug, $this->default_settings() );
		} // end if

		add_settings_section(
			'general',
			__( 'General', $this->plugin_slug ),
			'',
			$this->plugin_slug
		);

		add_settings_field(
			'pages_unsortable',
			__( 'Pages to disable sortable meta boxes:', $this->plugin_slug ),
			array( $this, 'pages_unsortable_callback' ),
			$this->plugin_slug,
			'general'
		);

		add_settings_field(
			'pages_reset_positions',
			__( 'Pages to reset positions of meta boxes:', $this->plugin_slug ),
			array( $this, 'pages_reset_positions_callback' ),
			$this->plugin_slug,
			'general'
		);

		register_setting(
			$this->plugin_slug,
			$this->plugin_slug
		);

	} // end admin_init

	/**
	 * Provides default values for the plugin settings.
	 */
	public function default_settings() {

		$defaults = array(
			'pages_unsortable' => 	array(
							'dashboard' => 'dashboard',
							'post' => 'post',
							'page' => 'page'
						),
			'pages_reset_positions'	=> array(
							'dashboard' => 'dashboard',
							'post' => 'post',
							'page' => 'page'
						   )
		);

		return apply_filters( 'default_settings', $defaults );

	} // end default_settings

	public function pages_unsortable_callback() {

		$options = get_option( $this->plugin_slug );
		$options = isset( $options['pages_unsortable'] ) ? $options['pages_unsortable'] : array();

		$pages = $this->get_pages();
		$html = '';
		foreach ( $pages as $key => $value ) {
			$option = ( isset( $options[$key] ) ) ? $options[$key] : '';
			$html .= '<input type="checkbox" id="pages_unsortable-' . $key . '" name="' . $this->plugin_slug . '[pages_unsortable][' . $key . ']" value="' . $key . '"' . checked( $key, $option, false ) . '/>';
			$html .= '<label for="pages_unsortable-' . $key . '">' . $value . '</label> ';
		}

		$html .= '<p class="description">' . __( 'Meta boxes in checked pages can\'t be dragged or sorted.', $this->plugin_slug ) . '</p>';

		echo $html;

	} // end pages_unsortable_callback

	public function pages_reset_positions_callback() {

		$options = get_option( $this->plugin_slug );
		$options = ( isset( $options['pages_reset_positions'] ) ) ? $options['pages_reset_positions'] : array();

		$pages = $this->get_pages();
		$html = '';
		foreach ( $pages as $key => $value ) {
			$option = ( isset( $options[$key] ) ) ? $options[$key] : '';
			$html .= '<input type="checkbox" id="pages_reset_positions-' . $key . '" name="' . $this->plugin_slug . '[pages_reset_positions][' . $key . ']" value="' . $key . '"' . checked( $key, $option, false ) . '/>';
			$html .= '<label for="pages_reset_positions-' . $key . '">' . $value . '</label> ';
		}

		$html .= '<p class="description">' . __( 'The positions of meta boxes in checked pages will be reset.', $this->plugin_slug ) . '</p>';

		echo $html;

	} // end pages_reset_positions_callback

	public function get_post_type_name( $post_type ) {

		$obj = get_post_type_object( $post_type );
		$post_type_name = $obj->labels->name;

		return $post_type_name;
	}

	public function get_pages() {

		$pages = array(
			'dashboard' => 'Dashboard'
			);
		$post_types = get_post_types();
		$unset_post_types = array( 'nav_menu_item', 'revision', 'attachment' );
		foreach ( $post_types as $post_type ) {
			if ( ! in_array( $post_type, $unset_post_types ) )
				$pages[$post_type] = $this->get_post_type_name( $post_type );
		}

		return $pages;
	}
}

Unsortable_Meta_Box_Settings::get_instance();
?>