<?php
/**
 * Template part for displaying pages
 *
 * Pages built with WPBakery run full width with no visible title, so their
 * rows control the layout. Other pages (mostly plugin pages such as Login,
 * Account or the donor dashboard, plus LearnDash courses and lessons through
 * single.php) get a title above a text column, as on the original site. Neither shows an edit link; the admin bar has one.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hopewave
 */

?>

<?php if ( hopewave_is_builder_page() ) : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
		// The design puts each page's heading inside its content, so keep the
		// page title for screen readers only. The front page's <h1> is in the header.
		if ( ! is_front_page() ) {
			the_title( '<h1 class="sr-only">', '</h1>' );
		}
		?>

		<div class="entry-content builder-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-entry' ); ?>>

		<header class="entry-header">
			<?php
			if ( ! is_front_page() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title">', '</h2>' );
			}
			?>
		</header><!-- .entry-header -->

		<?php hopewave_post_thumbnail(); ?>

		<?php // No Tailwind Typography: the plugin pages bring their own styles. ?>
		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div>' . __( 'Pages:', 'hopewave' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>
