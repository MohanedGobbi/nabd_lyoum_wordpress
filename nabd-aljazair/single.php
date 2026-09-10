<?php
/**
 * Single article page.
 */

get_header();
?>
<main>
	<?php while ( have_posts() ) : the_post();
		$cats = get_the_category();
		$cat  = $cats ? $cats[0] : null;
		?>
		<article class="mx-auto max-w-[820px] px-4 py-6 lg:px-6 lg:py-10">
			<div class="mb-3 flex items-center gap-1.5 text-[13px] text-ink-700/50 dark:text-white/40">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand"><?php esc_html_e( 'الرئيسية', 'nabd-aljazair' ); ?></a>
				<?php echo nabd_icon( 'chevron-left', 'h-3.5 w-3.5' ); ?>
				<?php if ( $cat ) : ?>
					<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="hover:text-brand"><?php echo esc_html( $cat->name ); ?></a>
				<?php endif; ?>
			</div>

			<?php if ( $cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="text-[13.5px] font-bold" style="<?php echo esc_attr( nabd_cat_text_style( $cat ) ); ?>">
					<?php echo esc_html( $cat->name ); ?>
				</a>
			<?php endif; ?>

			<h1 class="text-balance mt-2 text-[26px] font-extrabold leading-snug text-ink-950 dark:text-white lg:text-[34px]">
				<?php the_title(); ?>
			</h1>

			<div class="num mt-3 flex flex-wrap items-center gap-3 text-[13px] text-ink-700/50 dark:text-white/40">
				<span class="flex items-center gap-1.5"><?php echo nabd_icon( 'clock', 'h-3.5 w-3.5' ); ?> <?php echo esc_html( nabd_time_ago( get_the_ID() ) ); ?></span>
				<span class="flex items-center gap-1.5"><?php echo nabd_icon( 'eye', 'h-3.5 w-3.5' ); ?> <?php echo esc_html( number_format_i18n( nabd_get_views( get_the_ID() ) ) ); ?></span>
				<span><?php the_author(); ?></span>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mt-6 overflow-hidden rounded-2xl">
					<?php the_post_thumbnail( 'nabd-hero', array( 'class' => 'w-full object-cover' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="prose-nabd mt-6 text-[16px] leading-[1.9] text-ink-800 dark:text-white/80">
				<?php the_content(); ?>
			</div>

			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				?>
				<div class="mt-8 flex flex-wrap gap-2">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="rounded-full bg-ink-900/5 px-3 py-1 text-[12.5px] font-semibold text-ink-700 transition hover:bg-brand hover:text-white dark:bg-white/10 dark:text-white/60">
							#<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</article>

		<?php if ( $cat ) :
			$related = new WP_Query( array(
				'post_type'      => 'post',
				'cat'            => $cat->term_id,
				'posts_per_page' => 4,
				'post__not_in'   => array( get_the_ID() ),
				'no_found_rows'  => true,
			) );
			if ( $related->have_posts() ) :
				?>
				<section class="mx-auto max-w-[1400px] px-4 py-6 lg:px-6">
					<div class="mb-4 flex items-center gap-2">
						<span class="h-5 w-1 rounded-full bg-brand"></span>
						<h2 class="text-[17px] font-extrabold text-ink-950 dark:text-white">
							<?php printf( esc_html__( 'أخبار ذات صلة — %s', 'nabd-aljazair' ), esc_html( $cat->name ) ); ?>
						</h2>
					</div>
					<div class="grid grid-cols-2 gap-x-4 gap-y-6 lg:grid-cols-4">
						<?php
						while ( $related->have_posts() ) :
							$related->the_post();
							get_template_part( 'template-parts/article-card', null, array( 'post_id' => get_the_ID() ) );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</section>
			<?php endif; endif; ?>

	<?php endwhile; ?>

	<?php get_template_part( 'template-parts/newsletter' ); ?>
</main>

<?php get_footer(); ?>
