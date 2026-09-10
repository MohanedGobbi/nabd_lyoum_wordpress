<?php
/**
 * "فيديو نبض اليوم" — pulls real posts from the "فيديو" category (real
 * data, not a mock list) so editors publish videos the same way as any
 * other article; the featured image is the thumbnail and the optional
 * per-post "video duration" meta shows as a badge.
 */

$video_cat = get_term_by( 'slug', 'video', 'category' );
if ( ! $video_cat ) {
	return;
}

$q = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'cat'            => $video_cat->term_id,
	'no_found_rows'  => true,
) );

if ( ! $q->have_posts() ) {
	return;
}

$posts = $q->posts;
$hero  = $posts[0];
$rest  = array_slice( $posts, 1 );
wp_reset_postdata();
?>
<section class="bg-ink-950 py-8">
	<div class="mx-auto max-w-[1400px] px-4 lg:px-6">
		<div class="mb-4 flex items-center gap-2">
			<span class="h-5 w-1 rounded-full bg-brand"></span>
			<h2 class="text-[17px] font-extrabold text-white"><?php esc_html_e( 'فيديو نبض اليوم', 'nabd-aljazair' ); ?></h2>
		</div>

		<div class="grid gap-4 lg:grid-cols-[1.4fr_1fr_1fr]">
			<a href="<?php echo esc_url( get_permalink( $hero ) ); ?>" class="group relative aspect-video overflow-hidden rounded-2xl lg:aspect-auto">
				<div class="absolute inset-0 transition duration-500 group-hover:scale-105"><?php nabd_post_image( $hero->ID, 'nabd-hero' ); ?></div>
				<div class="absolute inset-0 bg-black/25"></div>
				<?php if ( nabd_video_duration( $hero->ID ) ) : ?>
					<span class="num absolute bottom-3 end-3 rounded bg-black/70 px-1.5 py-0.5 text-[12px] font-bold text-white"><?php echo esc_html( nabd_video_duration( $hero->ID ) ); ?></span>
				<?php endif; ?>
				<span class="absolute inset-0 flex items-center justify-center">
					<span class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-ink-950 shadow-pop transition group-hover:scale-110">
						<?php echo nabd_icon( 'play', 'h-6 w-6' ); ?>
					</span>
				</span>
				<p class="text-balance absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4 pt-10 text-[14px] font-bold text-white"><?php echo esc_html( get_the_title( $hero ) ); ?></p>
			</a>

			<div class="grid grid-cols-2 gap-4 lg:col-span-2 lg:grid-cols-2">
				<?php foreach ( $rest as $v ) : ?>
					<a href="<?php echo esc_url( get_permalink( $v ) ); ?>" class="group relative aspect-video overflow-hidden rounded-xl">
						<div class="absolute inset-0 transition duration-500 group-hover:scale-105"><?php nabd_post_image( $v->ID, 'nabd-card' ); ?></div>
						<div class="absolute inset-0 bg-black/25"></div>
						<?php if ( nabd_video_duration( $v->ID ) ) : ?>
							<span class="num absolute bottom-2 end-2 rounded bg-black/70 px-1.5 py-0.5 text-[11px] font-bold text-white"><?php echo esc_html( nabd_video_duration( $v->ID ) ); ?></span>
						<?php endif; ?>
						<span class="absolute inset-0 flex items-center justify-center">
							<span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-ink-950 transition group-hover:scale-110">
								<?php echo nabd_icon( 'play', 'h-4 w-4' ); ?>
							</span>
						</span>
						<p class="text-balance absolute inset-x-0 bottom-0 line-clamp-2 bg-gradient-to-t from-black/80 to-transparent p-2.5 pt-8 text-[12px] font-semibold text-white"><?php echo esc_html( get_the_title( $v ) ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
		</div>

		<a href="<?php echo esc_url( get_category_link( $video_cat ) ); ?>"
		   class="mt-4 flex w-full items-center justify-center gap-1.5 rounded-full border border-white/15 py-2.5 text-[14px] font-semibold text-white/80 transition hover:border-brand hover:text-brand">
			<?php esc_html_e( 'عرض كل الفيديوهات', 'nabd-aljazair' ); ?>
		</a>
	</div>
</section>
