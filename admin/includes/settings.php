<?php

if ( !class_exists( 'Unsortable_Meta_Box_Settings' ) ):
	class Unsortable_Meta_Box_Settings {

	public $settings_api;

	function __construct() {
		$this->settings_api = new WeDevs_Settings_API;

		$plugin = Unsortable_Meta_Box::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id' => $this->plugin_slug,
				'title' => __( 'Settings', $this->plugin_slug )
			)
		);
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		$pages = array(
			'dashboard' => 'Dashboard'
			);
		$post_types = get_post_types();
		$unset_post_types = array( 'nav_menu_item', 'revision', 'attachment' );
		foreach ( $post_types as $post_type ) {
			if ( ! in_array( $post_type, $unset_post_types ) )
				$pages[$post_type] = $this->get_post_type_name( $post_type );
		}

		$settings_fields = array(
			$this->plugin_slug => array(
				array(
					'name' => 'pages_unsortable',
					'label' => __( 'Pages to disable sortable meta boxes:', $this->plugin_slug ),
					'desc' => __( 'Meta boxes in checked pages can\'t be dragged or sorted.', $this->plugin_slug ),
					'type' => 'multicheck',
					'options' => $pages
				),
				array(
					'name' => 'pages_reset_positions',
					'label' => __( 'Pages to reset positions of meta boxes:', $this->plugin_slug ),
					'desc' => __( 'The positions of meta boxes in checked pages will be reset.', $this->plugin_slug ),
					'type' => 'multicheck',
					'options' => $pages
				)
			)
		);

		return $settings_fields;
	}

	function get_post_type_name( $post_type ) {

		$obj = get_post_type_object( $post_type );
		$post_type_name = $obj->labels->name;

		return $post_type_name;
	}

}
endif;

global $settings;
$settings = new Unsortable_Meta_Box_Settings();
