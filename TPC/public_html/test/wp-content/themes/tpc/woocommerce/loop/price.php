<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product;
$unit_price = get_post_meta( get_the_ID(), '_regular_price', true );
$container_price = get_post_meta( get_the_ID(), '_container_price', true );
$volume_price= ((int)$unit_price * .9);
?>

<?php if (($price_html = $product->get_price_html()) && ( current_user_can( 'see_container_price' ) )) { ?>
	<span class="price unit"><span class="amount punit">Unit Price:</span> <?php if (!empty($unit_price)) {?><span class="amount"><?php echo '$' . number_format($unit_price, 2); ?></span><?php }else{ echo'<span class="price unit">N/A</span>';}?></span>
	
	<span class="price unit container"><span class="amount pcontainer">Container Price:</span> <?php if (!empty($container_price)) {?><span class="amount"><?php echo '$' . number_format($container_price, 2); ?></span><?php }else{ echo'<span class="price container">N/A</span>';}?></span>
	
	<a class="read-more" href="<?php the_permalink() ?>"><?php echo apply_filters( 'yit_shop_loop_read_more_text', __( 'Read More', 'yit' ) ) ?></a>
<?php }else{ ?>
<span class="price"><a class="price" href="/login-form/">Please Apply to See Price</a></span>
	

<?php } ?>
