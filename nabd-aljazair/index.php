<?php
/**
 * Generic fallback archive (tag pages, author pages, date archives —
 * anything not covered by front-page.php, category.php, or single.php).
 */

get_header();
?>
<main>
	<div class="mx-auto max-w-[1400px] px-4 py-6 lg:px-6">
		<h1 class="mb-6 text-[22px] font-extrabold text-ink-950 dark:text-white">
			<?php echo wp_kses_post( get_the_archive_title() ); ?>
		</h1>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/article-card', null, array( 'post_id' => get_the_ID() ) );
				endwhile;
				?>
			</div>
			<div class="mt-8 flex justify-center gap-2 text-[14px] font-semibold">
				<?php the_posts_pagination( array(
					'prev_text' => nabd_icon( 'chevron-right', 'h-4 w-4' ),
					'next_text' => nabd_icon( 'chevron-left', 'h-4 w-4' ),
				) ); ?>
			</div>
		<?php else : ?>
			<p class="py-10 text-center text-ink-700/50 dark:text-white/40"><?php esc_html_e( 'لا توجد نتائج.', 'nabd-aljazair' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
