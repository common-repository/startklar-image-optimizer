=== Startklar Image Optimizer ===
Tags: performance, optimization, SEO
Contributors: WEB-SHOP-HOSTING
Donate link: https://web-shop-hosting.com/
Tested up to: 6.0
Stable tag: 1.0
Requires PHP: 5.6.20
Requires at least: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/donate/?hosted_button_id=J2FXPNSYGWLBE

This plugin allows you to optimize images from your media library and thus improve the SEO performance of your site.

== Description ==
This plugin allows you to optimize images from your media library and thus improve the SEO performance of your site.
This plugin is based on the JPEGOPTIM utility and PNGQUANT utility which must be installed on your host.
The essence of our plugin is that when it starts, it sorts through all the attachments for the articles of your WP-site
and processes them right at the place where they are located.
After that, the attachment is marked as processed, which prevents it from being processed again.
In the admin page you can view the total number of your images and the number of processed images,
as well as select the number of images to be processed in one cycle.
At the moment, the script for optimization is made in the form of a standard wp-action (its name is "startklar_image_optimizer_process")
that can be called from another place.

 Here is an example of how to call this action:
 do_action( 'startklar_image_optimizer_process' );


For example, for a simple implementation, you can use the "WP Crontrol" plugin (https://ru.wordpress.org/plugins/wp-crontrol/)
 by which you can create a cron task that can optimize one image every minute.
This tactic was chosen in order to process all the files of the site without introducing excessive load to the site
(since the native cron in WP is activated by hits and has a runtime limit, like similar http sessions of this host).

Screenshot #1 shows how easy it is to set up a cron-task.


== Installation ==
**Plugin installation.**
Installation is done as standard for WP. Install "WP Crontrol" plugin in addition if you need to run cron optimization.

**Plugin setup.**
The setup interface is as simple and intuitive as possible.
Go to the admin page and make sure you have the JPEGOPTIM utility and the PNGQUANT utility installed.
Use the admin page to view statistics and select how many images, are processed per cycle.
**Usage.**
Create a new cron task for the action "startklar_image_optimizer_process" in the plugin "WP Crontrol".
Screenshot #1 shows how easy it is to set up a cron-task.


== Frequently Asked Questions ==

= How can I check that the plugin is configured and working correctly? =

You can temporarily activate debug mode in WordPress.

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

'WP_DEBUG' is a PHP constant (a permanent global variable) that can be used to trigger the debug mode throughout WordPress.
'WP_DEBUG_LOG'   - When set to true, the log is saved to debug.log in the content directory (usually /wp-content/plugins/startklar_image_optimizer/debug.log) within your sites filesystem. Alternatively, you can set it to a valid file path to have the file saved elsewhere.

Now you can see lines like this in your log file:

START OPTIMIZATION 14.06.2022 18:25:18
_wp_attachment_metadata id=26
PROCESS FILEC:\xampp1\htdocs\my-wp/wp-content/uploads/2022/06/pexels-jhovani-morales-12319997-200x300.jpg  BY jpegoptim
END
After processing, the source file should reduce in size, it's not difficult to track.
After checking, return the constants that are responsible for debugging to their original state.

== Screenshots ==

1. How easy it is to set up a cron-task.


== Changelog ==

= 1.0 =
* First Release