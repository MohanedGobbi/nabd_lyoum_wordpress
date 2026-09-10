<!DOCTYPE html>
<html <?php language_attributes(); ?> class="">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
		// Applied before paint so there is no light-mode flash for users who
		// chose dark last time. Mirrors the localStorage key assets/js/main.js uses.
		(function () {
			try {
				var t = localStorage.getItem( 'nabd-theme' );
				if ( t === 'dark' || ( ! t && window.matchMedia( '(prefers-color-scheme: dark)' ).matches ) ) {
					document.documentElement.classList.add( 'dark' );
				}
			} catch ( e ) {}
		})();
	</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-white dark:bg-ink-950 font-body text-ink-900' ); ?>>
<?php wp_body_open(); ?>

<?php
$nabd_categories   = nabd_ordered_categories();
$nabd_breaking     = nabd_current_breaking_post();
$nabd_breaking_txt = get_theme_mod( 'nabd_breaking_fallback', '' );

$nabd_drawer_icon_for = array(
	'aljazair'  => 'flag',
	'world'     => 'globe',
	'politics'  => 'landmark',
	'economy'   => 'trending-up',
	'society'   => 'users',
	'sport'     => 'trophy',
	'tech'      => 'cpu',
	'culture'   => 'book-open',
	'varieties' => 'sparkles',
	'video'     => 'play-circle',
);
?>

