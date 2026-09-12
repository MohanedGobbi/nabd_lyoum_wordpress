<?php
/**
 * Small, reusable template helpers: relative time, social links, and the
 * currency ticker's data (static for now — see the note on
 * nabd_currency_rates() for how to make it live later).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * "منذ 5 دقائق" / "منذ 3 ساعات" / "منذ يومين" — same phrasing rules as the
 * original design (minutes under an hour, hours under a day, else days).
 */
function nabd_time_ago( $post_id ) {
	$then = get_post_time( 'U', true, $post_id );
	$diff_minutes = max( 0, round( ( time() - $then ) / 60 ) );

	if ( $diff_minutes < 60 ) {
		return sprintf( __( 'منذ %s دقيقة', 'nabd-aljazair' ), nabd_ar_num( $diff_minutes ) );
	}

	$hours = round( $diff_minutes / 60 );
	if ( $hours < 24 ) {
		$unit = 1 === $hours ? __( 'ساعة', 'nabd-aljazair' ) : __( 'ساعات', 'nabd-aljazair' );
		return sprintf( __( 'منذ %1$s %2$s', 'nabd-aljazair' ), nabd_ar_num( $hours ), $unit );
	}

	$days = round( $hours / 24 );
	$unit = 1 === $days ? __( 'يوم', 'nabd-aljazair' ) : __( 'أيام', 'nabd-aljazair' );
	return sprintf( __( 'منذ %1$s %2$s', 'nabd-aljazair' ), nabd_ar_num( $days ), $unit );
}

/** Western digits, kept tabular via the .num utility class in CSS — not Eastern Arabic numerals, matching the original site. */
function nabd_ar_num( $n ) {
	return number_format_i18n( $n );
}

/**
 * Single source of truth for social links, consumed by the header, footer,
 * and mobile drawer. Edit the href values here (or move to Customizer
 * settings — see inc/customizer.php) if the client's handles change.
 */
function nabd_social_links() {
	return array(
		array( 'key' => 'facebook', 'label' => 'فيسبوك', 'href' => 'https://www.facebook.com/NabadElyoum' ),
		array( 'key' => 'instagram', 'label' => 'إنستغرام', 'href' => 'https://www.instagram.com/nabadelyoum/' ),
		array( 'key' => 'tiktok', 'label' => 'تيك توك', 'href' => 'https://www.tiktok.com/@nabdalyoum' ),
		array( 'key' => 'youtube', 'label' => 'يوتيوب', 'href' => 'https://www.youtube.com/@NabadElyoum' ),
		array( 'key' => 'threads', 'label' => 'ثريدز', 'href' => 'https://www.threads.com/@nabadelyoum?hl=ar' ),
	);
}

/**
 * Currency ticker data. There is no natural WordPress data source for this
 * (it's not content an editor writes), so it's a small static list here —
 * update the numbers by editing this array. A future upgrade path: pull
 * these from a real FX API on a cron (wp_schedule_event) and cache them in
 * a transient, or use Customizer fields if the client wants to edit them
 * from wp-admin without a developer. Both are straightforward additions
 * that don't change any template markup.
 */
function nabd_currency_rates() {
	return array(
		array( 'code' => 'USD', 'name' => 'دولار أمريكي', 'rate' => '135.25', 'change' => 0.11, 'flag' => 'flag-us' ),
		array( 'code' => 'EUR', 'name' => 'يورو', 'rate' => '150.12', 'change' => 0.27, 'flag' => 'flag-eu' ),
		array( 'code' => 'GBP', 'name' => 'جنيه إسترليني', 'rate' => '178.36', 'change' => -0.07, 'flag' => 'flag-gb' ),
		array( 'code' => 'CHF', 'name' => 'فرنك سويسري', 'rate' => '160.89', 'change' => 0.35, 'flag' => 'flag-ch' ),
		array( 'code' => 'CAD', 'name' => 'دولار كندي', 'rate' => '97.54', 'change' => 0.15, 'flag' => 'flag-ca' ),
	);
}

/**
 * Whether a post belongs to the "فيديو" category — used to overlay a small
 * play badge on its thumbnail wherever it's shown as a card, so video
 * content reads at a glance even outside the dedicated video rail.
 */
function nabd_post_is_video( $post_id ) {
	return has_category( 'video', $post_id );
}

/** Excerpt trimmed to a fixed length, stripped of shortcodes/tags — used in the hero and article grid cards. */
function nabd_card_excerpt( $post_id, $length = 22 ) {
	$excerpt = get_the_excerpt( $post_id );
	return wp_trim_words( $excerpt, $length, '…' );
}

/** Renders a full <img> (or a category-tinted placeholder block when the post has no featured image). */
function nabd_post_image( $post_id, $size = 'nabd-card', $extra_class = '' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size, array( 'class' => 'h-full w-full object-cover ' . esc_attr( $extra_class ), 'loading' => 'lazy', 'alt' => '' ) );
		return;
	}

	$cats = get_the_category( $post_id );
	$slug = $cats ? $cats[0]->slug : 'aljazair';
	printf(
		'<div class="flex h-full w-full items-center justify-center %s" style="%s">%s</div>',
		esc_attr( $extra_class ),
		esc_attr( nabd_cat_bg_style( $slug ) . 'opacity:.9' ),
		nabd_icon( 'sparkles', 'h-8 w-8 text-white/70' )
	);
}
