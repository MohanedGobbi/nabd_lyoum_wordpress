<?php
/**
 * Inline SVG icon set — a single authored, consistent-stroke icon library
 * (no icon font, no emoji), mirroring the icons used in the original design.
 * Usage: echo nabd_icon( 'menu', 'h-6 w-6' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nabd_icon( $name, $class = 'h-5 w-5' ) {
	$class = esc_attr( $class );
	$stroke_icons = array(
		'menu'          => '<line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/>',
		'search'        => '<circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
		'x-close'       => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
		'clock'         => '<circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/>',
		'chevron-left'  => '<polyline points="15 18 9 12 15 6"/>',
		'chevron-right' => '<polyline points="9 18 15 12 9 6"/>',
		'moon'          => '<path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/>',
		'sun'           => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
		'cloud-sun'     => '<path d="M6 15a4 4 0 1 1 1-7.9A5 5 0 0 1 17 9a3.5 3.5 0 0 1-.5 7H7"/><path d="M15 2v2M20 5l-1.4 1.4M22 10h-2"/>',
		'play'          => '<polygon points="6 4 20 12 6 20 6 4" fill="currentColor" stroke="none"/>',
		'play-circle'   => '<circle cx="12" cy="12" r="9"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/>',
		'home'          => '<path d="M4 11.5 12 4l8 7.5"/><path d="M6 10v9a1 1 0 0 0 1 1h4v-6h2v6h4a1 1 0 0 0 1-1v-9"/>',
		'flag'          => '<path d="M5 3v18"/><path d="M5 4h11l-2 4 2 4H5"/>',
		'globe'         => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a13 13 0 0 1 0 18M12 3a13 13 0 0 0 0 18"/>',
		'landmark'      => '<line x1="4" y1="21" x2="20" y2="21"/><path d="M5 21V10M9 21V10M15 21V10M19 21V10"/><path d="M3 10l9-6 9 6"/>',
		'trending-up'   => '<polyline points="4 16 10 10 14 13 20 6"/><polyline points="14 6 20 6 20 12"/>',
		'users'         => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 19a6 6 0 0 1 11 0"/><path d="M16 8.2a3 3 0 1 1 3 5.1"/><path d="M15 12.5c2.8.3 5 1.9 5.5 6"/>',
		'trophy'        => '<path d="M8 4h8v5a4 4 0 1 1-8 0V4Z"/><path d="M8 6H5a2 2 0 0 0 2 4M16 6h3a2 2 0 0 1-2 4"/><path d="M10 15v3M14 15v3M8 21h8"/>',
		'cpu'           => '<rect x="7" y="7" width="10" height="10" rx="1"/><rect x="2.5" y="9.5" width="2" height="5"/><rect x="19.5" y="9.5" width="2" height="5"/><rect x="9.5" y="2.5" width="5" height="2"/><rect x="9.5" y="19.5" width="5" height="2"/>',
		'book-open'     => '<path d="M4 5.5C6 4.5 9 4.5 12 6c3-1.5 6-1.5 8-.5v13c-2-1-5-1-8 .5-3-1.5-6-1.5-8-.5Z"/><path d="M12 6v13"/>',
		'sparkles'      => '<path d="M12 3l1.8 4.6L18 9.4l-4.2 1.8L12 16l-1.8-4.8L6 9.4l4.2-1.8Z"/><path d="M5 17l.8 2 2 .8-2 .8L5 22l-.8-1.4-2-.8 2-.8Z"/>',
		'star'          => '<polygon points="12 2 15 9 22 9.5 16.5 14 18.5 21 12 17 5.5 21 7.5 14 2 9.5 9 9"/>',
		'bell'          => '<path d="M6 9a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 13 6 9Z"/><path d="M9.5 17a2.5 2.5 0 0 0 5 0"/>',
		'globe-toggle'  => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a13 13 0 0 1 0 18 13 13 0 0 1 0-18Z"/>',
		'log-in'        => '<path d="M11 16l4-4-4-4"/><path d="M15 12H3"/><path d="M8 4h9a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H8"/>',
		'external-link' => '<path d="M14 5h5v5"/><path d="M19 5 10 14"/><path d="M18 13v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/>',
		'mail'          => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'arrow-up'      => '<line x1="12" y1="19" x2="12" y2="5"/><polyline points="6 11 12 5 18 11"/>',
		'arrow-down'    => '<line x1="12" y1="5" x2="12" y2="19"/><polyline points="6 13 12 19 18 13"/>',
		'archive'       => '<rect x="3" y="4" width="18" height="4" rx="1"/><path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/><line x1="10" y1="12" x2="14" y2="12"/>',
		'eye'           => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
		'zap'           => '<polygon points="13 2 3 14 11 14 10 22 21 10 13 10 13 2" fill="currentColor" stroke="none"/>',
		'more'          => '<circle cx="5" cy="12" r="1.6" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r="1.6" fill="currentColor" stroke="none"/><circle cx="19" cy="12" r="1.6" fill="currentColor" stroke="none"/>',
	);

	if ( isset( $stroke_icons[ $name ] ) ) {
		return sprintf(
			'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="%s" aria-hidden="true">%s</svg>',
			$class,
			$stroke_icons[ $name ]
		);
	}

	return nabd_brand_icon( $name, $class );
}

/** Filled brand marks (social + flags) — always currentColor, single path where possible. */
function nabd_brand_icon( $name, $class = 'h-5 w-5' ) {
	$class = esc_attr( $class );
	$paths = array(
		'facebook'  => '<path d="M13.5 21v-7.2h2.4l.4-2.8h-2.8V9.2c0-.8.2-1.4 1.4-1.4h1.5V5.2c-.3 0-1.2-.1-2.3-.1-2.3 0-3.9 1.4-3.9 4v2.9H7.8v2.8h2.4V21h3.3Z"/>',
		'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="4.5" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="16.6" cy="7.4" r="0.9"/>',
		'youtube'   => '<path d="M21.6 7.6c-.2-1-.9-1.7-1.9-2C17.9 5 12 5 12 5s-5.9 0-7.7.6c-1 .3-1.7 1-1.9 2C2 9.4 2 12 2 12s0 2.6.4 4.4c.2 1 .9 1.7 1.9 2 1.8.6 7.7.6 7.7.6s5.9 0 7.7-.6c1-.3 1.7-1 1.9-2 .4-1.8.4-4.4.4-4.4s0-2.6-.4-4.4ZM10 15V9l5.2 3-5.2 3Z"/>',
		'tiktok'    => '<path d="M16.6 5.82c-1.36-1.57-3.24-1.48-3.24-1.48h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6 0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64 0 3.33 2.76 5.7 5.69 5.7 3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.14.05-2.06-.5c-.66-.4-.85-.61-1-1Z"/>',
		'threads'   => '<path d="M12.19 24h-.01c-3.58-.02-6.33-1.2-8.18-3.5C2.35 18.44 1.5 15.59 1.47 12.01v-.02c.03-3.58.88-6.43 2.53-8.48C5.85 1.2 8.6.02 12.18 0h.01c2.75.02 5.04.73 6.83 2.1 1.68 1.29 2.86 3.13 3.51 5.47l-2.04.57c-1.1-3.94-3.9-5.95-8.3-5.98-2.91.02-5.11.94-6.53 2.72-1.32 1.65-2.04 4.03-2.06 7.04.03 3 .74 5.37 2.08 7.07 1.42 1.78 3.62 2.7 6.53 2.72 2.62-.02 4.36-.63 5.79-2.06 1.63-1.63 1.6-3.63 1.07-4.87-.31-.73-.88-1.34-1.64-1.78-.2 1.32-.63 2.37-1.29 3.14-.86.99-2.08 1.52-3.65 1.58a4.58 4.58 0 0 1-1.98-.4 3.42 3.42 0 0 1-1.5-1.2 3.09 3.09 0 0 1-.55-1.79c0-1.2.6-2.27 1.67-3 1-.68 2.34-1.04 3.87-1.04.65 0 1.28.05 1.9.13-.18-.94-.6-1.65-1.26-2.13-.77-.56-1.84-.85-3.18-.86-1.55-.01-2.83.35-3.81 1.07l-1.25-1.62c1.32-1.05 3.1-1.58 5.1-1.55 2.13.03 3.87.62 5.17 1.75 1.22 1.06 1.96 2.58 2.18 4.52.17 1.6-.08 3.31-.76 4.92-.66 1.6-1.71 2.87-3.11 3.78-1.44.93-3.19 1.42-5.21 1.44Zm-.32-11.17c-.91 0-1.77.19-2.41.53-.62.32-.97.78-.97 1.24 0 .43.19.8.54 1.05.35.25.82.39 1.33.39.94 0 1.7-.28 2.19-.81.38-.41.63-1 .73-1.75a7.54 7.54 0 0 0-1.41-.14Z"/>',
		'apple'     => '<path d="M16.4 12.3c0-1.7 1-2.6 1-2.6s-1-1.4-2.5-1.4c-1.2 0-1.9.7-2.9.7-1 0-1.8-.7-2.9-.7-1.6 0-3.1 1-3.9 2.6-1.6 2.8-.4 7.2 1.2 9.6.8 1.1 1.7 2.3 2.9 2.3 1.1 0 1.6-.7 3-.7s1.8.7 3 .7c1.2 0 2-1.1 2.7-2.2.6-.9.9-1.4 1.4-2.4-3.6-1.4-3-6-.2-6.9Zm-3.2-6.7c.6-.7 1-1.7.9-2.6-.9.1-1.9.6-2.5 1.3-.6.6-1 1.6-.9 2.6.9 0 1.9-.6 2.5-1.3Z" fill="currentColor" stroke="none"/>',
		'google-play' => '<path d="M4 3.5v17l9-8.5-9-8.5Z"/><path d="M4 3.5l12.5 7.2L20 8.5 5.3 3 4 3.5Z"/><path d="M4 20.5l12.5-7.2 3.5 2-15.3 5.5-.7-.3Z"/><path d="M16.5 10.7l3.6 2a1 1 0 0 1 0 1.6l-3.6 2-2.7-2.8 2.7-2.8Z"/>',
		'flag-us'    => '<rect width="24" height="16" rx="2" fill="#b22234"/><rect y="1" width="24" height="1" fill="#fff"/><rect y="3" width="24" height="1" fill="#fff"/><rect y="5" width="24" height="1" fill="#fff"/><rect y="7" width="24" height="1" fill="#fff"/><rect y="9" width="24" height="1" fill="#fff"/><rect y="11" width="24" height="1" fill="#fff"/><rect y="13" width="24" height="1" fill="#fff"/><rect width="10" height="8.5" fill="#3c3b6e"/>',
		'flag-eu'    => '<rect width="24" height="16" rx="2" fill="#039"/><circle cx="12" cy="3" r="0.8" fill="#fc0"/><circle cx="12" cy="13" r="0.8" fill="#fc0"/><circle cx="7" cy="8" r="0.8" fill="#fc0"/><circle cx="17" cy="8" r="0.8" fill="#fc0"/><circle cx="8.5" cy="4.5" r="0.8" fill="#fc0"/><circle cx="15.5" cy="4.5" r="0.8" fill="#fc0"/><circle cx="8.5" cy="11.5" r="0.8" fill="#fc0"/><circle cx="15.5" cy="11.5" r="0.8" fill="#fc0"/>',
		'flag-gb'    => '<rect width="24" height="16" rx="2" fill="#012169"/><path d="M0 0 24 16M24 0 0 16" stroke="#fff" stroke-width="2.6"/><path d="M0 0 24 16M24 0 0 16" stroke="#C8102E" stroke-width="1.2"/><path d="M12 0v16M0 8h24" stroke="#fff" stroke-width="4.4"/><path d="M12 0v16M0 8h24" stroke="#C8102E" stroke-width="2.4"/>',
		'flag-ch'    => '<rect width="24" height="16" rx="2" fill="#d52b1e"/><rect x="10" y="4.5" width="4" height="7" fill="#fff"/><rect x="7" y="7" width="10" height="2" fill="#fff"/>',
		'flag-ca'    => '<rect width="24" height="16" rx="2" fill="#fff"/><rect width="6" height="16" fill="#d52b1e"/><rect x="18" width="6" height="16" fill="#d52b1e"/><path d="M12 4.5l1 2.2 2-1-.6 2.3 1.9.3-1.6 1.6.9 1-1.6-.3.2 2-1.2-1.4-1.2 1.4.2-2-1.6.3.9-1-1.6-1.6 1.9-.3-.6-2.3 2 1z" fill="#d52b1e"/>',
	);

	if ( isset( $paths[ $name ] ) ) {
		return sprintf( '<svg viewBox="0 0 24 24" fill="currentColor" class="%s" aria-hidden="true">%s</svg>', $class, $paths[ $name ] );
	}

	return '';
}
