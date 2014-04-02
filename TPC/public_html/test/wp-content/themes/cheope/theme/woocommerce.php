<?php 
/**
 * All functions and hooks for woocommerce plugin  
 *
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.4
 */          
 
// global flag to know that woocommerce is active
$yiw_is_woocommerce = true; 

/* === GENERAL SETTINGS === */
register_sidebar( yit_sidebar_args( 'Shop Sidebar' ) );

// add support to woocommerce
add_theme_support( 'woocommerce' );


/* === HOOKS === */                                                     
add_action( 'woocommerce_before_main_content', 'yit_shop_page_meta' );
if ( yit_get_option( 'shop-show-breadcrumb' ) ) add_action( 'shop_page_meta', 'woocommerce_breadcrumb' );
add_action( 'shop_page_meta'     , 'yit_woocommerce_list_or_grid' );
add_action( 'shop_page_meta'     , 'yit_woocommerce_catalog_ordering' );
add_filter( 'woocommerce_page_settings', 'yit_woocommerce_deactive_logout_link' );
add_action( 'wp_head', 'yit_size_images_style' );
add_filter( 'loop_shop_per_page' , 'yit_set_posts_per_page');
add_filter( 'woocommerce_catalog_settings', 'yit_add_featured_products_slider_image_size' );
//add_filter( 'woocommerce_catalog_settings', 'yit_add_responsive_image_option' );
add_filter( 'wp_redirect', 'yit_remove_add_to_cart_query', 10, 2 );

add_action( 'yit_activated', 'yit_woocommerce_default_image_dimensions');
add_action( 'admin_init', 'yit_woocommerce_update' ); //update image names after woocommerce update

add_filter( 'yit_sample_data_tables',  'yit_save_woocommerce_tables' );
add_filter( 'yit_sample_data_options', 'yit_save_woocommerce_options' );
add_filter( 'yit_sample_data_options', 'yit_save_wishlist_options' );
add_filter( 'yit_sample_data_options', 'yit_add_plugins_options' );

