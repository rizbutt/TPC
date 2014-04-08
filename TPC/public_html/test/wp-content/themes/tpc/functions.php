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
add_image_size( 'shop_catalog', 177, 177, false );
add_action( 'woocommerce_product_options_pricing', 'container_product_options_pricing' );
function container_product_options_pricing()
{
	woocommerce_wp_text_input( array( 
		'id' => '_container_price',
		'class' => 'wc_input_container_price short',
		'label' => __( 'Container Price', 'woocommerce' ) . ' ('.get_woocommerce_currency_symbol().')',
		'type' => 'number'
	));
}
require_once( 'class.yith-wcwl-init.php' );
remove_action( 'admin_notices', 'woothemes_updater_notice' );

add_action( 'woocommerce_process_product_meta_simple', 'container_process_product_meta_simple', 10, 1 );
function container_process_product_meta_simple( $product_id )
{
	if( isset($_POST['_container_price']) && $_POST['_container_price'] > 0 )
	{
	update_post_meta( $product_id, '_container_price', $_POST['_container_price'] );
	}
}
/*
add_action( 'woocommerce_checkout_process', 'wc_minimum_meter3_amount' );
function wc_minimum_meter3_amount() {
	global $woocommerce;
	$minimum = 65;
	if ( $woocommerce->cart->get_cart_total(); < $minimum ) {
           $woocommerce->add_error( sprintf( 'You need to have more than %s CBM to fill up the container.' , $minimum ) );
	}
}
*/
add_filter( 'woocommerce_get_price', 'nick_get_price', 10, 2);
function nick_get_price( $price, $product )
{

  

	if( current_user_can('see_container_price'))
	{
			 $temp_cookie = isset($_COOKIE['cart_or_container']) ? $_COOKIE['cart_or_container']: "cart";
      if ( isset($_POST['_container_price']) && (isset($temp_cookie)) && (get_post_meta( $product->id, '_container_price', true ) > 0 ) && ($temp_cookie == "container"))
       {
      // $price = get_post_meta( $product->id, '_container_price', true );
       }
	}
		
return $price;
}



//add_filter('woocommerce_get_price', 'nick_custom_price', 10, 2);
/**
* nick_custom_price
*
* filter the price based on user role
* @param $price
* @param $product
* @return
*/
function nick_custom_price($price, $product) {
  if (!is_user_logged_in())
  {
    return '99';
  }
  //check if the product is in a category you want, let say shirts
  //if(has_term('shirts', 'product_cat' ,$product->ID)) {
  //check if the user has a role of dealer using a helper function, see bellow
  if (nick_has_role_123('wholesale'))
  { //wholesale,volume,container

    $price = $price * 5.9;
  }
//wpcf-container-price
//wpcf-volume-price
return $price;
}
/**
* has_role_WPA111772
*
* function to check if a user has a specific role
*
* @param string $role role to check against
* @param int $user_id user id
* @return boolean
*/
function nick_has_role_123($role = '',$user_id = null){
  if (is_numeric($user_id))
  {
    $user = get_user_by('id',$user_id);
  }
  else
  {
    $user = wp_get_current_user();
  }
  if (empty($user))
  {
    return false;
  }
  echo $user->roles;
return in_array($role, (array)$user->roles);
}

// Instanciation of inherited class


 
    



/**
 * Get the excerpt of a specific post ID or object
 * 
 * @author Pippin Williamson
 * @link http://goo.gl/lhtZD
 * @param object/int $post The ID or object of the post to get the excerpt of
 * @param int $length The length of the excerpt in words
 * @param string $tags The allowed HTML tags. These will not be stripped out
 * @param string $extra Text to append to the end of the excerpt
 */
