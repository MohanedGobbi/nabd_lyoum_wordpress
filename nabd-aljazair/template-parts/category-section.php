<?php
/**
 * One homepage section per category: header (name + chevron, links to the
 * category archive) → grid of its latest article cards → "see more" link.
 *
 * Usage: get_template_part( 'template-parts/category-section', null, array( 'category' => $term ) );
 */

$cat = $args['category'] ?? null;
if ( ! $cat ) {
	return;
}

$q = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'cat'            => $cat->term_id,
	'no_found_rows'  => true,
	'ignore_sticky_posts' => true,
) );

if ( ! $q->have_posts() ) {
	return;
}
?>
<section class="py-6">
	<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="group mb-4 flex items-center gap-1.5">
		<h2 class="text-[18px] font-extrabold" style="<?php echo esc_attr( nabd_cat_text_style( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></h2>
		<span class="transition group-hover:-translate-x-0.5" style="<?php echo esc_attr( nabd_cat_text_style( $cat ) ); ?>"><?php echo nabd_icon( 'chevron-left', 'h-5 w-5' ); ?></span>
	</a>

	<div class="grid grid-cols-2 gap-x-4 gap-y-6 lg:grid-cols-4">
		<?php
		while ( $q->have_posts() ) :
			$q->the_post();
			get_template_part( 'template-parts/article-card', null, array( 'post_id' => get_the_ID() ) );
		endwhile;
		wp_reset_postdata();
		?>
	</div>

	<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
	   class="mt-5 flex w-full items-center justify-center gap-1.5 rounded-full border border-ink-900/10 py-2.5 text-[13.5px] font-semibold text-ink-700/70 transition hover:border-brand hover:text-brand dark:border-white/15 dark:text-white/50">
		<?php printf( esc_html__( 'عرض المزيد من %s', 'nabd-aljazair' ), esc_html( $cat->name ) ); ?>
	</a>
</section>
