<?php
/**
 * Homepage: hero + "آخر الأخبار" list, the video rail, one stacked section
 * per official category (see template-parts/category-section.php), the
 * currency ticker, then the newsletter signup.
 */

get_header();

$hero_q = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 6,
	'no_found_rows'  => true,
) );
$latest_posts = $hero_q->posts;
$hero_post    = $latest_posts ? $latest_posts[0] : null;
$sidebar_posts = array_slice( $latest_posts, 1, 5 );
wp_reset_postdata();
?>

<main>
	<?php if ( $hero_post ) :
		$hero_cats = get_the_category( $hero_post->ID );
		$hero_cat  = $hero_cats ? $hero_cats[0] : null;
		?>
		<section class="mx-auto max-w-[1400px] px-4 py-6 lg:px-6 lg:py-8">
			<div class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
				<a href="<?php echo esc_url( get_permalink( $hero_post ) ); ?>"
				   class="group relative flex min-h-[320px] flex-col justify-end overflow-hidden rounded-2xl bg-ink-950 p-6 lg:min-h-[440px] lg:p-8">
					<div class="absolute inset-0 opacity-90 transition duration-500 group-hover:scale-105">
						<?php nabd_post_image( $hero_post->ID, 'nabd-hero' ); ?>
					</div>
					<div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/30 to-transparent"></div>
					<div class="relative z-10">
						<?php if ( $hero_cat ) : ?>
							<span class="inline-flex items-center gap-2 text-[13.5px] font-bold text-white">
								<span class="h-3.5 w-1 rounded-full bg-brand"></span>
								<?php echo esc_html( $hero_cat->name ); ?>
							</span>
						<?php endif; ?>
						<h1 class="text-balance mt-3 max-w-xl text-[22px] font-extrabold leading-snug text-white lg:text-[32px]">
							<?php echo esc_html( get_the_title( $hero_post ) ); ?>
						</h1>
						<p class="mt-3 hidden max-w-lg text-[15px] leading-relaxed text-white/70 lg:block">
							<?php echo esc_html( nabd_card_excerpt( $hero_post->ID, 26 ) ); ?>
						</p>
						<span class="num mt-4 flex items-center gap-1.5 text-[13px] text-white/60">
							<?php echo nabd_icon( 'clock', 'h-3.5 w-3.5' ); ?> <?php echo esc_html( nabd_time_ago( $hero_post->ID ) ); ?>
						</span>
					</div>
				</a>

				<div class="rounded-2xl border border-ink-900/8 bg-white p-4 dark:border-white/10 dark:bg-ink-900 lg:p-5">
					<div class="flex items-center gap-2 border-b border-ink-900/8 pb-3 dark:border-white/10">
						<span class="h-5 w-1 rounded-full bg-brand"></span>
						<h2 class="text-[17px] font-extrabold text-ink-950 dark:text-white"><?php esc_html_e( 'آخر الأخبار', 'nabd-aljazair' ); ?></h2>
					</div>
					<div>
						<?php foreach ( $sidebar_posts as $p ) : ?>
							<?php get_template_part( 'template-parts/article-list-row', null, array( 'post_id' => $p->ID ) ); ?>
						<?php endforeach; ?>
					</div>
					<a href="<?php echo esc_url( nabd_news_page_url() ); ?>"
					   class="mt-2 flex items-center justify-center gap-1.5 rounded-full border border-ink-900/10 py-2.5 text-[14px] font-semibold text-ink-800 transition hover:border-brand hover:text-brand dark:border-white/15 dark:text-white/70">
						<?php esc_html_e( 'عرض كل الأخبار', 'nabd-aljazair' ); ?>
					</a>
				</div>
			</div>
		</section>
	<?php else : ?>
		<div class="mx-auto max-w-[1400px] px-4 py-16 text-center text-ink-700/50 dark:text-white/40">
			<?php esc_html_e( 'لا توجد مقالات منشورة بعد. أضف أول مقال من لوحة التحكم.', 'nabd-aljazair' ); ?>
		</div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/video-rail' ); ?>

	<div class="mx-auto max-w-[1400px] divide-y divide-ink-900/8 px-4 dark:divide-white/10 lg:px-6">
		<?php foreach ( nabd_ordered_categories() as $cat ) : ?>
			<?php get_template_part( 'template-parts/category-section', null, array( 'category' => $cat ) ); ?>
		<?php endforeach; ?>
	</div>

	<?php get_template_part( 'template-parts/currency-widget' ); ?>
	<?php get_template_part( 'template-parts/newsletter' ); ?>
</main>

<?php get_footer(); ?>