function iweb_get_excerpt_by_id( $postz_ID ) {
global $post, $woocommerce, $product;
	if ( is_int( $postz_ID ) ) {
		$post = get_post( $postz_ID );
	} elseif( ! is_object( $post ) ) {
		return 'noottt';
	}
	
	if ( has_excerpt( $post->ID ) ) {
		$the_excerpt = $post->post_excerpt;
		return $the_excerpt ;
	} else {
		$the_excerpt = $post->post_content;
	}
	
	//$the_excerpt = strip_shortcodes( strip_tags( $the_excerpt, $tags ) );
	//$the_excerpt = preg_split( '/\b/', $the_excerpt, $length * 2 + 1 );
	//$excerpt_waste = array_pop( $the_excerpt );
	//$the_excerpt = implode( $the_excerpt );
//	$the_excerpt .= $extra;
	
	return $the_excerpt ;
}
add_action('init', 'PDFPrinterz');







function PDFPrinterz()
{
    if (isset($_GET['pdf-generate']) && ($_GET['pdf-generate'] == 1))
    {
     global $post, $woocommerce, $product;
       
 require_once(dirname(__FILE__).'/tcpdf/tcpdf.php');

 $productSKU = $_GET['pSKU'];
        $pstID = $_GET['zID'];
        $show_logo_price = isset($_GET['show_logo_price']) ? 1 : 0;
        $product = get_product( $pstID );
        $the_pricez =  $product->get_price(); 
        $the_width = get_post_meta($pstID, "_width", true); 
        $the_length = get_post_meta($pstID, "_length", true); 
        $the_height = get_post_meta($pstID, '_height', true);
        $pstID = (int)$pstID;
        $excerptz = iweb_get_excerpt_by_id($pstID);

               //  $image   = get_the_post_thumbnail( $postID );
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="thepangaeacollection.pdf"');
header('Content-Transfer-Encoding: binary');
//header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('The Pangaea Collection');
$pdf->SetTitle('Title Stats');
$pdf->SetSubject('Subject Stats');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document



// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
	require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
//$fontname = $pdf->addTTFfont('http://themes.googleusercontent.com/static/fonts/habibi/v3/tN_wdomvOBEGSfusT6BAOA.woff', 'TrueTypeUnicode', '', 32);

// set font
$pdf->SetFont('Helvetica', '', 11);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
      $html = '
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" id="table-pdf">
         <tr>
            <td width="150"></td>
            <td height="50">&nbsp; </td>
            <td width="150"></td>
         </tr>
         <tr>
            <td width="150"></td>
            <td width="350" align="center"><h1>'.get_the_title($pstID).'</h1></td>
            <td width="150"></td>
         </tr>
         <tr>
            <td colspan="3" height="5">&nbsp; </td>
         </tr>
         <tr>
            <td width="150"></td>
            <td width="350" ><img src="'. wp_get_attachment_url( get_post_thumbnail_id($pstID)).'"/></td>
            <td width="150"></td>
         </tr>
         <tr>
            <td colspan="3" height="5">&nbsp; </td>
         </tr>
      </table>
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
         <tr height="30">
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td width="150"></td>
            <td width="350" >'. $excerptz .'</td>
            <td width="150"></td>
         </tr>
      </table>
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
         <tr  height="1">
            <td width="150"></td>
            <td width="350" colspan="3">
            <hr color="grey" size="5" />
            </td>
            <td width="150"></td>
         </tr>
         <tr>
            <td width="150"></td>
            <td width="116">Length: '.$the_length.'" </td>
            <td width="116">Width: '.$the_width.'" </td>
            <td width="116">Height: '.$the_height.'" </td>
            <td width="150"></td>
         </tr>
         <tr  height="1">
            <td width="150"></td>
            <td width="350" colspan="3">
            <hr color="grey" size="5" />
            </td>
            <td width="150"></td>
         </tr>
         <tr>
            <td colspan="5" height="325"></td>
         </tr>
      </table>
      ';
      if (!$show_logo_price){
      $html .= '
      <table width="650" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
         <tr>
            <td valign="top" width="650" align="left"><img  width="250" src="/wp-content/uploads/2013/12/logo-pangaeaecollection.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price $'.$the_pricez.'.00</td>
         </tr>
      </table>';
      }
            

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
die();
//============================================================+
// END OF FILE
//============================================================+
}
}
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
    /*   
       
       
       
       
        // Instanciation of inherited class
        $productSKU = $_GET['pSKU'];
        $pstID = $_GET['zID'];
        $product = get_product( $pstID );
        $the_pricez =  $product->get_price(); 
        $the_width = get_post_meta($pstID, "_width", true); 
        $the_length = get_post_meta($pstID, "_length", true); 
        $the_height = get_post_meta($pstID, '_height', true);
        $the_origin = get_post_meta($pstID, "_product_origin", true); 
        $pstID = (int)$pstID;
        $excerptz = iweb_get_excerpt_by_id($pstID);
        if ((isset($the_length)) || (! empty($the_length))) {
        
        $the_length = "<br><br>Length: " . $the_length . " inches<br>";
        
        }
        if ((isset($the_width)) || (! empty($the_width))) {
        
        $the_width = "<br><br>Width: " . $the_width . " inches<br>";
        
        }
        if ((isset($the_height)) || (! empty($the_height))) {
        
        $the_height = "<br><br>Height: " . $the_height . " inches<br>";
        
        }
        if ((isset($the_origin)) || (! empty($the_origin))) {
        
        $the_origin = "<br><br>Origin: " . $the_origin . "<br>";
        
        }
               //  $image   = get_the_post_thumbnail( $postID );
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="test.pdf"');
header('Content-Transfer-Encoding: binary');
//header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');

$html = '<table width="700" height="400"><tr><td>Short Description: Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room. Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room. Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room. Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room</td></tr></table> <br><br><br><br><br><br>Product Title: '.get_the_title($pstID).' <br><br>';
$htmll = '<br><br><br><br> <br><br><br><br><br> <br><br><br><br><br><br><br><br><br><br> <br><br><br><br><br><br><br><br> <br><br>';

$htmlll = 'Overview: '.$excerptz;

$htmllll = '<br><br>'. $the_length .''.$the_width.''.$the_height.''.ucfirst($the_origin).'<br>Unit Price: $' .$the_pricez.'.00 ' ;
$pdf = new PDF();
// First page
$pdf->AddPage();
//$pdf->SetFont('Arial','',20);
//$pdf->Write(5,"To find out what's new in this tutorial, click ");
//$pdf->SetFont('','U');
//$link = $pdf->AddLink();
//$pdf->Write(5,'here',$link);
//$pdf->SetFont('');
// Second page

//$pdf->SetLink($link);
$pdf->Image('http://test.thepangaeacollection.com/wp-content/uploads/2014/01/logo-pangaeaecollection2.png',60,2,100,0,'','http://test.thepangaeacollection.com');
$pdf->SetLeftMargin(5);
$pdf->SetFontSize(18);
$pdf->WriteHTML($html);
$pdf->Image( wp_get_attachment_url( get_post_thumbnail_id($pstID)),60,60,90,0,'','');
//$pdf->centreImage(wp_get_attachment_url( get_post_thumbnail_id($pstID)));
//$html = '<br><br>Short Description: Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room. Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room. Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room. Created using a unique process of drying the wood before applying the paint, the Acacia Console brings character to any room.<br><br> Length: '. $product->get_price_html() .'<br><br> Width: $454.00<br><br> Height: $454.00<br><br> Origin: $454.00<br><br> Unit Price: ' . $the_pricez;


$pdf->WriteHTML($htmll);
//$pdf->WriteHTML($htmlll);
$pdf->MultiCell( 200, 40, $htmlll, 1);
$pdf->WriteHTML($htmllll);
$pdf->Output();*/

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );

