<?php
/**
 * Plugin Name: Woo Mixed Products
 * Plugin URI: https://facebook.com/alarayv/
 * Description: Plugin for selling few products together
 * Version: 1.0
 * Author: A.A.V.
 * Author URI: https://facebook.com/alarayv/
 **/

add_action('init', 'do_session_start');
function do_session_start()
{
    if (!session_id()) session_start();

}
add_action('wp_footer', 'recalc_products', 100000);
function recalc_products(){
    echo "<script>setTimeout(recalc, '1000');</script>";
}
add_action('woocommerce_after_main_content', 'add_or_remove_html');
function add_or_remove_html()
{
    wp_enqueue_script('shop_script', plugins_url() . '/mixpro/shop.js', '', '', true);
    wp_enqueue_style('mixpro_style', plugins_url() . '/mixpro/style.css');

}

/**
 *              AJAX START
 */
add_action('wp_head', 'add_or_remove_product');
function add_or_remove_product()
{ ?>
    <script>
        var plan_count = 1;
        var choosed_plan = "<?php echo $_SESSION['plan'];?>";
        if (choosed_plan == '110') {
            plan_count = 6;
        }
        if (choosed_plan == '135') {
            plan_count = 12;
        }
        if (choosed_plan == '136') {
            plan_count = 24;
        }
        if (choosed_plan == '217') {
            plan_count = 1;
        }
        function recalc() {
            var product_count = 0;
            jQuery('#secondary .mymeels li.product .min_prod_left span').each(function( index ,el) {
                product_count += parseInt(jQuery(this).text());
            });
            jQuery(document).find('.your_meels_count').html(product_count + ' of <span class="choos">' + plan_count + '</span>');
            var must_choose = plan_count - product_count;
            if(product_count != plan_count){
                jQuery('.next_add_to_cart').css('background', '#f9bdaf');
                jQuery('.next_add_to_cart').removeAttr('href');
                jQuery('.choose_x_meals').html('Please add '+must_choose+' meals to continue');
            }else{
                jQuery('.next_add_to_cart').css('background', '#f15a38');
                jQuery('.next_add_to_cart').attr('href', jQuery('.next_add_to_cart').attr('data-href'));
                jQuery('.choose_x_meals').html('Please add '+must_choose+' meals to continue');
            }
            mobile_recalc(plan_count, product_count);

        }
        ajaxurl = "<?php echo get_site_url();?>/wp-admin/admin-ajax.php";
        jQuery(document).ready(function () {
            jQuery('.plus').click(function () {
                plus = jQuery(this);
                jQuery(this).attr('disabled', true);
                var prodcount = 0;
                pcount = jQuery('.min_prod_left span').each(function () {
                    prodcount = prodcount + parseInt(jQuery(this).html());
                    return prodcount;
                });
                if (prodcount > parseInt(parseInt(plan_count) - 1)) {
                    if(parseInt(jQuery(this).parent().find('span').html()) != 0) {
                        /*jQuery(this).parent().find('span').html(parseInt(jQuery(this).parent().find('span').html()) - 1);*/
                    }
                    alert('You Can Choose Only ' + plan_count + ' Items');
                    return false;
                }
                else {
                    plus.parent().find('.minus').css('background', '#8C9192');
                    var data = {
                        'action': 'add_or_remove',
                        'prod': jQuery(this).parent().parent().find('a').attr('title')
                    };
                    var _this = jQuery(this);
                    /**
                     *            SEND AJAX
                     **/

                    jQuery.post(ajaxurl, data, function (response) {
                        plus.attr('disabled', false);
                        var arr = JSON.parse(response);
                        /* FIND SAME */
                        if (jQuery('.mymeels .product').is('[data-title="' + arr.title + '"]')) {
                            jQuery('.mymeels .product[data-title="' + arr.title + '"] .min_prod_left span').html(parseInt(jQuery('.mymeels .product[data-title="' + arr.title + '"] .min_prod_left span').html()) + 1);
                        }
                        else   /**  DOESNT HAVE SAME  **/
                        {

                            var cat =  plus.parents('li.product[data-delivery]').attr('data-delivery');
                            var dates = cat.split(', ');
                            var section1 = jQuery('#secondary .mymeels [data-dilevery]').eq(0).attr('data-dilevery');
                            var section2 = jQuery('#secondary .mymeels [data-dilevery]').eq(1).attr('data-dilevery');

                            var finalSection = null;
                            if(jQuery.inArray(section1, dates) !== -1){
                                finalSection = section1;
                            }else if(jQuery.inArray(section2, dates) !== -1){

                                finalSection = section2;
                            }
                            jQuery('#secondary .mymeels [data-dilevery="'+finalSection+'"]').append("<li class='product' data-title='" + arr.title + "'>" +
                                "<table class='min_prod_left '>" +
                                "<tr>" +
                                "<td>" +
                                "<button class='smallplus'><i class='fa fa-plus' aria-hidden='true'></i></button>" +
                                "<span>1</span>" +
                                "<button class='smallminus'><i class='fa fa-minus' aria-hidden='true'></i></button>" +
                                "</td>" +
                                "<td>" + arr.thumb + "</td>" +
                                "<td><h5>" + arr.title + "</h5><p>" + arr.exp + "</p>" + "</td>" +
                                "<td>" + "<a class='full_remove'><i class='fa fa-times' aria-hidden='true'></i></a>" + "</td>" +
                                "</tr>" +
                                "</table>" +
                                "</li>");

                        }

                        /**DOESNT HAVE SAME --- END **/


                        var bigtitle = _this.parent().parent().find('a').attr('title');
                        var smallspan = jQuery('.mymeels li[data-title="' + bigtitle + '"]').find('.min_prod_left span');
                        _this.parent().find('span').html(parseInt(smallspan.html()));

                        recalc();


                    });
                }

            });
        });

        /**
         *              SMALL PLUS
         **/
        jQuery(document).on('click', '.smallplus', function () {
            var count = 0;
            jQuery('.min_prod_left span').each(function () {
                count += parseInt(jQuery(this).html());
                return count;
            });
            /**                     CHECK COUNT OF ITEMS        **/
            if (count > parseInt(plan_count) - 1) {
                alert('You can chouse only ' + plan_count + ' Items');
                return false;
            }
            else {
                var product_name = jQuery(this).parents('li').attr('data-title');
                var product_count_span = jQuery('.item-title a[title="' + product_name + '"]').parents('.item-info').find('.addremove span');
                product_count_span.html(parseInt(product_count_span.html()) + 1);
                var smallspan = jQuery(this).parent().find('span');
                smallspan.html(parseInt(smallspan.html()) + 1);

                var spdata = {
                    'action': 'add_or_remove',
                    'prod': product_name
                };
                jQuery.post(ajaxurl, spdata, function (spresponse) {
                    /** smal plus response **/
                    sparr = JSON.parse(spresponse);
                });
            }

            recalc();
        });
        /**
         *          SMALL PLUS END
         **/

        /**
         * MINUS MINUS MINUS MINUS MINUS MINUS MINUS MINUS MINUS MINUS MINUS MINUS
         **/
        jQuery(document).ready(function () {
            jQuery('.minus').click(function () {
                var th = jQuery(this);
                var bigtitle = jQuery(this).parent().parent().find('a').attr('title');
                var smallspan = jQuery('.mymeels li[data-title="' + bigtitle + '"]').find('.min_prod_left span');
                if(typeof parseInt(smallspan.html()) !== 'undefined' && parseInt(smallspan.html()) > 0) {
                    smallspan.html(parseInt(smallspan.html()) - 1);
                    jQuery(this).parent().find('span').html(parseInt(smallspan.html()));
                }
                if (smallspan.html() == '0') {
                    jQuery('.mymeels li[data-title="' + bigtitle + '"]').remove();
                    th.css('background', '#d8d8d8');
                }
                var data = {
                    'action': 'remove',
                    'prod': jQuery(this).parent().parent().find('a').attr('title')
                };
                jQuery.post(ajaxurl, data, function (response) {
                    recalc();
                });

            });
        });
        /**
         *          SMALL MINUSS
         **/
        jQuery(document).on('click', '.smallminus', function () {
            var product_name = jQuery(this).parents('li').attr('data-title');
            var product_count_span = jQuery('.item-title a[title="' + product_name + '"]').parents('.item-info').find('.addremove span');
            if(parseInt(product_count_span.html())>0){
                product_count_span.html(parseInt(product_count_span.html()) - 1);
            }
            var smallspan = jQuery(this).parent().find('span');
            if (parseInt(smallspan.html()) > 0) {
                smallspan.html(parseInt(smallspan.html()) - 1);
            }
            if (smallspan.html() == '0') {
                jQuery('.mymeels li[data-title="' + product_name + '"]').remove();

            }
            var data = {
                'action': 'remove',
                'prod': product_name
            };
            jQuery.post(ajaxurl, data, function (response) {
                console.log(response);
            });
            recalc();

        });
        /**
         *          Remove item X
         */
        jQuery(document).on('click', '.full_remove', function () {
            var remove_title = jQuery(this).parent().parent().parent().parent().parent().attr('data-title');
            jQuery('a[title="' + remove_title + '"]').parent().parent().parent().parent().find('span').html('0');
            jQuery(this).parent().parent().parent().parent().parent().remove();
            var removedata = {
                'action': 'full_remove',
                'title': remove_title
            };
            jQuery.post(ajaxurl, removedata, function (response) {
                console.log('removed = ' + response);
            });
            recalc();
        });
    </script>
    <?php

}

