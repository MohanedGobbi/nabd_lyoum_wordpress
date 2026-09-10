<?php
/**
 * Category archive: breadcrumb + title, then three tabs (all three lists
 * are rendered up front and toggled with plain CSS/JS — see
 * assets/js/main.js — rather than re-querying, since a category rarely has
 * enough posts to make that costly).
 *
 * "المقالات" is a stub: it shows posts tagged "مقال-رأي" if that tag
 * exists on any post in this category, and simply mirrors "أحدث الأخبار"
 * otherwise. Real op-ed/analysis tagging can replace this once the client
 * has that kind of content — the markup won't need to change.
 */

get_header();

$cat = get_queried_object();

$make_query = function ( $orderby, $meta_key = '' ) use ( $cat ) {
	$args = array(
		'post_type'      => 'post',
		'cat'            => $cat->term_id,
		'posts_per_page' => 12,
		'orderby'        => $orderby,
		'order'          => 'DESC',
		'no_found_rows'  => true,
	);
	if ( $meta_key ) {
		$args['meta_key'] = $meta_key;
	}
	return new WP_Query( $args );
};

$latest_q    = $make_query( 'date' );
$most_read_q = $make_query( 'meta_value_num', '_nabd_views' );

$articles_q = new WP_Query( array(
	'post_type'      => 'post',
	'cat'            => $cat->term_id,
	'tag'            => 'مقال-رأي',
	'posts_per_page' => 12,
	'no_found_rows'  => true,
) );
if ( ! $articles_q->have_posts() ) {
	$articles_q = $latest_q;
}

$tabs = array(
	'latest'    => array( 'label' => __( 'أحدث الأخبار', 'nabd-aljazair' ), 'query' => $latest_q ),
	'most-read' => array( 'label' => __( 'الأكثر قراءة', 'nabd-aljazair' ), 'query' => $most_read_q ),
	'articles'  => array( 'label' => __( 'المقالات', 'nabd-aljazair' ), 'query' => $articles_q ),
);
?>
<main>
	<div class="mx-auto max-w-[1400px] px-4 py-5 lg:px-6">
		<div class="mb-3 flex items-center gap-1.5 text-[13px] text-ink-700/50 dark:text-white/40">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand"><?php esc_html_e( 'الرئيسية', 'nabd-aljazair' ); ?></a>
			<?php echo nabd_icon( 'chevron-left', 'h-3.5 w-3.5' ); ?>
			<span class="text-ink-900 dark:text-white/70"><?php echo esc_html( $cat->name ); ?></span>
		</div>

		<h1 class="mb-4 text-[24px] font-extrabold lg:text-[28px]" style="<?php echo esc_attr( nabd_cat_text_style( $cat ) ); ?>">
			<?php echo esc_html( $cat->name ); ?>
		</h1>

		<div class="flex items-center gap-6 border-b border-ink-900/8 dark:border-white/10" data-nabd-tabs>
			<?php $first = true; foreach ( $tabs as $key => $tab ) : ?>
				<button type="button" data-nabd-tab="<?php echo esc_attr( $key ); ?>"
						class="relative py-3 text-[15px] font-bold transition-colors <?php echo $first ? 'text-brand' : 'text-ink-700/60 hover:text-ink-950 dark:text-white/50 dark:hover:text-white'; ?>"
						data-active="<?php echo $first ? '1' : '0'; ?>">
					<?php echo esc_html( $tab['label'] ); ?>
					<span class="absolute inset-x-0 -bottom-px h-[3px] rounded-full bg-brand <?php echo $first ? '' : 'hidden'; ?>" data-nabd-tab-underline></span>
				</button>
			<?php $first = false; endforeach; ?>
		</div>

		<?php $first = true; foreach ( $tabs as $key => $tab ) : ?>
			<div data-nabd-tab-panel="<?php echo esc_attr( $key ); ?>" class="<?php echo $first ? '' : 'hidden'; ?>">
				<?php if ( $tab['query']->have_posts() ) :
					$posts  = $tab['query']->posts;
					$hero_p = $posts[0];
					$rest_p = array_slice( $posts, 1, 6 );
					?>
					<div class="grid gap-8 py-6 lg:grid-cols-[1.4fr_1fr]">
						<?php get_template_part( 'template-parts/article-card', null, array( 'post_id' => $hero_p->ID ) ); ?>
						<div class="rounded-2xl border border-ink-900/8 p-1 dark:border-white/10 lg:p-4">
							<?php foreach ( $rest_p as $p ) : ?>
								<?php get_template_part( 'template-parts/article-list-row', null, array( 'post_id' => $p->ID ) ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else : ?>
					<p class="py-10 text-center text-[14px] text-ink-700/50 dark:text-white/40"><?php esc_html_e( 'لا توجد مقالات في هذا التصنيف حالياً.', 'nabd-aljazair' ); ?></p>
				<?php endif; ?>
			</div>
		<?php $first = false; endforeach; ?>
		<?php wp_reset_postdata(); ?>
	</div>

	<?php get_template_part( 'template-parts/newsletter' ); ?>
</main>

<?php get_footer(); ?>
