<?php
/**
 * Template Name: Home Page Woo
 */
/*if(is_user_logged_in() && !is_user_admin()){
header('Location: '.get_site_url().'/shop/');
}*/
get_header();
do_action('shoore_that_not_same_plan');
$metrostore_page_layout = esc_attr( get_post_meta($post->ID, 'metrostore_page_layouts', true) );
if(!$metrostore_page_layout){
    $metrostore_page_layout = 'rightsidebar';
}
if(!empty($metrostore_page_layout) && $metrostore_page_layout == 'rightsidebar' || $metrostore_page_layout == 'leftsidebar' ) {
    $metrostore_col = 9;
}else if(!empty($metrostore_page_layout) && $metrostore_page_layout == 'nosidebar' ){
    $metrostore_col = 12;
}

?>
    <div class="slider_content">
        <?php
        echo do_shortcode('[smartslider3 slider=2]');
        ?>
        <?php if(!is_user_logged_in()){ ?>
        <div class="page_wrapper">
            <div class="reg_form_container">
                <h1>From our kitchen,<br>to your DOORSTEP.</h1>
                <p class="form_price_info">A healthy chef-created meal subscription plan prepared & delivered
                    for you to devour conveniently - starting at $10.99 a meal.</p><br>
  <form action="<?php echo get_site_url()."/choose-plan/";?>" method = "POST">
                    <div class="full-width-left reg_form_box">
                        <div class="col-md-6 col-sm-6">
                            <select class="selectpicker" data-live-search="true" name="billing_city" id="reg_billing_city" title="Select your city" required>
                            <option selected disabled>Select your city</option>
<?php
                            global $wpdb;
                            $res = $wpdb->get_results("SELECT `city_name` FROM `city` ORDER BY `city_name` ASC");
                            foreach($res as $city){ ?>
                                <option data-tokens="<?php echo $city->city_name;?>"><?php echo $city->city_name;?></option>
                           <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <input type="email" name='email' class="form-control form_field" placeholder="Email" required>
                        </div>
                        <div class="col-md-12 ">
                            <input type="submit" class="button get_started_btn" name="register" value="GET STARTED">
                        </div>
                        <p class="full-width-left text-center terms_link">By continuing, you agree to our <a href="http://dvour.ca/terms-conditions/"> Terms </a>and <a href="http://dvour.ca/privacy/">Privacy Policy</a></p>
                    </div>
                </form>

                 
                          
            </div>
        </div>
        <?php }?>

    </div>
<div class="mybody">
    <div class="main-container col1-layout">
        <div class="page_wrapper">

                <?php the_post(); the_content(); ?>


        </div>
    </div>
    <div class="home_center_content">
        <div class="page_wrapper clearfix">
            <div id="pplans">
                <h2 class="block_title">CHOOSE A PLAN</h2>
                <?php echo do_shortcode('[hg_price_table id="37"]'); ?>
            </div>
            <div class="full-width-left">
                <h3 style="text-align:center">Still not sure? No problem.</h3>
                <h3 style="text-align:center">We have a FREE meal for you to try out.<br/>Just pay for delivery.
                </h3>
                <a href="/choose-delivery-day/?sub=217" class="onefree">CHOOSE 1 FREE MEAL</a>
            </div>

        </div>
        <div class="page_wrapper menu_block">
            <h2 class="block_title">Next Week's Menu</h2>
            <div class="witm">

<?php //Same Setup that we are doing in archive-product.php where we get the current day, figure out what the following Monday is and format it so that we cant pull the proper attributes from the backend, and based on that day pull only products with that and day ?>


<?php $monday = new DateTime(); ?>
<?php $monday->modify('+1 days next Sunday');?>
<?php $nextMonday = strtolower($monday->format('d-F'));?>

<?php $thursday = new DateTime(); ?>
<?php $thursday->modify('+4 days next Sunday');?>
<?php $nextThursday = strtolower($thursday->format('d-F'));?>

		<?php echo do_shortcode("[product_attribute attribute='meal-date' filter=$nextMonday per_page='5' columns='5']"); ?>
		<?php echo do_shortcode("[product_attribute attribute='meal-date' filter=$nextThursday per_page='5' columns='5']"); ?>


                <?php //echo do_shortcode('[recent_products per_page="4" columns="4"]');?>
            </div>
            <a href="/menu" class="showmenu">View Entire Season's Menu</a>
        </div>
        <div class="faq">
            <?php $post_7 = get_post(362);
$title = $post_7->post_content;
echo $title;
?>

            </div>

    </div>
    </div>
<script>
    jQuery('.hg_ft_col_0').prepend('<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Singles-Icon.png" style="width:40px">');
    jQuery('.hg_ft_col_1').prepend('<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Couples-Icon.png" style="width:40px">');
    jQuery('.hg_ft_col_2').prepend('<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Family-Icon.png" style="width:40px">');
</script>


<?php get_footer(); ?>