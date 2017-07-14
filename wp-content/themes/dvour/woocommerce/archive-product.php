<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'step' ); ?>

<?php if(isset($_GET['date']))
{
	$_SESSION['date']=$_GET['date'];
	if(isset($_SESSION['prods'])){
		unset($_SESSION['prods']);
	}
}
do_action('mixpro_last_choosed_prods');
?>
<div class="breadcrumps">
<a href="<?php echo get_site_url();?>"><img src="<?php echo get_site_url();?>/wp-content/uploads/2017/04/logosmall.png" class='step-header-img'></a>

Plan&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspDay&nbsp&nbsp&nbsp>&nbsp&nbsp&nbsp<span>Meals</span>&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspCheckout
</div>

<style>
.breadcrumps {
            width: 100%;
            display: block;
            text-align: center;
            font-size: 18px;
            color:#969696;
            font-family: 'DINProRegular';
        }
        .breadcrumps span {
            color:#d15137;
        }

.breadcrumps {
    border-bottom: thin solid rgba(0,0,0,0.1);
    padding-bottom: 10px !important;
display:inline-block;
padding:0 20px;
}

.step-header-img {
width:20px;
}
</style>


<?php
if(is_user_logged_in() && !isset($_GET['date'])){
$now = time()+(3*24*60*60);
}
elseif(isset($_GET['date'])) {
	$now = $_GET['date'];
}
for($i=0; $i<7; $i++ )
{
$day = $now + ($i*24*60*60);
if(date('l', $day)==do_shortcode('[seconddeliveryday]')){
		$thursday = date('d F', $day);
		$t = $day;
	}
if(date('l', $day)==do_shortcode('[firstdeliveryday]')){
		$monday = date('d F', $day);
		$m = $day;
	}
}
?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php /*if ( have_posts() ) : ?>

			<?php

				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>


				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>


				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php

				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif;*/ ?>

<?php //We are using the Date field to create a unique filter to only pull items that have a specific date attribute attached ?>
<?php //By doing it this way if an items attribute doesnt have the current date setup, then the item wont show ?>
<?php $thurs = "'" . strtolower(str_replace(' ','-',$thursday)) . "'";?>
<?php $mon = "'" . strtolower(str_replace(' ','-',$monday)) . "'";?>

		<?php if($m<$t){?>
<h2 class="my_shop_title"><?php echo do_shortcode('[firstdeliveryday]');?> <span class="bigsun"><?php echo $monday;?></span> Delivery</h2>


<?php //echo do_shortcode('[product_category category="monday" per_page="-1"]');?>
<?php echo do_shortcode("[product_attribute attribute='meal-date' filter=$mon]");?>

<h2 class="my_shop_title"><?php echo do_shortcode('[seconddeliveryday]');?> <span class="bigwed"><?php echo $thursday;?></span> Delivery</h2>
<?php echo do_shortcode("[product_attribute attribute='meal-date' filter=$thurs]");?>

<?php //echo do_shortcode('[product_category category="thursday" per_page="-1"]');?>
<?php } 
if($m>$t){
?>
<h2 class="my_shop_title"><?php echo do_shortcode('[seconddeliveryday]');?> <span class="bigwed"><?php echo $thursday;?></span> Delivery</h2>
<?php echo do_shortcode("[product_attribute attribute='meal-date' filter=$thurs]");?>

<?php //echo do_shortcode('[product_category category="thursday" per_page="-1"]');?>
<h2 class="my_shop_title"><?php echo do_shortcode('[firstdeliveryday]');?><span class="bigsun"><?php echo $monday;?></span> Delivery</h2>
<?php echo do_shortcode("[product_attribute attribute='meal-date' filter=$mon]");?>

<?php //echo do_shortcode('[product_category category="monday" per_page="-1" ]');?>
<?php } ?>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?> 

<?php get_footer( 'step' ); ?>
<script type="text/javascript">
	var current_element = 'ul.products li.product .item-title h3 a'; 
	var current_img = 'ul.products li.product figure';
	jQuery(current_element).on('click', function(event){
	event.preventDefault();
	var current_index = jQuery(current_element).index(this);
	jQuery(this).parents().find('.open-popup-link')[current_index].click();
	});
	jQuery(current_img).on('click', function(){
		var current_img_index = jQuery(current_img).index(this);
		jQuery(this).parents().find('.open-popup-link')[current_img_index].click();
	});
</script>
<style>
.post-type-archive-product {
margin-top:30px;
}
</style> 