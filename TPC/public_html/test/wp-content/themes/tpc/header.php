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

//Add body classes
$body_classes = 'no_js';
if( ( yit_get_option( 'responsive-enabled' ) && !$GLOBALS['is_IE'] ) || ( yit_get_option( 'responsive-enabled' ) && yit_ie_version() >= 9 ) ) 
{
    $body_classes .= ' responsive';
}

$body_classes .= ' ' . yit_get_option( 'layout-type' );

if (isset($_GET['added-to-cart']) || isset($_POST['added-to-cart']))
{
		if (isset($_COOKIE['container_expirations']))
		{
					$master_id = $_COOKIE['container_expirations'];
					$item_id = isset($_GET['added-to-cart']) ? $_GET['added-to-cart'] : $_POST['added-to-cart'];
					insert_woo_cart_timer($master_id, $item_id);
		}
}
?>

<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" class="ie"<?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 7]>
<html id="ie7"  class="ie"<?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 8]>
<html id="ie8"  class="ie"<?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 9]>
<html id="ie9"  class="ie"<?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->

<!-- This doesn't work but i prefer to leave it here... maybe in the future the MS will support it... i hope... -->
<!--[if IE 10]>
<html id="ie10"  class="ie"<?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->

<!--[if gt IE 9]>
<html class="ie"<?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->

<![if !IE]>
<html <?php language_attributes() ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]>

<!-- START HEAD -->
<head>
    <?php do_action( 'yit_head' ) ?> 
    <?php wp_head() ?>
    <style>

    
    </style>
 <script type="text/javascript">
/* <![CDATA[ */
var urlParams;
var query;
var newQuery = '';
(window.onpopstate = function () {
    var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); };
    
    query  = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query))
       urlParams[decode(match[1])] = decode(match[2]);
})();



function getNewQuery(paramToExclude1, paramToExclude2, paramToExclude3, paramToExclude4, paramToExclude5, paramToExclude6){
    paramToExclude2 = typeof paramToExclude2 !== 'undefined' ? paramToExclude2 : '';
    paramToExclude3 = typeof paramToExclude3 !== 'undefined' ? paramToExclude3 : '';
    paramToExclude4 = typeof paramToExclude4 !== 'undefined' ? paramToExclude4 : '';
    paramToExclude5 = typeof paramToExclude5 !== 'undefined' ? paramToExclude5 : '';
    paramToExclude6 = typeof paramToExclude6 !== 'undefined' ? paramToExclude6 : '';
    
    var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); };
    
    query  = window.location.search.substring(1);
    newQuery = '';
    while (match = search.exec(query)){
        if( paramToExclude1 !== '' && paramToExclude2 !== ''){
            if( decode(match[1]) !== paramToExclude1 && decode(match[1]) !== paramToExclude2 ){
                if( newQuery == ''){
                    newQuery = decode(match[1]) + '=' + decode(match[2]);  
                }
                else{
                    newQuery = newQuery + '&' + decode(match[1]) + '=' + decode(match[2]);  
                }

            }               
        }
        else if( paramToExclude1 !== '' ){
            if( decode(match[1]) !== paramToExclude1 ){
                if( newQuery == ''){
                    newQuery = decode(match[1]) + '=' + decode(match[2]);  
                }
                else{
                    newQuery = newQuery + '&' + decode(match[1]) + '=' + decode(match[2]);  
                }

            }             
        }
        
        
    
    }
       
}


function submitDimensionSearch(){
    getNewQuery('length', 'pre_length', 'depth', 'pre_depth', 'height', 'pre_height' );
    
    
    if ( jQuery('#length').val() !== "" && jQuery('#depth').val() !== "" && jQuery('#height').val() !== "" ) {
        location.href = '?filtering=1&length='+jQuery('#length').val()+'&pre_length='+jQuery('#pre_length').val()+'&depth='+jQuery('#depth').val()+'&pre_depth='+jQuery('#pre_depth').val()+'&height='+jQuery('#height').val()+'&pre_height='+jQuery('#pre_height').val()+'&'+newQuery;
    }
    else{
        location.href = '?'+newQuery;
    }    
    
    //cancelDimensionSearch();
}

