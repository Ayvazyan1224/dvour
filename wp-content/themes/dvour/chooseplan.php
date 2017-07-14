<?php
/**
 * Template Name:  Choose Plans
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>
<?php get_header('step'); ?>

<?php
    do_action('shoore_that_not_same_plan');
    $_SESSION['city'] = $_POST['billing_city'];
    $_SESSION['email'] = $_POST['email'];

 ?>

    <div class="main-container col1-layout">
        <div class="container-fluid">
            <div class="row">

                <div id="primary" class="col-sm-12">
                    <main id="main" class="site-main" role="main">
                        <div class="breadcrumps">
<a href="<?php echo get_site_url();?>"><img src="<?php echo get_site_url();?>/wp-content/uploads/2017/04/logosmall.png" class='step-header-img'></a>

                            <span>Plan</span>&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspDay&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspMeals&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspCheckout
                        </div><br><br>
                        <div class="page_wrapper clearfix">
                            <div id="pplans">
                                <h2 class="block_title">CHOOSE A PLAN</h2>
                                <?php echo do_shortcode('[hg_price_table id="37"]'); ?>
                            </div>
                            <div class="full-width-left">
                                <h3 style="text-align:center">Still not sure? No problem.</h3>
                                <h3 style="text-align:center">We have a FREE meal for you to try out.
<br>Just pay for delivery.
                                </h3>
                                <a href="<?php echo get_site_url();?>/choose-delivery-day/?sub=217" class="onefree">CHOOSE 1 FREE MEAL</a>
                            </div>

                        </div>
<br><br><br>
                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
        </div>
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
    padding-bottom: 10px;
display:inline-block;
}

.step-header-img {
width:20px;
}
        </style>
<?php get_footer('step'); ?>
