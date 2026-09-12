<?php
/**
 * Grid article card.
 *
 * Regular post: clean photo (no overlay/badge), headline below, then a
 * plain-text meta line (category in its own color + a middle dot + time).
 *
 * Video post: one continuous box — the video thumbnail on top (with its
 * play badge/duration), and the headline sits directly under it inside a
 * solid video-colored panel, so the whole card reads as "this is a video"
 * at a glance, not just a small text label.
 *
 * Usage: get_template_part( 'template-parts/article-card', null, array( 'post_id' => $id ) );
 */

$post_id = $args['post_id'] ?? get_the_ID();
$cats    = get_the_category( $post_id );
$cat     = $cats ? $cats[0] : null;
$is_video = nabd_post_is_video( $post_id );
?>
<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="group block<?php echo $is_video ? ' overflow-hidden rounded-xl shadow-card' : ''; ?>">
	<div class="relative aspect-[16/11] overflow-hidden <?php echo $is_video ? '' : 'rounded-xl'; ?> bg-ink-900/5 dark:bg-white/5">
		<div class="absolute inset-0 transition duration-500 group-hover:scale-105">
			<?php nabd_post_image( $post_id, 'nabd-card' ); ?>
		</div>
		<?php if ( $is_video ) : ?>
			<span class="absolute inset-0 flex items-center justify-center bg-black/10 transition group-hover:bg-black/25">
				<span class="flex h-10 w-10 items-center justify-center rounded-full text-white shadow-pop" style="<?php echo esc_attr( nabd_cat_bg_style( 'video' ) ); ?>">
					<?php echo nabd_icon( 'play', 'h-4 w-4' ); ?>
				</span>
			</span>
			<?php if ( nabd_video_duration( $post_id ) ) : ?>
				<span class="num absolute bottom-2 end-2 rounded bg-black/70 px-1.5 py-0.5 text-[11px] font-bold text-white"><?php echo esc_html( nabd_video_duration( $post_id ) ); ?></span>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<?php if ( $is_video ) : ?>
		<div class="px-3 py-2.5" style="<?php echo esc_attr( nabd_cat_bg_style( 'video' ) ); ?>">
			<h3 class="line-clamp-2 text-[14.5px] font-bold leading-snug text-white">
				<?php echo esc_html( get_the_title( $post_id ) ); ?>
			</h3>
			<div class="num mt-1.5 flex items-center gap-1.5 text-[12px] text-white/80">
				<?php echo nabd_icon( 'play-circle', 'h-3.5 w-3.5' ); ?>
				<span class="font-semibold"><?php esc_html_e( 'فيديو', 'nabd-aljazair' ); ?></span>
				<span class="text-white/40">·</span>
				<span><?php echo esc_html( nabd_time_ago( $post_id ) ); ?></span>
			</div>
		</div>
	<?php else : ?>
		<h3 class="mt-2.5 line-clamp-2 text-[14.5px] font-bold leading-snug text-ink-900 transition-colors group-hover:text-brand dark:text-white/90">
			<?php echo esc_html( get_the_title( $post_id ) ); ?>
		</h3>
		<div class="num mt-1.5 flex items-center gap-1.5 text-[12.5px] text-ink-700/45 dark:text-white/35">
			<?php if ( $cat ) : ?>
				<span class="font-bold" style="<?php echo esc_attr( nabd_cat_text_style( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></span>
				<span class="text-ink-900/15 dark:text-white/15">·</span>
			<?php endif; ?>
			<span><?php echo esc_html( nabd_time_ago( $post_id ) ); ?></span>
		</div>
	<?php endif; ?>
</a>
