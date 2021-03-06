<?php
/**
 * Title: Function
 *
 * Description: Defines theme specific functions including actions and filters.
 *
 * Please do not edit this file. This file is part of the CyberChimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category CyberChimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

$template_directory = get_template_directory();

require( get_template_directory() . '/inc/admin-about.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'altitude_setup' ) ) : /**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */ {
	function altitude_setup() {

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Altitude, use a find and replace
		 * to change 'altitude' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'altitude', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			                    'primary' => __( 'Primary Menu', 'altitude' ),
			                    'footer'  => __( 'Footer Menu', 'altitude' )
		                    ) );

		/**
		 * Enable support for Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		/**
		 * Setup the WordPress core custom background feature.
		 */
		add_theme_support( 'custom-background', apply_filters( 'altitude_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		/**
		 * Add new thumbnails size
		 */
		add_image_size( 'altitude-home', '706', '240', true );
		add_image_size( 'altitude-blog', '1170', '283', true );
		add_image_size( 'altitude-post', '848', '205', true );

		/**
		 * Enable support for HTML5 markup.
		 */
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'caption',
		) );
	}
}
endif; // altitude_setup
add_action( 'after_setup_theme', 'altitude_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function altitude_widgets_init() {
	register_sidebar( array(
		                  'name'          => __( 'Sidebar', 'altitude' ),
		                  'id'            => 'sidebar-1',
		                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		                  'after_widget'  => '</aside>',
		                  'before_title'  => '<h3 class="widget-title">',
		                  'after_title'   => '</h3>',
	                  ) );
}

add_action( 'widgets_init', 'altitude_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function altitude_scripts() {

	$template_directory_uri = get_template_directory_uri();

	// Check if it exists in child theme.
	if ( file_exists( get_stylesheet_directory() . '/layouts/core.css' ) ) {
		wp_enqueue_style( 'altitude-core', get_stylesheet_directory_uri() . '/layouts/core.css', array(), '20131022' );
	} else {
		wp_enqueue_style( 'altitude-core', $template_directory_uri . '/layouts/core.css', array(), '20131022' );
	}

	wp_enqueue_style( 'altitude-style', get_stylesheet_uri() );

	wp_enqueue_script( 'altitude-skip-link-focus-fix', $template_directory_uri . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'altitude-keyboard-image-navigation', $template_directory_uri . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	wp_enqueue_script( 'altitude-stellar', $template_directory_uri . '/js/jquery.stellar.min.js', array( 'jquery' ), '20130825', true );

	wp_enqueue_script( 'altitude-theme', $template_directory_uri . '/js/theme-js.js', array(
			'jquery',
			'altitude-stellar'
		), '20130825', true );

	wp_enqueue_script( 'altitude-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
}

add_action( 'wp_enqueue_scripts', 'altitude_scripts' );

/**
 * Customizer additions.
 */
require $template_directory . '/inc/customizer.php';

/**
 * Implement the Custom Header feature.
 */
require $template_directory . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require $template_directory . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require $template_directory . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require $template_directory . '/inc/jetpack.php';

/**
 * function decides where to put the sidebar. Left or right of content
 *
 * @param $loc string - left or right
 */
function altitude_get_sidebar( $loc ) {
	$location = get_theme_mod( 'altitude_sidebar' );
	$location = $location ? $location : 'right';

	if ( $loc == $location ) {
		get_sidebar();
	}
}

/**
 * Enqueue Styles
 */
function altitude_load_styles() {
	wp_enqueue_style( 'altitude-sourcesanspro', altitude_google_font_url(), array(), null );
	wp_enqueue_style( 'altitude-fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
}

add_action( 'wp_enqueue_scripts', 'altitude_load_styles' );

/**
 * Enqueue Admin Scripts for custom headers
 */
function altitude_admin_scripts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix ) {
		return;
	}

	wp_enqueue_style( 'altitude-sourcesanspro', altitude_google_font_url(), array(), null );
	wp_enqueue_style( 'altitude-fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
}

add_action( 'admin_enqueue_scripts', 'altitude_admin_scripts' );

/**
 * Create the font urls
 */
function altitude_google_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Source Sans Pro or font awesome, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'source sans pro font: on or off', 'altitude' ) ) {
		$font_url = add_query_arg( 'family', 'Source+Sans+Pro:200,300,400,600,700,900', "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Customize excerpt more
 */
function altitude_excerpt_more( $more ) {
	return '... <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Continue Reading', 'altitude' ) . '</a>';
}

add_filter( 'excerpt_more', 'altitude_excerpt_more' );

add_action( 'admin_notices', 'my_admin_notice' );
function my_admin_notice(){
	global $altitude_check_screen;
	$altitude_check_screen = get_admin_page_title();

   if ( $altitude_check_screen == 'Manage Themes' )
{
          echo '<div class="notice notice-info"><p class="altitude-upgrade-callout" style="font-size:1.2em; font-weight:bold;"><img src="'.get_template_directory_uri().'/images/chimp.png" alt="CyberChimps" style="padding-right:1em; vertical-align:middle"/>Welcome to Altitude Lite! Get 30% off on <a href="https://cyberchimps.com/store/altitude/" target="_blank" title="Altitude">Altitude</a> using Coupon Code <span style="color:red">ALTITUDE30</span></p></div>';

          echo '<div class="notice notice-info is-dismissible"><p class="altitude-upgrade-callout" style="font-size:18px; "><a href="https://cyberchimps.com/free-download-50-stock-images-use-please/?utm_source=AltitudeLite" target="_blank" style="text-decoration:none;">FREE - Download CyberChimps\' Pack of 50 High-Resolution Stock Images Now</a></p></div>';
}
}

// enabling theme support for title tag
function altitudelite_title_setup()
{
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'altitudelite_title_setup' );


function altitude_lite_customize_edit_links( $wp_customize ) {


   $wp_customize->selective_refresh->add_partial( 'blogname', array(
'selector' => '.site-title'
) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description'
	) );

	$wp_customize->selective_refresh->add_partial( 'altitude_logo_image', array(
		'selector' => '#site_logo a'
	) );

	$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[footer]', array(
		'selector' => '#footer_menu_container'
	) );

	$wp_customize->selective_refresh->add_partial( 'altitude_copyright_textbox', array(
		'selector' => '#copyright_text'
	) );

	$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[primary]', array(
		'selector' => '#navigation .nav'
	) );

	$wp_customize->selective_refresh->add_partial( 'header_image', array(
		'selector' => '#site_branding_container'
	) );

}
add_action( 'customize_register', 'altitude_lite_customize_edit_links' );
add_theme_support( 'customize-selective-refresh-widgets' );

add_action( 'admin_notices', 'altitude_lite_admin_notice' );
function altitude_lite_admin_notice(){

	$admin_check_screen = get_admin_page_title();

	if( !class_exists('SlideDeckPlugin') )
	{

	$slug = 'slidedeck';
	 if ( $admin_check_screen == 'Manage Themes' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the SlideDeck Lite plugin</a>
		</p>
		</div>
		<?php
	}
	}

	if( !class_exists('WPForms') )
	{

	$slug = 'wpforms-lite';
	 if ( $admin_check_screen == 'Manage Themes' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the WP Forms Lite plugin</a>
		</p>
		</div>
		<?php
	}
	}

	if ( $admin_check_screen == 'Manage Themes' )
	{
	?>
		<div class="notice notice-success is-dismissible">
				<b><p>Liked this theme? <a href="https://wordpress.org/support/theme/altitude-lite/reviews/#new-post" target="_blank">Leave us</a> a ***** rating. Thank you! </p></b>
		</div>
		<?php
	}

}
