<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MetroStore
 */

?>
</div><!-- #content -->

	<?php 

		do_action( 'metrostore_footer_before' );

		/**
		 * @see  metrostore_footer_widget_area() - 10
		 */
		do_action( 'metrostore_footer_widget' ); 

		
			do_action( 'metrostore_sub_footer_before' );

				/**
				 * @see  metrostore_footer_credit() - 10
				 * @see  metrostore_social_media() - 15
				 */
				do_action( 'metrostore_sub_footer' ); 

			do_action( 'metrostore_sub_footer_after' );

	
	 	do_action( 'metrostore_footer_after' ); 
	?>

</div><!-- #page -->

<?php wp_footer(); ?>
<a href="#" class="scrollup">
	<i class="fa fa-angle-up" aria-hidden="true"></i>
</a>
<script>
 jQuery('.reg_form_container .register').after('<p class="form_links">By continuing, you agree to our <a href="<?php get_site_url();?>/terms-conditions/">Terms</a> and <a href="<?php get_site_url();?>/privacy/">Privacy Policy</a></p>');
jQuery('figure li.product img').click(
function(){window.location.href = jQuery(this).parent().parent().parent().parent().find('h3 a').attr('href');
}); 
jQuery('.woocomerce-FormRow.form-row .woocommerce-Button.button').attr('value', 'GET STARTED');
</script>
</body>
</html>
<?php
$content = ob_get_clean();
echo $content;
?>