/**
 *          NEXT BUTTON
 */
add_action('wp_footer', 'add_next_button', 1000);
function add_next_button()
{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'menu') {
            $nextbutton = "<div class='next'><p class='choose_x_meals'>Please add 6 meals to continue</p><a data-href='" . get_site_url() . "/cart/?sub=" . $_GET['sub'] . "&date=" . $_GET['date'] . "&action=add_to_cart' class='next_add_to_cart'>NEXT</a></div>";
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('.archive.post-type-archive.post-type-archive-product.woocommerce.woocommerce-page .col-main.col-sm-9').append("<?php echo $nextbutton;?>");

                    jQuery(document).on('click','.next_add_to_cart', function(event) {
                        var count_pr = 0;
                        jQuery('.product table tbody td span').each(function (key, value) {
                            count_pr += parseInt(jQuery(value).html());
                        });
                        if(count_pr !== plan_count) {
                            event.preventDefault();
                            alert('You should select ' + plan_count + ' meals. \n Already selected '+count_pr+' meals');
                        }
                    });
                });
            </script>
            <style>

                .next_add_to_cart {
                    display: block;
                    /*position: fixed;*/
                    background: #f9bdaf;
                    border: 2px solid #f15a38;
                    width: 100%;
                    text-align: center;
                    float: right;
                    z-index: 99999;
                    clear: both;
                    color: #fff;
                    padding: 10px;
                    font-family: DINProMedium;
                    bottom: 10px;
                    right:100px;
                    margin-bottom: 10px;
                    cursor: pointer;
                }
                @media screen and (max-width: 1750px){
                    .next_add_to_cart {
                        right:60px;
                    }
                }
                @media screen and (max-width: 1400px){
                    .next_add_to_cart {
                        right:40px;
                    }
                }
                @media screen and (max-width: 1300px){
                    .next_add_to_cart {
                        right:20px;
                    }
                    .next{
                        padding-right: 0
                    }
                }
                @media screen and (max-width: 1160px){
                    /*.next_add_to_cart {
                        right:20px;
                        width:250px;
                    }*/

                }
                @media screen and (max-width: 990px){
                    .next_add_to_cart {
                        right:0px;
                    }
                    .choose_x_meals{
                        font-size: 14px;
                    }
                }
                @media screen and (max-width: 768px){
                    .next_add_to_cart {
                        right:0px;
                        width:100%;
                        bottom: 0px;
                        margin-bottom: 0px;
                    }
                    li.product {
                        width:45% !important;
                    }
                    .next {
                        position: fixed;
                        right: 0;
                        left: 0;
                        bottom: 0;
                        height: auto;
                        width: 100%;
                        padding: 0;
                        z-index: 4;
                    }
                }
                @media screen and (max-width: 610px){
                    li.product {
                        width:95% !important;
                    }
                }
                .next_add_to_cart:hover {
                    color: #f15a38 !important;
                    background: #fff !important;
                    font-weight: bold !important;

                }
            </style>
            <?php
        }
    }
    else {
        $nextbutton = "<div class='next'><a class='next_add_to_cart'>Submit</a></div>";
        echo $nextbutton; ?>
        <style>
            .next_add_to_cart {display:none;}
            .archive.post-type-archive.post-type-archive-product.wp-custom-logo.woocommerce.woocommerce-page .next_add_to_cart {
                display: block;
                /*position: fixed;*/
                background: #f15a38;
                border: 2px solid #f15a38;
                width: 100%;
                text-align: center;
                float: right;
                z-index: 99999;
                clear: both;
                color: #fff;
                padding: 10px;
                font-family: DINProMedium;
                bottom: 10px;
                right:100px;
                margin-bottom: 10px;
                cursor: pointer;
            }
            @media screen and (max-width: 1750px){
                .next_add_to_cart {
                    right:60px;
                }
            }
            @media screen and (max-width: 1400px){
                .next_add_to_cart {
                    right:40px;
                }
            }
            @media screen and (max-width: 1300px){
                .next_add_to_cart {
                    right:20px;
                }
                .next{
                    padding-right: 0
                }
            }
            @media screen and (max-width: 1160px){
                /*.next_add_to_cart {
                    right:20px;
                    width:250px;
                }*/

            }
            @media screen and (max-width: 990px){
                .next_add_to_cart {
                    right:0px;
                }
                .choose_x_meals{
                    font-size: 14px;
                }
            }
            @media screen and (max-width: 768px){
                .next_add_to_cart {
                    right:0px;
                    width:100%;
                    bottom: 0px;
                    margin-bottom: 0px;
                }
                li.product {
                    width:45% !important;
                }
                .next {
                    position: fixed;
                    right: 0;
                    left: 0;
                    bottom: 0;
                    height: auto;
                    width: 100%;
                    padding: 0;
                    z-index: 4;
                }
            }
            @media screen and (max-width: 610px){
                li.product {
                    width:95% !important;
                }
            }
            .next_add_to_cart:hover {
                color: #f15a38 !important;
                background: #fff !important;
                font-weight: bold !important;

            }
        </style>
        <script>
            jQuery('.next_add_to_cart').click(function(){location.reload();})
        </script>
        <?php
    }
}

