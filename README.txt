=== Unsortable Meta Box ===

Contributors: 1fixdotio, yoren
Donate link: http://1fix.io/
Tags: disable-dragging, meta-box, unsort, reset-positions
Requires at least: 3.5
Tested up to: 3.8.1
Stable tag: 0.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Disable dragging of meta boxes and reset their positions.

== Description ==

Draggable and sortable meta boxes is one of the cool features of WordPress. But let users customize the UI could become painful when doing technical supports online or on the phone. The client might has moved the publish box to the bottom of the page, but you still ask her / him to look at the top right corner for it. Unsortable Meta Box is a simple fix to situation like this.

This plugin is made for:

* Disable dragging of meta boxes. You could disable dragging on all or certain pages (Dashboard, Post, Page, Custom Post Types etc.), which could be set on the Settings page.
* Reset positions of the meta boxes on certain pages. Do this on the Settings page.
* TODO - Add roles selection. (Disable dragging or reset the positions for selected roles.)
* TODO - Save the positions of the meta boxes for recovery later.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'unsortable-meta-box'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `unsortable-meta-box.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `unsortable-meta-box.zip`
2. Extract the `unsortable-meta-box` directory to your computer
3. Upload the `unsortable-meta-box` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Screenshots ==

1. Display a notification after plugin activation.
2. A settings page for this plugin.

== Changelog ==

= 0.9.0 =
* Fix "commentsBox is not defined" issue.

= 0.8.0 =
* Use 3-digit version number.
* Remove weDevs Settings API wrapper class. Use WordPress Settings API directly.
* Debug and improve performance via Scrutinizer.

= 0.7 =
* Translation for Traditional Chinese has been added.

= 0.6 =
* Add activation and deactivation messages.

= 0.5 =
* The first version.
