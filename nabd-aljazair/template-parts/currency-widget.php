<?php
/**
 * Currency ticker — see the note on nabd_currency_rates() in
 * inc/template-helpers.php for how this data is sourced and how to make it
 * live later.
 */
?>
<section class="mx-auto max-w-[1400px] px-4 py-6 lg:px-6 lg:py-8">
	<div class="rounded-2xl border border-ink-900/8 bg-white p-4 shadow-card dark:border-white/10 dark:bg-ink-900 lg:p-6">
		<div class="mb-4 flex flex-wrap items-end justify-between gap-1">
			<h2 class="text-[17px] font-extrabold text-ink-950 dark:text-white"><?php esc_html_e( 'سعر صرف اليوم', 'nabd-aljazair' ); ?></h2>
			<p class="text-[13px] text-ink-700/50 dark:text-white/40"><?php esc_html_e( 'أسعار العملات مقابل الدينار الجزائري', 'nabd-aljazair' ); ?></p>
		</div>

		<div class="flex gap-3 overflow-x-auto pb-1">
			<?php foreach ( nabd_currency_rates() as $c ) : ?>
				<div class="flex min-w-[140px] flex-1 flex-col gap-1 rounded-xl border border-ink-900/8 p-3.5 dark:border-white/10">
					<div class="flex items-center justify-between">
						<?php echo nabd_icon( $c['flag'], 'h-4 w-6 rounded-sm' ); ?>
						<span class="num flex items-center gap-0.5 text-[12px] font-bold <?php echo $c['change'] >= 0 ? 'text-emerald-600' : 'text-brand'; ?>">
							<?php echo nabd_icon( $c['change'] >= 0 ? 'arrow-up' : 'arrow-down', 'h-3 w-3' ); ?>
							<?php echo esc_html( abs( $c['change'] ) ); ?>%
						</span>
					</div>
					<p class="text-[12.5px] font-semibold text-ink-700/70 dark:text-white/50"><?php echo esc_html( $c['name'] ); ?></p>
					<p class="num text-[17px] font-extrabold text-ink-950 dark:text-white">
						<?php echo esc_html( $c['rate'] ); ?> <span class="text-[12px] font-medium text-ink-700/50 dark:text-white/40">دج</span>
					</p>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="mt-4 text-[12px] text-ink-700/45 dark:text-white/35"><?php esc_html_e( 'الأسعار قابلة للتغير في أي لحظة', 'nabd-aljazair' ); ?></p>
	</div>
</section>
