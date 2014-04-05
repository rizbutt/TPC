<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
//STANDARD 20 FT	5.9 X 2.35 X 2.393 Mt	33.2 = 560cm x 223cm x 227cm = 29.88
// 	STANDARD 40 FT	12.036 X 2.35 X 2.392 Mt	67.7 = 60.93
// 	HIGH CUBE 40 FT	12.036 X 2.35 X 2.697 Mt	76.3 = 68.67

//high cube 40 - 1204cm x 235cm x 270cm or 90% - 1084 x 212 x 243 = 55.8
global $woocommerce;



?>

<?php $woocommerce->show_messages(); ?>

<form id="cart-table" action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">
<?php do_action( 'woocommerce_before_cart_table' );
$temp_cookie = $_COOKIE['cart_or_container'];
 if (isset($temp_cookie) && ($temp_cookie == "container")){
?>
  <div class="cinventory"><span class="ccinventory">CONTAINER INVENTORY</span></div>
  
  <?php
  $text_c = "Update Container";
} 
elseif (isset($temp_cookie) && ($temp_cookie == "cart"))
{
?>
 <div class="cinventory"><span class="ccinventory">SHOPPING CART</span></div>
<?php
$text_c = "Update Cart";
//$cart_container_price = 
}
?>      


<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>

			<th class="product-name"><?php _e('Name', 'yit'); ?></th>
			<th class="product-quantity">&nbsp;</th>
			<th class="product-subtotal quantoid"><?php _e('Quantity', 'yit'); ?></th>
			<?php if (isset($temp_cookie) && ($temp_cookie == "container")){ ?><th class="product-subtotal hours_left"><?php _e('Hours Left', 'yit'); ?></th><?php } ?>
			<?php if (isset($temp_cookie) && ($temp_cookie == "container")){ ?><th class="product-subtotal cbm_cbm"><?php _e('CBM', 'yit'); ?></th><?php } ?>
			<th class="product-subtotal preiceoid"><?php _e('Price', 'yit'); ?></th>
<th>&nbsp;</th>
<th>&nbsp;</th>

		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		$security_code = "nocode";
		$container_price_item_quantity = 0;
		$container_price_all_total = 0;
		$meter3_item_quantity = 0;
		$finalmeters = 0;
		$meter3_all_quantity = 0;
		$container_price = 0;
		$str_array = "";
		$iii = 0;
		$tweight = 1;
		$meter3_item  = 0;
		$quantity_item = 0;
		$master_quantity = 0;
		$data = array('api_key'=>'dd3cd3f7dd614cfe21793c9be8843fe8',
        	 'include_images'=>1,
        	 'response'=>'json',
        	 'bin'=>array('w'=>220, 'h'=>233, 'd'=>1098,'wg'=>21600)
        	 );
     
     
     
        	 
       if (isset($_COOKIE['container_expirations'])) {$security_code = $_COOKIE['container_expirations'];}
			$array_expirations = array();
			$array_expirations = get_expiration_array($security_code);
//var_dump($array_expirations);
		if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
			foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];
				//var_dump($_product);

				if ( $_product->exists() && $values['quantity'] > 0 ) {

            		$twidth =  get_post_meta($product_id, '_width', true);
			$tlength = get_post_meta($product_id, '_length', true);
			$theight = get_post_meta($product_id, '_height', true);
			if (!is_numeric($twidth) || (!isset($twidth)) || ($twidth <= 0))
			{
				$twidth = 17.7;
			}
			if (!is_numeric($tlength) || (!isset($tlength)) || ($tlength <= 0))
			{
				$tlength = 17.7;
			}
			if (!is_numeric($theight) || (!isset($theight)) || ($theight <= 0))
			{
				$theight = 17.7;
			}
                       	$twidth *= 2.54;
			$tlength *= 2.54;
			$theight *= 2.54;
            $meter3_item = $tlength * $twidth * $theight;
						$meter3_item = ($meter3_item / 1000000);
						$meter3_item = number_format((float)$meter3_item, 2, '.', '');



						?>
					<tr class = "<?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $values, $cart_item_key ) ); ?>">


						<!-- Product Name -->
						<td class="product-name">
							<?php
								if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
									echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
								else
									printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );

								// Meta data
								echo $woocommerce->cart->get_item_data( $values );

                // Backorder notification
                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
                echo '<p class="backorder_notification">' . __('Ships in 8-10 weeks', 'yit') . '</p>';
							?>
						</td>

						<!-- Product price -->
						<td class="product-thumbnail">