/**
 *          DISPLAY THE PRODUCTS FROM SESSION
 */
add_action('wp_footer', 'choosed_prods', '1');
function choosed_prods()
{
    global $wpdb;
    $user_id = get_current_user_id();
    if (!isset($_SESSION['prods']) && $user_id !== 0) {
        $plan = $_SESSION['plan'];
        $prods = $wpdb->get_var("SELECT `products` FROM `wp_mixpro_meels` WHERE `plan` = '{$plan}' AND `user_id` = '{$user_id}' ");
        $prods = json_decode($prods, true);
        $_SESSION['prods'] = array_values(array_filter($prods));
    } else if(!isset($_SESSION['prods']) && $user_id == 0) {
        $where = array(
            'user_id' => $user_id
        );
        $data = array(
            'products' => ''
        );
        $wpdb->update('wp_mixpro_meels', $data, $where);

    }
    foreach ($_SESSION['prods'] as $meel_id) {
        $meal_days = wc_get_product( $meel_id)->get_attribute('pa_meal-date');
        $cats = get_the_terms($meel_id, 'product_cat');
        foreach ($cats as $category) {
            $cat = $category->slug;
        }
        $name = get_the_title($meel_id);
        $thumb = get_the_post_thumbnail($meel_id, array('50px', '50px'));
        $exp = get_the_excerpt($meel_id);
        $counts = array_count_values(array_filter($_SESSION['prods']));

        ?>
        <script>
            if (jQuery('.mymeels .product').is('[data-title="<?php echo $name;?>"]')) {
                jQuery('.mymeels .product[data-title="<?php echo $name;?>"] .min_prod_left span').html(parseInt(jQuery('.mymeels .product[data-title="<?php echo $name;?>"] .min_prod_left span').html()) + 1);
            }
            else {
                var cat =  "<?php echo $meal_days;?>";
                var dates = cat.split(', ');
                var section1 = jQuery('#secondary .mymeels [data-dilevery]').eq(0).attr('data-dilevery');
                var section2 = jQuery('#secondary .mymeels [data-dilevery]').eq(1).attr('data-dilevery');

                var finalSection = null;
                if(jQuery.inArray(section1, dates) !== -1){
                    finalSection = section1;
                }else if(jQuery.inArray(section2, dates) !== -1){

                    finalSection = section2;
                }
                jQuery('.mymeels [data-dilevery="'+finalSection+'"]').append('<li class="product" data-title="<?php echo $name;?>">' +
                    "<table class='min_prod_left '>" +
                    '<tr>' +
                    '<td>' +
                    '<button class="smallplus"><i class="fa fa-plus" aria-hidden="true"></i></button>' +
                    '<span>1</span>' +
                    '<button class="smallminus"><i class="fa fa-minus" aria-hidden="true"></i></button>' +
                    '</td>' +
                    '<td><?php echo $thumb; ?></td>' +
                    '<td><h5><?php echo $name;?></h5><p><?php echo $exp;?></p>' + '</td>' +
                    '<td>' + '<a class="full_remove"><i class="fa fa-times" aria-hidden="true"></i></a>' + '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</li>');
            }
            var mycount = jQuery('.item-title h3 a[title="<?php echo $name;?>"]').parent().parent().parent().parent().find('.addremove span');
            mycount.html(parseInt(mycount.html()) + 1);
        </script>

        <script type="text/javascript">
            setTimeout(function () {
                jQuery('a[title="<?=$name?>"]').parents('.item-info').find('.addremove span').html('<?=$counts[$meel_id]?>');
            }, 300);
        </script>
        <?php
    }

    if (count($_SESSION['prods']) > 0) {
        $count_products = count($_SESSION['prods']);
    } else {
        $count_products = 0;
    }

    ?>
    <script type="text/javascript">
        setTimeout(function () {
            var product_count = <?=$count_products?>;
            jQuery(document).find('.your_meels_count').html(product_count + ' of <span class="choos">' + plan_count + '</span>');
        }, 100);


    </script>
    <?php
}

