<?php
/**
 * Post meta: a simple view counter and a "breaking news" flag, both exposed
 * as an editor meta box so staff don't need a separate plugin for either.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** ---- View counter ------------------------------------------------- */

function nabd_get_views( $post_id ) {
	$views = get_post_meta( $post_id, '_nabd_views', true );
	return $views ? (int) $views : 0;
}

function nabd_record_view( $post_id ) {
	if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
		return; // don't inflate counts from staff previewing their own posts
	}
	$views = nabd_get_views( $post_id );
	update_post_meta( $post_id, '_nabd_views', $views + 1 );
}
add_action( 'wp_head', function () {
	if ( is_single() && get_post_type() === 'post' ) {
		nabd_record_view( get_the_ID() );
	}
} );

/** Show a "views" column on the Posts admin list. */
add_filter( 'manage_posts_columns', function ( $columns ) {
	$columns['nabd_views'] = __( 'المشاهدات', 'nabd-aljazair' );
	return $columns;
} );
add_action( 'manage_posts_custom_column', function ( $column, $post_id ) {
	if ( 'nabd_views' === $column ) {
		echo esc_html( number_format_i18n( nabd_get_views( $post_id ) ) );
	}
}, 10, 2 );

/** ---- Breaking-news flag -------------------------------------------- */

function nabd_is_breaking( $post_id ) {
	return (bool) get_post_meta( $post_id, '_nabd_breaking', true );
}

add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'nabd_breaking_box',
		__( 'عاجل', 'nabd-aljazair' ),
		'nabd_render_breaking_box',
		'post',
		'side',
		'high'
	);
} );

function nabd_render_breaking_box( $post ) {
	wp_nonce_field( 'nabd_breaking_save', 'nabd_breaking_nonce' );
	$checked = nabd_is_breaking( $post->ID );
	?>
	<label style="display:flex;align-items:center;gap:8px;font-weight:600;">
		<input type="checkbox" name="nabd_breaking" value="1" <?php checked( $checked ); ?> />
		<?php esc_html_e( 'وسّم هذا المقال كخبر عاجل (يظهر في شريط العاجل بالصفحة الرئيسية)', 'nabd-aljazair' ); ?>
	</label>
	<?php
}

add_action( 'save_post_post', function ( $post_id ) {
	if ( ! isset( $_POST['nabd_breaking_nonce'] ) || ! wp_verify_nonce( $_POST['nabd_breaking_nonce'], 'nabd_breaking_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, '_nabd_breaking', isset( $_POST['nabd_breaking'] ) ? 1 : 0 );

	if ( isset( $_POST['nabd_video_duration'] ) ) {
		update_post_meta( $post_id, '_nabd_video_duration', sanitize_text_field( $_POST['nabd_video_duration'] ) );
	}
} );

/** ---- Optional video duration (shown on cards for posts in the "فيديو" category) ---- */

add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'nabd_video_box',
		__( 'مدة الفيديو (اختياري)', 'nabd-aljazair' ),
		'nabd_render_video_box',
		'post',
		'side',
		'default'
	);
} );

function nabd_render_video_box( $post ) {
	$value = get_post_meta( $post->ID, '_nabd_video_duration', true );
	?>
	<label style="display:block;font-size:12px;color:#666;margin-bottom:4px;">
		<?php esc_html_e( 'مثال: 02:15 — تظهر كشارة على صورة المقال إذا كان مصنّفاً ضمن "فيديو".', 'nabd-aljazair' ); ?>
	</label>
	<input type="text" name="nabd_video_duration" value="<?php echo esc_attr( $value ); ?>" placeholder="00:00" style="width:100%;" />
	<?php
}

function nabd_video_duration( $post_id ) {
	return get_post_meta( $post_id, '_nabd_video_duration', true );
}

/**
 * The single latest post flagged breaking, if any — used for the homepage
 * breaking-news strip. Falls back to null (the strip hides itself).
 */
function nabd_current_breaking_post() {
	$q = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
		'meta_key'       => '_nabd_breaking',
		'meta_value'     => '1',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	) );
	$post = $q->have_posts() ? $q->posts[0] : null;
	wp_reset_postdata();
	return $post;
}