<header class="sticky top-0 z-40 bg-white shadow-sm dark:bg-ink-950">
	<!-- Utility bar (desktop only) -->
	<div class="hidden border-b border-white/10 bg-ink-950 text-[13px] text-white/70 lg:block">
		<div class="mx-auto flex h-9 max-w-[1400px] items-center justify-between px-6">
			<div class="flex items-center gap-1.5">
				<?php foreach ( nabd_social_links() as $s ) : ?>
					<a href="<?php echo esc_url( $s['href'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $s['label'] ); ?>"
					   class="flex h-6 w-6 items-center justify-center rounded-full text-white/60 transition hover:bg-white/10 hover:text-white">
						<?php echo nabd_icon( $s['key'], 'h-3.5 w-3.5' ); ?>
					</a>
				<?php endforeach; ?>
			</div>

			<p class="num text-white/50" id="nabd-date"></p>

			<div class="flex items-center gap-3">
				<span class="num flex items-center gap-1 text-white/60">
					<?php echo nabd_icon( 'cloud-sun', 'h-3.5 w-3.5' ); ?>
					<?php echo esc_html( get_theme_mod( 'nabd_weather_text', '25° الجزائر' ) ); ?>
				</span>
				<button type="button" data-nabd-theme-toggle aria-label="<?php esc_attr_e( 'تبديل المظهر', 'nabd-aljazair' ); ?>"
						class="flex h-6 w-6 items-center justify-center rounded-full text-white/60 transition hover:bg-white/10 hover:text-white">
					<?php echo nabd_icon( 'moon', 'h-3.5 w-3.5 nabd-theme-icon-dark' ); ?>
					<?php echo nabd_icon( 'sun', 'hidden h-3.5 w-3.5 nabd-theme-icon-light' ); ?>
				</button>
			</div>
		</div>
	</div>

	<!-- Main row: hamburger, logo, search -->
	<div class="mx-auto flex h-16 max-w-[1400px] items-center justify-between px-4 lg:h-20 lg:px-6">
		<button type="button" data-nabd-drawer-open aria-label="<?php esc_attr_e( 'فتح القائمة', 'nabd-aljazair' ); ?>"
				class="flex h-10 w-10 items-center justify-center rounded-full text-ink-800 transition hover:bg-ink-900/5 dark:text-white/80 dark:hover:bg-white/10 lg:hidden">
			<?php echo nabd_icon( 'menu', 'h-6 w-6' ); ?>
		</button>

		<div class="flex-1 lg:flex-none">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-center leading-none">
				<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
					<span class="font-logo text-3xl text-brand sm:text-4xl"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
				<span class="mt-0.5 text-[10px] tracking-wide text-ink-700/60 dark:text-white/40">
					Nabd Aljazair <span class="text-ink-900/30 dark:text-white/25">·</span> الخبر أولاً
				</span>
			</a>
		</div>

		<div class="flex items-center gap-2">
			<a href="<?php echo esc_url( admin_url() ); ?>" aria-label="<?php esc_attr_e( 'لوحة التحكم', 'nabd-aljazair' ); ?>"
			   class="flex h-10 items-center gap-1.5 rounded-full bg-brand-50 px-3 text-[13px] font-bold text-brand transition hover:bg-brand/15 dark:bg-brand/15 dark:hover:bg-brand/25">
				<?php echo nabd_icon( 'cpu', 'h-4 w-4' ); ?>
				<span class="hidden sm:inline"><?php esc_html_e( 'لوحة التحكم', 'nabd-aljazair' ); ?></span>
			</a>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="hidden lg:block">
				<label class="sr-only" for="nabd-search"><?php esc_html_e( 'بحث', 'nabd-aljazair' ); ?></label>
				<input id="nabd-search" type="search" name="s" placeholder="<?php esc_attr_e( 'بحث...', 'nabd-aljazair' ); ?>"
					   class="w-40 rounded-full border border-ink-900/10 bg-white px-3.5 py-2 text-[13px] outline-none focus:border-brand dark:border-white/15 dark:bg-ink-900 dark:text-white">
			</form>
			<button type="button" data-nabd-search-open aria-label="<?php esc_attr_e( 'بحث', 'nabd-aljazair' ); ?>"
					class="flex h-10 w-10 items-center justify-center rounded-full text-ink-800 transition hover:bg-ink-900/5 dark:text-white/80 dark:hover:bg-white/10 lg:hidden">
				<?php echo nabd_icon( 'search', 'h-5 w-5' ); ?>
			</button>
		</div>
	</div>

	<!-- Category nav (desktop) -->
	<nav class="hidden border-b border-ink-900/8 bg-white dark:border-white/10 dark:bg-ink-950 lg:block">
		<div class="mx-auto flex max-w-[1400px] items-center gap-6 overflow-x-auto px-6">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
			   class="relative shrink-0 whitespace-nowrap py-3.5 text-[15px] font-semibold transition-colors <?php echo is_front_page() ? 'text-brand' : 'text-ink-700 hover:text-ink-950 dark:text-white/60 dark:hover:text-white'; ?>">
				<?php esc_html_e( 'الرئيسية', 'nabd-aljazair' ); ?>
				<?php if ( is_front_page() ) : ?><span class="absolute inset-x-0 -bottom-px h-[3px] rounded-full bg-brand"></span><?php endif; ?>
			</a>
			<?php foreach ( $nabd_categories as $cat ) :
				$is_active = is_category( $cat->term_id );
				?>
				<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
				   class="relative shrink-0 whitespace-nowrap py-3.5 text-[15px] font-semibold transition-colors <?php echo $is_active ? 'text-brand' : 'text-ink-700 hover:text-ink-950 dark:text-white/60 dark:hover:text-white'; ?>">
					<?php echo esc_html( $cat->name ); ?>
					<?php if ( $is_active ) : ?><span class="absolute inset-x-0 -bottom-px h-[3px] rounded-full bg-brand"></span><?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</nav>

	<!-- Breaking ticker -->
	<?php if ( $nabd_breaking || $nabd_breaking_txt ) : ?>
		<div class="border-b border-ink-900/8 bg-white dark:border-white/10 dark:bg-ink-950">
			<div class="mx-auto flex max-w-[1400px] items-center gap-3 px-4 py-2.5 lg:px-6">
				<span class="flex shrink-0 items-center gap-1 rounded-md bg-brand px-2.5 py-1 text-[13px] font-bold text-white">
					<?php echo nabd_icon( 'zap', 'h-3.5 w-3.5' ); ?> <?php esc_html_e( 'عاجل', 'nabd-aljazair' ); ?>
				</span>
				<?php if ( $nabd_breaking ) : ?>
					<a href="<?php echo esc_url( get_permalink( $nabd_breaking ) ); ?>" class="truncate text-[14px] font-medium text-ink-800 hover:text-brand dark:text-white/80">
						<?php echo esc_html( get_the_title( $nabd_breaking ) ); ?>
					</a>
				<?php else : ?>
					<p class="truncate text-[14px] font-medium text-ink-800 dark:text-white/80"><?php echo esc_html( $nabd_breaking_txt ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Mobile drawer -->
	<div id="nabd-drawer" class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity" aria-hidden="true">
		<button type="button" data-nabd-drawer-close aria-label="<?php esc_attr_e( 'إغلاق القائمة', 'nabd-aljazair' ); ?>"
				class="absolute inset-0 bg-ink-950/50"></button>

		<div class="absolute inset-y-0 start-0 flex w-[86%] max-w-sm translate-x-full flex-col bg-white shadow-pop transition-transform dark:bg-ink-950" data-nabd-drawer-panel>
			<div class="flex items-center justify-between border-b border-ink-900/8 px-5 py-4 dark:border-white/10">
				<button type="button" data-nabd-drawer-close aria-label="<?php esc_attr_e( 'إغلاق', 'nabd-aljazair' ); ?>"
						class="flex h-9 w-9 items-center justify-center rounded-full text-ink-700 transition hover:bg-ink-900/5 dark:text-white/70 dark:hover:bg-white/10">
					<?php echo nabd_icon( 'x-close', 'h-5 w-5' ); ?>
				</button>
				<span class="font-logo text-2xl text-brand"><?php bloginfo( 'name' ); ?></span>
			</div>

			<nav class="flex-1 overflow-y-auto px-2 py-2">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-[15px] font-medium text-ink-800 transition hover:bg-brand-50 hover:text-brand dark:text-white/80 dark:hover:bg-white/5">
					<?php echo nabd_icon( 'home', 'h-[18px] w-[18px] shrink-0 opacity-70' ); ?> <?php esc_html_e( 'الرئيسية', 'nabd-aljazair' ); ?>
				</a>
				<?php foreach ( $nabd_categories as $cat ) : ?>
					<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
					   class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-[15px] font-medium text-ink-800 transition hover:bg-brand-50 hover:text-brand dark:text-white/80 dark:hover:bg-white/5">
						<?php echo nabd_icon( $nabd_drawer_icon_for[ $cat->slug ] ?? 'flag', 'h-[18px] w-[18px] shrink-0 opacity-70' ); ?>
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>

				<div class="my-2 h-px bg-ink-900/8 dark:bg-white/10"></div>

				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 rounded-xl px-4 py-2.5">
					<?php echo nabd_icon( 'search', 'h-[18px] w-[18px] shrink-0 opacity-70' ); ?>
					<input type="search" name="s" placeholder="<?php esc_attr_e( 'بحث...', 'nabd-aljazair' ); ?>" class="w-full bg-transparent text-[15px] font-medium text-ink-800 outline-none dark:text-white/80">
				</form>

				<div class="my-2 h-px bg-ink-900/8 dark:bg-white/10"></div>

				<div class="flex items-center justify-between rounded-xl px-4 py-2">
					<span class="flex items-center gap-3 text-[15px] font-medium text-ink-800 dark:text-white/80">
						<?php echo nabd_icon( 'moon', 'h-[18px] w-[18px] shrink-0 opacity-70' ); ?> <?php esc_html_e( 'الوضع الليلي', 'nabd-aljazair' ); ?>
					</span>
					<button type="button" data-nabd-theme-toggle aria-label="<?php esc_attr_e( 'تبديل الوضع الليلي', 'nabd-aljazair' ); ?>"
							class="relative h-6 w-11 rounded-full bg-ink-900/15 transition nabd-theme-switch">
						<span class="absolute top-0.5 translate-x-[22px] h-5 w-5 rounded-full bg-white shadow transition-transform nabd-theme-knob"></span>
					</button>
				</div>
			</nav>

			<div class="border-t border-ink-900/8 px-5 py-4 dark:border-white/10">
				<a href="<?php echo esc_url( admin_url() ); ?>"
				   class="mb-2.5 flex w-full items-center justify-center gap-2 rounded-full border border-brand/30 bg-brand-50 py-2.5 text-[14px] font-bold text-brand transition hover:bg-brand/15 dark:border-brand/40 dark:bg-brand/15">
					<?php echo nabd_icon( 'cpu', 'h-[18px] w-[18px]' ); ?> <?php esc_html_e( 'لوحة التحكم', 'nabd-aljazair' ); ?>
				</a>
				<a href="<?php echo esc_url( wp_login_url() ); ?>"
				   class="flex w-full items-center justify-center gap-2 rounded-full bg-brand py-3 text-[15px] font-bold text-white shadow-card transition hover:bg-brand-600">
					<?php echo nabd_icon( 'log-in', 'h-[18px] w-[18px]' ); ?> <?php esc_html_e( 'تسجيل الدخول', 'nabd-aljazair' ); ?>
				</a>

				<p class="mt-4 text-center text-[13px] text-ink-700/50 dark:text-white/40"><?php esc_html_e( 'تابعنا على', 'nabd-aljazair' ); ?></p>
				<div class="mt-2 flex items-center justify-center gap-2.5">
					<?php foreach ( nabd_social_links() as $s ) : ?>
						<a href="<?php echo esc_url( $s['href'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $s['label'] ); ?>"
						   class="flex h-8 w-8 items-center justify-center rounded-full bg-ink-900/5 text-ink-700 transition hover:bg-brand hover:text-white dark:bg-white/10 dark:text-white/70">
							<?php echo nabd_icon( $s['key'], 'h-4 w-4' ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</header>

<div id="content" class="min-h-screen pb-16 lg:pb-0">
