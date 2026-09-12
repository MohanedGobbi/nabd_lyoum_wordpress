<?php
/**
 * Small thumbnail + headline row — used in the homepage hero's "آخر
 * الأخبار" sidebar list.
 *
 * Usage: get_template_part( 'template-parts/article-list-row', null, array( 'post_id' => $id ) );
 */

$post_id = $args['post_id'] ?? get_the_ID();
$cats    = get_the_category( $post_id );
$cat     = $cats ? $cats[0] : null;
$is_video = nabd_post_is_video( $post_id );
?>
<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="group flex gap-3 border-b border-ink-900/8 py-3.5 last:border-0 dark:border-white/10">
	<div class="relative h-[70px] w-[92px] shrink-0 overflow-hidden rounded-lg">
		<?php nabd_post_image( $post_id, 'nabd-thumb', 'transition duration-300 group-hover:scale-105' ); ?>
		<?php if ( $is_video ) : ?>
			<span class="absolute inset-0 flex items-center justify-center bg-black/10">
				<span class="flex h-6 w-6 items-center justify-center rounded-full text-white" style="<?php echo esc_attr( nabd_cat_bg_style( 'video' ) ); ?>">
					<?php echo nabd_icon( 'play', 'h-2.5 w-2.5' ); ?>
				</span>
			</span>
		<?php endif; ?>
	</div>
	<div class="flex flex-1 flex-col justify-center gap-1.5">
		<h4 class="line-clamp-2 text-[14.5px] font-semibold leading-snug text-ink-900 transition-colors group-hover:text-brand dark:text-white/90">
			<?php echo esc_html( get_the_title( $post_id ) ); ?>
		</h4>
		<div class="num flex items-center gap-1.5 text-[12px] text-ink-700/45 dark:text-white/35">
			<?php if ( $cat ) : ?>
				<span class="font-bold" style="<?php echo esc_attr( nabd_cat_text_style( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></span>
				<span class="text-ink-900/15 dark:text-white/15">·</span>
			<?php endif; ?>
			<span><?php echo esc_html( nabd_time_ago( $post_id ) ); ?></span>
		</div>
	</div>
</a>
