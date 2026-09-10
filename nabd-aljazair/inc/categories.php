<?php
/**
 * The site's fixed 10-category taxonomy, its color system, and the
 * first-run setup that creates the categories automatically so the theme
 * is usable immediately after activation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slug => Arabic name, in the client's official display order.
 * This order drives the primary nav, the drawer, and the homepage's
 * stacked per-category sections — change it here to change it everywhere.
 */
function nabd_category_taxonomy() {
	return array(
		'aljazair'  => 'الجزائر',
		'world'     => 'العرب والعالم',
		'politics'  => 'سياسة',
		'economy'   => 'اقتصاد',
		'society'   => 'مجتمع',
		'sport'     => 'رياضة',
		'tech'      => 'تكنولوجيا',
		'culture'   => 'ثقافة',
		'varieties' => 'منوعات',
		'video'     => 'فيديو',
	);
}

/**
 * Category identity colors — the same values as the site's original design
 * system. Light-mode text/background use the color as-is; dark-mode text
 * swaps to a lighter shade for the three hues too dark to read on a
 * near-black surface (aljazair, politics, video).
 */
function nabd_category_colors() {
	return array(
		'aljazair'  => array( 'hex' => '#16181d', 'dark_text' => '#94a3b8' ), // slate-400
		'world'     => array( 'hex' => '#1d5fbf', 'dark_text' => '#60a5fa' ), // blue-400
		'politics'  => array( 'hex' => '#233a5e', 'dark_text' => '#cbd5e1' ), // slate-300
		'economy'   => array( 'hex' => '#c8151c', 'dark_text' => '#f87171' ), // red-400
		'society'   => array( 'hex' => '#b45309', 'dark_text' => '#fbbf24' ), // amber-400
		'sport'     => array( 'hex' => '#1f8a4c', 'dark_text' => '#34d399' ), // emerald-400
		'tech'      => array( 'hex' => '#0f8fa8', 'dark_text' => '#22d3ee' ), // cyan-400
		'culture'   => array( 'hex' => '#7c3aed', 'dark_text' => '#a78bfa' ), // violet-400
		'varieties' => array( 'hex' => '#0d9488', 'dark_text' => '#2dd4bf' ), // teal-400
		'video'     => array( 'hex' => '#334155', 'dark_text' => '#94a3b8' ), // slate-400
	);
}

/**
 * Create the ten categories on theme activation if they don't already
 * exist, so a fresh WordPress install matches the client's brief without
 * anyone having to type them in by hand.
 */
function nabd_create_default_categories() {
	foreach ( nabd_category_taxonomy() as $slug => $name ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'after_switch_theme', 'nabd_create_default_categories' );

/**
 * Inline <style> block defining one CSS custom property per category
 * (--cat-<slug>) plus its dark-mode override, so templates and the
 * compiled Tailwind CSS never need to inline hex values by hand.
 */
function nabd_category_color_vars() {
	$css = ':root{';
	foreach ( nabd_category_colors() as $slug => $c ) {
		$css .= "--cat-{$slug}:{$c['hex']};";
	}
	$css .= '}.dark{';
	foreach ( nabd_category_colors() as $slug => $c ) {
		$css .= "--cat-{$slug}-text:{$c['dark_text']};";
	}
	$css .= '}:root{';
	foreach ( nabd_category_colors() as $slug => $c ) {
		$css .= "--cat-{$slug}-text:{$c['hex']};";
	}
	$css .= '}';
	echo '<style id="nabd-category-vars">' . $css . '</style>'; // phpcs:ignore
}
add_action( 'wp_head', 'nabd_category_color_vars', 5 );

/**
 * Resolves a category term object, a term ID, or a plain slug string down
 * to a slug — the one thing nabd_cat_bg_style()/nabd_cat_text_style() need.
 * Falls back to "aljazair" for anything unresolvable (e.g. the "Uncategorized"
 * default term) rather than emitting a PHP warning.
 */
function nabd_resolve_cat_slug( $category ) {
	if ( is_object( $category ) && isset( $category->slug ) ) {
		return $category->slug;
	}
	if ( is_string( $category ) && ! is_numeric( $category ) ) {
		return $category;
	}
	if ( $category ) {
		$term = get_term( $category );
		if ( $term && ! is_wp_error( $term ) ) {
			return $term->slug;
		}
	}
	return 'aljazair';
}

/**
 * A category's accent color as an inline style attribute value, e.g. for a
 * badge background: style="<?php echo nabd_cat_bg_style( $cat_id ); ?>"
 */
function nabd_cat_bg_style( $category ) {
	$slug = nabd_resolve_cat_slug( $category );
	return 'background-color:var(--cat-' . esc_attr( $slug ) . ',#121214);';
}

function nabd_cat_text_style( $category ) {
	$slug = nabd_resolve_cat_slug( $category );
	return 'color:var(--cat-' . esc_attr( $slug ) . '-text,#121214);';
}

/**
 * Returns the taxonomy-ordered list of WP_Term objects for the ten official
 * categories that actually exist in the database (so the front end never
 * breaks if one hasn't been created yet).
 */
function nabd_ordered_categories() {
	$ordered = array();
	foreach ( array_keys( nabd_category_taxonomy() ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( $term && ! is_wp_error( $term ) ) {
			$ordered[] = $term;
		}
	}
	return $ordered;
}
