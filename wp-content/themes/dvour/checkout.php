<?php

/**
 * Template Name:  Checkout
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>

<?php
if(is_user_logged_in() && isset($_GET['sub'])){
    global $wpdb;
    $user_id = get_current_user_id();
    $orders = array();
    $meta_orders = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value`='".$user_id."'");
        foreach($meta_orders as $value){
            $ord = get_post($value->post_id);
            if($ord->post_status == "wc-processing"){
                array_push($orders, $ord->ID);
            }
    }
   if(count($orders)>0){
       foreach($orders as $value){
           WC_Subscriptions_Manager::cancel_subscriptions_for_order( $value );
           $wpdb->update('wp_posts', array('post_status'=>'wc-completed'), array('ID'=>$value));
       }
   }
}
$_SESSION['plan']=$_GET['sub'];
?>
<?php
if(isset($_GET['key'])){
    ?>
    <style>
        ul.woocommerce-error {display:none;}
        table.shop_table.woocommerce-checkout-review-order-table {display:none;}
    </style>
    <?php
}
?>
<?php get_header( 'step' );
?>
<div class="breadcrumps">
<a href="<?php echo get_site_url();?>"><img src="<?php echo get_site_url();?>/wp-content/uploads/2017/04/logosmall.png" class='step-header-img'></a>

Plan&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspDay&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspMeals&nbsp&nbsp&nbsp>&nbsp&nbsp&nbsp<span>Checkout</span>
</div>
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
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>2</span> Delivery Address
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body j">
                            <div class="row">
                                <?php the_post(); the_content();?>

                            </div>
                        </div>
                    </div>
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
        <?php
            do_action( 'woocommerce_review_order_before_cart_contents' );

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    ?>
                    <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                        <td class="product-name">
                            <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
                            <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
                            <?php  echo WC()->cart->get_item_data( $cart_item );  ?>
                        </td>
                        <td class="product-total">
                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                        </td>
                    </tr>
                    <?php
                }
            }

            do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </tbody>
    <tfoot>

        <tr class="cart-subtotal">
            <th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
            <td><?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <tr class="fee">
                <th><?php echo esc_html( $fee->name ); ?></th>
                <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
            <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                    <tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                        <th><?php echo esc_html( $tax->label ); ?></th>
                        <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="tax-total">
                    <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                    <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

        <tr class="order-total">
            <th><?php _e( 'Total', 'woocommerce' ); ?></th>
            <td><?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

        <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

    </tfoot>
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
                                    $exp = get_post($meels)->post_content;
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
<?php get_footer('step');?>
<style>
    #customer_details .col-1 {
        width: 100% !important;
    }
    .woocommerce-billing-fields h3 {
        display:none;
    }
    .blockUI.blockOverlay {
        display:none !important;
    }
.j .panel.panel-default {
margin-left:-46px;
margin-right:-46px;
}
.j .panel.panel-default #order_review {
padding-left:46px;
padding-right:46px;
}
.woocommerce-Price-amount.amount {
display:block !important;
}
.order_block .woocommerce-checkout-review-order-table .product-name dl{
    display: none !important;
}
input#terms {
    display: inline !important;
    width: inherit !important;
}
    </style>
<?php if(isset($_GET['sub'])){if($_GET['sub']!='217'){?>
<script>
setTimeout(function(){jQuery('td[data-title="Shipping"]').html("$15");}, 600);
setTimeout(function(){jQuery('.cart-subtotal .amount').text('$'+(parseFloat(jQuery('.cart-subtotal .amount').text().replace('$', ''))-15));}, 600);
setTimeout(function(){jQuery('.product-total .amount').text('$'+(parseFloat(jQuery('.product-total .amount').text().replace('$', ''))-15));}, 600);
</script>
<?php 
}}
?>