<?php
/**
 * Template Name: Blog
 */

get_header();
?>
    <div class="page_wrapper clearfix blog_page">
        <h2 class="block_title page_template_title">BLOG</h2>
        <div class="row">
            <div id="columns">
                <?php
                $recent_posts = wp_get_recent_posts();
                foreach( $recent_posts as $recent ){
                    global $post;
                    $post = get_post($recent["ID"]);
                    echo '<div class="pin">
             <a href="' . get_permalink($recent["ID"]) . '">' .get_the_post_thumbnail($recent["ID"], 'medium').'</a>
            <div class="text_part">
              <p>'.get_the_date().'</p>
              <h2><a href="' . get_permalink($recent["ID"]) . '">'.get_the_title().'</a></h2>
              <p>'.get_the_excerpt($post->ID).'</p>
              <a href="'. get_permalink($recent["ID"]).'" class="my_read_more">Read More</a>
              <p class="post_author_name">'.get_the_author_meta( 'display_name', $post->post_author).'</p>
            </div>
         </div> ';
                }
                ?>
            </div>
        </div>

    </div>
<?php
get_footer();
?>