<?php
/**
 * 404.
 */

get_header();
?>
<main>
	<div class="mx-auto flex max-w-[1400px] flex-col items-center gap-4 px-4 py-24 text-center lg:px-6">
		<span class="font-logo text-5xl text-brand">404</span>
		<h1 class="text-[22px] font-extrabold text-ink-950 dark:text-white"><?php esc_html_e( 'الصفحة غير موجودة', 'nabd-aljazair' ); ?></h1>
		<p class="max-w-md text-ink-700/60 dark:text-white/50"><?php esc_html_e( 'يبدو أن الصفحة التي تبحث عنها غير موجودة أو تم نقلها.', 'nabd-aljazair' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rounded-full bg-brand px-6 py-2.5 text-[14px] font-bold text-white shadow-card transition hover:bg-brand-600">
			<?php esc_html_e( 'العودة إلى الرئيسية', 'nabd-aljazair' ); ?>
		</a>
	</div>
</main>

<?php get_footer(); ?>
