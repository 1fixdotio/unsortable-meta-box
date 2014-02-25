<?php

if ( !class_exists( 'Unsortable_Meta_Box_Settings' ) ):
	class Unsortable_Meta_Box_Settings {

		function __construct() {

			$plugin = Unsortable_Meta_Box::get_instance();
			$this->plugin_slug = $plugin->get_plugin_slug();

			add_action( 'admin_init', array( $this, 'admin_init' ) );

		}

		/**
		 * Provides default values for the Input Options.
		 */
		function default_settings() {

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

		/**
		 * Initializes the theme's input example by registering the Sections,
		 * Fields, and Settings. This particular group of options is used to demonstration
		 * validation and sanitization.
		 *
		 * This function is registered with the 'admin_init' hook.
		 */
		function admin_init() {

			if( false == get_option( $this->plugin_slug ) ) {
				add_option( $this->plugin_slug, apply_filters( 'default_settings', default_settings() ) );
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

		function pages_unsortable_callback() {

			$options = get_option( $this->plugin_slug );
			$options = $options['pages_unsortable'];

			$pages = $this->get_pages();
			$html = '';
			foreach ( $pages as $key => $value ) {
				$option = ( isset( $options[$key] ) ) ? $options[$key] : '';
				$html .= '<input type="checkbox" id="' . $key . '" name="' . $this->plugin_slug . '[pages_unsortable][' . $key . ']" value="' . $key . '"' . checked( $key, $option, false ) . '/>';
				$html .= '<label for="' . $key . '">' . $value . '</label> ';
			}

			$html .= '<p class="description">' . __( 'Meta boxes in checked pages can\'t be dragged or sorted.', $this->plugin_slug ) . '</p>';

			echo $html;

		} // end pages_unsortable_callback

		function pages_reset_positions_callback() {

			$options = get_option( $this->plugin_slug );
			$options = $options['pages_reset_positions'];

			$pages = $this->get_pages();
			$html = '';
			foreach ( $pages as $key => $value ) {
				$option = ( isset( $options[$key] ) ) ? $options[$key] : '';
				$html .= '<input type="checkbox" id="' . $key . '" name="' . $this->plugin_slug . '[pages_reset_positions][' . $key . ']" value="' . $key . '"' . checked( $key, $option, false ) . '/>';
				$html .= '<label for="' . $key . '">' . $value . '</label> ';
			}

			$html .= '<p class="description">' . __( 'The positions of meta boxes in checked pages will be reset.', $this->plugin_slug ) . '</p>';

			echo $html;

		} // end pages_reset_positions_callback

		function get_post_type_name( $post_type ) {

			$obj = get_post_type_object( $post_type );
			$post_type_name = $obj->labels->name;

			return $post_type_name;
		}

		function get_pages() {

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
endif;

global $settings;
$settings = new Unsortable_Meta_Box_Settings();
?>