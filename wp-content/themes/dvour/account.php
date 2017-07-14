<?php
/**
 * Template Name: Account
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>
<?php if(!is_user_logged_in()){
$login_url = wp_login_url();
header('Location:'.$login_url);
}?>
<?php get_header(); ?>
<div class="container">
<h2>My Account</h2>
    <div style="padding: 0 8px">
<?php if(is_user_logged_in()){
      $user_id = get_current_user_id();
      global $wpdb;
      $old_plan = $wpdb->get_var("SELECT `plan` FROM `wp_mixpro_meels` WHERE `user_id`='".$user_id."'");
      $_SESSION['plan'] = $old_plan;
      $meta_result = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value` = '".$user_id."'", ARRAY_A);
      if(count($meta_result)==0){
        header("Location: ".get_site_url()."/choose-plan/");
      }
      $ready_order = array();
    foreach($meta_result as $value){
        $ord = get_post($value['post_id'], 'OBJECT');
        if($ord->post_status=="wc-processing"){
            array_push($ready_order, $ord->ID);

        }
    }

    $order_id = end($ready_order);
$current_subscription = $wpdb->get_var("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE `order_id`='".$order_id."'");
      $order_items = $wpdb->get_row("SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id`='".$order_id."'", ARRAY_A);
      $order_item_id = $order_items['order_item_id'];
           $empty_prods = $plan_count+1-count($_SESSION['prods']);
           $meta_value_i = $plan_count+1-$empty_prods;
           $meta_key = 'meels'.$meta_value_i;
           /*$check_sub = $wpdb->get_var("SELECT `sub_id` FROM `wp_mixpro_meels` WHERE `user_id`='".get_current_user_id()."'");*/

           if(count($ready_order)>0){

//$user =  get_userdata( $user_id );
//$username = $user->user_login;
?>
<table id="my-account">
<tr>
<th>Current Subscription</th>
<td  class="center_td"><?php echo $current_subscription;?></td>
<td><a href="<?php echo get_site_url();?>/shop/" class="button pay">Meals</a></td>
<td><a href="<?php echo get_site_url();?>/choose-plan/" class="button pay">Change Plan</a></td>
<td><a class="button pay" id='unsubscribe'>Unsubscribe</a></td>
</tr>
</table>
<?php } }?>
<?php echo do_shortcode('[woocommerce_my_account order_count="-1"]'); ?>
        <?php the_post(); the_content(); ?>
    </div>

</div>
<?php get_footer(); ?>
<script>
    jQuery('#unsubscribe').click(function(){
        var ajaxurl = "<?php echo get_home_url();?>/wp-admin/admin-ajax.php";
        var data = {
            'action' : 'unsubscribe',
            'subscription_id' : '<?php echo $order_id;?>'
        }
        jQuery.post(ajaxurl, data, function(response){
            document.location.reload();
        });
    });
</script>
