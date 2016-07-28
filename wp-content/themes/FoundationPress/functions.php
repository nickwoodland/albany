<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/menu-walkers.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Change WP's sticky post class */
require_once( 'library/login-redirect.php' );

/** CPT for Reports */
require_once( 'library/cpt-reports.php' );

/** CPT for Companies */
require_once( 'library/cpt-companies.php' );

/** CPT for Locales */
require_once( 'library/cpt-locales.php' );

require_once( 'library/cmb-reports.php' );

require_once( 'library/cmb-locales.php' );

/** p2p connections */
require_once( 'library/connections.php' );

/** custom user auth functions */
require_once( 'library/user-auth.php' );

/** function to attach FTP'd pdf to a post */
require_once( 'library/pdf-handle.php' );

/** Handler for external form submissions*/
require_once( 'library/form-post-handler.php' );

/** pdf snatcher cron */
require_once( 'library/report-cron.php' );





/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/protocol-relative-theme-assets.php' );

?>
