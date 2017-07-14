<?php

add_action('wp_footer', 'unsubscribe');
function unsubscribe(){
global $wpdb;
$sub_id = $wpdb->get_var("SELECT `sub_id` FROM `wp_mixpro_meels` WHERE `user_id`='".get_current_user_id()."'");
?>
<script>
		jQuery('#unsubscribe').click(function(){
			var ajaxurl = "<?php echo get_site_url();?>/wp-admin/admin-ajax.php";
			var data = {
				'action' : 'unsubscribe',
				'subscription_id' : '<?php echo $sub_id;?>'
			}
			jQuery.post(ajaxurl, data, function(response){window.location.reload();});
		});
</script>
<?php }