<?php
/**
 * Template Name: Cart
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>

<?php if(is_user_logged_in()){
    $checkout_url = get_site_url()."/checkout/?date=".$_GET['date']."&sub=".$_GET['sub'];
    header('Location: '.$checkout_url);
}?>
<?php
if(!is_user_logged_in() && isset($_POST['my_email']) && isset($_POST['my_pass'])) {
    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];
    $pass = $_POST['my_pass'];
    $email = $_POST['my_email'];
    $tell = $_POST['my_tell'];
    $customer_id = wc_create_new_customer($email, $email, $pass);

    update_user_meta($customer_id, "first_name", $fn);
    update_user_meta($customer_id, "last_name", $ln);
     update_user_meta($customer_id, "billing_phone", $tell);
    if(isset($_SESSION['city'])){
        update_user_meta($customer_id, "billing_city", $_SESSION['city']);
    }
    $creds = array(
        'user_login' => $email,
        'user_password' => $pass,
        'remember' => true
    );
    wp_signon($creds);
    header("Refresh:0");
}
?>
<?php get_header('step'); ?>

<div class="breadcrumps">
<a href="<?php echo get_site_url();?>"><img src="<?php echo get_site_url();?>/wp-content/uploads/2017/04/logosmall.png" class='step-header-img'></a>

Plan&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspDay&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspMeals&nbsp&nbsp&nbsp>&nbsp&nbsp&nbsp<span>Checkout</span>
</div>
<div style="display:none"><?php the_post(); the_content();?></div>
<?php
$style = get_stylesheet_directory_uri()."/style.css";
$new_style = get_stylesheet_directory_uri()."/assets/css/newstyle.css";
$media = get_stylesheet_directory_uri()."/assets/css/media.css";
wp_enqueue_style('st1', $style);
wp_enqueue_style('st2', $new_style);
wp_enqueue_style('st3', $media);
?>
<div class="page_wrapper">
    <div class="row">
        <div class="col-lg-7 col-md-7  no-padding-left create_account">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <span>1</span> Create account
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <form id="reg_form" action="<?php echo get_site_url();?>/cart/?date=<?php echo $_GET['date'];?>&sub=<?php echo $_GET['sub']?>" method="post">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" id="fn" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" id="ln" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Email</label>
                                         <?php if(isset($_SESSION['email'])){?>
                                        <input type="email" name="my_email" value="<?php echo $_SESSION['email']; ?>" id="myemail" required>
                                        <?php }else {?>
                                        <input type="email" name="my_email" id="myemail" required>
                                        <?php }?>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Tel Number</label>
                                        <input type="tel" name="my_tell" id="mytell" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Password (6 Characters Minimum)</label>
                                        <input type="password" name="my_pass" id="mypass" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <p>Already have an account? <a href="<?php echo get_site_url().'/wp-login.php';?>" style="color: #f15a38 ">Log in</a></p>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="submit" value="Next" class="next_btn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="test">
                                <span>2</span> Delivery Address
                            </a>
                        </h4>
                    </div>
<!--                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">-->
<!--                        <div class="panel-body">-->
<!--                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span>3</span> Payment
                            </a>
                        </h4>
                    </div>
<!--                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">-->
<!--                        <div class="panel-body">-->
<!--                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5  no-padding-left order_block">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                       Order summary
                    </h4>
                </div>
                <div class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php
                        $sub = $_SESSION['plan'];
                        switch ($_SESSION['plan']) {
                            case '217' :
                                $c = 1;
                                break;
                            case '110' :
                                $c = 6;
                                break;
                            case '135' :
                                $c = 12;
                                break;
                            case '136' :
                                $c = 24;
                                break;
                        }
                        ?>
                         <table class="shop_table woocommerce-checkout-review-order-table" id="my">
    <thead>
        <tr>
            <th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
            <th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
                                <th><?php echo $c; ?> Meals Per Week</th>
                                <td class="a"><?php echo wc_get_product($_SESSION['plan'])->get_price();?></td>
                            </tr>
    </tbody>
</table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                       My Meals
                    </h4>
                </div>
                <div class="panel-collapse collapse in">
                    <div class="mymeel">
                        <table class="table my_meals_table">
                        <?php
                        if(isset($_SESSION['prods'])){

                            foreach($_SESSION['prods'] as $meels){
                                $name = get_the_title($meels);
                                $thumb = get_the_post_thumbnail($meels, array('55px', '55px'));
                                $exp = get_post($meels)->post_content;;
                                ?>

                                    <tr>
                                        <td>1</td>
                                        <td class="cart_thumb">
                                            <?php echo $thumb;?>
                                        </td>
                                        <td>
                                            <h5><?php echo $name;?></h5>
                                            <p><?php echo $exp;?></p>
                                        </td>
                                    </tr>
                                <style>
                                    .cart_thumb {
                                        width: 70px !important;
                                    }
                                    td {
                                        vertical-align:middle !important;
                                    }
                                </style>

                        <?php
                            }
                        }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery('#reg_form').submit(function(event){
    event.preventDefault();
    var ajaxurl = "<?php echo get_site_url();?>/wp-admin/admin-ajax.php";
    var email = jQuery('#myemail').attr('value');
    data = {
        'action': "email_validation",
        'email':email
    };
    jQuery.post(ajaxurl, data, function(response){
        if(response=="error_validation"){
            alert('This Email Address Already Exists');
            jQuery('#myemail').focus();
            return false;
        }
        if(response=="empty")
        {
            jQuery('#reg_form').unbind('submit').submit();
        }
    });
});
});
</script>
<style>
span.woocommerce-Price-amount.amount {
    display:inline !important;
}
.order_block .woocommerce-checkout-review-order-table .product-name dl{
    display: none !important;
}
.order_block .woocommerce-checkout-review-order-table {
	margin-top: 20px;
}
.no-padding-left{
	margin-top:90px;
}
</style>
<?php get_footer('step'); ?>

