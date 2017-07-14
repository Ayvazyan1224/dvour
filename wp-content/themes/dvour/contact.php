<?php
/**
 * Template Name: Contact
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>
<?php get_header(); ?>

<div class="page_wrapper clearfix contact_page">
    <h2 class="block_title page_template_title">CONTACT US</h2>
    <div class="col-lg-6 col-md-6 col-sm-6 left_section">
        <h2>Our Kitchen</h2>
        <p>If you have any suggestions or
            would like to request a dish on an upcoming menu,
            please send us a message.
        </p>
        <h2>Toronto</h2>
        <ul class="list-unstyled">

            <li class="contact_info">
                <p>Phone.<a href="tel: 6478239990"> 647-823-9990</a></p>
                <p>Email.<a href="mailto:info@dvour.ca">info@dvour.ca</a></p>
            </li>
        </ul>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-6">
<?php //echo do_shortcode('[contact-form-7 id="321" title="Comment"]');?>
        <div class="form_content pull-right">
<?php echo do_shortcode('[contact-form-7 id="321" title="Comment"]');?>
            <!--<form>
                <input type="text" placeholder="Name" class="input_field">
                <input type="email" placeholder="Email" class="input_field">
                <textarea placeholder="Comment"></textarea>
                <input type="submit" value="Submit" class="submit_btn">
            </form> -->

        </div>
    </div>
<?php /*
    <div class="team_part">
        <div class="header_part">
            <h2 class="text-center">Our Dedicated Team</h2>
            <p class="text-center">Lorem ipsum dolor sit amet, at morbi. Augue donec laoreet volutpat turpis, a ipsum
                erat interdum ipsum augue metus, ut arcu aute nunc non mi donec. </p>
        </div>
<?php 
global $wpdb;
$member1 = $wpdb->get_row("SELECT * FROM `members` WHERE `id`='1'", ARRAY_A);
$name1 = $member1['name'];
$role1 = $member1['role'];
$desc1 = $member1['descr'];
$pic1 = $member1['pic'];
$face1 = $member1['face'];
$twit1 = $member1['twit'];
$insta1 = $member1['insta'];
$pint1 = $member1['pint'];

$member2 = $wpdb->get_row("SELECT * FROM `members` WHERE `id`='2'", ARRAY_A);
$name2 = $member2['name'];
$role2 = $member2['role'];
$desc2 = $member2['descr'];
$pic2 = $member2['pic'];
$face2 = $member2['face'];
$twit2 = $member2['twit'];
$insta2 = $member2['insta'];
$pint2 = $member2['pint'];

$member3 = $wpdb->get_row("SELECT * FROM `members` WHERE `id`='3'", ARRAY_A);
$name3 = $member3['name'];
$role3 = $member3['role'];
$desc3 = $member3['descr'];
$pic3 = $member3['pic'];
$face3 = $member3['face'];
$twit3 = $member3['twit'];
$insta3 = $member3['insta'];
$pint3 = $member3['pint'];

$member4 = $wpdb->get_row("SELECT * FROM `members` WHERE `id`='4'", ARRAY_A);
$name4 = $member4['name'];
$role4 = $member4['role'];
$desc4 = $member4['descr'];
$pic4 = $member4['pic'];
$face4 = $member4['face'];
$twit4 = $member4['twit'];
$insta4 = $member4['insta'];
$pint4 = $member4['pint'];
?>
        <div class="col-lg-3 col-mh-3 col-sm-4 col-xs-6 text-center team_members">
            <img src="<?php echo $pic1;?>" alt="team">
            <h2><?php echo $name1;?></h2>
            <span class="member_position"><?php echo $role1;?></span>
            <p><?php echo $desc1;?> </p>
            <ul class="list-inline list-unstyled team_social_sites">
                <li><a href="<?php echo $insta1;?>"><span> <i class="fa fa-instagram" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $twit1;?>"><span><i class="fa fa-twitter" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $face1;?>"><span><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $pint1;?>"><span><i class="fa fa-pinterest" aria-hidden="true"></i></span></a></li>
            </ul>
        </div>
        <div class="col-lg-3 col-mh-3 col-sm-4 col-xs-6 text-center team_members">
            <img src="<?php echo $pic2;?>" alt="team">
            <h2><?php echo $name2;?></h2>
            <span  class="member_position"><?php echo $role2;?></span>
            <p><?php echo $desc2;?></p>
            <ul class="list-inline list-unstyled team_social_sites">
                <li><a href="<?php echo $insta2;?>"><span> <i class="fa fa-instagram" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $twit2;?>"><span><i class="fa fa-twitter" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $face2;?>"><span><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $pint2;?>"><span><i class="fa fa-pinterest" aria-hidden="true"></i></span></a></li>
            </ul>
        </div>
        <div class="col-lg-3 col-mh-3 col-sm-4 col-xs-6 text-center team_members">
            <img src="<?php echo $pic3;?>" alt="team">
            <h2><?php echo $name3;?></h2>
            <span  class="member_position"><?php echo $role3;?></span>
            <p><?php echo $desc3;?></p>
            <ul class="list-inline list-unstyled team_social_sites ">
                <li><a href="<?php echo $insta3;?>"><span> <i class="fa fa-instagram" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $twit3;?>"><span><i class="fa fa-twitter" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $face3;?>"><span><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $pint3;?>"><span><i class="fa fa-pinterest" aria-hidden="true"></i></span></a></li>
            </ul>
        </div>
        <div class="col-lg-3 col-mh-3 col-sm-4 col-xs-6 text-center team_members">
            <img src="<?php echo $pic4;?>" alt="team">
            <h2><?php echo $name4;?></h2>
            <span  class="member_position"><?php echo $role4;?></span>
            <p>Lorem ipsum dolor sit amet, at morbi. </p>
            <ul class="list-inline list-unstyled team_social_sites">
               <li><a href="<?php echo $insta4;?>"><span> <i class="fa fa-instagram" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $twit4;?>"><span><i class="fa fa-twitter" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $face4;?>"><span><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>
                <li><a href="<?php echo $pint4;?>"><span><i class="fa fa-pinterest" aria-hidden="true"></i></span></a></li>
            </ul>
        </div>
    </div>
*/ ?>
</div>
<?php get_footer(); ?>

