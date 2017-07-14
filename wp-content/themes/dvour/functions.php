<?php
add_action("init", 'add_php_config');
function add_php_config(){
	ini_set('post_max_size', '256M');
	ini_set('memory_limit', '512M');
	ini_set('max_input_vars', '100000');
}
add_action('wp_enqueue_scripts', 'add_styles_and_scripts', 1000);
function add_styles_and_scripts()
{
    $media_style_path = get_stylesheet_directory_uri() . "/assets/css/media.css";
    $new_style_path = get_stylesheet_directory_uri() . "/assets/css/newstyle.css";
    $boot_style = get_stylesheet_directory_uri() . "/assets/css/bootstrap-select.min.css";
    wp_enqueue_style('media_styles', $media_style_path);
    wp_enqueue_style('new_styles', $new_style_path);
    wp_enqueue_style('boot_style', $boot_style);
    wp_enqueue_script('boot_script', get_stylesheet_directory_uri() . "/bootstrap-select.min.js");

}

add_action('https_api_curl', function ($curl) {
    if (!$curl) {
        return;
    }

    if (OPENSSL_VERSION_NUMBER >= 0x1000100f) {
        if (!defined('CURL_SSLVERSION_TLSv1_2')) {
            // Note the value 6 comes from its position in the enum that
            // defines it in cURL's source code.
            define('CURL_SSLVERSION_TLSv1_2', 6); // constant not defined in PHP < 5.5
        }
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    } else {
        if (!defined('CURL_SSLVERSION_TLSv1')) {
            define('CURL_SSLVERSION_TLSv1', 1); // constant not defined in PHP < 5.5
        }
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    }
});

add_action('wp_footer', 'content_protect');
function content_protect()
{
    if (!is_user_logged_in()) {
        echo "<script>
/*jQuery('.cart').css('display', 'none');*/
console.log('protected');
</script>";
    } else {
        echo "<script>jQuery('.cart input[type=number]').attr('max', 6); </script>";
    }
}

add_action('wp', 'custom_set_session');
function custom_set_session()
{

    if (is_cart() or is_checkout()) {
        WC()->cart->empty_cart();
        $cart_content = WC()->cart->cart_contents;
        $subscription_id = $_SESSION['plan'];
        $subscription_date = date('d m, l', $_SESSION['date']);
        $subscription_args = array(
            'wccpf_subscription_start_date' => $subscription_date,
            'wccpf_next_delivery_date' => $subscription_date
        );
        $si = 1;
        foreach ($_SESSION['prods'] as $skey => $svalue) {
            $name = get_the_title($svalue);
            $delivery_dates = explode(', ', wc_get_product($svalue)->get_attribute('pa_meal-date'));
            $day = "error";
            foreach ($delivery_dates as $data) {
                $first_delivery = $_SESSION['date'];
                if ((strtotime($data) - $first_delivery < (8 * 24 * 60 * 60)) && (strtotime($data) - $first_delivery)>(-1*23*60*60)) {
                    $day = date('l, d F', strtotime($data));
                }
            }
            $subscription_args['wccpf_meals' . $si] = '<a href="' . get_permalink($svalue) . '" target="_blank">' . $name . "</a> ( " . $day . " )";

            $si++;
        }

        WC()->cart->add_to_cart($subscription_id, 1, '', '', $subscription_args);
        foreach ($cart_content as $item_key => $item_value) {
            wc_update_order_item_meta($item_value, 'subscription_payment_sync_date', $subscription_args);
            WC()->cart->set_quantity($item_key, 1);
        }

    }
}

