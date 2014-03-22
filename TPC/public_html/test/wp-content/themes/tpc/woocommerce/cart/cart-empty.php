<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 $temp_cookie = $_COOKIE['cart_or_container'];
$theword = "cart";
$theword2 = "Cart";

if (isset($temp_cookie) && ($temp_cookie == "container"))
{
$theword = "container";
$theword2 = "Container";
}
?>

<p>Your <?php echo $theword ?> is currently empty.</p>

<?php do_action('woocommerce_cart_is_empty'); ?>

<p><a class="button" href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>"><?php _e('&larr; Return To Shop', 'yit') ?></a></p>