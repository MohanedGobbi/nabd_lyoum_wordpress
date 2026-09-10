<?php
/**
 * A handful of Customizer fields for things that aren't really "content"
 * (so they don't belong in a post/page) but the client will still want to
 * edit themselves without a developer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nabd_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'nabd_options', array(
		'title'    => __( 'إعدادات نبض اليوم', 'nabd-aljazair' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'nabd_weather_text', array(
		'default'           => '25° الجزائر',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nabd_weather_text', array(
		'section' => 'nabd_options',
		'label'   => __( 'نص الطقس في الشريط العلوي', 'nabd-aljazair' ),
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'nabd_breaking_fallback', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nabd_breaking_fallback', array(
		'section'     => 'nabd_options',
		'label'       => __( 'نص شريط "عاجل" الافتراضي', 'nabd-aljazair' ),
		'description' => __( 'يظهر فقط إذا لم يوجد مقال موسوم كـ "عاجل" حالياً. اتركه فارغاً لإخفاء الشريط في هذه الحالة.', 'nabd-aljazair' ),
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'nabd_footer_blurb', array(
		'default'           => 'منصة إخبارية جزائرية تقدم لكم آخر الأخبار بمصداقية وموضوعية على مدار الساعة.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'nabd_footer_blurb', array(
		'section' => 'nabd_options',
		'label'   => __( 'وصف التذييل', 'nabd-aljazair' ),
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'nabd_app_store_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'nabd_app_store_url', array(
		'section' => 'nabd_options',
		'label'   => __( 'رابط App Store', 'nabd-aljazair' ),
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'nabd_play_store_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'nabd_play_store_url', array(
		'section' => 'nabd_options',
		'label'   => __( 'رابط Google Play', 'nabd-aljazair' ),
		'type'    => 'url',
	) );
}
add_action( 'customize_register', 'nabd_customize_register' );
