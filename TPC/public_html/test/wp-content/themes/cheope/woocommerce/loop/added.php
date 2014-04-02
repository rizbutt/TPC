<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product;

        $temp_cookie = isset($_COOKIE['cart_or_container']);
        $cartcontainerstring = 'container or cart';
        if (($temp_cookie) && ($temp_cookie == "container")){        
            $cartcontainerstring = 'container';
        }
        if (($temp_cookie) && ($temp_cookie == "cart")){  
            $cartcontainerstring = 'cart';
        }
?>

<a class="added button alt cart" href="<?php echo get_permalink(woocommerce_get_page_id('cart')) ?>" title="<?php _e( 'View '.ucwords($cartcontainerstring), 'yit' ) ?>"><?php echo apply_filters( 'yit_added_to_cart_text', __( 'ADDED', 'yit' ) ) ?></a>