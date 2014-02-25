<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Unsortable_Meta_Box
 * @author    1fixdotio <1fixdotio@gmail.com>
 * @license   GPL-2.0+
 * @link      http://1fix.io/unsortable-meta-box
 * @copyright 2014 1Fix.io
 */
?>

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">

	<div id="icon-themes" class="icon32"></div>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<?php // settings_errors(); ?>

	<form method="post" action="options.php">
		<?php
			$plugin = Unsortable_Meta_Box::get_instance();

			settings_fields( $plugin->get_plugin_slug() );
			do_settings_sections( $plugin->get_plugin_slug() );

			submit_button();

		?>
	</form>

</div><!-- /.wrap -->