function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
		 $tabs['test_tabo'] = array(
 'title' => __( 'Tearsheet', 'woocommerce' ),
 'priority' => 60,
 'callback' => 'cg_product_downloads_content'
 );
	$tabs['test_tab'] = array(
		'title' 	=> __( 'Product Inquiry', 'woocommerce' ),
		'priority' 	=> 80,
		'callback' 	=> 'woo_product_inquiry_tab'
	);



	return $tabs;

}
function woo_product_inquiry_tab() {

	// The new tab content

	echo '<h2>Product Inquiry</h2>';
	echo '<p>' . gravity_form(4, false, false, false, '', true, 12) . '</p>';
	
}


function cg_product_downloads_content() {
global $post, $woocommerce, $product;
?>
          <form id="pdf-gen" name="pdf-gen" method="get">
          <div "logo_and_price"><input type="checkbox" name="show_logo_price"><span class="show_logo_price">Check to remove the Logo and Price from the PDF file:</span></div>
              <input type="hidden" name="pSKU" value="<?php echo $product->get_sku(); ?>">
              <input type="hidden" name="zID" value="<?php echo $post->ID; ?>">
              <input type="hidden" name="pdf-generate" value="1">
              <button type="submit" class="pdf-g button alt container">Get PDF Tearsheet</button>
          </form>
<?php
}

