<?php
/**
 * Your Inspiration Themes
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
 
/**
 * Theme setup file
 */

/**
 * Set up all theme data.
 * 
 * @return void
 * @since 1.0.0
 */
function yit_setup_theme() {    
    //Content width. WP require it. So give to WordPress what is of WordPress
    if( !isset( $content_width ) ) { $content_width = yit_get_option( 'container-width' ); }
    
    //This theme have a CSS file for the editor TinyMCE
    add_editor_style( 'css/editor-style.css' );
    
    //This theme support post thumbnails
    add_theme_support( 'post-thumbnails' );
    
    //This theme uses the menues
    add_theme_support( 'menus' );
    
    //Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );
    
    //This theme support custom header
    add_theme_support( 'custom-headers' );
    
    //This theme support custom backgrounds
    add_theme_support( 'custom-backgrounds' );
    
    //This theme support post formats
    add_theme_support( 'post-formats', apply_filters( 'yit_post_formats_support', array( 'gallery', 'audio', 'video', 'quote' ) ) );
    
    // We'll be using post thumbnails for custom header images on posts and pages.
    // We want them to be 940 pixels wide by 198 pixels tall.
    // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
    //set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );    
    $image_sizes = array(
        'blog_big'     => array( 890, 340, true ),
        'blog_small'   => array( 365, 340, true ),
        'blog_elegant' => array( 539, 230, true ),
        'blog_thumb'   => array( 55, 55, true ),
        'section_blog' => array( 581, 155, true ),
        'section_blog_sidebar' => array( 386, 155, true ),
        'section_services' => array( 175, 175, true ),
        'thumb-testimonial' => array( 87, 85, true ),
        'thumb-testimonial-slider' => array( 35, 35, true ),
        'thumb_portfolio_fulldesc_related' => array( 258, 170, true ),
        'thumb_portfolio_bigimage' => array( 656, 0 ),
        'thumb_portfolio_filterable' => array( 260, 168, true ),
        'thumb_portfolio_fulldesc' => array( 574, 340, true ),
        'section_portfolio' => array( 573, 285, true ),
        'section_portfolio_sidebar' => array( 385, 192, true ),
        'thumb_portfolio_2cols' => array( 560, 324, true ),
        'thumb_portfolio_3cols' => array( 360, 216, true ),
        'thumb_portfolio_4cols' => array( 260, 172, true ),
        'accordion_thumb' => array( 266, 266, true ),
        'featured_project_thumb' => array( 320, 154, true ),
        'thumb_portfolio_slide' => array( 560, 377, true ),
        'thumb_portfolio_pinterest' => array( 260, 0 ),
        'nav_menu' => array( 170, 0 ),
    );
    
    $image_sizes = apply_filters( 'yit_add_image_size', $image_sizes );
    
    foreach ( $image_sizes as $id_size => $size )               
        add_image_size( $id_size, apply_filters( 'yit_' . $id_size . '_width', $size[0] ), apply_filters( 'yit_' . $id_size . '_height', $size[1] ), isset( $size[2] ) ? $size[2] : false );
    
    //Register theme default header. Usually one
    register_default_headers( array(
        'theme_header' => array(
            'url' => '%s/images/headers/001.jpg',
            'thumbnail_url' => '%s/images/headers/thumb/001.jpg',
            /* translators: header image description */
            'description' => __( 'Design', 'yit' ) . ' 1'
        )
    ) );
    
    //Set localization and load language file
    $locale = get_locale();
    $locale_file = YIT_THEME_PATH . "/languages/$locale.php";
    if ( is_readable( $locale_file ) )
        require_once( $locale_file );
    
    //Register menus
    register_nav_menus(
        array(
            'nav' => __( 'Main navigation', 'yit' ),
            'top' => __( 'Top Bar', 'yit' )
        )
    );
    // Set in Theme Options > General > Settings
    if( yit_get_option( 'show-top-menu-login-register' ) ) add_filter('wp_nav_menu_items','add_logout_button', 10, 2);

	if ( !is_nav_menu( 'Top Menu' )) {
        $menu_id = wp_create_nav_menu( 'Top Menu' );
        $menu = array( 'menu-item-type' => 'custom', 'menu-item-url' => get_home_url('/'),'menu-item-title' => 'Home' );
        wp_update_nav_menu_item( $menu_id, 0, $menu );
		
		$locations = get_theme_mod('nav_menu_locations');
		$locations['top'] = $menu_id;  
		set_theme_mod('nav_menu_locations', $locations);
    }
    
    //Register sidebars
    register_sidebar( yit_sidebar_args( 'Default Sidebar' ) );
    register_sidebar( yit_sidebar_args( 'Blog Sidebar' ) );
    register_sidebar( yit_sidebar_args( '404 Sidebar' ) );
    register_sidebar( yit_sidebar_args( 'Nav Sidebar', 'Widget area for Navigation Bar', 'widget' ) );
    
    //User definded sidebars
    do_action( 'yit_register_sidebars' );
    
    //Register custom sidebars
    $sidebars = maybe_unserialize( yit_get_option( 'custom-sidebars' ) );
    if( is_array( $sidebars ) && ! empty( $sidebars ) ) {
        foreach( $sidebars as $sidebar ) {
            register_sidebar( yit_sidebar_args( $sidebar, '', 'widget', apply_filters( 'yit_custom_sidebar_title_wrap', 'h3' ) ) );
        }
    }
    
    //Footer with sidebar type widgets
    if( strstr( yit_get_option( 'footer-type' ), 'sidebar' ) ) {
        register_sidebar( yit_sidebar_args( "Footer Widgets Area", __( "The widget area used in Footer With Sidebar section", 'yit' ), 'widget span2', apply_filters( 'yit_footer_widget_area_wrap', 'h3' ) ) );
        register_sidebar( yit_sidebar_args( "Footer Sidebar", __( "The sidebar used in Footer With Sidebar section", 'yit' ), 'widget span6', apply_filters( 'yit_footer_widget_area_wrap', 'h3' ) ) );
    } else {
        //Footer sidebars
        for( $i = 1; $i <= yit_get_option( 'footer-rows', 0 ); $i++ ) {
            register_sidebar( yit_sidebar_args( "Footer Row $i", sprintf(  __( "The widget area #%d used in Footer section", 'yit' ), $i ), 'widget span' . ( 12 / yit_get_option( 'footer-columns' ) ), apply_filters( 'yit_footer_sidebar_' . $i . '_wrap', 'h3' ) ) );
        }
    }
}