/* shop */
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'yit_woocommerce_added_button', 10 );
if ( yit_get_option('shop-view-show-description') )
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 5 );
remove_action( 'woocommerce_before_main_content' , 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_pagination'          , 'woocommerce_catalog_ordering', 20 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_filter( 'yith-wcan-frontend-args', 'yit_wcan_change_pagination_class' );


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
/* single */
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_filter( 'yith_wcwl_add_to_wishlist_std_icon', create_function( '', 'return "icon-heart-empty";' ) );
if ( ! has_action( 'woocommerce_share' ) )
	add_action( 'woocommerce_share', 'yit_woocommerce_share' );
add_action( 'woocommerce_single_product_summary', 'yit_woocommerce_compare_link', 35 );

/* related */
if ( yit_get_option('shop-show-related') ) {
	add_action( 'woocommerce_related_products_args', 'yit_related_posts_per_page', 1 );
}
function yit_related_posts_per_page() {
	global $product;
	$related = $product->get_related(yit_get_option('shop-number-related'));
	
	return array( 
		'posts_per_page' 		=> yit_get_option('shop-number-related'),
		'post_type'				=> 'product',
		'ignore_sticky_posts'	=> 1,
		'no_found_rows' 		=> 1,
		'post__in' 				=> $related
	);
}

/* tabs */                                                     
add_action( 'woocommerce_product_tabs', 'yit_woocommerce_add_tabs' );  // Woo 2
//add_action( 'woocommerce_product_tabs', 'yit_woocommerce_add_info_tab', 40 );
add_action( 'woocommerce_product_tab_panels', 'yit_woocommerce_add_info_panel', 40 );
//add_action( 'woocommerce_product_tabs', 'yit_woocommerce_add_custom_tab', 50 );
add_action( 'woocommerce_product_tab_panels', 'yit_woocommerce_add_custom_panel', 50 );


//if ( yit_get_option( 'shop-show-breadcrumb' ) ) add_action( 'shop_page_meta', 'woocommerce_breadcrumb' );
// active the price filter
global $woocommerce;
if( version_compare($woocommerce->version,"2.0.0",'<') ) {
	add_action('init', 'woocommerce_price_filter_init');
}
add_filter('loop_shop_post_in', 'woocommerce_price_filter'); 

/* fix woo2*/
if( yit_get_option('shop-fields-order') ) {
	add_filter( 'woocommerce_billing_fields' , 'woocommerce_restore_billing_fields_order' );
	function woocommerce_restore_billing_fields_order( $fields ) {
		 $fields['billing_city']['class'][0] = 'form-row-last';
		 $fields['billing_country']['class'][0] = 'form-row-first';
		 $fields['billing_address_1']['class'][0] = 'form-row-first';
		 $fields['billing_address_2']['class'][0] = 'form-row-last';
		
		 $country = $fields['billing_country'];
		 unset( $fields['billing_country'] );
		 yit_array_splice_assoc( $fields, array('billing_country' => $country), 'billing_city' );
		
		 return $fields;
	}
	
	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_restore_shipping_fields_order' );
	function woocommerce_restore_shipping_fields_order( $fields ) {
		 $fields['shipping_city']['class'][0] = 'form-row-last';
		 $fields['shipping_country']['class'][0] = 'form-row-first';
		 $fields['shipping_address_1']['class'][0] = 'form-row-first';
		 $fields['shipping_address_2']['class'][0] = 'form-row-last';
		
		 $country = $fields['shipping_country'];
		 unset( $fields['shipping_country'] );
		 yit_array_splice_assoc( $fields, array('shipping_country' => $country), 'shipping_state' );
		
		 return $fields;
	}
}

/* compare */
global $yith_woocompare;
if ( isset($yith_woocompare) ) {
    remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
    if ( get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) add_action( 'woocommerce_after_shop_loop_item_title', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
}
/* === FUNCTIONS === */
function yit_remove_add_to_cart_query( $location, $status ) {
    return remove_query_arg( 'add-to-cart', $location );    
}

function yit_woocommerce_catalog_ordering() {
    if ( ! is_single() ) woocommerce_catalog_ordering();    
}         

function yit_set_posts_per_page( $cols ) {        
    $items = yit_get_option( 'shop-products-per-page', $cols );         
    return $items == 0 ? -1 : $items;
}                             

function yit_woocommerce_list_or_grid() {
    woocommerce_get_template( 'shop/list-or-grid.php' );
}                            

function yit_woocommerce_added_button() {
    woocommerce_get_template( 'loop/added.php' );
}   

function yit_shop_page_meta() {
    woocommerce_get_template( 'shop/page-meta.php' );
}


function yit_woocommerce_show_product_thumbnails() {
	woocommerce_get_template( 'single-product/thumbs.php' );
}                     

function yit_woocommerce_compare_link() {
    if(function_exists('woo_add_compare_button')) echo woo_add_compare_button(), '<a class="woo_compare_button_go"></a>';
}

function yit_wcan_change_pagination_class( $args ) {
    $args['pagination'] = '.general-pagination';
    return $args;
}

/* Woo >= 2 */
function yit_woocommerce_add_tabs( $tabs ) {

    if ( yit_get_post_meta( yit_post_id(), '_use_ask_info' ) == 1 ) {
    	$tabs['info'] = array(
    		'title'    => apply_filters( 'yit_ask_info_label', __('Product Inquiry', 'yit') ),
    		'priority' => 30,
    		'callback' => 'yit_woocommerce_add_info_panel'
    	);
    }
	
	$custom_tabs = yit_get_post_meta( yit_post_id(), '_custom_tabs');
	if( !empty( $custom_tabs ) ) {
        foreach( $custom_tabs as $tab ) {
        	$tabs['custom-'.$tab["position"]] = array(
        		'title'    => $tab["name"],
        		'priority' => 30 + $tab["position"],
        		'callback' => 'yit_woocommerce_add_custom_panel',
        		'custom_tab' => $tab
        	);
        }
    }
	
	return $tabs;
}
                               
/* custom and info tabs */
function yit_woocommerce_add_info_tab() {
	woocommerce_get_template( 'single-product/tabs/tab-info.php' );
}

function yit_woocommerce_add_info_panel() {
	woocommerce_get_template( 'single-product/tabs/info.php' );
}
        
function yit_woocommerce_add_custom_tab() {
	woocommerce_get_template( 'single-product/tabs/tab-custom.php' );
}

function yit_woocommerce_add_custom_panel( $key, $tab ) {
	woocommerce_get_template( 'single-product/tabs/custom.php', array( 'key' => $key, 'tab' => $tab ) );
}

function woocommerce_template_loop_product_thumbnail() {
	echo '<a href="' . get_permalink() . '" class="thumb">' . woocommerce_get_product_thumbnail() . '</a>';
}

/* share */
function yit_woocommerce_share() {
    if( !yit_get_option( 'shop-share' ) )
        { return; }
    
	echo do_shortcode('[share class="product-share" title="' . yit_get_option( 'shop-share-title' ) . '" socials="' . yit_get_option( 'shop-share-socials' ) . '"]');
}

/* logout link */
function yit_woocommerce_deactive_logout_link( $options ) {
    foreach ( $options as $option ) {
        if ( isset( $option['id'] ) && $option['id'] != 'yit_woocommerce_deactive_logout_link' ) continue;
        
        $option['std'] = 'no';
        break;
    }
    
    return $options;
}

/* checkout */
add_filter('wp_redirect', 'yit_woocommerce_checkout_registration_redirect'); 
function yit_woocommerce_checkout_registration_redirect( $location ) {
	if ( isset($_POST['register']) && $_POST['register'] && isset($_POST['yit_checkout']) && $location == get_permalink(woocommerce_get_page_id('myaccount')) ) {
		$location = get_permalink(woocommerce_get_page_id('checkout'));
	}
	
	return $location;
}

        
/**
 * SIZES
 */ 

// shop small
if( !function_exists( 'yit_shop_small_w' ) ) { function yit_shop_small_w() { global $woocommerce; $size = $woocommerce->get_image_size('shop_catalog'); return $size['width']; } }
if( !function_exists( 'yit_shop_small_h' ) ) { function yit_shop_small_h() { global $woocommerce; $size = $woocommerce->get_image_size('shop_catalog'); return $size['height']; } }
// shop thumbnail
if( !function_exists( 'yit_shop_thumbnail_w' ) ) { function yit_shop_thumbnail_w() { global $woocommerce; $size = $woocommerce->get_image_size('shop_thumbnail'); return $size['width']; } }
if( !function_exists( 'yit_shop_thumbnail_h' ) ) { function yit_shop_thumbnail_h() { global $woocommerce; $size = $woocommerce->get_image_size('shop_thumbnail'); return $size['height']; } }
// shop large
if( !function_exists( 'yit_shop_large_w' ) ) { function yit_shop_large_w() { global $woocommerce; $size = $woocommerce->get_image_size('shop_single'); return $size['width']; } }
if( !function_exists( 'yit_shop_large_h' ) ) { function yit_shop_large_h() { global $woocommerce; $size = $woocommerce->get_image_size('shop_single'); return $size['height']; } }

// print style for small thumb size
function yit_size_images_style() {
    ?>
    <style type="text/css">
        ul.products li.product.list .product-thumbnail { margin-left:<?php echo yit_shop_small_w() + 30 + 10 + 2; ?>px; }
        ul.products li.product.list .product-thumbnail .thumbnail-wrapper { margin-left:-<?php echo yit_shop_small_w() + 30 + 10 + 2; ?>px; }
        
        /* IE8, Portrait tablet to landscape and desktop till 1024px */
        .single-product .sidebar-no div.images,
        .single-product .sidebar-no div.images { width:<?php echo ( yit_shop_large_w() - 30 + 2 ) / 1200 * 100 ?>%; }
        .single-product .sidebar-no div.summary,
        .single-product .sidebar-no div.summary { width:<?php echo ( 1200 - yit_shop_large_w() - 30 + 2 ) / 1200 * 100 ?>%; }
        
        .single-product .sidebar-right .span10 div.images,
        .single-product .sidebar-left .span10 div.images { width:<?php echo ( yit_shop_large_w() - 30 + 2 ) / 970 * 100 ?>%; }
        .single-product .sidebar-right .span10 div.summary,
        .single-product .sidebar-left .span10 div.summary { width:<?php echo ( 970 - yit_shop_large_w() - 30 + 2 ) / 970 * 100 ?>%; }
        
        .single-product .sidebar-right .span9 div.images,
        .single-product .sidebar-left .span9 div.images { width:<?php echo ( yit_shop_large_w() - 30 + 2 ) / 870 * 100 ?>%; }
        .single-product .sidebar-right .span9 div.summary,
        .single-product .sidebar-left .span9 div.summary { width:<?php echo ( 870 - yit_shop_large_w() - 30 + 2 ) / 870 * 100 ?>%; }
        /* WooCommerce standard images */
        .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 80 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 80 ) ?>px !important; }
        /* Slider images */
        .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 80 ) ?>px !important; }
        
        /* Desktop above 1200px */
        @media (min-width:1200px) {            
            /* WooCommerce standard images */
            .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 100 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 100 ) ?>px !important; }
            /* Slider images */
            .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 100 ) ?>px !important; }
        }
        
        /* Desktop above 1200px */
        @media (max-width: 979px) and (min-width: 768px) {            
            /* WooCommerce standard images */
            .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 63 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 63 ) ?>px !important; }
            /* Slider images */
            .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 63 ) ?>px !important; }
        }

        <?php if( yit_get_option( 'responsive-enabled' ) ) : ?>
        /* Below 767px, mobiles included */
        @media (max-width: 767px) {
            .single-product div.images,
            .single-product div.summary { float:none;margin-left:0px !important;width:100% !important; }
            
            .single-product div.images { margin-bottom:20px; }    
            
            /* WooCommerce standard images */
            .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 65 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 65 ) ?>px !important; }
            /* Slider images */
            .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 65 ) ?>px !important; }
        }
        <?php endif ?>
    </style>
    <?php
}