<?php
								$thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );

								if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
									echo $thumbnail;
								else
									printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail );
							?>
						</td>

						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {

									$step	= apply_filters( 'woocommerce_quantity_input_step', '1', $_product );
									$min 	= apply_filters( 'woocommerce_quantity_input_min', '', $_product );
									$max 	= apply_filters( 'woocommerce_quantity_input_max', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), $_product );

									$product_quantity = sprintf( '<div class="quantity"><input type="number" name="cart[%s][qty]" step="%s" min="%s" max="%s" value="%s" size="4" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="input-text qty text" maxlength="12" /></div>', $cart_item_key, $step, $min, $max, esc_attr( $values['quantity'] ) );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
								$quantity_item = 0;
								$quantity_item = esc_attr( $values['quantity'] );
							?>
						</td>
					<?php
					if (isset($temp_cookie) && ($temp_cookie == "container")){
					?>
											<td class="product-subtotal timediff">
						<span class="ccinventory">
					<?php 
							if ($array_expirations['full'] === 1 && isset($array_expirations[$_product->id]) )
							{
									$date_db = date_create_from_format('Y-m-d H:i:s', $array_expirations[$_product->id]);
									$today_dt = new DateTime();
									$today_dt = $today_dt->format('Y-m-d H:i:s');
									$today_dt  = date_create_from_format('Y-m-d H:i:s', $today_dt );
									$interval = $today_dt->diff($date_db);
									$ddays =  (int)$interval->format('%d'); 
									$hhours = (int)$interval->format('%h'); 
									$hhours += 7;
							} else {
									$ddays = 0;
									$hhours = rand(20, 35);
							}
							echo (($ddays * 24) + $hhours);
					?></span>
						</td>
						<td class="product-subtotal cubm3">
						
						<?php 
						$container_price =	get_post_meta( $_product->id, '_container_price', true );
						$container_price_item_quantity = $container_price * $quantity_item;
						$container_price_item_quantity = number_format((float)$container_price_item_quantity, 2, '.', '');
						$meter3_item_quantity = $meter3_item * $quantity_item;
						$meter3_item_quantity = number_format((float)$meter3_item_quantity, 2, '.', '');
						$master_quantity += $quantity_item;
		           			$meter3_all_quantity += $meter3_item_quantity;
         					$container_price_all_total += $container_price_item_quantity;
						echo $meter3_item ;
						?>
						</td>
<?php
} 
?>  					
						<td class="product-subtotal subtt">
							<?php 
							if (isset($temp_cookie) && ($temp_cookie == "container"))
							{
									$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
									echo "$".apply_filters('woocommerce_cart_item_price_html', number_format((float)$container_price, 2, '.', ''), $values, $cart_item_key );
							} elseif (isset($temp_cookie) && ($temp_cookie == "cart"))
							{
									$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
									echo "$".apply_filters('woocommerce_cart_item_price_html', number_format((float)$product_price, 2, '.', ''), $values, $cart_item_key );
							}
							?>
						</td>
<!-- Remove from cart link -->
						<td class="product-remove"><?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s&pid=%s&sid=%s" class="button" title="%s">Remove &nbsp; &times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), $_product->id, $security_code, __('Remove this item', 'yit') ), $cart_item_key );
							?></td>
						<td class="product-update"><input type="submit" class="button" name="update_cart" value="<?php echo $text_c; ?>" /></td>
					</tr>
					<?php
if ((isset($temp_cookie)) && ($temp_cookie == "container")){
            $str_array[] = array('w'=>$twidth,'h'=>$theight,'d'=>$tlength,'wg'=>$tweight,'q'=>$quantity_item);
            $data['box'][$iii] =array('w'=>$twidth,'h'=>$theight,'d'=>$tlength,'wg'=>$tweight,'q'=>$quantity_item);
            $iii++;
}
				}
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">


				<?php  do_action('woocommerce_proceed_to_checkout'); ?>

				<?php $woocommerce->nonce_field('cart') ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>
<?php do_action( 'woocommerce_after_cart_table' ); ?>

<div class="cart-collaterals row-fluid">
	<input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e('Proceed to Checkout &rarr;', 'yit'); ?>" />
	</form>