function add_logout_button( $nav, $args )
{
	if( is_user_logged_in() )
	{
		if( $args->theme_location == 'top' )
			return $nav.'<li><a href="' . wp_logout_url( home_url() ) . '"> ' . __('Logout', 'yit') . ' </a></li>';
		return $nav;
	}
	else
	{
		if( $args->theme_location == 'top' )
			if( is_shop_installed() )
			{
				$accountPage = get_permalink( get_option('woocommerce_myaccount_page_id') );
				return $nav.'<li><a href="' . $accountPage . '">' . __('Login', 'yit') . ' / ' . __('Register', 'yit') . '</a></li>';
			}
			else
				return $nav.'<li><a href="' . wp_login_url() . '">' . __('Login', 'yit') . '</a></li>'.wp_register(' / ','', false);
		return $nav;
	}
}

function yit_include_woocommerce_functions() {
    if ( ! is_shop_installed() ) return;

    include_once locate_template( basename( YIT_THEME_FUNC_DIR ) . '/woocommerce.php' );
}
add_action( 'yit_loaded', 'yit_include_woocommerce_functions' );

wp_oembed_add_provider( '#https?://(?:api\.)?soundcloud\.com/.*#i', 'http://soundcloud.com/oembed', true );

function yit_meta_like_body( $css ) {
    $body_bg = yit_get_option( 'background-style' );
    
    return $css . '.blog-big .meta, .blog-small .meta { background: ' . $body_bg['color'] . '; }';
}
add_filter( 'yit_custom_style', 'yit_meta_like_body' );

/**
 * Remove Shortcode tab in the Theme Options
 * 
 * @param array $tree
 * @return array
 * @since 1.0.0
 */
function yit_remove_tab_sc( $tree ) {
    if( isset( $tree['shortcodes'] ) )
        { unset( $tree['shortcodes'] ); }
    
    return $tree;
}

/**
 * Remove Items option from the magnifier
 * 
 * @param array $array
 * @return array
 * @since 1.3
 */
function yit_remove_items_options_yith_wcmg( $array ) {
    foreach( $array['slider'] as $key => $option ) {
        if( $option['id'] == 'yith_wcmg_slider_items' ) {
            unset( $array['slider'][$key] );
        }
    }
    
    return $array;
}

/**
 * Add a back to top button
 *
 */
function yit_back_to_top() {
    if ( yit_get_option('back-top') ) {
        echo '<div id="back-top"><a href="#top">' . __('Back to top', 'yit') . '</a></div>';
    }
}