add_action('wp_footer', 'mobile_recalc', 99);
function mobile_recalc(){
    ?>

    <script>
        function mobile_recalc(plan_count, product_count){
            if(jQuery(window).width()<769){
                jQuery('.left_your_meels').html('Choose '+plan_count+' meals /');
                jQuery('.your_meels_count').append(' chosen');
            }
        }
        jQuery('.show_prod').on('click', function(){
            console.log('click');
            if(jQuery('.mymeels').css('display')=='none')
            {
                jQuery('.mymeels').css('display', 'block');
                jQuery('.archive .row .col-main').toggleClass('overlay_effect');
                jQuery('html').css('overflow-x', 'visible');
                jQuery('body').css('overflow', 'hidden');
                jQuery('.main-container').css('overflow', 'hidden');
            }
            else {if(jQuery('.mymeels').css('display')=='block')
            {
                jQuery('.mymeels').css('display', 'none');
                jQuery('.archive .row .col-main').removeClass('overlay_effect');
                jQuery('html').css('overflow-x', 'hidden');
                jQuery('body').css('overflow', 'auto');
            }}

        });
        jQuery('.cart_close').on('click', function(){
            jQuery('.mymeels').css('display', 'none');
            jQuery('.archive .row .col-main').removeClass('overlay_effect');
            jQuery('html').css('overflow-x', 'hidden');
            jQuery('body').css('overflow', 'auto');
        });
    </script>
    <?php
}
if($_SERVER['REQUEST_URI']=='/customer-account/'){
    $stripe_dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/mixpro/stripe.php';
    include($stripe_dir);
}




