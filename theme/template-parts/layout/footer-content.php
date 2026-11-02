<?php
/**
 * Template part for displaying the footer content
 *
 * Mirrors the original Elementor footer: logo, Quick Links, an "Our Courses"
 * image carousel, Other Links and a "Subscribe Us" Gravity Form, followed by
 * a copyright bar.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hopewave
 */

$hopewave_course_images = hopewave_footer_course_images();
$hopewave_subscribe_id  = (int) get_theme_mod( 'hopewave_subscribe_form', 0 );
?>

<footer id="colophon" class="site-footer">

	<div class="bg-light">
		<div class="mx-auto grid max-w-[1400px] grid-cols-1 gap-x-5 gap-y-10 px-[5%] py-[10%] md:grid-cols-3 md:gap-y-12 md:py-[8%] lg:grid-cols-5 lg:px-5 lg:pt-[60px] lg:pb-[100px]">

			<div class="footer-logo">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="font-bold text-secondary"><?php bloginfo( 'name' ); ?></a>
				<?php endif; ?>
			</div>

			<?php hopewave_footer_menu_column( 'menu-2' ); ?>

			<?php if ( $hopewave_course_images ) : ?>
				<section class="footer-column" aria-labelledby="footer-courses-heading">
					<h2 id="footer-courses-heading" class="footer-heading lg:text-center"><?php esc_html_e( 'Our Courses', 'hopewave' ); ?></h2>

					<div class="course-carousel" data-autoplay="5000">
						<button type="button" class="carousel-arrow" data-direction="-1">
							<span class="sr-only"><?php esc_html_e( 'Previous image', 'hopewave' ); ?></span>
							<svg viewBox="0 0 320 512" fill="currentColor" aria-hidden="true"><path d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"/></svg>
						</button>

						<ul class="carousel-track" tabindex="0" aria-label="<?php esc_attr_e( 'Course images', 'hopewave' ); ?>">
							<?php foreach ( $hopewave_course_images as $hopewave_image_id ) : ?>
								<li><?php echo wp_get_attachment_image( $hopewave_image_id, 'medium', false, array( 'sizes' => '(max-width: 767px) 45vw, 100px' ) ); ?></li>
							<?php endforeach; ?>
						</ul>

						<button type="button" class="carousel-arrow" data-direction="1">
							<span class="sr-only"><?php esc_html_e( 'Next image', 'hopewave' ); ?></span>
							<svg viewBox="0 0 320 512" fill="currentColor" aria-hidden="true"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
						</button>
					</div>
				</section>
			<?php endif; ?>

			<?php hopewave_footer_menu_column( 'menu-3' ); ?>

			<?php /* Subscribe moves to the top of the stack on mobile, as on the original site. */ ?>
			<section class="footer-column footer-subscribe max-md:order-first max-md:mb-6 lg:ml-[10%]" aria-labelledby="footer-subscribe-heading">
				<h2 id="footer-subscribe-heading" class="footer-heading"><?php esc_html_e( 'Subscribe Us', 'hopewave' ); ?></h2>

				<?php $hopewave_subscribe_text = get_theme_mod( 'hopewave_subscribe_text', __( 'Donations or support!', 'hopewave' ) ); ?>
				<?php if ( $hopewave_subscribe_text ) : ?>
					<p class="font-light text-slate"><?php echo esc_html( $hopewave_subscribe_text ); ?></p>
				<?php endif; ?>

				<?php
				if ( $hopewave_subscribe_id && function_exists( 'gravity_form' ) ) {
					// Title and description off, AJAX on, the plain "gravity-theme" so our styles apply cleanly.
					gravity_form( $hopewave_subscribe_id, false, false, false, null, true, 0, true, 'gravity-theme' );
				}
				?>
			</section>

		</div>
	</div>

	<div class="flex min-h-[45px] items-center justify-center bg-primary px-4 py-2.5">
		<p class="text-center leading-normal font-light text-white">
			<?php
			/* translators: %s: current year. */
			printf( esc_html__( '© %s All Rights Reserved.', 'hopewave' ), esc_html( wp_date( 'Y' ) ) );
			?>
		</p>
	</div>

</footer><!-- #colophon -->
