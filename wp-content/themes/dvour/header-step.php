<?php
/**
 * The header for Steps.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package DVOUR
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<style>
.widget-area.sidebar.col-xs-12.col-sm-3 {
margin-top:-25px;
}
.step-header-img {
float:left;
width:30px;
}
</style>