function cg_product_downloads_tab($tabs) {


 return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);

 return $tabs;
}

add_filter('woocommerce_order_actions_start', 'woocommerce_order_assign_custom_meta_box');
function woocommerce_order_assign_custom_meta_box( $post ) {
	//global $woocommerce, $theorder, $wpdb;

//	if ( ! is_object( $theorder ) )
	//	$theorder = new WC_Order( $post->ID );

	//$order = $theorder;
	?>
	<style>
#meta\5b 33633\5d \5b value\5d {
background-color: orange;
font-size: 28px;
font-weight: 700;
line-height: 21px;
vertical-align: middle;
}
	</style>
<link rel='stylesheet' id='easy-modal-styles-css'  href='http://test.thepangaeacollection.com/wp-content/plugins/easy-modal/inc/css/easy-modal.min.css?ver=0.1' type='text/css' media='all' />
<script type='text/javascript' src='http://test.thepangaeacollection.com/wp-content/plugins/easy-modal/inc/js/jquery.animate-colors-min.js?ver=3.8.1'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var easymodal = [];
easymodal = {"modals":{"1":{"id":"1","name":"Container Cart Choice","sitewide":true,"title":"Container Builder","content":"<div id=\"container_builder\" >Content<\/div>","theme":1,"size":"custom","userHeight":90,"userHeightUnit":"%","userWidth":90,"userWidthUnit":"%","animation":"growAndSlide","direction":"bottom","duration":800,"overlayClose":true,"overlayEscClose":true}},"themes":{"1":{"name":"Cart-or-Container","overlayColor":"#64687d","overlayOpacity":50,"containerBgColor":"#ffffff","containerPadding":9,"containerBorderColor":"#5e5558","containerBorderStyle":"solid","containerBorderWidth":2,"containerBorderRadius":8,"closeLocation":"outside","closeBgColor":"#5f5458","closeFontColor":"#61bb57","closeFontSize":15,"closeBorderRadius":10,"closeSize":20,"closeText":"&#215;","closePosition":"topright","contentTitleFontColor":"#6e6d66","contentTitleFontSize":28,"contentTitleFontFamily":"Times New Roman","contentFontColor":"#6e6d66","id":1}}};;
/* ]]> */
</script>
<script type='text/javascript' src='http://test.thepangaeacollection.com/wp-content/plugins/easy-modal/inc/js/easy-modal.min.js?ver=3.8.1'></script>
<a href="#" class="eModal-1">click here<a/>
<div id="eModal-1" class="modal">
		<div class="title">Container Builder</div>
		<div id="container_builder" >
		<?php

