<?php
/**
 * @package WordPress
 * @subpackage Your Inspiration Themes
 */                                                          

$slider_class = '';
$slider_class .= yit_slide_get('align') != '' ? ' align' . yit_slide_get('align') : '';
?>
 
<!-- START SLIDER -->
<div id="<?php echo $slider_id ?>"<?php yit_slider_class($slider_class) ?>> 
    <div class="shadowWrapper">
        <?php echo do_shortcode('[rev_slider ' . yit_slide_get( 'slider_name' ) . ']'); ?>
    </div>
</div>
<!-- END SLIDER -->