add_action('wp_ajax_add_or_remove', 'add_or_remove');
add_action('wp_ajax_nopriv_add_or_remove', 'add_or_remove');
function add_or_remove()
{
    global $wpdb;
    $prod = $_POST['prod'];
    $plan = $_SESSION['plan'];
    $user_id = get_current_user_id();
    $prod_id = $wpdb->get_var("SELECT `ID` FROM `wp_posts` WHERE `post_title` = '{$prod}' ");
    $prods = $wpdb->get_var("SELECT `products` FROM `wp_mixpro_meels` WHERE `plan` = '{$plan}' AND `user_id` = '{$user_id}' ");
    $prods = json_decode($prods, TRUE);
    if (isset($_SESSION['prods'])) {
        $plan_count = 0;
        switch ($plan) {
            case '217' :
                $plan_count = 0;
                break;
            case '110' :
                $plan_count = 5;
                break;
            case '135' :
                $plan_count = 11;
                break;
            case '136' :
                $plan_count = 23;
                break;
        }
        if (count($_SESSION['prods']) > $plan_count) {

        } else {
            $_SESSION['prods'][] = $prod_id;
            $where = array(
                'user_id' => $user_id,
                'plan' => $plan
            );
            $data = array(
                'products' => json_encode(array_filter($_SESSION['prods']))
            );
            $wpdb->update('wp_mixpro_meels', $data, $where);
        }

    } else {
        if (!empty($prods)) {
            $_SESSION['prods'] = $prods;
        }
        $_SESSION['prods'][] = $prod_id;
        $where = array(
            'user_id' => $user_id,
            'plan' => $plan
        );
        $data = array(
            'products' => json_encode(array_filter($_SESSION['prods']))
        );
        $wpdb->update('wp_mixpro_meels', $data, $where);
    }


    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $meta_result = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value` = '" . $user_id . "'", ARRAY_A);
        $last_order = array_pop($meta_result);
        $order_id = $last_order['post_id'];
        $order_items = $wpdb->get_row("SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id`='" . $order_id . "'", ARRAY_A);
        $order_item_id = $order_items['order_item_id'];
        $empty_prods = $plan_count + 1 - count($_SESSION['prods']);
        $meta_value_i = $plan_count + 1 - $empty_prods;
        $meta_key = 'meals' . $meta_value_i;
        $_product = wc_get_product($prod_id);
        $meals_date = explode(',', $_product->get_attribute('pa_meal-date'));
                   $day="not available";
                   foreach($meals_date as $val){
                    $d = strtotime($val);
                    if($d<time()+(10*24*60*60) && $d>time()-(12*60*60)){
                        $day=date('l, d F', strtotime($val));
                    }
                   }
        $meta_value = '<a href="' . get_permalink($prod_id) . '" target="_blank">' . $prod . "</a> (" . $day . ")";
        $order_update = array('meta_value' => $meta_value);
        $where = array('order_item_id' => $order_item_id, 'meta_key' => $meta_key);
        $wpdb->update('wp_woocommerce_order_itemmeta', $order_update, $where);
    }


    $prod_title = get_the_title($prod_id);
    $prod_thumb = get_the_post_thumbnail($prod_id, array('50px', '50px'));
    $exp = get_post($prod_id)->post_content;
    $res = array('id' => $prod_id, 'title' => $prod_title, 'thumb' => $prod_thumb, 'exp' => $exp);
    $newres = json_encode($res);

    echo $newres;
    wp_die();
}

function get_user_plan()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $plan = $wpdb->get_var("SELECT `plan` FROM `wp_mixpro_meels` WHERE `user_id` = '" . $user_id . "' ");

    if (empty($plan) || $plan == 0) {
        if (isset($_SESSION['plan'])) {
            $plan = $_SESSION['plan'];
        } else {
            $plan = 110;
        }
        $data = array(
            'user_id' => $user_id,
            'plan' => $plan
        );
        $wpdb->insert('wp_mixpro_meels', $data);
    }

    $_SESSION['plan'] = $plan;

}

add_action('wp_login', 'get_user_plan', 99);

add_action('wp_ajax_remove', 'remove');
add_action('wp_ajax_nopriv_remove', 'remove');
function remove()
{
    global $wpdb;
    $prod = $_POST['prod'];
    $prod_id = $wpdb->get_var("SELECT `ID` FROM `wp_posts` WHERE `post_title` = '" . $prod . "'");
    $prod_title = get_the_title($prod_id);
    foreach ($_SESSION['prods'] as $item_key => $item_value) {
        if ($item_value == $prod_id) {
            unset($_SESSION['prods'][$item_key]);
            break;
        }
    }
    $_SESSION['prods'] = array_filter($_SESSION['prods']);
    $plan = $_SESSION['plan'];
    $user_id = get_current_user_id();
    $where = array(
        'user_id' => $user_id,
        'plan' => $plan
    );
    $data = array(
        'products' => json_encode(array_filter($_SESSION['prods']))
    );
    $wpdb->update('wp_mixpro_meels', $data, $where);
    $res = array('id' => $prod_id, 'title' => $prod_title);
    $newres = json_encode($res);
    echo $newres;
    wp_die();
}

add_action('wp_footer', 'change_menu_items');
function change_menu_items()
{
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $log = $current_user->user_login;
        if ($log == '') {
            $log = $current_user->user_email;
        }

        echo "<script>
jQuery('.menu-item-448 a').html('" . $log . "');
</script>";
    }
}