global $woocommerce, $wpdb;
$data = array(
	'api_key' => 'dd3cd3f7dd614cfe21793c9be8843fe8',
	'include_images' => 1,
	'response' => 'json',
	'bin' => array(
		'w' => 220,
		'h' => 233,
		'd' => 1098,
		'wg' => 21600
	)
);
$oidd = isset($_POST['post']) ? $_POST['post'] : $_GET['post'];
$iii=0;
$iiii=0;
$masterlist = array();
// var_dump($array_expirations);
$order = new WC_Order( $oidd );
$items = $order->get_items();
$container_price_all_total =0;
$container_price_all_total =0;
$master_quantity =0;
$container_price_item_quantity =0;
$container_price =0;
$meter3_item =0;
$quantity_item =0;
$tweight = 1;
//var_dump($order);

  //  $product_name = $item['name'];
  //  $product_id = $item['product_id'];
  //  $product_variation_id = $item['variation_id'];

	foreach ( $items as $item ) 
	{
		//$_product = $values['data'];
		// var_dump($_product);
			$product_id = $item['product_id'];
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
			$quantity_item = esc_attr( $values['quantity'] );
			$twidth *= 2.54;
			$tlength *= 2.54;
			$theight *= 2.54;
			$iii++;
			$meter3_item = $tlength * $twidth * $theight;
			$meter3_item = ($meter3_item / 1000000);
			$meter3_item = number_format((float)$meter3_item, 2, '.', '');
			$container_price =	get_post_meta( $product_id, '_container_price', true );
			$container_price_item_quantity = $container_price * $quantity_item;
			$container_price_item_quantity = number_format((float)$container_price_item_quantity, 2, '.', '');
			$meter3_item_quantity = $meter3_item * $quantity_item;
			$meter3_item_quantity = number_format((float)$meter3_item_quantity, 2, '.', '');
			$master_quantity += $quantity_item;
   			$meter3_all_quantity += $meter3_item_quantity;
			$container_price_all_total += $container_price_item_quantity;
			
			$masterlist[$iii]['length'] = $tlength;
			$masterlist[$iii]['width'] = $twidth;
			$masterlist[$iii]['height'] = $theight;
			$masterlist[$iii]['quantity'] = $quantity_item;
			$masterlist[$iii]['price'] = $container_price;
			$masterlist[$iii]['name'] = $item['name'];
			$masterlist[$iii]['meter3'] = $meter3_item;

            $str_array[] = array('w'=>$twidth,'h'=>$theight,'d'=>$tlength,'wg'=>$tweight,'q'=>$quantity_item);
            $data['box'][$iiii] =array('w'=>$twidth,'h'=>$theight,'d'=>$tlength,'wg'=>$tweight,'q'=>$quantity_item);
            $iiii++;


}
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

		?></div>
	<a class="close-modal">&#215;</a>
</div>
	<ul class="order_actions submitbox">
		<li class="wide" id="actions">
<!--	<select name="wc_assign_action">
			<optgroup label="----------------">
				<option value="view_sequence">View Container Packaging Sequence</option>
				</optgroup>
			</select>
-->
<input type="reset" class="eModal-1 button save_order button-primary tips" name="save" value="Container Factory" data-tip="See the sequence of how container packaged.">
		</li>

		<li class="wide">

<hr style="color:#eee;">
			
		</li>



	</ul>
	<?php
}

//admin function for container building