// ADD IMAGE CATEGORY OPTION
function yit_add_featured_products_slider_image_size( $options ) {
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );
    
    $options[] = array(  
		'name' => __( 'Featured Products Widget', 'woocommerce' ),
		'desc' 		=> __( 'This size is usually used for the products thubmnails in the slider widget Featured Products.', 'yit' ),
		'id' 		=> 'woocommerce_featured_products_slider_image',
		'css' 		=> '',
		'type' 		=> 'image_width',
		'default'	=> array(
							'width' => 160,
							'height' => 124,
							'crop' => true
					   ),
		'std' 		=> array(
							'width' => 160,
							'height' => 124,
							'crop' => true
					   ),
		'desc_tip'	=>  true,
	);              
	$options[] = $tmp;     
                          
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );     
    $options[] = array(
		'name'		=> __( 'Active responsive images', 'yit' ),
		'desc' 		=> __( 'Active this to make the images responsive and adaptable to the layout grid.', 'yit' ),
		'id' 		=> 'woocommerce_responsive_images',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox'
	);       
	$options[] = $tmp;
                        
    return $options; 
}

// add image size for the images of widget featured product slider
function yit_add_featured_products_slider_size( $image_sizes ) {
    $size = get_option('woocommerce_featured_products_slider_image');
    $width  = $size['width'];
    $height = $size['height'];
    $crop = $size['crop'];
    $image_sizes['featured_products_slider'] = array( $width, $height, $crop );
    return $image_sizes;
}
add_filter( 'yit_add_image_size', 'yit_add_featured_products_slider_size' );

