<?php
/**
 * smart_foundation functions and definitions
 *
 * @package smart_foundation
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'smart_foundation_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function smart_foundation_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on smart_foundation, use a find and replace
	 * to change 'smart_foundation' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'smart_foundation', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'smart_foundation' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'smart_foundation_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	/**
	 * Add Advanced Custom Fields Options pages
	 */
	if( function_exists('acf_set_options_page_title') )
	{
	    acf_set_options_page_title( __('Options', 'smart') );
	}
	if( function_exists('acf_set_options_page_menu') )
	{
	    acf_set_options_page_menu( __('Options', 'smart') );
	}
}
endif; // smart_foundation_setup
add_action( 'after_setup_theme', 'smart_foundation_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function smart_foundation_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'smart_foundation' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	/*register_sidebar( array(
		'name'          => __( 'Menu', 'smart' ),
		'id'            => 'offcanvas-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<ul class="off-canvas-list"><li><label class="offcanvas-title">',
		'after_title'   => '</label></li></ul>',
	) );*/
}
add_action( 'widgets_init', 'smart_foundation_widgets_init' );

/**
 * Add TinyMCE editor styles
 */
function smart_add_editor_styles() {
    add_editor_style();
}
add_action( 'init', 'smart_add_editor_styles' );

/**
 * Enqueue scripts and styles.
 */
function smart_foundation_scripts() {
	// Core styles and theme stylesheet
	wp_enqueue_style( 'wp-core-styles', get_template_directory_uri() . '/css/wp-core-styles.css');
	wp_enqueue_style( 'smart_foundation-style', get_stylesheet_uri() );

	// Scripts
	// jQuery
	wp_enqueue_script( 'jquery' );

	// REM Polyfill for rem support in the hell of IE
	wp_enqueue_script('rem-polyfill', get_template_directory_uri() . '/js/rem-polyfill.js', array('jquery'), false, true);

	// jQuery Viewport (mostly for parallax websites or to give elements classes and stuff when in viewport)
	//wp_enqueue_script('jquery-viewport', get_template_directory_uri() . '/js/jquery.viewport.min.js', array('jquery'), false, true);

	// Foundation JS
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/modernizr/modernizr.js', array('jquery'), false, true);
	wp_enqueue_script( 'foundation-script', get_template_directory_uri() . '/assets/foundation/js/foundation.js', array('jquery'), false, true);
	wp_enqueue_script( 'foundation-topbar-script', get_template_directory_uri() . '/assets/foundation/js/foundation/foundation.topbar.js', array('jquery', 'foundation-script'), false, true);
	//wp_enqueue_script( 'foundation-offcanvas-script', get_template_directory_uri() . '/assets/bower-foundation/js/foundation/foundation.offcanvas.js', array('jquery', 'foundation-script'), false, true);

	// Main Script
	wp_enqueue_script('main-script', get_template_directory_uri() . '/js/main.js', array('jquery','webfont-loader'), false, true);
	
	// Google Webfont Loader
	wp_enqueue_script('webfont-loader', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js', false, true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'smart_foundation_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Load Matthew Ruddy image resizer file.
 */
require_once get_template_directory() . '/inc/image-resizer.php';

/**
 * Load custom Foundation walker file.
 */
require_once get_template_directory() . '/inc/foundation-walker.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Load Types and Fields.
 */
require_once get_template_directory() . '/inc/types-and-fields.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
