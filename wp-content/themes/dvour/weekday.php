<?php
/**
 * Template Name: Week Day
 */
?>
<?php

/** PUTING IN DB PLAN **/
if(is_user_logged_in() && isset($_GET['sub'])){
    $plan = $_GET['sub'];
    $user_id = get_current_user_id();
    global $wpdb;
    $wpdb->update('wp_mixpro_meels', array('plan' => $plan, 'products'=>''), array('user_id' => $user_id));
    unset($_SESSION['prods']);
   $orders_meta = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value`='".get_current_user_id()."'");
    $orders = array();
    foreach ($orders_meta as $value_orders){
        $post = get_post($value_orders->post_id);
        if($post->post_status=="wc-processing"){
            array_push($orders, $post->ID);
        }
    }
    $have_orders = count($orders);
    if($have_orders>0){
        echo "<script>alert('You already have subscription, if you change your plan, you current subscription will  be lost');</script>";
    }
}
/** PUTING PLAN IN SESSION */
$_SESSION['plan'] = $_GET['sub'];
?>
<?php
get_header('step');
?>
<div class="week">
<div class="breadcrumps">
<a href="<?php echo get_site_url();?>"><img src="<?php echo get_site_url();?>/wp-content/uploads/2017/04/logosmall.png" class='step-header-img'></a>

Plan&nbsp&nbsp&nbsp>&nbsp&nbsp&nbsp<span>Day</span>&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspMeals&nbsp&nbsp&nbsp>&nbsp&nbsp&nbspCheckout
</div>
    <h2 class="block_title">CHOOSE A DELIVERY DAY</h2>
    <section id="visible_part">
<ul>  
<?php
$now = time() + (3 * 24 * 60 * 60);
for($i=7; $i>0; $i--)
{
    $day = $now - ($i * 24 * 60 * 60);
    if(date('l', $day)==do_shortcode('[seconddeliveryday]')){
      echo "<li class='last' data-time='".$day."'>".date('l, d M', $day)."</li>";  
    }
    if(date('l', $day)==do_shortcode('[firstdeliveryday]')){
        echo "<li class='last' data-time='".$day."'>".date('l, d M', $day)."</li>";
    }
}
for($i=0; $i<7; $i++){
    $day = $now + ($i * 24 * 60 * 60);
    if(date('l', $day)==do_shortcode('[seconddeliveryday]')){
        $thursday = $day;  
    }
    if(date('l', $day)==do_shortcode('[firstdeliveryday]')){
        $monday = $day;
    }
}
if($monday>$thursday){
    $earliest = date('l, d M', $thursday);
    echo "<li class='nowis' data-time='".$thursday."'>".date('l, d M', $thursday)."<span>Earliest available day</span></li>";
    echo "<li data-time='".$monday."'>".date('l, d M', $monday)."</li>";
}
if($monday<$thursday){
    $earliest = date('l, d M', $monday);
    echo "<li class='nowis' data-time='".$monday."'>".date('l, d M', $monday)."<span>Earliest available day</span></li>";
    echo "<li data-time='".$thursday."'>".date('l, d M', $thursday)."</li>";
}

    for($j=7; $j<100; $j++){
    $day = $now + ($j * 24 * 60 * 60);
    if(date('l', $day)==do_shortcode('[seconddeliveryday]')){
        echo "<li data-time='".$day."'>".date('l, d M', $day)."</li>";  
    }
    if(date('l', $day)==do_shortcode('[firstdeliveryday]')){
        echo "<li data-time='".$day."'>".date('l, d M', $day)."</li>";
    }
}
?>
    </ul>
    </section>
    <a href="#" id="more">More available dates</a>
    <a href="#" id="continue">CONTINUE TO MEAL SELECTION</a>
    <span id="first_date">First Delivery Date: <?php echo $earliest; ?></span>
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
        .week h2 {
            width: 100%;
            text-align: center;
            font-family: 'DINProRegular';
            margin: 40px 0;
        }
        .week ul {
            display:block;
            max-width: 500px;
            margin-left:auto;
            margin-right:auto;
        }
        .week li {
            list-style: none;
            padding: 15px 20px;
            border: 1px solid rgba(50,50,50,0.3);
            font-family: 'DINProRegular';
            font-weight: bold;
            font-size: 18px;
            width: 100%;
            float: left;
            vertical-align: middle;
        }
        .week li.last {

            color: #999999;
        }
        .week li.nowis {
            border-left: 5px solid #d15137;
        }
        .week li.nowis span {
            float: right;
            font-size: 16px;
            color: #999;
            background-color: #f7f7f7;
            padding: 1px 10px 5px;
            vertical-align: middle;
        }
        .week li.nowis span:before{
            content: "*";
        }
        .week li:not(.last):hover {
            cursor:pointer;
        }
        #visible_part {
            height:371px;
            overflow: hidden;
        }
        #more {
            font-size: 16px;
            font-family: 'DINProMedium';
            width: 151px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            color:#d15137;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        #continue {font-size: 20px;
            font-family: 'DINProMedium';
            width: 500px;
            display: block;
            margin-left: auto;
            text-align: center;
            margin-right: auto;
            color:#fff;
            border:2px solid #d15137;
            margin-bottom: 20px;
            margin-top: 20px;
        background:#d15137;
            padding: 15px;
        }
        #continue:hover {
            color:#d15137;
            background: #fff;

        }
        #first_date {
            color:#999;
            font-size: 16px;
            font-family: 'DINProMedium';
            width:300px;
            display: block;
            margin-left: auto;
            margin-right:auto;
            margin-top:20px;
            margin-bottom:20px;
        }


.page-template-weekday {
margin-top:30px;
}

.week .breadcrumps {
    border-bottom: thin solid rgba(0,0,0,0.1);
    padding-bottom: 10px;
display:inline-block;
}

.week {
padding:0 20px;
}

.step-header-img {
width:20px;
}

        @media only screen and (max-width: 500px){
            #continue{
                width: 100%;
                font-size: 16px;
            }
            .week{
                padding: 0 15px;
            }
        }

    </style>
<?php echo "
<script>
    jQuery(document).ready(function(){
        var nt = jQuery('.week li.nowis').attr('data-time');
        jQuery('#continue').attr('href', '".get_site_url()."/shop/?sub=".$_GET['sub']."&date='+nt+'&action=menu');
    });
    jQuery('.week li:not(.last)').click(function(){
        jQuery('.week li').each(function(){
            jQuery(this).css('border', '1px solid rgba(0,0,0,0.3)');
        });
         jQuery(this).css('border-left', '5px solid #d15137');
          t=jQuery(this).attr('data-time');
           jQuery('#continue').attr('href', '".get_site_url()."/shop/?sub=".$_GET['sub']."&date='+t+'&action=menu');
           });
    </script>";
?>
<script>
    jQuery('#more').click(function(){jQuery('#visible_part').css('height', 'auto'); jQuery(this).css('display', 'none');});

</script>
<?php
get_footer('step');
?>
