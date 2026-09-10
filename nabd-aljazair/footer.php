	<?php // closes #content opened in header.php ?>
</div>

<?php
$nabd_footer_categories = array_slice( nabd_ordered_categories(), 0, 5 );
?>

<footer class="bg-ink-950 pt-10 text-white/70">
	<div class="mx-auto max-w-[1400px] px-4 lg:px-6">
		<div class="flex flex-col items-center gap-4 border-b border-white/10 pb-8 text-center lg:flex-row lg:items-start lg:justify-between lg:text-start">
			<div class="flex flex-col items-center gap-3 lg:items-start">
				<span class="font-logo text-3xl text-brand"><?php bloginfo( 'name' ); ?></span>
				<p class="max-w-xs text-[13px] text-white/40"><?php echo esc_html( get_theme_mod( 'nabd_footer_blurb', '' ) ); ?></p>
				<div class="flex items-center gap-2.5">
					<?php foreach ( nabd_social_links() as $s ) : ?>
						<a href="<?php echo esc_url( $s['href'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $s['label'] ); ?>"
						   class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 text-white/60 transition hover:bg-brand hover:text-white">
							<?php echo nabd_icon( $s['key'], 'h-4 w-4' ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="grid grid-cols-2 gap-8 text-[14px] sm:grid-cols-2">
				<div>
					<h3 class="mb-3 font-bold text-white"><?php esc_html_e( 'الأقسام', 'nabd-aljazair' ); ?></h3>
					<ul class="space-y-2">
						<?php foreach ( $nabd_footer_categories as $cat ) : ?>
							<li><a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="text-white/50 transition hover:text-brand"><?php echo esc_html( $cat->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div>
					<h3 class="mb-3 font-bold text-white"><?php bloginfo( 'name' ); ?></h3>
					<ul class="space-y-2">
						<?php
						$footer_pages = array(
							__( 'من نحن', 'nabd-aljazair' )       => home_url( '/about/' ),
							__( 'اتصل بنا', 'nabd-aljazair' )     => home_url( '/contact/' ),
							__( 'سياسة الخصوصية', 'nabd-aljazair' ) => get_privacy_policy_url() ? get_privacy_policy_url() : home_url( '/privacy/' ),
							__( 'شروط الاستخدام', 'nabd-aljazair' ) => home_url( '/terms/' ),
						);
						foreach ( $footer_pages as $label => $url ) : ?>
							<li><a href="<?php echo esc_url( $url ); ?>" class="text-white/50 transition hover:text-brand"><?php echo esc_html( $label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="flex flex-col items-center gap-3 lg:items-start">
				<h3 class="font-bold text-white"><?php esc_html_e( 'تطبيق نبض اليوم', 'nabd-aljazair' ); ?></h3>
				<div class="flex flex-col gap-2">
					<a href="<?php echo esc_url( get_theme_mod( 'nabd_play_store_url', '#' ) ); ?>"
					   class="flex items-center gap-2 rounded-xl border border-white/15 px-4 py-2 text-[13px] font-semibold text-white/80 transition hover:border-brand hover:text-white">
						<?php echo nabd_icon( 'google-play', 'h-5 w-5' ); ?>
						<span><span class="block text-[10px] text-white/40">GET IT ON</span>Google Play</span>
					</a>
					<a href="<?php echo esc_url( get_theme_mod( 'nabd_app_store_url', '#' ) ); ?>"
					   class="flex items-center gap-2 rounded-xl border border-white/15 px-4 py-2 text-[13px] font-semibold text-white/80 transition hover:border-brand hover:text-white">
						<?php echo nabd_icon( 'apple', 'h-5 w-5' ); ?>
						<span><span class="block text-[10px] text-white/40">DOWNLOAD ON THE</span>App Store</span>
					</a>
				</div>
			</div>
		</div>

		<p class="py-5 text-center text-[13px] text-white/35">
			<?php printf( esc_html__( 'جميع الحقوق محفوظة © %s %s', 'nabd-aljazair' ), esc_html( date_i18n( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) ); ?>
		</p>
	</div>
</footer>

<!-- Bottom tab bar (mobile) -->
<nav class="fixed inset-x-0 bottom-0 z-30 border-t border-ink-900/8 bg-white/95 backdrop-blur dark:border-white/10 dark:bg-ink-950/95 lg:hidden">
	<div class="flex items-stretch justify-between px-2">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-1 flex-col items-center gap-1 py-2.5 text-[11px] font-semibold <?php echo is_front_page() ? 'text-brand' : 'text-ink-700/60 dark:text-white/45'; ?>">
			<?php echo nabd_icon( 'home', 'h-5 w-5' ); ?> <?php esc_html_e( 'الرئيسية', 'nabd-aljazair' ); ?>
		</a>
		<a href="<?php echo esc_url( nabd_news_page_url() ); ?>" class="flex flex-1 flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-ink-700/60 dark:text-white/45">
			<?php echo nabd_icon( 'book-open', 'h-5 w-5' ); ?> <?php esc_html_e( 'الأخبار', 'nabd-aljazair' ); ?>
		</a>
		<a href="#" class="flex flex-1 flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-ink-700/60 dark:text-white/45">
			<?php echo nabd_icon( 'star', 'h-5 w-5' ); ?> <?php esc_html_e( 'المفضلة', 'nabd-aljazair' ); ?>
		</a>
		<?php $video_cat = get_term_by( 'slug', 'video', 'category' ); ?>
		<a href="<?php echo esc_url( $video_cat ? get_category_link( $video_cat ) : '#' ); ?>" class="flex flex-1 flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-ink-700/60 dark:text-white/45">
			<?php echo nabd_icon( 'play-circle', 'h-5 w-5' ); ?> <?php esc_html_e( 'فيديو', 'nabd-aljazair' ); ?>
		</a>
		<button type="button" data-nabd-drawer-open class="flex flex-1 flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-ink-700/60 dark:text-white/45">
			<?php echo nabd_icon( 'more', 'h-5 w-5' ); ?> <?php esc_html_e( 'المزيد', 'nabd-aljazair' ); ?>
		</button>
	</div>
</nav>

<?php wp_footer(); ?>
</body>
</html>
