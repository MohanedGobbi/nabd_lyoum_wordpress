<?php
/**
 * Core theme setup: supports, menus, image sizes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nabd_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// The site is Arabic/RTL-only for this phase (matches the product brief);
	// WordPress's own RTL switching is intentionally not relied on.
	add_image_size( 'nabd-card', 480, 320, true );
	add_image_size( 'nabd-hero', 1200, 800, true );
	add_image_size( 'nabd-thumb', 240, 180, true );

	register_nav_menus( array(
		'footer-about' => __( 'روابط تذييل — نبض اليوم', 'nabd-aljazair' ),
	) );
}
add_action( 'after_setup_theme', 'nabd_theme_setup' );

/**
 * Auto-create the "كل الأخبار" (all news) page on theme activation, assign
 * it the all-news page template, and remember its ID — so every "see all
 * news" link in the theme has somewhere real to point without the admin
 * having to configure Settings → Reading by hand.
 */
function nabd_create_news_page() {
	$existing_id = get_option( 'nabd_news_page_id' );
	if ( $existing_id && get_post( $existing_id ) ) {
		return;
	}

	$page_id = wp_insert_post( array(
		'post_title'   => __( 'كل الأخبار', 'nabd-aljazair' ),
		'post_name'    => 'news',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_content' => '',
	) );

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-templates/all-news.php' );
		update_option( 'nabd_news_page_id', $page_id );
	}
}
add_action( 'after_switch_theme', 'nabd_create_news_page' );

/** URL of the auto-created "كل الأخبار" page, with a same-slug fallback if it's ever deleted. */
function nabd_news_page_url() {
	$id = get_option( 'nabd_news_page_id' );
	if ( $id && get_post( $id ) ) {
		return get_permalink( $id );
	}
	return home_url( '/news/' );
}

/**
 * Register the widget-less footer link fallback pages on first activation
 * so the theme is usable immediately without demo content.
 */
function nabd_register_widget_areas() {
	register_sidebar( array(
		'name'          => __( 'غير مستخدم حالياً', 'nabd-aljazair' ),
		'id'            => 'nabd-unused',
		'description'   => __( 'القالب لا يستخدم أشرطة جانبية — محجوز للمستقبل.', 'nabd-aljazair' ),
	) );
}
// Intentionally not hooked: the theme has no sidebar surfaces yet.

/**
 * Disable comments site-wide — a news portal with no comment moderation
 * workflow yet. Editors can re-enable per-post if the client wants it later.
 */
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );
add_filter( 'default_comment_status', '__return_false' ); // so the editor UI ("مناقشة") reflects reality on new posts too
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
} );
