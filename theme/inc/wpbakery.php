<?php
/**
 * WPBakery Page Builder elements
 *
 * Shortcodes are registered whether or not WPBakery is active, so content
 * keeps rendering; the `vc_map()` calls only add them to WPBakery's
 * "Add Element" panel.
 *
 * @package hopewave
 */

/**
 * Outputs the primary menu as an in-page navigation bar.
 *
 * Used under the Home page hero. From the `lg` breakpoint down the links
 * collapse to a menu button that opens the header's menu drawer, as the
 * original site's menu collapsed to a toggle on tablets and phones.
 *
 * @return string
 */
function hopewave_page_nav_shortcode() {
	if ( ! has_nav_menu( 'menu-1' ) ) {
		return '';
	}

	ob_start();
	?>
	<nav class="page-nav" aria-label="<?php esc_attr_e( 'Main Navigation', 'hopewave' ); ?>">
		<button type="button" class="page-nav-toggle" aria-controls="site-drawer" aria-expanded="false">
			<span class="sr-only"><?php esc_html_e( 'Open menu', 'hopewave' ); ?></span>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
		</button>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'menu-1',
				'menu_class'     => 'page-nav-menu',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
	<?php
	return ob_get_clean();
}
add_shortcode( 'hopewave_page_nav', 'hopewave_page_nav_shortcode' );

/**
 * Adds the theme's elements to WPBakery.
 */
function hopewave_vc_map_elements() {
	vc_map(
		array(
			'name'                    => __( 'Page Navigation', 'hopewave' ),
			'base'                    => 'hopewave_page_nav',
			'category'                => __( 'Hope Wave', 'hopewave' ),
			'description'             => __( 'Primary menu; a menu button on tablets and phones', 'hopewave' ),
			'icon'                    => 'icon-wpb-wp',
			'show_settings_on_create' => false,
			'params'                  => array(),
		)
	);
}
add_action( 'vc_before_init', 'hopewave_vc_map_elements' );
