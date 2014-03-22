<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product, $price;

if ( ! isset( $price )  ) $price = $product->get_price_html();

if ( empty( $price ) ) return;
$unit_price = get_post_meta( get_the_ID(), '_regular_price', true );
$container_price = get_post_meta( get_the_ID(), '_container_price', true );
$volume_price= ((int)$unit_price * .9);
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<?php if ( current_user_can( 'see_container_price' ) ) { ?>
	<p class="price unit"><span itemprop="price" class="price-label unit">Unit Price: </span><span class="amount"><?php echo '$' . number_format($unit_price, 2); ?></span></p>
  <p class="price volume"><span itemprop="price" class="price-label volume">Volume Price: </span><span class="amount"><?php echo '$' . number_format($volume_price, 2); ?></span></p>
  <p class="price containerz"><span itemprop="price" class="price-label containerz">Container Price: </span><?php if (!empty($container_price)) {?><span class="amount"><?php echo '$' . number_format($container_price, 2); ?></span><?php }else{ echo'<span class="price unit">N/A</span>';}?></p>
  <?php } else {?>      
  <p class="price unit"><span class="price-label unit"></span><span itemprop="price"><a class="price" href="/login-form/">Please Apply to See Price</a></span></p>
  <?php } ?>                                              
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>