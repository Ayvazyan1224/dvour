<?php
/**
 * The template for displaying Shop footer.
 *
 */
?>
<?php 
	wp_enqueue_style('step', '/wp-content/themes/dvour/assets/css/step.css');
?>
<?php wp_footer(); ?>

<script>
 jQuery('.reg_form_container .register').after('<p class="form_links">By continuing, you agree to our <a href="<?php get_site_url();?>/terms/">Terms</a> and <a href="<?php get_site_url();?>/privacy/">Privacy Policy</a></p>');
jQuery('figure li.product img').click(
function(){window.location.href = jQuery(this).parent().parent().parent().parent().find('h3 a').attr('href');
}); 
jQuery('.woocomerce-FormRow.form-row .woocommerce-Button.button').attr('value', 'GET STARTED');
</script>
</body>
</html>
