<?php
/**
 * نبض اليوم — theme bootstrap.
 * Loads the split-out includes; keeps this file as a short index.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NABD_VERSION', '1.0.0' );
define( 'NABD_DIR', get_template_directory() );
define( 'NABD_URI', get_template_directory_uri() );

require NABD_DIR . '/inc/setup.php';
require NABD_DIR . '/inc/enqueue.php';
require NABD_DIR . '/inc/categories.php';
require NABD_DIR . '/inc/post-meta.php';
require NABD_DIR . '/inc/template-helpers.php';
require NABD_DIR . '/inc/icons.php';
require NABD_DIR . '/inc/customizer.php';