/*
function get_array_product_ids_quantity_fromorder($orderID)
{
    global $woocommerce, $post;
    // we want the line_items only and not other order item types
    $order = new WC_Order($orderID);
    $full_name_array = array();
    $order_items = $order->get_items(apply_filters('woocommerce_admin_order_item_types', array(
    'line_item'
    )));
    foreach($order_items as $item_id => $item)
    {
          if ($metadata = $order->has_meta($item_id))
          {
          foreach($metadata as $meta)
          {
          // Skip hidden woocommerce core fields just in case
          if (in_array($meta['meta_key'], apply_filters('woocommerce_hidden_order_itemmeta', array(
          '_qty',
          '_tax_class',
          '_product_id',
          '_variation_id',
          '_line_subtotal',
          '_line_subtotal_tax',
          '_line_total',
          '_line_tax',
          )))) continue;
          // Skip serialised meta just in case
          if (is_serialized($meta['meta_value'])) continue;
          $meta['meta_key'] = esc_attr($meta['meta_key']);
          $meta['meta_value'] = esc_textarea($meta['meta_value']); // using a textarea
          // replace the country and garbage in the signpost address field
          //var_dump($meta);
          if (("Contact Person" == $meta['meta_key']) && (("first_name" == $item_field) || ("last_name" == $item_field )))
          {


              //r_dump($meta);
              $full_name_array = explode(" ",$meta["meta_value"]);

              $value_to_return = ("first_name" == $item_field) ? $full_name_array[0] : $full_name_array[1] ;
              //var_dump($value_to_return);
               return $value_to_return ;
          }
          if (("Signpost Address" == $meta['meta_key']) && (("street_address" == $item_field) || ("zipcode" == $item_field )))
          {
              $meta['meta_value'] = str_replace("United StatesMap It", "", $meta['meta_value']);
              // regular expression to add a space when a small letter is found in front of Capital letter
              // It is used because there is no space between 'the end of street' and 'the first letter of city' that follow street
              $meta['meta_value'] = preg_replace('/\B([A-Z])/', ' $1', $meta['meta_value']);
              //$value_to_return = $meta['meta_value'];
              $tt5=substr($meta['meta_value'], -5);
              $tt6= substr($meta['meta_value'], 0, -5);
              $value_to_return = ("zipcode" == $item_field) ? $tt5 : $tt6 ;
              return $value_to_return ;
          }
      }

      if (("Special Instructions" ==  $meta['meta_key']) && ("special_instructions" == $item_field))
      {
      $value_to_return =  $meta['meta_value'];
      return $value_to_return;
      }


      echo '<p><strong>' . $meta['meta_key'] . ':</strong> ' . $meta['meta_value'] . '<br /></p>';
      } //closes --- foreach($metadata as $meta)

}

*/
add_action('woocommerce_before_checkout_billing_form', array(&$this, 'custom_before_checkout_billing_form') );

function custom_before_checkout_billing_form($checkout) {

    echo '<input type="hidden" class="input-hidden" name="test" id="test" placeholder="test" value="test" />';
}


function cubic_meter_maker_single($length=0,$width=0,$height=0)
{
		//inches come in

            

            if (!is_numeric($width) || ($width <= 0)) 
            {
            $width = 17.7;
            
            }
            if (!is_numeric($length) || ($length <= 0)) 
            {
            $width = 17.7;
            
            }
            if (!is_numeric($height) || ($height <= 0)) 
            {
            $height = 17.7;
            
            }
       
		$total_in_m3 = 0;
		$length = $length * 2.54;
		$width = $width * 2.54;
		$height = $height * 2.54;
		$total_in_m3 = $length * $width * $height;
		$total_in_m3 = ($total_in_m3 / 1000000);
		return($total_in_m3);
}

