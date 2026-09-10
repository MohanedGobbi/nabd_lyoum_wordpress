<?php
/**
 * Newsletter signup. No mailing-list provider is wired up yet — the form
 * currently has nowhere to submit to. Point its action at Mailchimp,
 * Brevo, or whatever the client picks (or wire it to WP's own users table)
 * before launch; the markup will not change.
 */
?>
<section class="mx-auto max-w-[1400px] px-4 py-6 lg:px-6 lg:py-8">
	<div class="flex flex-col items-center gap-4 rounded-2xl bg-brand-50 px-6 py-10 text-center dark:bg-brand/10">
		<span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand text-white">
			<?php echo nabd_icon( 'mail', 'h-5 w-5' ); ?>
		</span>
		<h2 class="text-[19px] font-extrabold text-ink-950 dark:text-white"><?php esc_html_e( 'اشترك في نشرة نبض اليوم', 'nabd-aljazair' ); ?></h2>
		<p class="max-w-md text-[14px] text-ink-700/70 dark:text-white/60">
			<?php esc_html_e( 'كن أول من يعرف آخر الأخبار والتحديثات، مباشرة إلى بريدك الإلكتروني كل صباح.', 'nabd-aljazair' ); ?>
		</p>
		<form class="flex w-full max-w-md flex-col gap-2.5 sm:flex-row" method="post" action="#">
			<input type="email" required placeholder="<?php esc_attr_e( 'أدخل بريدك الإلكتروني', 'nabd-aljazair' ); ?>" name="email"
				   class="flex-1 rounded-full border border-ink-900/10 bg-white px-4 py-2.5 text-[14px] text-ink-900 outline-none placeholder:text-ink-700/40 focus:border-brand dark:border-white/15 dark:bg-ink-900 dark:text-white">
			<button type="submit" class="rounded-full bg-brand px-6 py-2.5 text-[14px] font-bold text-white shadow-card transition hover:bg-brand-600">
				<?php esc_html_e( 'اشترك الآن', 'nabd-aljazair' ); ?>
			</button>
		</form>
	</div>
</section>
