<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2">
	<label class="sr-only" for="nabd-search-form"><?php esc_html_e( 'بحث', 'nabd-aljazair' ); ?></label>
	<input id="nabd-search-form" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
		   placeholder="<?php esc_attr_e( 'بحث...', 'nabd-aljazair' ); ?>"
		   class="w-full rounded-full border border-ink-900/10 bg-white px-4 py-2 text-[14px] outline-none focus:border-brand dark:border-white/15 dark:bg-ink-900 dark:text-white">
	<button type="submit" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand text-white">
		<?php echo nabd_icon( 'search', 'h-4 w-4' ); ?>
	</button>
</form>