function cubic_meter_maker_quantity($length=0,$width=0,$height=0,$quantity=0)
{
		//inches come in
		$total_in_m3 = 0;
		$length = $length * 2.54;
		$width = $width * 2.54;
		$height = $height * 2.54;
		$total_in_m3 = $length * $width * $height;
		$total_in_m3 = ($total_in_m3 / 1000000) * $quantity;
		return($total_in_m3);
}
function what_size_container($current_m3=0)
{
		//STANDARD 20 FT	5.9 X 2.35 X 2.393 Mt	33.2 = 560cm x 223cm x 227cm = 29.88
		// 	STANDARD 40 FT	12.036 X 2.35 X 2.392 Mt	67.7 = 60.93
		// 	HIGH CUBE 40 FT	12.036 X 2.35 X 2.697 Mt	76.3 = 68.67
		$standard20 = 29.88;
		$standard40 = 60.93;
		$high_cube = 68.67;
		$percent_filled = 0;

		if	($current_m3 <= $standard20) 
		{
			$percent_filled1 = ($current_m3 / $standard20) * 100;
			$percent_filled2 = ($current_m3 / $standard40) * 100;
			$percent_filled3 = ($current_m3 / $high_cube) * 100;
			$anArray['full'] = 0;
			$anArray['name1'] = "20 foot Container";
			$anArray['volume1'] = 29.88;
			$anArray['percent_full1'] = $percent_filled1;
			$anArray['is_full'] = $percent_filled1;
			$anArray['name2'] = "40 foot Container";
			$anArray['volume2'] = 60.93;
			$anArray['percent_full2'] = $percent_filled2;
			$anArray['name3'] = "40 foot Cube";
			$anArray['volume3'] = 68.67;
			$anArray['percent_full3'] = $percent_filled3;
			
		} elseif (($standard20 < $current_m3) && ($current_m3 <=  $standard40) )
		{
			$percent_filled = ($current_m3 / $standard40) * 100;

			$anArray[] = "40 foot Container";
			$anArray[] = 60.93;
			$anArray[] = $percent_filled;
			$anArray[] = 1;

		} elseif (($standard40 < $current_m3) && ($current_m3 <= $high_cube)) 
		{
			$percent_filled = ($current_m3 / $high_cube) * 100;

			$anArray[] = "40 foot Cube";
			$anArray[] = 68.67;
			$anArray[] = $percent_filled;
			$anArray[] = 2;

		} elseif ($current_m3 >  $high_cube) 
		{
			return(0);
		 
		}
		return($anArray);
}
//remove_filter( 'woocommerce_cart_item_price_html', array( $this, 'get_cart_widget_item_price_html' ), 10, 3 );
/*

add_filter( 'woocommerce_cart_item_price_html', 'substitute_price_if_container', 10, 3 );

function substitute_price_if_container( $price_html, $cart_item, $cart_item_key ) {
	//	var_dump($cart_item_key);
	$zz=23.59;	
		//die();
		if ( isset( $cart_item['pricing_item_meta_data']['_price'] ) ) {
		//	return woocommerce_price( (float) $cart_item['pricing_item_meta_data']['_price'] );
		}
return woocommerce_price( (float)$zz );
		// default
		/*
		return $price_html;
		$temp_cookie = (isset($_COOKIE['cart_or_container']));
    if (isset($temp_cookie) && ($temp_cookie == "container")){
				global $woocommerce;
				$container_price =	get_post_meta( $cart_item['product_id'], '_container_price', true );
			//	$container_price = woocommerce_price($container_price);
				return $container_price ;
				exit;
    }
    
    
    return get_post_meta( $cart_item['product_id'], '_container_price', true ) ;
 }   */


function insert_woo_cart_timer($c_session_id, $c_product_id){

 global $wpdb;
        $the_table_name =  $wpdb->prefix . "woo_cart_timer";
//$date = new DateTime();
				//	$date->add(new DateInterval('PT48H'));
				//	$temp_date = $date->format('Y-m-d H:i:s');
        //creating new form
          $results = $wpdb->get_var($wpdb->prepare("SELECT expiration_date FROM $the_table_name  WHERE session_id='".$c_session_id."' and product_id = ".$c_product_id." "));
          if ($results)
          {
							$sql = $wpdb->prepare("UPDATE $the_table_name  SET expiration_date=DATE(DATE_ADD(NOW(), INTERVAL 48 HOUR)) WHERE session_id=%s and product_id = %s", $c_session_id, $c_product_id) ;
							$wpdb->query($sql);
          } else
          {
        $wpdb->query($wpdb->prepare("INSERT INTO $the_table_name(session_id, product_id, expiration_date) VALUES(%s,  %s, DATE_ADD(now(), INTERVAL 48 HOUR))", $c_session_id, $c_product_id));
					}
        //returning newly created form id
        return true;
}

