<?php
/**
 * Template Name: FAQ
 *
 * @package WordPress
 * @subpackage dvour
 * @since dvour 1.0
 */
?>
<?php get_header(); ?>
<div class="container top_margin">
    <div style="padding: 0 8px">
        <?php the_post(); the_content(); ?>
    </div>

</div>
<?php get_footer(); ?>
