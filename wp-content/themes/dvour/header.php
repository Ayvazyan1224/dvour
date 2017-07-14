<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MetroStore
 */
function correct_link($buffer){
    $buffer1 = str_replace('/wp-content/', 'http://localhost/newdvour/wp-content/', $buffer);
    $buffer2 = str_replace('/newdvourhttp://localhost/', '/', $buffer1);
   return $buffer2;

}
ob_start('correct_link');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png">
<link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- mobile menu -->
<?php do_action( 'metrostore-mobile-menu' ); ?>
<?php do_action( 'dvour_mobile_menu' ); ?>
<a href="<?php echo get_site_url()?>/choose-plan/" id="mobile_sign_up">SIGN UP</a>

<div id="page" class="site">

	<?php 
		/**
		 * @see  metrostore_skip_links() - 5
		 */	
		do_action( 'metrostore_header_before' );
	
		/**
		 * @see  metrostore_top_header() - 15
		 * @see  metrostore_main_header() - 20
		 */
		do_action( 'metrostore_header' );
	
	 	do_action( 'metrostore_header_after' );
	?>

<nav class="mainnav">
    <div class="stick-logo">
    	<?php
        if ( function_exists( 'the_custom_logo' ) ) {
          the_custom_logo();
        }
      ?>
    </div>

    <div class="page_wrapper">
      <div class="row">
        <div class="mtmegamenu">
            <?php the_custom_logo();?>
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
            
        </div>
      </div>
    </div>
</nav><!-- end nav -->

<?php
	if( is_front_page() ){
		$slider_options = esc_attr( get_theme_mod( 'metrostore_home_slider_options', 'enable' ) );
		if( !empty( $slider_options ) && $slider_options == 'enable' ){
			do_action( 'metrostore_slider' );
		}
	}	
?>

<div id="content" class="site-content">