// ADD IMAGE RESPONSIVE OPTION
function yit_add_responsive_image_option( $options ) {
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );
    
    $options[] = array(
		'name'		=> __( 'Active responsive images', 'yit' ),
		'desc' 		=> __( 'Active this to make the images responsive and adaptable to the layout grid.', 'yit' ),
		'id' 		=> 'woocommerce_responsive_images',
		'std' 		=> 'yes',
		'default'   => 'yes',
		'type' 		=> 'checkbox'
	);              
	
	$options[] = $tmp;
                        
    return $options;   
}



/** NAV MENU
-------------------------------------------------------------------- */

add_action('admin_init', array('yitProductsPricesFilter', 'admin_init'));

class yitProductsPricesFilter {
	// We cannot call #add_meta_box yet as it has not been defined,
    // therefore we will call it in the admin_init hook
	static function admin_init() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) || basename($_SERVER['PHP_SELF']) != 'nav-menus.php' ) 
			return;
			                                                    
		wp_enqueue_script('nav-menu-query', YIT_THEME_ASSETS_URL . '/js/metabox_nav_menu.js', 'nav-menu', false, true);
		add_meta_box('products-by-prices', 'Prices Filter', array(__CLASS__, 'nav_menu_meta_box'), 'nav-menus', 'side', 'low');
	}

	function nav_menu_meta_box() { ?>
	<div class="prices">        
		<input type="hidden" name="woocommerce_currency" id="woocommerce_currency" value="<?php echo get_woocommerce_currency_symbol( get_option('woocommerce_currency') ) ?>" />
		<input type="hidden" name="woocommerce_shop_url" id="woocommerce_shop_url" value="<?php echo get_option('permalink_structure') == '' ? site_url() . '/?post_type=product' : get_permalink( get_option('woocommerce_shop_page_id') ) ?>" />
		<input type="hidden" name="menu-item[-1][menu-item-url]" value="" />
		<input type="hidden" name="menu-item[-1][menu-item-title]" value="" />
		<input type="hidden" name="menu-item[-1][menu-item-type]" value="custom" />
		
		<p>
		    <?php _e( sprintf( 'The values are already expressed in %s', get_woocommerce_currency_symbol( get_option('woocommerce_currency') ) ), 'yiw' ) ?>
		</p>
		
		<p>
			<label class="howto" for="prices_filter_from">
				<span><?php _e('From', 'yit'); ?></span>
				<input id="prices_filter_from" name="prices_filter_from" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('From', 'yit'); ?>" />
			</label>
		</p>

		<p style="display: block; margin: 1em 0; clear: both;">
			<label class="howto" for="prices_filter_to">
				<span><?php _e('To', 'yit'); ?></span>
				<input id="prices_filter_to" name="prices_filter_to" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('To'); ?>" />
			</label>
		</p>

		<p class="button-controls">
			<span class="add-to-menu">
				<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
				<input type="submit" class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-custom-menu-item" />
			</span>
		</p>

	</div>
<?php
	}
}     

