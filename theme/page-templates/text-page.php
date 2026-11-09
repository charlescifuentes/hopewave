<?php
/**
 * Template Name: Text Page
 *
 * Long-form pages written in the block editor, such as the Terms of Use and
 * Privacy Policy: the page title above the text on a grey band, as on the
 * original site.
 *
 * @package hopewave
 */

get_header();
?>

	<section id="primary">
		<main id="main">

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'text-page' ); ?>>
					<div class="text-page-inner">

						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</header><!-- .entry-header -->

						<div <?php hopewave_content_class( 'entry-content' ); ?>>
							<?php the_content(); ?>
						</div><!-- .entry-content -->

					</div>
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php
			endwhile;
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
