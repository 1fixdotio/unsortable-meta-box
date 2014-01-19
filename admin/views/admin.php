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

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php

	global $settings;

	// $settings->settings_api->show_navigation();
	$settings->settings_api->show_forms();
	?>

</div>