jQuery(document).ready(function() {
  jQuery(".cb-enable-container").on("click touchstart", function() {
    jQuery("#radio-container").prop("checked", !0);
    jQuery("#radio-cart").prop("checked", 0);
    var a = jQuery(this).parents(".switch-panel");
    jQuery(".cb-disable-cart", a).removeClass("selected");
    jQuery(this).addClass("selected");
  });
  jQuery(".cb-disable-cart").on("click touchstart", function() {
    jQuery("#radio-cart").prop("checked", !0);
    jQuery("#radio-container").prop("checked", 0);
    var a = jQuery(this).parents(".switch-panel");
    jQuery(".cb-enable-container", a).removeClass("selected");
    jQuery(this).addClass("selected");
  });
  jQuery("#zimbo").on("click touchstart", function() {
    var a = jQuery("#radio-cart").prop("checked");
    var b = jQuery("#radio-container").prop("checked");
    var c = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    a && (jQuery.cookie("cart_or_container", "cart", {path:"/", expires:3}), location.reload(!0));
    if( b ){
        jQuery.cookie("cart_or_container", "container", {path:"/", expires:3});
        jQuery.cookie("container_expirations", c, {path:"/", expires:3});
        location.reload(!0);
    };
  });
  
  jQuery(window).bind("load", function() {
    jQuery("#cart_or_container").prev("input").val("Container");
    jQuery("#cart_or_container").attr("readonly", "readonly");
  });
  
  jQuery('#sidebar-ltl-custom-pricing #product_categories-2 #dropdown_product_cat option:first-child').after('<option value="">All Categories</option>');
  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-5 #dropdown_layered_nav_sub-category option:contains("Any Sub Category")').html('All Sub Categories');
  jQuery('#sidebar-ltl-custom-pricing #price_filter-3 #dropdown_product_pri option:first-child').after('<option value="">All Prices</option>');
  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-7 #dropdown_layered_nav_product-color option:contains("Any Color")').html('All Colors');
  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-8 #dropdown_layered_nav_product-material option:contains("Any Material")').html('All Materials');
  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-6 #dropdown_layered_nav_product-style option:contains("Any Style")').html('All Styles');
  
  //put $ signs
  jQuery('#sidebar-ltl-custom-pricing #price_filter-3 #dropdown_product_pri option:contains("0-250")').html('$0 - $250');
  jQuery('#sidebar-ltl-custom-pricing #price_filter-3 #dropdown_product_pri option:contains("250-500")').html('$250 - $500');
  jQuery('#sidebar-ltl-custom-pricing #price_filter-3 #dropdown_product_pri option:contains("500-750")').html('$500 - $750');
  jQuery('#sidebar-ltl-custom-pricing #price_filter-3 #dropdown_product_pri option:contains("750-1000")').html('$750 - $1000');
  jQuery('#sidebar-ltl-custom-pricing #price_filter-3 #dropdown_product_pri option:contains("1000+")').html('$1000+');
  
  

  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-7 #dropdown_layered_nav_product-color').prepend('<option value="">Select a color</option>');
  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-8 #dropdown_layered_nav_product-material').prepend('<option value="">Select a material</option>');
  jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-6 #dropdown_layered_nav_product-style').prepend('<option value="">Select a style</option>');
    
  if(query === ''){
    jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-7 #dropdown_layered_nav_product-color option:contains("Select a color")').attr('selected', 'selected');
    jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-8 #dropdown_layered_nav_product-material option:contains("Select a material")').attr('selected', 'selected');
    jQuery('#sidebar-ltl-custom-pricing #woocommerce_layered_nav-6 #dropdown_layered_nav_product-style option:contains("Select a style")').attr('selected', 'selected');
  }

 
 jQuery('#dropdown_product_cat').change(function(){
    if ( jQuery('#dropdown_product_cat').val()  === '' ) {
        location.href = '/shop/'+'?'+query;
    }
    else{
        location.href = '/?product_cat='+jQuery('#dropdown_product_cat').val()+'&'+query;
    }
 }); 
 
 
 
 jQuery('#dropdown_layered_nav_sub-category').change(function(){
    if( jQuery('#dropdown_layered_nav_sub-category').val()  !== '' ){
        location.href = '/?product_cat='+jQuery('#dropdown_product_cat').val()+'&filtering=1&filter_sub-category=' + jQuery('#dropdown_layered_nav_sub-category').val()+'&'+query;
    }
    else{
        location.href = '/?product_cat='+jQuery('#dropdown_product_cat').val()+'&'+query;
    }
    
 }); 
 
 
 jQuery('#dropdown_product_pri').change(function(){
    getNewQuery('min_price','max_price');
    
    
    if ( jQuery('#dropdown_product_pri').val() !== "" ) {
        location.href = '?'+jQuery('#dropdown_product_pri').val()+'&'+newQuery;
    }
    else{
        location.href = '?'+newQuery;
    }
 }); 
 
 

 jQuery('#dropdown_layered_nav_product-color').change(function(){
     getNewQuery('filter_product-color');
     if( jQuery('#dropdown_layered_nav_product-color').val() !== '' ){
         location.href = '?filter_product-color=' + jQuery('#dropdown_layered_nav_product-color').val()+'&'+newQuery;
     }
     else{
         location.href = '?'+newQuery;
     }
    
 }); 
 
 //hide add to cart for the related products on the add product page
 jQuery('.related .products .product .product-actions form').hide();
 
 //add a Return to All Products button on the Individual Page  
 if( jQuery('#content-shop div[id^="product-"]').length > 0 ){
     jQuery('#content-shop #page-meta .product-title').append('<a class="btn btn-mini pull-right" href="/shop" style="text-transform: none; font-size: 10px; padding: 3px 15px;">Return to All Products</a>');
 }
     
 if( jQuery('.row .summary .cart .woocommerce-price-and-add .yith-wcwl-add-to-wishlist').length > 0 ){
     jQuery('.cart .woocommerce-price-and-add .yith-wcwl-add-to-wishlist').hide();
 }
 
 if( jQuery('a[href="http://test.thepangaeacollection.com/wishlist/"]').length > 0 ){
     jQuery('a[href="http://test.thepangaeacollection.com/wishlist/"]').hide();
 }
          
if( jQuery('#text-8').length > 0 ){
    jQuery('#text-8').hide();
}

                //add link on menu
        if( jQuery('#cartOrContainerMenuItem').length <= 0 ){
            jQuery('#menu-item-205 #menu-item-123').after('<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-children-0"><a id="cartOrContainerMenuItem" class="eModal-2" href="javascript: void(0);">Shop by Cart or Container</a></li>');         
        }
 
 <?php
 
    $temp_cookie = ($_COOKIE['cart_or_container']);
    //echo '$temp_cookie is '.$temp_cookie;
        $cartcontainerstring = 'container or cart';
        
        //echo '$cartcontainerstring is '.$cartcontainerstring;
        if (isset($temp_cookie) && ($temp_cookie == "container")){        
            $cartcontainerstring = 'container';
?>
            var m = setInterval(function ()
           {
               if ( jQuery('a:contains("View Cart")').length )
               {
                   clearInterval(m);
                   jQuery('a:contains("View Cart")').html('View <?php echo ucwords($cartcontainerstring); ?>  &rarr;');
               }
           }, 25);
           
            var n = setInterval(function ()
           {
               if ( jQuery('.woocommerce-message:contains("Cart updated.")').length )
               {
                   clearInterval(n);
                   jQuery('.woocommerce-message:contains("Cart updated.")').html('<?php echo ucwords($cartcontainerstring); ?> updated.');
               }
           }, 25);           
           
<?php        
        }
        else{        
            $cartcontainerstring = 'cart';
?>
            var m = setInterval(function ()
           {
               if ( jQuery('a:contains("View Container")').length )
               {
                   clearInterval(m);
                   jQuery('a:contains("View Container")').html('View <?php echo ucwords($cartcontainerstring); ?>  &rarr;');
               }
           }, 25);   
           
            var n = setInterval(function ()
           {
               if ( jQuery('.woocommerce-message:contains("Container updated.")').length )
               {
                   clearInterval(n);
                   jQuery('.woocommerce-message:contains("Container updated.")').html('<?php echo ucwords($cartcontainerstring); ?> updated.');
               }
           }, 25);    
           
            var o = setInterval(function ()
           {
               if ( jQuery('.woocommerce-price-and-add button.single_add_to_cart_button:contains("Add to Container")').length )
               {
                   clearInterval(o);
                   jQuery('.woocommerce-price-and-add button.single_add_to_cart_button:contains("Add to Container")').html('Add to <?php echo ucwords($cartcontainerstring); ?>.');
               }
           }, 25);                                     
           
<?php                    
        } 
 ?>

            
});


/* ]]> */
</script>
</head>
<!-- END HEAD -->
<!-- START BODY -->
<body <?php body_class( $body_classes ) ?>>
    
    <!-- START BG SHADOW -->
    <div class="bg-shadow">
    
        <?php do_action( 'yit_before_wrapper' ) ?>
        <!-- START WRAPPER -->
        <div id="wrapper" class="container group">
        	
            <?php do_action( 'yit_before_header' ) ?>
            <!-- START HEADER -->
            <div id="header" class="group">
                <div class="group container">
                	<div class="row">
                		<div class="span12">
	                    <?php
	                    /**
	                     * @see yit_header
	                     */
	                    do_action( 'yit_header' ) ?>
	                    </div>
                    </div>
                </div>
            </div>
            <!-- END HEADER -->
            <?php
            /**
             * @see yit_map
             * @see yit_page_meta
             */
            do_action( 'yit_after_header' ) ?>