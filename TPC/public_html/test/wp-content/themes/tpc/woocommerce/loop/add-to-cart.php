<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product;                                    

$details = sprintf('<a href="%s" rel="nofollow" title="%s" class="details">%s</a>', get_permalink(), __( 'Details', 'yit' ), __( 'Details', 'yit' ));
if ( ! yit_get_option('shop-view-show-details') )
    { $details = ''; } 

if ( ! is_shop_enabled() || ! yit_get_option('shop-view-show-add-to-cart') || ! $product->is_purchasable() ) 
{
$add_to_cart = ''; 

$out_of_stock = '';
//$label = apply_filters( 'out_of_stock_add_to_cart_text', __( 'Ships in 10-12 weeks.', 'yit' ) );$out_of_stock = sprintf( '<a class="button out-of-stock" title="%s">%s</a>', $label, $label );


} else {

	$add_to_cart = '';
	$temp_cookie = "";
	$temp_cookie = $_COOKIE['cart_or_container'];
                 if (($temp_cookie === "container") &&  current_user_can( 'see_container_price' ))
                 {
										$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
										$label 	= 'Add to Container 123';
										$quantity = apply_filters( 'add_to_cart_quantity', ( get_post_meta( $product->id, 'minimum_allowed_quantity', true ) ? get_post_meta( $product->id, 'minimum_allowed_quantity', true ) : 1 ) );
										$add_to_cart = '<form action="' . esc_url( $product->add_to_cart_url() ) .'" class="cart" method="post" enctype="multipart/form-data"><div class="woocommerce-add-to-cart container"><button type="submit" class="single_add_to_cart_button button alt container">Add to Container</button></div>';
                } 
                elseif (($temp_cookie === "cart") &&  current_user_can( 'see_container_price' ) )
                {
										$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
										$label 	= 'Add to Cart 123';
										$quantity = apply_filters( 'add_to_cart_quantity', ( get_post_meta( $product->id, 'minimum_allowed_quantity', true ) ? get_post_meta( $product->id, 'minimum_allowed_quantity', true ) : 1 ) );
										$add_to_cart = '<form action="' . esc_url( $product->add_to_cart_url() ) .'" class="cart" method="post" enctype="multipart/form-data"><div class="woocommerce-add-to-cart cart"><button type="submit" class="single_add_to_cart_button button alt container">Add to Cart</button></div>';
                 } 
                elseif (!isset($_COOKIE['cart_or_container']) &&  current_user_can( 'see_container_price' ) )
                {
                ?>
										<style>
										#header-sidebar .widget_shopping_cart {
										display: none !important;
										}
										div.summary.entry-summary>form>div.woocommerce-price-and-add.group>div.yith-wcwl-add-to-wishlist>div.yith-wcwl-add-button>a, div.row>div.summary.entry-summary>form>div.woocommerce-price-and-add.group>a{
										display:none;
										}
										</style>
<?php
															
											$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
											$label 	= apply_filters( 'add_to_cart_text', __('Cart or Container', 'yit') );
											$quantity = apply_filters( 'add_to_cart_quantity', ( get_post_meta( $product->id, 'minimum_allowed_quantity', true ) ? get_post_meta( $product->id, 'minimum_allowed_quantity', true ) : 1 ) );
											$add_to_cart = sprintf('<form action="/" class="cart" method="post" enctype="multipart/form-data"><div class="woocommerce-add-to-hart cart"><button type="reset" class="eModal-2 single_add_to_gart_button button altt cart">Add to Cart or Container</button></div>');
											

  
                 } 
                else
                {
										$add_to_cart="";
 }
 }
  if ( ! empty( $add_to_cart ) || ! empty( $details ) ) : ?>
<div class="product-actions">   
<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'> 
    <?php echo $details; ?>
    <?php echo $add_to_cart; ?>
    <?php if (isset($out_of_stock) && $out_of_stock != '') : echo $out_of_stock; endif ?>
    </form>
</div>
<?php endif; ?>