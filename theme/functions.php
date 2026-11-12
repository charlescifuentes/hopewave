<?php
/**
 * hopewave functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hopewave
 */

if ( ! defined( 'HOPEWAVE_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'HOPEWAVE_VERSION', '0.1.0' );
}

if ( ! defined( 'HOPEWAVE_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `hopewave_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'HOPEWAVE_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'hopewave_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hopewave_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on hopewave, use a find and replace
		 * to change 'hopewave' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hopewave', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in three locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary (header drawer)', 'hopewave' ),
				'menu-2' => __( 'Footer: Quick Links', 'hopewave' ),
				'menu-3' => __( 'Footer: Other Links', 'hopewave' ),
			)
		);

		// The header and footer logo is managed under Appearance → Customize.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 231,
				'width'       => 173,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'hopewave_setup' );

/**
 * Enqueue scripts and styles.
 */
function hopewave_scripts() {
	// Google Fonts, as on the original site: Poppins for the site chrome, and
	// Roboto titles over Montserrat text for WPBakery page content. This uses
	// the older `css` API, which takes every family in one `family` value:
	// css2 repeats the `family` key, and WordPress's query-arg helpers (run on
	// this URL by the Disable XML-RPC-API plugin) keep only the last one.
	wp_enqueue_style( 'hopewave-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,400i,700|Poppins:300,400,400i,500,600,700|Roboto:600&display=swap', array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	wp_enqueue_style( 'hopewave-style', get_stylesheet_uri(), array( 'hopewave-fonts' ), HOPEWAVE_VERSION );
	wp_enqueue_script( 'hopewave-script', get_template_directory_uri() . '/js/script.min.js', array(), HOPEWAVE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hopewave_scripts' );

/**
 * Enqueue the block editor script.
 */
function hopewave_enqueue_block_editor_script() {
	$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'hopewave-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			HOPEWAVE_VERSION,
			true
		);
		wp_add_inline_script( 'hopewave-editor', "tailwindTypographyClasses = '" . esc_attr( HOPEWAVE_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'hopewave_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function hopewave_tinymce_add_class( $settings ) {
	$settings['body_class'] = HOPEWAVE_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'hopewave_tinymce_add_class' );

/**
 * Limit the block editor to heading levels supported by Tailwind Typography.
 *
 * @param array  $args Array of arguments for registering a block type.
 * @param string $block_type Block type name including namespace.
 * @return array
 */
function hopewave_modify_heading_levels( $args, $block_type ) {
	if ( 'core/heading' !== $block_type ) {
		return $args;
	}

	// Remove <h1>, <h5> and <h6>.
	$args['attributes']['levelOptions']['default'] = array( 2, 3, 4 );

	return $args;
}
add_filter( 'register_block_type_args', 'hopewave_modify_heading_levels', 10, 2 );

/**
 * Keep Elementor Pro's Theme Builder from replacing our header and footer.
 *
 * Elementor Pro takes over `get_header()`/`get_footer()` for any theme that
 * hasn't registered these locations. Registering them here (without ever
 * calling `elementor_theme_do_location()`) means the legacy Elementor header
 * and footer templates never render while Elementor is still installed during
 * the rebuild. This hook simply stops firing once Elementor is removed.
 *
 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $manager Elementor's locations manager.
 */
function hopewave_register_elementor_locations( $manager ) {
	$manager->register_location( 'header' );
	$manager->register_location( 'footer' );
}
add_action( 'elementor/theme/register_locations', 'hopewave_register_elementor_locations' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer settings (footer subscribe form and text).
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Contact Form 7 integration (subscribe and contact forms).
 */
require get_template_directory() . '/inc/contact-form-7.php';

/**
 * WPBakery Page Builder elements.
 */
require get_template_directory() . '/inc/wpbakery.php';