/**
 * Add 'On Sale Filter to Product list in Admin
 */
add_filter( 'parse_query', 'on_sale_filter' );
function on_sale_filter( $query ) {
    global $pagenow, $typenow, $wp_query;

    if ( $typenow=='product' && isset($_GET['onsale_check']) && $_GET['onsale_check'] ) :

        if ( $_GET['onsale_check'] == 'yes' ) :
            $query->query_vars['meta_compare']  =  '>';
            $query->query_vars['meta_value']    =  0;
            $query->query_vars['meta_key']      =  '_sale_price';
        endif;

        if ( $_GET['onsale_check'] == 'no' ) :
            $query->query_vars['meta_value']    = '';
            $query->query_vars['meta_key']      =  '_sale_price';
        endif;

    endif;
}

add_action('restrict_manage_posts','woocommerce_products_by_on_sale');
function woocommerce_products_by_on_sale() {
    global $typenow, $wp_query;
    if ( $typenow=='product' ) :

        $onsale_check_yes = '';
        $onsale_check_no  = '';

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'yes' ) :
            $onsale_check_yes = ' selected="selected"';
        endif;

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'no' ) :
            $onsale_check_no = ' selected="selected"';
        endif;

        $output  = "<select name='onsale_check' id='dropdown_onsale_check'>";
        $output .= '<option value="">'.__('Show all products (Sale Filter)', 'yit').'</option>';
        $output .= '<option value="yes"'.$onsale_check_yes.'>'.__('Show products on sale', 'yit').'</option>';
        $output .= '<option value="no"'.$onsale_check_no.'>'.__('Show products not on sale', 'yit').'</option>';
        $output .= '</select>';

        echo $output;

    endif;
}


