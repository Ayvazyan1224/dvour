<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */

			do_action( 'woocommerce_single_product_summary' );
			the_content();
		?>
		<h2 class="prodhtwo">want to try out this meal? </h2>
<?php if(is_user_logged_in()){?>
<a href="<?php echo get_site_url();?>/shop/" class="gotoplans" style="padding: 10px 0; text-align:center;">GET THIS MEAL</a>
<?php } else {?>
		<a href="<?php echo get_site_url(); ?>/choose-plan/" class="gotoplans" style="padding: 10px 0; text-align:center;">GET STARTED </a>
<?php }
global $product;
echo "<div class='attr'>";
$product->list_attributes();
		echo "</div>"; 

?>
<?php //Commenting out Reivews ?>
<?php /*
		
		<a href="#review" id="reviev"><span class="op">+</span> Reviews </a>
		<div class="revi" style="display: none">
		</div>
		<script>
			jQuery(document).ready(function(){jQuery('.revi').append(jQuery('#reviews').html())});
			jQuery(document).ready(function() {
				jQuery('#reviev').on('click',function () {
					if (jQuery('.revi').css('display') == 'none') {
						jQuery('.revi').show();
						jQuery('.revi').css('height', 'auto');
						jQuery('#reviev span').html('-');
					}
					else {
						jQuery('.revi').hide();
						jQuery('#reviev span').html('+');

					}
				})
			});
		</script>
*/?>
	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