function get_expiration_array($c_session_id){
		global $wpdb;
		$the_table_name =  $wpdb->prefix . "woo_cart_timer";
		$query = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(product_id), expiration_date FROM $the_table_name  WHERE session_id=%s",$c_session_id));
		$tempArray = $startArray = $finalArray = array();
		$finalArray['full'] = 0;
		$counter=0;
		foreach($query as $row)
		{
				foreach($row as $key=>$value)
				{
						if ($counter % 2 == 0) 
						{
								$tempArray[$counter] = $value;
						} 
						else
						{
								
								$finalArray[$tempArray[$counter-1]] = $value;
						}
						$finalArray['full'] = 1;
						$counter++; 
				}  
		}
	//	if ($counter===0) $finalArray['empty'] = 1;
		 return $finalArray;
}

add_filter("woocommerce_add_to_cart_message", "woocommerce_add_to_cart_message_override");

function woocommerce_add_to_cart_message_override( $message ) {
		if (isset($_COOKIE['cart_or_container']) && ($_COOKIE['cart_or_container'] == "container")){
				$message = str_replace("cart.","container.", $message);
		}
return $message;
}
// send automatic scheduled email
if ( ! wp_next_scheduled('my_task_hook') ) {
	wp_schedule_event( time(), 'hourly', 'my_task_hook' ); // hourly, daily and twicedaily
}

//add_action( 'my_task_hook', 'my_task_function' );
function my_task_function() {
	
//	wp_mail( 
	//	'example@yoursite.com', 
		//'Automatic mail', 
	//	'Hello, this is an automatically scheduled email from WordPress.'
	//);
}
add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );

function add_custom_price( $cart_object ) 
{
    $custom_price = 10; // This will be your custome price  
    $temp_cookie = (isset($_COOKIE['cart_or_container']));
    if (($temp_cookie) && ($temp_cookie == "container"))
    {
				foreach ( $cart_object->cart_contents as $key => $value ) 
				{
						
						$value['data']->price = get_post_meta( $value['product_id'], '_container_price', true );
				}
		}
}


//add_filter( 'cron_schedules', 'filter_cron_schedules' );
// add custom time to cron
function filter_cron_schedules( $schedules ) {
	
	$schedules['once_half_hour'] = array( 
		'interval' => 1800, // seconds
		'display'  => __( 'Once Half an Hour' ) 
	);
	
	return $schedules;
}

add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');

function my_custom_checkout_field( $checkout ) {
$temp_cookie = isset($_COOKIE['cart_or_container']);
 if (($temp_cookie) && ($temp_cookie == "container")){
    echo '<input type="hidden" id="container_or_cart_form" name="container_or_cart_form" value="Container">';
 } else {
 
		echo '<input type="hidden" id="container_or_cart_form" name="container_or_cart_form" value="Cart">';
 }

   // echo '</div>';

}

/**
 * Process the checkout
 **/
//add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

//function my_custom_checkout_field_process() {
    //global $woocommerce;
//
    // Check if set, if its not set add an error.
 //  if (!$_POST['container_or_cart'])
      //   $woocommerce->add_error( __('Please enter something into this new shiny field.') );
//}


/**
 * Update the order meta with field value
 **/
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ($_POST['container_or_cart_form']) update_post_meta( $order_id, 'Cart_Container', esc_attr($_POST['container_or_cart_form']));
}

/**
 * Display field value on the order edition page
 **/
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
 
function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Cart_Container').':</strong> ' . $order->order_custom_fields['Cart_Container'][0] . '</p>';
}

/**
 * Custom Successfull Add To Cart Messages
 * 
 **/
 /*
add_filter( 'woocommerce_add_to_cart_message', 'custom_add_to_cart_message' );
function custom_add_to_cart_message() {
	global $woocommerce;
 
	// Output success messages
	if (get_option('woocommerce_cart_redirect_after_add')=='yes') :
		$return_to 	= get_permalink(woocommerce_get_page_id('shop'));
 
		$message 	= sprintf('<a href="%s" class="button">%s</a> %s', $return_to, __('Continue Shopping &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
 
	else :
 
		$message 	= sprintf('<a href="%s" class="button">%s</a> %s', get_permalink(woocommerce_get_page_id('cart')), __('View Cart &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
 
	endif;
 
		return $message;
}
*/