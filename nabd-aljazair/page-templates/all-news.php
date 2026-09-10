<?php
/**
 * Template Name: كل الأخبار
 *
 * A catch-all "all articles, latest first" feed — assigned automatically
 * to a page created on theme activation (see nabd_create_news_page() in
 * inc/setup.php), and selectable from any Page's Template dropdown too.
 */

get_header();

$paged = max( 1, get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
$q     = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 16,
	'paged'          => $paged,
) );
?>
<main>
	<div class="mx-auto max-w-[1400px] px-4 py-5 lg:px-6">
		<div class="mb-3 flex items-center gap-1.5 text-[13px] text-ink-700/50 dark:text-white/40">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand"><?php esc_html_e( 'الرئيسية', 'nabd-aljazair' ); ?></a>
			<?php echo nabd_icon( 'chevron-left', 'h-3.5 w-3.5' ); ?>
			<span class="text-ink-900 dark:text-white/70"><?php the_title(); ?></span>
		</div>

		<h1 class="mb-6 text-[24px] font-extrabold text-ink-950 dark:text-white lg:text-[28px]"><?php esc_html_e( 'آخر الأخبار', 'nabd-aljazair' ); ?></h1>

		<?php if ( $q->have_posts() ) : ?>
			<div class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
				<?php
				while ( $q->have_posts() ) :
					$q->the_post();
					get_template_part( 'template-parts/article-card', null, array( 'post_id' => get_the_ID() ) );
				endwhile;
				?>
			</div>

			<div class="mt-8 flex justify-center gap-2 text-[14px] font-semibold">
				<?php
				echo paginate_links( array(
					'total'     => $q->max_num_pages,
					'current'   => $paged,
					'prev_text' => nabd_icon( 'chevron-right', 'h-4 w-4' ),
					'next_text' => nabd_icon( 'chevron-left', 'h-4 w-4' ),
				) );
				?>
			</div>
		<?php else : ?>
			<p class="py-10 text-center text-ink-700/50 dark:text-white/40"><?php esc_html_e( 'لا توجد مقالات منشورة بعد.', 'nabd-aljazair' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>

	<?php get_template_part( 'template-parts/newsletter' ); ?>
</main>

<?php get_footer(); ?>
