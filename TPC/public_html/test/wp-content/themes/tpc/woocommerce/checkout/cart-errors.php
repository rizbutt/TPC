<?php
/**
 * Cart errors page
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
?>

<?php $woocommerce->show_messages(); ?>

<p><?php _e('There are some issues with the items in your '.$theword.' (shown above). Please go back to the '.$theword.' page and resolve these issues before checking out.', 'yit') ?></p>

<?php do_action('woocommerce_cart_has_errors'); ?>

<p><a class="button" href="<?php echo get_permalink(woocommerce_get_page_id('cart')); ?>">&larr; Return To <?php echo $theword2; ?></a></p>