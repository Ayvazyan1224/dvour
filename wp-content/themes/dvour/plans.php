<?php
/**
 * Template Name: Plans
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>
<?php get_header(); ?>

<div class="page_wrapper clearfix">
    <div class="believe">
        <h2 class="block_title page_template_title">WHY CHOOSE US</h2>
        <div class="belp">
            We believe in food!</p>
<p class="a">
Food nurtures us, it fuels us, and let’s admit it, it makes us happy, but who has the time to prepare a meal? Answer, WE DO!
</p>
<p class="a">
We understand that your plate is full with practical activities like work, appointments, kids, sports, and your significant other. Balancing your day is tough and time is a luxury that most of us can’t afford.<span style="color:#f15a38;"> We rather you make memories, not meals!</span>
</p>
<p class="a">
Our professional, local and international chefs are passionate about flavour, and have been trained and worked across the globe. They source fresh, high-quality ingredients, with no pretence and no preservations.
</p>
<p class="a">
We provide honest, home-style, comfort food delivered straight to your door. Food that will leave you full, satisfied, and free to do whatever it is you need to.
</p>
<p class="a">
Sign up with d’Vour and you’ll be signing up for no prep, no shopping, no cooking, and best of all, no cleaning up! It’s a no-brainer!
</p>
        </div>
        <div class="belim">
            <div class="belim-right">
                <h4>COOKED</h4>
                <p>By our chefs with a varity of healthy and fresh meal choices</p>
                <h4>DELIVERED</h4>
                <p>Twice a week, always fresh  and ready to eat</p>
                <h4>d'VOUR</h4>
                <p>& enjoy with only  2 minutes of prep</p>
                <img src="http://dvour.erabuilder.com/wp-content/uploads/2017/04/logosmall.png" alt="" width="20" class="alignnone size-full wp-image-46" />
            </div>
        </div>
    </div>
</div>
<div class="faq">
      <?php $post_7 = get_post(362);
$title = $post_7->post_content;
echo $title;
 ?>
</div>
<div id="testimonials" class="full-width-left">
    <div class="page_wrapper clearfix">
        <h2 class="block_title">TESTIMONIALS</h2>
        <p class="sub_title">"I heard about d’Vour from a friend and decided to give it a try as an alternative to the fast food drive thru I make most evenings after a long day at work. I was pleasantly surprised with the ease of sign up and placing an order. The selection is great and the meals are well thought out, not to mention the food is yum. They got me hooked and I can’t wait to try next week’s meals."
        </p>
<?php /*
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="testimonial_block full-width-left">
                    <p class="testimonial_text">Lorem ipsum dolor sit amet, at morbi. Augue donec laoreet volutpat turpis, a ipsum
                        erat interdum ipsum augue metus, ut arcu aute nunc non mi donec.
                    </p>
                    <ul class="list-inline list-unstyled">
                        <li>
                            <a href="javascript:void(0)">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/team_1.png" alt="testimonial">
                            </a>
                        </li>
                        <li>
                            <h4><a href="javascript:void(0)">Jane Smith</a></h4>
                            <p>MANAGER</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="testimonial_block full-width-left">
                    <p class="testimonial_text">Lorem ipsum dolor sit amet, at morbi. Augue donec laoreet volutpat turpis, a ipsum
                        erat interdum ipsum augue metus, ut arcu aute nunc non mi donec.
                    </p>
                    <ul class="list-inline list-unstyled">
                        <li>
                            <a href="javascript:void(0)">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/team_1.png" alt="testimonial">
                            </a>
                        </li>
                        <li>
                            <h4><a href="javascript:void(0)">Jane Smith</a> </h4>
                            <p>MANAGER</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="testimonial_block full-width-left">
                    <p class="testimonial_text">Lorem ipsum dolor sit amet, at morbi. Augue donec laoreet volutpat turpis, a ipsum
                        erat interdum ipsum augue metus, ut arcu aute nunc non mi donec.
                    </p>
                    <ul class="list-inline list-unstyled">
                        <li>
                            <a href="javascript:void(0)">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/team_1.png" alt="testimonial">
                            </a>
                        </li>
                        <li>
                            <h4><a href="javascript:void(0)">Jane Smith Smith</a></h4>
                            <p>MANAGER</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
*/ ?>
    </div>
</div>
<div id="plans" class="full-width-left">
    <div class="page_wrapper clearfix">
        <h2 class="block_title">CHOOSE A PLAN</h2>
        <?php echo do_shortcode('[hg_price_table id="37"]'); ?>
    </div>
</div>
<div class="full-width-left">
    <h3 style="text-align:center">Still not sure? No problem.</h3>
    <h3 style="text-align:center">We have a FREE meal for your to try out.<br/>Just pay for delivery.
    </h3>
    <a href="<?php echo get_site_url();?>/choose-delivery-day/?sub=217" class="onefree">CHOOSE 1 FREE MEAL</a>
</div>
</div>




<script>
    jQuery('.hg_ft_col_0').prepend('<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Singles-Icon.png" style="width:40px">');
    jQuery('.hg_ft_col_1').prepend('<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Couples-Icon.png" style="width:40px">');
    jQuery('.hg_ft_col_2').prepend('<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Family-Icon.png" style="width:40px">');
</script>
<?php get_footer(); ?>

