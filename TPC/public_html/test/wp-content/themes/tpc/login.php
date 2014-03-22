<?php
/**
 * Login Form
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

/*
Template Name: Login Form
*/
get_header();
do_action( 'yit_before_primary' ) ?>
<style>
#gf_progressbar_wrapper_2 {
display: none;
}
#field_2_36 .gfield_label, #field_2_34 .gfield_label {
font-weight: normal !important;
}
</style>
<!-- START PRIMARY -->
<div id="primary" class="<?php yit_sidebar_layout(); ?>">
    <div class="container group">
	    <div class="row">
	        <?php do_action( 'yit_before_content' ) ?>
	        <!-- START CONTENT -->
	        <div id="content-home" class="span<?php echo yit_get_sidebar_layout() == 'sidebar-no' ? 12 : 12; ?> content group">
	        <?php	        
global $woocommerce; ?>

<?php $woocommerce->show_messages(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

<div class="col2-set" id="customer_login">

	<div class="col-1">

<?php endif; ?>

		<h2><?php _e('Login', 'woocommerce'); ?></h2>
		<form method="post" class="login">
			<p class="form-row form-row-first">
				<label for="username"><?php _e('Username or email', 'yit'); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" />
			</p>
			<p class="form-row form-row-last">
				<label for="password"><?php _e('Password', 'yit'); ?> <span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" />
			</p>
			<div class="clear"></div>

			<p class="form-row">
				<?php $woocommerce->nonce_field('login', 'login') ?>
				<input type="submit" class="button" name="login" value="<?php _e('Login', 'yit'); ?>" />
				<a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url( home_url() ) ); ?>"><?php _e('Lost Password?', 'yit'); ?></a>
			</p>
		</form>

<?php if ( ! is_user_logged_in()) { ?>

	</div>

	<div class="col-2">
	<h3>Register Below to Unlock Prices</h3>
<?php
	do_action( 'yit_loop_page' );
	gravity_form(2, false, false, false, '', true, 12); 
?>
	</div>

</div>
<?php } ?>

<?php do_action('woocommerce_after_customer_login_form'); 


//do_action( 'yit_loop_page' );

?>

	        </div>
	        <!-- END CONTENT -->
	        <?php do_action( 'yit_after_content' ) ?>
	        
	        <?php get_sidebar() ?>
	        
	        <?php do_action( 'yit_after_sidebar' ) ?>
	        
	        <!-- START EXTRA CONTENT -->
	        <?php do_action( 'yit_extra_content' ) ?>
	        <!-- END EXTRA CONTENT -->
	
	    </div>
    </div>
</div>
<!-- END PRIMARY -->
<?php
do_action( 'yit_after_primary' );
get_footer() ?>