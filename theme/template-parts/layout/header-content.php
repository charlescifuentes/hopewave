<?php
/**
 * Template part for displaying the header content
 *
 * Mirrors the original Elementor header: dot-grid icon, logo and three call to
 * action buttons. The dot-grid icon opens a drawer holding the primary menu.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hopewave
 */

$hopewave_header_buttons = array(
	array(
		'label' => __( 'Donate', 'hopewave' ),
		'url'   => home_url( '/donation/' ),
		'class' => 'btn-header bg-primary text-white shadow-glow-mist pr-4',
		'arrow' => true,
	),
	array(
		'label' => __( 'Sign Up', 'hopewave' ),
		'url'   => home_url( '/register/' ),
		'class' => 'btn-header bg-secondary text-white text-shadow-[0_0_10px_rgb(0_0_0_/_0.3)]',
		'arrow' => false,
	),
	array(
		'label' => __( 'Login', 'hopewave' ),
		'url'   => home_url( '/login/' ),
		'class' => 'btn-header bg-tertiary text-black shadow-glow-sky',
		'arrow' => false,
	),
);
?>

<header id="masthead" class="mx-auto flex max-w-wide flex-wrap items-center px-4 md:flex-nowrap">

	<div class="flex w-full items-center md:w-auto md:flex-1">
		<button
			type="button"
			class="menu-toggle mr-6 rounded-sm p-1 text-secondary transition-colors hover:text-primary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary md:mx-6"
			aria-controls="site-drawer"
			aria-expanded="false"
		>
			<span class="sr-only"><?php esc_html_e( 'Open menu', 'hopewave' ); ?></span>
			<svg class="size-7 lg:size-9" viewBox="0 0 36 38" fill="currentColor" aria-hidden="true">
				<?php
				foreach ( array( 6, 18, 30 ) as $hopewave_cy ) :
					foreach ( array( 6, 18, 30 ) as $hopewave_cx ) :
						?>
						<circle cx="<?php echo (int) $hopewave_cx; ?>" cy="<?php echo (int) ( $hopewave_cy + 1 ); ?>" r="5" />
						<?php
					endforeach;
				endforeach;
				?>
			</svg>
		</button>

		<div class="site-branding w-20 shrink-0 py-2.5 md:w-24 lg:w-31">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="font-bold text-secondary"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>

			<?php if ( is_front_page() ) : ?>
				<h1 class="sr-only"><?php bloginfo( 'name' ); ?></h1>
			<?php endif; ?>
		</div>
	</div>

	<ul class="flex w-full items-center justify-center gap-3 pb-2.5 md:w-auto md:justify-end md:gap-6 md:pb-0 lg:gap-14">
		<?php foreach ( $hopewave_header_buttons as $hopewave_button ) : ?>
			<li>
				<a href="<?php echo esc_url( $hopewave_button['url'] ); ?>" class="<?php echo esc_attr( $hopewave_button['class'] ); ?>">
					<?php echo esc_html( $hopewave_button['label'] ); ?>
					<?php if ( $hopewave_button['arrow'] ) : ?>
						<svg class="size-4" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M313.941 216H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h301.941v46.059c0 21.382 25.851 32.09 40.971 16.971l86.059-86.059c9.373-9.373 9.373-24.569 0-33.941l-86.059-86.059c-15.119-15.119-40.971-4.411-40.971 16.971V216z"/></svg>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

</header><!-- #masthead -->

<dialog id="site-drawer" class="site-drawer" aria-label="<?php esc_attr_e( 'Site menu', 'hopewave' ); ?>">
	<div class="flex h-full flex-col">
		<div class="flex items-center justify-between border-b border-tertiary px-6 py-5">
			<span class="text-sm font-semibold tracking-widest text-slate uppercase"><?php esc_html_e( 'Menu', 'hopewave' ); ?></span>
			<button type="button" class="drawer-close rounded-sm p-1 text-secondary hover:text-primary focus-visible:outline-2 focus-visible:outline-primary" autofocus>
				<span class="sr-only"><?php esc_html_e( 'Close menu', 'hopewave' ); ?></span>
				<svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
			</button>
		</div>

		<nav id="site-navigation" class="flex-1 overflow-y-auto px-6 py-6" aria-label="<?php esc_attr_e( 'Main Navigation', 'hopewave' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'drawer-menu',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</div>
</dialog>
