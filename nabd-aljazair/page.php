<?php
/**
 * Generic Page template (about/contact/privacy/terms, etc.).
 */

get_header();
?>
<main>
	<article class="mx-auto max-w-[820px] px-4 py-10 lg:px-6">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="mb-6 text-[26px] font-extrabold text-ink-950 dark:text-white lg:text-[32px]"><?php the_title(); ?></h1>
			<div class="prose-nabd text-[16px] leading-[1.9] text-ink-800 dark:text-white/80">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</article>
</main>

<?php get_footer(); ?>