<?php
//echo $master_quantity;
if (isset($temp_cookie) && ($temp_cookie == "container") && ($master_quantity <= 60))
{
echo" <div class='container_wrapper'>";
 
    $url_query = http_build_query($data, '', '&');
    $ch = curl_init('http://3dbinpacking.com/request/api/pack');
    curl_setopt($ch, CURLOPT_POST, true); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $url_query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($ch);
    curl_close($ch);
    $resp = json_decode($resp);
  //  var_dump($resp);
    if (1 == $resp->status)
    {
        if (1 == $resp->response->packed)
        {
           // echo 'Boxes packed';
            $ii = 0;
           // echo '<br/>'.$resp->response->remaining_space_percentage . ' of container remaining empty<br/>';
          //  echo $resp->response->used_space_percentage . ' of container has been filled up<br/>';
            $total_iterations = count($resp->response->images);
            foreach($resp->response->images as $img)
            {
              $ii++;
              if ($ii === $total_iterations)
              {
									echo '<div class="container_image_wrapper">';
                  echo '<img class="container_image" style="width:400px;height:auto;" src="data:image/png;base64,'.$img.'"><br>';
                  echo '</div>';
              }
            } 
        } else {
            //echo 'Timeout failure.';
         //   echo '<br/>11.3% of container remaining empty<br/>';
         //   echo '88.7% of container has been filled up<br/>';
        }
    } else {
        echo "Errors occured: ";
        echo implode(',',$resp->errors);
    }

}
if (isset($temp_cookie) && ($temp_cookie == "container"))
{
?>
<div id="container40" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

	
<script type="text/javascript">
jQuery(function () {
	
    jQuery('#container40').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: true
	    },
	    
	    title: {
	        text: '40 Foot Container Capacity'
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 67,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'Cubic Meters'
	        },
	        plotBands: [{
	            from: 0,
	            to: 50,
	            color: '#DF5353' // red
	        }, {
	            from: 50,
	            to: 63,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 63,
	            to: 67,
	            color: '#55BF3B' // green
	        }]        
	    },
	
	    series: [{
	        name: 'Capacity Filled: ',
	        data: [<?php echo number_format((float)$meter3_all_quantity, 2, '.', '');  ?>],
	        tooltip: {
	            valueSuffix: 'CBM / 67CBM'
	        }
	    }]
	
	}, 
	// Add some life
	function (chart) {
		if (!chart.renderer.forExport) {
		    setInterval(function () {
		        var point = chart.series[0].points[0],
		            newVal,
		            inc = Math.round((Math.random() - 0.5) * 1);
		        
		        newVal = point.y + inc;
		        if (newVal < 0 || newVal > 67) {
		            newVal = point.y - inc;
		        }
		        
		        point.update(newVal);
		        
		    }, 3000);
		}
	});
});
</script>
<?php

}
if (isset($temp_cookie) && ($temp_cookie == "container") && ($master_quantity <= 60)) echo '</div>';
?>

	<div class="span6 cart_totals ">
		<?php
if (isset($temp_cookie) && ($temp_cookie == "container")){
$container_price_all_total_half = ( $container_price_all_total / 2 );
		$container_price_all_total_half = number_format((float)$container_price_all_total_half , 2, '.', '');
		$cont_array = array();
		$cont_array = what_size_container($meter3_all_quantity);
		//$contarray[0] 
$prefix_ct = "Container";
$perc_cont = ($meter3_all_quantity / 65) * 100;
}elseif (isset($temp_cookie) && ($temp_cookie == "cart")){
$prefix_ct = "Cart";
}
?>            
		<h2><?php echo $prefix_ct." Stats & Totals" ?></h2>
		<table align="right" cellspacing="0" cellpadding="0">
			<tbody>	
			
			<?php if (isset($temp_cookie) && ($temp_cookie == "container")){ ?>
<tr class="cart-subtotal cbmer">
		
					<th><strong>CBM Used</strong></th>
						
					<td><strong><span class="amount"><?php echo number_format((float)$meter3_all_quantity, 2, '.', '');  ?> out of 67 CBM</span></strong></td>
	
		</tr>
		<tr class="cart-subtotal percenter">
		
					<th><strong>Percentage Used:</strong></th>
			
					<td><strong><span class="amount"><?php echo number_format((float)$perc_cont, 2, '.', '') ?>% Filled</span></strong></td>
				
		</tr>	<?php }  ?>
			<tr class="cart-subtotal pricer">
		
					
							<?php if (isset($temp_cookie) && ($temp_cookie == "container")){ ?>
							<th><strong><?php echo $prefix_ct . " Total" ?></strong></th>
					<td><strong><span class="amount"><?php echo woocommerce_price($container_price_all_total);  ?></span></strong></td>
					<?php } else {  ?>
					<th><strong><?php echo $prefix_ct . " Total" ?></strong></th>
					<td><strong><?php echo $woocommerce->cart->get_cart_subtotal(); ?></strong></td>
					<?php } ?>
		</tr>
	<tr class="total">
					
					<?php if (isset($temp_cookie) && ($temp_cookie == "container")){ ?>
					<th><strong><?php _e('Pay Now', 'yit'); ?></strong></th>
					<td>
						<strong><span class="amount"><?php echo woocommerce_price($container_price_all_total_half);  ?></span></strong> (50% Deposit)

					</td>
					<?php } else {  ?>
					<th><strong><?php _e('Order Total', 'yit'); ?></strong></th>
						<td>
						<strong><?php echo $woocommerce->cart->get_total(); ?></strong>
					
					</td>
					
					<?php }  ?>
				</tr>
		</tbody>
		</table>


				<?php  do_action('woocommerce_proceed_to_checkout'); ?>

				<?php $woocommerce->nonce_field('cart') ?>
				<?php if (isset($temp_cookie) && ($temp_cookie == "container")){ ?>
<div class="small">To qualify for free shipping, your container must be 100% full.<br>A shipping charge of $10,000 is added to all containers less than 100% full.</div>
</div>
			<?php }  ?>