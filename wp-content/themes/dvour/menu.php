<?php
/**
 * Template Name: Menu
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>
<?php get_header(); ?>
<?php 
remove_action('woocommerce_after_shop_loop_item','wpb_wl_hook_quickview_link');
remove_action('woocommerce_after_shop_loop_item','wpb_wl_hook_quickview_content');
remove_action('init', 'wpb_wl_textdomain');
remove_action('wp_enqueue_scripts', 'wpb_wl_adding_scripts');
remove_action('wp_enqueue_scripts', 'wpb_wl_adding_style');
?>
<div class="page_wrapper clearfix contact_page">
    <h2 class="block_title page_template_title">This Season's Menu</h2>
    <div class="row">
        <div class="col-lg-3 col-md-4 menu_right_sidebar">
            <?php dynamic_sidebar('menuright'); ?>
        </div>
        <div class="col-lg-9 col-md-8  menu_left_block">
            <?php echo do_shortcode('[recent_products per_page="-1" columns="3"]'); ?>
        </div>

    </div>


</div>
<?php add_action('wp_footer', 'script_for_menu', 99);
function script_for_menu(){ ?>
<script type="text/javascript">
    jQuery('#woocommerce_product_categories-2 ul').prepend('<li class="cat-itemi selected" id="all">All</li>');
    jQuery('#all').click(function () {
        jQuery('.col-lg-9.col-md-8.menu_left_block li.product').show();
    });
    jQuery('.product-categories .cat-item').each(function () {
        jQuery(this).html(jQuery('.product-categories .cat-item a').html())
    });
    jQuery('.product-categories .cat-item').click(function () {
        jQuery('.col-lg-9.col-md-8.menu_left_block li.product').hide();
        cat = jQuery(this).html().toLowerCase();
        jQuery('.col-lg-9.col-md-8.menu_left_block li.product_cat-' + cat).show();
    });

    jQuery('.cat-item, .cat-itemi').click(function () {
        jQuery(this).addClass('selected');
        jQuery(this).siblings('li').removeClass('selected');
    });

    if(jQuery("#content .products").offset().top < jQuery(window).scrollTop()) {
        if(jQuery('#colophon').offset().top < jQuery(window).scrollTop() + jQuery('#colophon').outerHeight()) {
            jQuery('.col-lg-3.col-md-4.menu_right_sidebar').removeAttr('style');
            jQuery('.col-lg-3.col-md-4.menu_right_sidebar').css({'bottom': jQuery('#colophon').outerHeight()});
        } else {
            jQuery('.col-lg-3.col-md-4.menu_right_sidebar').removeAttr('style');
            jQuery('.col-lg-3.col-md-4.menu_right_sidebar').css('top', '90px');
        }
    } else {
        jQuery('.col-lg-3.col-md-4.menu_right_sidebar').removeAttr('style');
    }

    jQuery(document).scroll(function () {
        if(jQuery("#content .products").offset().top < jQuery(window).scrollTop()) {
            if(jQuery('#colophon').offset().top < jQuery(window).scrollTop() + jQuery('#colophon').outerHeight()) {
                jQuery('.col-lg-3.col-md-4.menu_right_sidebar').removeAttr('style');
                jQuery('.col-lg-3.col-md-4.menu_right_sidebar').css({'bottom': jQuery('#colophon').outerHeight()});
            } else {
                jQuery('.col-lg-3.col-md-4.menu_right_sidebar').removeAttr('style');
                jQuery('.col-lg-3.col-md-4.menu_right_sidebar').css('top', '90px');
            }
        } else {
            jQuery('.col-lg-3.col-md-4.menu_right_sidebar').removeAttr('style');
        }
    });
jQuery('li.product figure img').click(
function(){window.location.href = jQuery(this).parent().parent().parent().parent().find('h3 a').attr('href');
}); 
</script>
<style type="text/css">

    .product-categories li.selected {
        color: #f15a38 !important;
    }

    li.product h3 a {
        white-space: initial !important;
        line-height: 1.5em;
        height: 3em;
        font-size: 15px !important;
    }

    li.product {
        clear: none !important;
        margin-left: 10px !important;
        margin-right: 10px !important;
    }

    .post-110, .post-136, .post-135 {
        display: none;
    }

    @media screen and (min-width: 992px) {
        .col-lg-3.col-md-4.menu_right_sidebar {
            position: fixed;
            right: 5%;
            z-index: 1;
            -webkit-transition: all 0.5s ease-in-out;
            -moz-transition: all 0.5s ease-in-out;
            -ms-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
    }
</style><?php } ?>
<?php get_footer(); ?>

