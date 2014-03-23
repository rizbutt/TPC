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
    var a = jQuery("#radio-cart").prop("checked"), b = jQuery("#radio-container").prop("checked"), c = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    a && (jQuery.cookie("cart_or_container", "cart", {path:"/", expires:3}), location.reload(!0));
    b && jQuery.cookie("cart_or_container", "container", {path:"/", expires:3}) && (jQuery.cookie("container_expirations", c, {path:"/", expires:3}), location.reload(!0));
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
  



 var product_cat_dropdown = document.getElementById("dropdown_product_cat");
 function onProductCatChange() {
    if ( product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value ==='' ) {
        location.href = '/shop/'+'?'+query;
    }
    else{
        location.href = '/?product_cat='+product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value+'&'+query;
    }
 }
 product_cat_dropdown.onchange = onProductCatChange;   
 
 
 jQuery('#dropdown_layered_nav_sub-category').change(function(){
    if(jQuery('#') !== '' ){
        location.href = '/?product_cat='+product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value+'&filtering=1&filter_sub-category=' + jQuery('#dropdown_layered_nav_sub-category').val()+'&'+query;
    }
    else{
        location.href = '/?product_cat='+product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value+'&'+query;
    }
    
 }); 
 
 var product_pri_dropdown = document.getElementById("dropdown_product_pri");
 function onProductPriChange() {
    if ( product_pri_dropdown.options[product_pri_dropdown.selectedIndex].value !=="" ) {
        location.href = "/?product_cat="+product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value+'&'+product_pri_dropdown.options[product_pri_dropdown.selectedIndex].value;
    }
    else{
        
    }
 }
 product_pri_dropdown.onchange = onProductPriChange; 
 
 
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