add_action('user_register', 'user_reg_mixpro');
function user_reg_mixpro()
{
    global $wpdb;
    $meta_id = $wpdb->insert_id;
    $query = "SELECT `user_id` FROM `wp_usermeta` WHERE `umeta_id`='" . $meta_id . "'";
    $user_id = $wpdb->get_var($query);
    $wpdb->insert('wp_mixpro_meels', array('user_id' => $user_id));
}

add_action('wp_ajax_full_remove', 'full_remove_product');
add_action('wp_ajax_nopriv_full_remove', 'full_remove_product');
function full_remove_product()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $where = array(
        'user_id' => $user_id
    );
    $title = $_POST['title'];
    foreach ($_SESSION['prods'] as $key => $products) {
        $product_title = get_the_title($products);
        if ($product_title == $title) {
            unset($_SESSION['prods'][$key]);
        }
    }
    $data = array(
        'products' => json_encode($_SESSION['prods'])
    );
    $wpdb->update('wp_mixpro_meels', $data, $where);
}

add_action('login_enqueue_scripts', 'my_login_logo');
function my_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Logo.png);
            height: 105px;
            width: 100%;
            background-size: 100% auto;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }

add_filter('login_headerurl', 'my_login_logo_url');
function my_login_logo_url()
{
    return home_url();
}

function my_login_logo_url_title()
{
    return 'd`VOUR';
}

add_filter('login_headertitle', 'my_login_logo_url_title');
function my_login_stylesheet()
{
    wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.css');
}

add_action('login_enqueue_scripts', 'my_login_stylesheet');
function admin_default_page()
{
    return get_site_url();
}

if (is_user_logged_in() && !current_user_can('administrator')) {
    add_filter('login_redirect', 'admin_default_page');
}

add_action('no-woocommerce_archive_description', 'product_date');
function product_date()
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1000
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        $id = get_the_ID();
        $product = wc_get_product($id);
        $start_date = strtotime($product->get_attribute('pa_start-date'));
        $end_date = strtotime($product->get_attribute('pa_end-date'));
        $now = time();
        global $wpdb;
        if ($now < $end_date && $now > $start_date) {
            $wpdb->update('wp_posts', array('post_status' => 'publish'), array('ID' => $id));
        } else {
            $wpdb->update('wp_posts', array('post_status' => 'draft'), array('ID' => $id));
        }
    endwhile;

}

add_action('admin_menu', function () {
    add_menu_page('d`VOUR Options', 'd`VOUR', 'edit_pages', __FILE__, 'dvour_admin');
    function dvour_admin()
    {
        require_once(get_stylesheet_directory() . "/admin.php");
    }
});

add_action('wp_ajax_remove_city', 'remove_city');
add_action('wp_ajax_nopriv_remove_city', 'remove_city');
function remove_city()
{
    global $wpdb;
    $name = $_POST['name'];
    $wpdb->delete('city', array('city_name' => $name));
    echo $name . " is deleted";
    wp_die();
}

add_action('wp_logout', 'logout_session_unset');
function logout_session_unset()
{
    session_unset();
}

function my_wp_nav_menu_args($args = '')
{
    if (is_user_logged_in()) {
        $args['menu'] = 'logged-in';
    } else {
        $args['menu'] = 'menu-1';
    }
    return $args;
}

add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');


function firstdelivery()
{
    $firstday = get_term_by('slug', 'monday', 'product_cat', ARRAY_A);
    return $firstday['name'];
}

add_shortcode('firstdeliveryday', 'firstdelivery');
function seconddelivery()
{
    $secondday = get_term_by('slug', 'thursday', 'product_cat', ARRAY_A);
    return $secondday['name'];
}

add_shortcode('seconddeliveryday', 'seconddelivery');

