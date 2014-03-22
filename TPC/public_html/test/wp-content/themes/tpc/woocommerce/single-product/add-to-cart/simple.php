<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $product;

if ( ! $product->is_purchasable() && ! $product->is_in_stock() ) {
    // Availability
    $availability = $product->get_availability();

    echo apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] );

    return;
} else if( ! $product->is_purchasable() ) {
    return;
}
?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>

    <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'>

        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <?php
      $xxx=  get_post_meta( get_the_ID(), '_regular_price', true );
        if ( $product->is_in_stock() ) :
            ?>
            <div class="simple-quantity">
                <?php
                // Availability
                $availability = $product->get_availability();

                if ($availability['availability']) {
                   // echo apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] );
                   echo "<p class='stock'>Ships in 2-3 Weeks!</p>";
                } else {
                
                echo "<p class='stock'>Ships in 10-12 Weeks!</p>";
                }

                if ( is_shop_enabled() && !$product->is_sold_individually() ) {

                    $min_value = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
                    $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product );

                    woocommerce_quantity_input( array( 'min_value' => $min_value, 'max_value' => $max_value ) );
                }
                ?>
            </div>
        <?php
        else :
            // Availability
            $availability = $product->get_availability();

           // $x = apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] );
           echo "<p class='stock'>Ships in 8-10 Weeks!</p>";
        endif
        ?>

        <?php if( yit_get_option('shop-detail-show-price') || (is_shop_enabled() && yit_get_option('shop-detail-add-to-cart') ) ): ?>
            <div class="woocommerce-price-and-add group">
                <?php if( yit_get_option('shop-detail-show-price') ): ?>
                    <div class="woocommerce-price"><?php woocommerce_get_template( 'single-product/price.php' ); ?></div>
                <?php endif ?>

                <?php if ( is_shop_enabled() && yit_get_option('shop-detail-add-to-cart') && $product->is_in_stock() && current_user_can( 'see_container_price' )) : ?>
                <?php
                $temp_cookie = isset($_COOKIE['cart_or_container']);
                 if (($temp_cookie) && ($temp_cookie == "container")){
                ?>
                  <div class="woocommerce-add-to-cart cart"><button type="submit" class="single_add_to_cart_button button alt container">Add to Container</button></div>
                <?php
                } 
                elseif (($temp_cookie) && ($temp_cookie == "cart"))
                {
                ?>
                 <div class="woocommerce-add-to-cart cart"><button type="submit" class="single_add_to_cart_button button alt cart">Add to cart</button></div>
                <?php
                }
                else
                {
                ?>
                <div class="woocommerce-add-to-hart cart"><button type="reset" class="eModal-2 single_add_to_gart_button button alt cart">Add to Cart or Container</button></div>
                <?php
                }
								endif;
								global $yith_wcwl, $product;
								if (!isset($product_id) || ( ! $product_id )) {
									$product_id = isset( $product->id ) && $product->exists() ? $product->id : 0;
								}		 
								$url_args = array(
												'action' => 'yith-woocompare-add-product',
												'id' => $product_id
										);
								$html = YITH_WCWL_UI::add_to_wishlist_button( $yith_wcwl->get_wishlist_url(), $product->product_type, $yith_wcwl->is_product_in_wishlist( $product->id ) ); 
								$html .= YITH_WCWL_UI::popup_message();
								echo $html;
								?>
				<a href="<?php echo wp_nonce_url( add_query_arg( $url_args ), 'yith-woocompare-add-product' ) ?>" class="compare button" data-product_id="<?php echo $product_id ?>">Compare</a>
			
		</div>
<?php endif ?>
<?php do_action('woocommerce_after_add_to_cart_button'); ?>
</form>



<?php do_action('woocommerce_after_add_to_cart_form'); ?>