if( yit_get_option('shop-customer-vat' ) && yit_get_option('shop-customer-ssn' ) ) {

	add_filter( 'woocommerce_billing_fields' , 'woocommerce_add_billing_fields' );
	function woocommerce_add_billing_fields( $fields ) {
        //$fields['billing_country']['clear'] = true;
		$field = array('billing_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-first'),
		    'clear'       => false
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');

		$field = array('billing_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');

		return $fields;
	} 


	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_add_shipping_fields' );
	function woocommerce_add_shipping_fields( $fields ) {
		$field = array('shipping_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-first'),
		    'clear'       => false
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');

		$field = array('shipping_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');
		return $fields;
	}


    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    function woocommerce_add_billing_shipping_fields_admin( $fields ) {
        $fields['vat'] = array(
            'label' => apply_filters( 'yit_vatssn_label', __('VAT', 'yit') )
        );
        $fields['ssn'] = array(
            'label' => apply_filters( 'yit_ssn_label', __('SSN', 'yit') )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_data' );
    function woocommerce_add_var_load_order_data( $fields ) {
        $fields['billing_vat'] = '';
        $fields['shipping_vat'] = '';
        $fields['billing_ssn'] = '';
        $fields['shipping_ssn'] = '';
        return $fields;
    }



} elseif( yit_get_option('shop-customer-vat' ) ) {
	add_filter( 'woocommerce_billing_fields' , 'woocommerce_add_billing_fields' );
	function woocommerce_add_billing_fields( $fields ) {
		$fields['billing_company']['class'] = array('form-row-first');
		$fields['billing_company']['clear'] = false;
        //$fields['billing_country']['clear'] = true;
		$field = array('billing_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT/SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT or SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');
		return $fields;
	} 
	
	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_add_shipping_fields' );
	function woocommerce_add_shipping_fields( $fields ) {
		$fields['shipping_company']['class'] = array('form-row-first');
		$fields['shipping_company']['clear'] = false;
        //$fields['shipping_country']['clear'] = true;
		$field = array('shipping_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT/SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT or SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');
		return $fields;
	}

    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    function woocommerce_add_billing_shipping_fields_admin( $fields ) {
        $fields['vat'] = array(
            'label' => apply_filters( 'yit_vatssn_label', __('VAT/SSN', 'yit') )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_data' );
    function woocommerce_add_var_load_order_data( $fields ) {
        $fields['billing_vat'] = '';
        $fields['shipping_vat'] = '';
        return $fields;
    }
}    
elseif( yit_get_option('shop-customer-ssn' ) ) {
	add_filter( 'woocommerce_billing_fields' , 'woocommerce_add_billing_ssn_fields' );
	function woocommerce_add_billing_ssn_fields( $fields ) {
		$fields['billing_company']['class'] = array('form-row-first');
		$fields['billing_company']['clear'] = false;	
		$field = array('billing_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');
		return $fields;
	} 
	
	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_add_shipping_ssn_fields' );
	function woocommerce_add_shipping_ssn_fields( $fields ) {
		$fields['shipping_company']['class'] = array('form-row-first');
		$fields['shipping_company']['clear'] = false;	
		$field = array('shipping_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');
		return $fields;
	} 
    
    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_ssn_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_ssn_fields_admin' );
    function woocommerce_add_billing_shipping_ssn_fields_admin( $fields ) {
        $fields['ssn'] = array(
    		'label' => apply_filters( 'yit_ssn_label', __('SSN', 'yit') )
  		);
        
        return $fields;
    }
    
    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_ssn_data' );
    function woocommerce_add_var_load_order_ssn_data( $fields ) {
        $fields['billing_ssn'] = '';
        $fields['shipping_ssn'] = '';
        return $fields;
    }
}
// custom field for two different layout
add_image_size( 'shop_catalog_3cols', 258, 180, true );
add_image_size( 'shop_catalog_5cols', 158, 158, true );    

function yit_change_shop_image_size_init() {
    if ( ! function_exists( 'is_shop' ) || ! function_exists( 'is_product_category' ) || ! function_exists( 'is_product_tag' ) ) return;

    global $post, $_wp_additional_image_sizes, $yit_live_post_id;

    if ( is_shop() || is_product_category() || is_product_tag() )
        $yit_live_post_id = woocommerce_get_page_id( 'shop' );
    else if ( isset( $post->ID ) )
        $yit_live_post_id = $post->ID;
    else
        $yit_live_post_id = 0;

    $post_id = $yit_live_post_id;

    if ( $post_id == 0 ) return;

    $postmeta = get_post_meta( $post_id, 'shop_layout', true );
    $new_size = yit_get_model('image')->get_size( "shop_catalog_$postmeta" );

    if ( empty( $new_size ) ) return;

    $new_width  = $new_size['width'];
    $new_height = $new_size['height'];
    $crop       = $new_size['crop'];

    yit_get_model('image')->set_size( 'shop_catalog', array( $new_width, $new_height, $crop ) );

    add_filter( 'woocommerce_get_image_size_shop_catalog', create_function( '', "return array( 'width' => $new_width, 'height' => $new_height, 'crop' => true );" ) );
    add_filter( 'post_thumbnail_size', 'yit_change_shop_image_size' );
}
add_action( 'wp_head', 'yit_change_shop_image_size_init', 1 );

function yit_change_shop_image_size( $size ) {
    global $post, $yit_live_post_id;
    
    $post_id = $yit_live_post_id;
                                            
    if ( !( $size == 'shop_catalog' && $post_id != 0 ) ) return $size;
    
    $postmeta = get_post_meta( $post_id, 'shop_layout', true );
    if ( ! empty( $postmeta ) && in_array( $postmeta, array( '3cols', '5cols' ) ) ) {
        $size .= '_' . $postmeta;    
    }   
    
    return $size;
}



/* is image responsive enabled? */
function yit_print_image_responsive_enabled_variables() {
?>
<script type="text/javascript">
var elastislide_defaults = {
	imageW: <?php echo get_option('woocommerce_responsive_images') == 'no' || ! get_option('woocommerce_responsive_images') ? yit_shop_small_w() + 10 + 2 : '"100%"'; ?>,
	border		: 0,
	margin      : 0,
	preventDefaultEvents: false,
	infinite : true,
	slideshowSpeed : 3500
};
</script>
<?php
}
add_action( 'wp_head', 'yit_print_image_responsive_enabled_variables', 1 );
add_action( 'yit_after_import', create_function( '', 'update_option("woocommerce_responsive_images", "yes");' ) );

/**
 * Add default images dimensions to woocommerce options
 * 
 */
function yit_woocommerce_default_image_dimensions() {
	$field = 'yit_woocommerce_image_dimensions_' . get_template();
	
	if( get_option($field) == false ) {
		update_option($field, time());
		
		update_option( 'woocommerce_thumbnail_image_width', '90' );
		update_option( 'woocommerce_thumbnail_image_height', '90' );
		update_option( 'woocommerce_single_image_width', '470' );
		update_option( 'woocommerce_single_image_height', '365' ); 
		update_option( 'woocommerce_catalog_image_width', '258' );
		update_option( 'woocommerce_catalog_image_height', '180' );
		update_option( 'woocommerce_magnifier_image_width', '940' );
		update_option( 'woocommerce_magnifier_image_height', '730' );
		update_option( 'woocommerce_featured_products_slider_image_width', '160' );
		update_option( 'woocommerce_featured_products_slider_image_height', '124' );
		
		update_option( 'woocommerce_thumbnail_image_crop', 1 );
		update_option( 'woocommerce_single_image_crop', 1 ); 
		update_option( 'woocommerce_catalog_image_crop', 1 );
		update_option( 'woocommerce_magnifier_image_crop', 1 );
		update_option( 'woocommerce_featured_products_slider_image_crop', 1 );
		
		//woocommerce 2.0
		update_option( 'shop_thumbnail_image_size', array( 'width' => 90, 'height' => 90, 'crop' => true ) );
		update_option( 'shop_single_image_size', array( 'width' => 470, 'height' => 365, 'crop' => true ) ); 
		update_option( 'shop_catalog_image_size', array( 'width' => 258, 'height' => 180, 'crop' => true ) );
		update_option( 'woocommerce_magnifier_image', array( 'width' => 940, 'height' => 730, 'crop' => true ) );
		update_option( 'woocommerce_featured_products_slider_image', array( 'width' => 160, 'height' => 124, 'crop' => true ) );
	}
}

/**
 * Update woocommerce options after update from 1.6 to 2.0
 */
function yit_woocommerce_update() {
	global $woocommerce; 
	
	$field = 'yit_woocommerce_update_' . get_template();
	
	if( get_option($field) == false && version_compare($woocommerce->version,"2.0.0",'>=') ) {
		update_option($field, time());

		//woocommerce 2.0
		update_option( 
			'shop_thumbnail_image_size', 
			array( 
				'width' => get_option('woocommerce_thumbnail_image_width', 90), 
				'height' => get_option('woocommerce_thumbnail_image_height', 90),
				'crop' => get_option('woocommerce_thumbnail_image_crop', 1)
			)
		);
		
		update_option( 
			'shop_single_image_size', 
			array( 
				'width' => get_option('woocommerce_single_image_width', 300 ),
				'height' => get_option('woocommerce_single_image_height', 300 ),
				'crop' => get_option('woocommerce_single_image_crop', 1)
			) 
		); 
		
		update_option( 
			'shop_catalog_image_size', 
			array( 
				'width' => get_option('woocommerce_catalog_image_width', 150 ),
				'height' => get_option('woocommerce_catalog_image_height', 150 ),
				'crop' => get_option('woocommerce_catalog_image_crop', 1)
			) 
		);
		
		update_option( 
			'woocommerce_magnifier_image', 
			array( 
				'width' => get_option('woocommerce_magnifier_image_width', 600 ),
				'height' => get_option('woocommerce_magnifier_image_height', 600 ),
				'crop' => get_option('woocommerce_magnifier_image_crop', 1)
			) 
		);
		
		update_option( 
			'woocommerce_featured_products_slider_image', 
			array( 
				'width' => get_option('woocommerce_featured_products_slider_image_width', 160 ),
				'height' => get_option('woocommerce_featured_products_slider_image_height', 124 ),
				'crop' => get_option('woocommerce_featured_products_slider_image_crop', 1)
			) 
		);
	}
}

/**
 * Backup woocoomerce options when create the export gz
 *
 */
function yit_save_woocommerce_tables( $tables ) {
    $tables[] = 'woocommerce_termmeta';
    $tables[] = 'woocommerce_attribute_taxonomies';
    return $tables;
}

/**
 * Backup woocoomerce options when create the export gz
 *
 */
function yit_save_woocommerce_options( $options ) {
    $options[] = 'woocommerce\_%';
    $options[] = '_wc_needs_pages';
    return $options;
}

/**
 * Backup woocoomerce wishlist when create the export gz
 *
 */
function yit_save_wishlist_options( $options ) {
    $options[] = 'yith\_wcwl\_%';
    $options[] = 'yith-wcwl-%';
    return $options;
}

/**
 * Backup options of plugins when create the export gz
 *
 */
function yit_add_plugins_options( $options ) {
    $options[] = 'yith_woocompare_%';
    $options[] = 'yith_wcmg_%';

    return $options;
}

add_action('woocommerce_after_checkout_form', 'woocommerce_braintree_compatibility');
function woocommerce_braintree_compatibility(){

    ?>
    <script type='text/javascript' charset='utf-8'>
        jQuery(document).ready(function($){
            if( typeof  Braintree !== 'undefined' ){
                var braintree = Braintree.create( braintree_params.cse_key );
            }

            // Perform validation on the card info entered and encrypt the card info when successful
            function validateCardData( $form ) {

                var savedCardSelected = $( 'input[name=braintree-cc-token]:radio' ).filter( ':checked' ).val();

                // don't validate fields or encrypt data if a saved card is being used
                if ( 'undefined' !== typeof savedCardSelected && '' !== savedCardSelected ) {
                    return true;
                }

                var errors = [];

                var cardNumber = $( '#braintree-cc-number' ).val();
                var cvv        = $( '#braintree-cc-cvv' ).val();
                var expMonth   = $( '#braintree-cc-exp-month' ).val();
                var expYear    = $( '#braintree-cc-exp-year' ).val();

                // replace any dashes or spaces in the card number
                cardNumber = cardNumber.replace( /-|\s/g, '' );

                // validate card number
                if ( ! cardNumber ) {

                    errors.push( braintree_params.card_number_missing );

                } else if ( cardNumber.length < 12 || cardNumber.length > 19 || /\D/.test( cardNumber ) || ! luhnCheck( cardNumber ) ) {

                    errors.push( braintree_params.card_number_invalid );
                }

                // validate expiration date
                var currentYear = new Date().getFullYear();
                if ( /\D/.test( expMonth ) || /\D/.test( expYear ) ||
                    expMonth > 12 ||
                    expMonth < 1 ||
                    expYear < currentYear ||
                    expYear > currentYear + 20 ) {
                    errors.push( braintree_params.card_exp_date_invalid );
                }

                // validate CVV if present
                if ( 'undefined' !== typeof cvv ) {

                    if ( ! cvv ) {
                        errors.push( braintree_params.cvv_missing );
                    } else if (/\D/.test( cvv ) ) {
                        errors.push( braintree_params.cvv_invalid );
                    } else if ( cvv.length < 3 || cvv.length > 4 ) {
                        errors.push( braintree_params.cvv_length_invalid );
                    }
                }


                if ( errors.length > 0 ) {

                    // hide and remove any previous errors
                    $( '.woocommerce-error, .woocommerce-message' ).remove();

                    // add errors
                    $form.prepend( '<ul class="woocommerce-error"><li>' + errors.join( '</li><li>' ) + '</li></ul>' );

                    // unblock UI
                    $form.removeClass( 'processing' ).unblock();

                    $form.find( '.input-text, select' ).blur();

                    // scroll to top
                    $( 'html, body' ).animate( {
                        scrollTop: ( $form.offset().top - 100 )
                    }, 1000 );

                    return false;

                } else {

                    // get rid of any space/dash characters
                    $( '#braintree-cc-number' ).val( cardNumber );

                    // encrypt the credit card fields
                    braintree.encryptForm( $form );

                    return true;
                }
            }

            // show/hide the credit cards when a saved card is de-selected/selected
            function handleSavedCards() {

                $( 'input[name=braintree-cc-token]:radio' ).change(function () {

                    var savedCreditCardSelected = $( this ).filter( ':checked' ).val(),
                        $newCardSection = $( 'div.braintree-new-card' );

                    // if a saved card is selected, hide the credit card form
                    if ( '' !== savedCreditCardSelected ) {
                        $newCardSection.slideUp( 200 );
                    } else {
                        // otherwise show it so customer can enter new card
                        $newCardSection.slideDown( 200 );
                    }
                } ).change();
            }

            // luhn check
            function luhnCheck( cardNumber ) {
                var sum = 0;
                for ( var i = 0, ix = cardNumber.length; i < ix - 1; i++ ) {
                    var weight = parseInt( cardNumber.substr( ix - ( i + 2 ), 1 ) * ( 2 - ( i % 2 ) ) );
                    sum += weight < 10 ? weight : weight - 9;
                }

                return cardNumber.substr( ix - 1 ) == ( ( 10 - sum % 10 ) % 10 );
            }
            jQuery(document).on('click', '#multistep_steps #order_review input#place_order', function() { return validateCardData( jQuery('form.checkout') ) });

        });
    </script>
<?php
}