function right_widget_dates()
{
    if (isset($_GET['date'])) {
        $nowis = $_GET['date'];
    } else {
        $nowis = time() + (3 * 24 * 60 * 60);
    }
    $firstdata = get_term_by('slug', 'monday', 'product_cat', ARRAY_A);
    $seconddata = get_term_by('slug', 'thursday', 'product_cat', ARRAY_A);
    $firstday = $firstdata['name'];
    $secondday = $seconddata['name'];
    for ($j = 0; $j < 7; $j++) {
        $day = $nowis + ($j * 24 * 60 * 60);
        if (date('l', $day) == $firstday) {
            $firstdeliverytime = $day;
        }
        if (date('l', $day) == $secondday) {
            $seconddeliverytime = $day;
        }
    }
    if ($firstdeliverytime > $seconddeliverytime) {
        $widget_content = "<div class='show_prod'>View Cart <i class='fa fa-caret-down' aria-hidden='true'></i></div><div class='mymeels'><span class='cart_close'>close</span>
        <div class='wednesday' data-dilevery='" . date('d F', $seconddeliverytime) . "'><h4>" . $secondday . "<span class='next_wednesday'> " . date('d F', $seconddeliverytime) . "</span> Delivery</h4></div>
        <div class='sunday' data-dilevery='" . date('d F', $firstdeliverytime) . "'><h4>" . $firstday . "<span class='next_sunday'> " . date('d F', $firstdeliverytime) . "</span> Delivery</h4></div>
        </div>";
        return $widget_content;
    }
    if ($firstdeliverytime < $seconddeliverytime) {
        $widget_content = "<div class='show_prod'>View Cart <i class='fa fa-caret-down' aria-hidden='true'></i></div><div class='mymeels'><span class='cart_close'>close</span>
        <div class='sunday' data-dilevery='" . date('d F', $firstdeliverytime) . "'><h4>" . $firstday . "<span class='next_sunday'> " . date('d F', $firstdeliverytime) . "</span> Delivery</h4></div>
        <div class='wednesday' data-dilevery='" . date('d F', $seconddeliverytime) . "'><h4>" . $secondday . "<span class='next_wednesday'> " . date('d F', $seconddeliverytime) . "</span> Delivery</h4></div>
        </div>";
        return $widget_content;
    }

}

add_shortcode('delivery_dates', 'right_widget_dates');
add_filter('widget_text', 'do_shortcode');

add_action('wp_ajax_email_validation', 'email_validation');
add_action('wp_ajax_nopriv_email_validation', 'email_validation');
function email_validation()
{
    $new_email = $_POST['email'];
    global $wpdb;
    $old_email = $wpdb->get_var("SELECT `user_email` FROM `wp_users` WHERE `user_email`='" . $new_email . "'");
    if ($old_email == NULL) {
        echo "empty";
    } else {
        echo "error_validation";
    }
    wp_die();
}


add_action('new_order_mail', 'send_new_mail');
function send_new_mail()
{
    if (date('l', time()) == 'Friday') {
        global $wpdb;
        $capability = 'a:1:{s:8:"customer";b:1;}';/*'a:2:{s:8:"customer";b:1;s:8:"Customer";b:1;}';*/
        $user_id_s = $wpdb->get_results("SELECT `user_id` FROM `wp_usermeta` WHERE `meta_value`='" . $capability . "'", 'ARRAY_A');
        foreach ($user_id_s as $user_id) {
            $order_id = $wpdb->get_var("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value`='".$user_id."'");
            $order_item_id = $wpdb->get_var("SELECT `order_item_id` FROM `wp_woocommerce_order_items` WHERE `order_id`='".$order_id."' AND `order_item_type`='line_item'");
            $subscription_start_day = $wpdb->get_var("SELECT `meta_value` FROM `wp_woocommerce_order_itemmeta` WHERE `meta_key`='Subscription start date' AND `order_item_id`='".$order_item_id."'");
            if(strtotime($subscription_start_day)<time()){
            $user = $wpdb->get_var("SELECT `user_email` FROM `wp_users` WHERE `ID`='" . $user_id['user_id'] . "'");
            $to = $user;
           include('chooseproduct-email-template.php');
            wp_mail($to, $subject, $message);
        }
    }
    }
}

add_action('dvour_mobile_menu', 'burger_signup_corection');
function burger_signup_corection()
{
    ?>
    <script type="text/javascript">
        setTimeout(function () {
            jQuery('.mm-toggle').click(function () {
                if (jQuery('#mobile_sign_up').css('display') == "block") {
                    jQuery('#mobile_sign_up').css('display', 'none');
                }
                else {
                    if (jQuery('#mobile_sign_up').css('display') == "none") {
                        jQuery('#mobile_sign_up').css('display', 'block');
                    }
                }
            });
        }, '1000');
    </script>
    <?php
}

add_action('wp_ajax_unsubscribe', 'ajax_unsubscribe');
add_action('wp_ajax_nopriv_unsubscribe', 'ajax_unsubscribe');
function ajax_unsubscribe(){
    global $wpdb;
    $sub_id = $_POST['subscription_id'];
    include(ABSPATH . 'wp-content/plugins/woocommerce-subscriptions/includes/class-wc-subscriptions-manager.php');
    WC_Subscriptions_Manager::cancel_subscriptions_for_order( $sub_id );
    $wpdb->update('wp_mixpro_meels', array('sub_id'=>''), array('user_id'=>get_current_user_id()));
    $wpdb->update('wp_posts', array('post_status'=>'wc-completed'), array('ID'=>$sub_id));
    wp_die();
}


