<?php
/**
 * Styles & scripts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nabd_enqueue_assets() {
	wp_enqueue_style(
		'nabd-google-fonts',
		'https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Lalezar&family=Rakkas&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'nabd-main',
		NABD_URI . '/assets/css/main.css',
		array( 'nabd-google-fonts' ),
		NABD_VERSION
	);

	wp_enqueue_script(
		'nabd-main',
		NABD_URI . '/assets/js/main.js',
		array(),
		NABD_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'nabd_enqueue_assets' );

/**
 * Force RTL + Arabic on the document element regardless of the WordPress
 * site locale setting, and drop the admin bar's own (LTR) assets from the
 * front end so they never fight the theme's direction.
 */
add_filter( 'language_attributes', function ( $output ) {
	return 'lang="ar" dir="rtl"';
}, 20 );