add_action('next_delivery_date', 'next_delivery_date_update');
function next_delivery_date_update (){
    for($i=3; $i<10; $i++){
        $day = time()+($i*24*60*60);
        if(date('l', $day)=="Monday" || date('l', $day)=='Thursday'){
            $next_delivery_date = date('d M, l', $day);
            break;
        }
    }
    $orders = new WP_Query(array('post_type' => 'order'));
    if($orders->have_posts()){
        while($orders->have_posts()){
            $orders->the_post();
	        $order_id = get_the_ID();
	        $order_items = $wpdb->get_row("SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id`='" . $order_id . "'", ARRAY_A);
	        $order_item_id = $order_items['order_item_id'];
	        $start_day = $wpdb->get_var("SELECT `meta_value` FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id`='".$order_item_id."' AND `meta_key`='Subscription start date'");
		        if(strtotime($start_day)<strtotime($next_delivery_date)){
		            $meta_key = 'Next Delivery Date';
		            $meta_value = $next_delivery_day;
		            $order_update = array('meta_value' => $meta_value);
		            $where = array('order_item_id' => $order_item_id, 'meta_key' => $meta_key);
		            $wpdb->update('wp_woocommerce_order_itemmeta', $order_update, $where);
		        }
        }
    }
}
add_action('meal_delivery_date', 'meal_delivery_date');
function meal_delivery_date(){
	global $wpdb;
	 $orders = new WP_Query(array('post_type' => 'shop_order', 'post_status' => 'publish'));
        while($orders->have_posts()){

            $orders->the_post();
            $order_id = get_the_ID();

	        $order_items = $wpdb->get_row("SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id`='" . $order_id . "'", ARRAY_A);
	        $order_item_id = $order_items['order_item_id'];
	        	for($i=1; $i<25; $i++){
	        		 $meta_key = 'meals'.$i;
	        		$meal = $wpdb->get_var("SELECT `meta_value` FROM `wp_woocommerce_order_itemmeta` WHERE `meta_key`='".$meta_key."' AND `order_item_id`='".$order_item_id."'");
	        		if($meal == NULL){
	        			break;
	        		}
	        		else {
                        $meal1 = stristr($meal, '</a>', true);
                        $meal2 = stristr($meal1, '">');
                        $meal = substr($meal2, 2);
		           $_product = get_page_by_title( $meal, '', 'product' );
                   $_product = wc_get_product($_product->ID);
                   $meals_date = explode(',', $_product->get_attribute('pa_meal-date'));
                   $day="not available";
                   foreach($meals_date as $val){
                    $d = strtotime($val);
                    if($d<time()+(7*24*60*60) && $d>time()-(12*60*60)){
                        $day=date('l, d F', strtotime($val));
                    }
                   }

		            $meta_value = '<a href="'.get_permalink($_product->id).'" target="_blank">'.get_the_title($_product->id).'</a> ('.$day.')';
		            $order_update = array('meta_value' => $meta_value);
		            $where = array('order_item_id' => $order_item_id, 'meta_key' => $meta_key);
		            $wpdb->update('wp_woocommerce_order_itemmeta', $order_update, $where);
		        }
		    }
    }
}
add_action('shoore_that_not_same_plan', 'choose_same_plan_warning');
function choose_same_plan_warning(){
    if(is_user_logged_in()) {
        global $wpdb;
        $order_ids = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value`='".get_current_user_id()."'");
        $orders = array();
        foreach($order_ids as $value){
            $order = $wpdb->get_row("SELECT * FROM `wp_posts` WHERE `ID`='".$value->post_id."'");
            if($order->post_status=="wc-processing"){
                array_push($orders, $order);
            }
        }
        //echo  "<pre>"; var_dump(end($orders)->ID); exit;
        $last_order_id = end($orders)->ID;
        $last_order_title = $wpdb->get_var("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE `order_item_type`='line_item' AND `order_id`='".$last_order_id."'");
        ?>
<script>
    jQuery(document).ready(function(){
        jQuery('.huge_it_features_buy_link_a').click(function(event){

            console.log('ok');
            var title = jQuery(this).parents('.hugeit_features_name').find('.huge_it_features_head span').text();
            if(title.indexOf('<?php echo $last_order_title;?>')+1){
               alert('You are already using that plan, please choose another');
                event.preventDefault();
            }
        });
    });
</script>
<?php
    }
}