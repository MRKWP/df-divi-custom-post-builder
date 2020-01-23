<?php
get_header();
global $post;

$content = $post->post_content;
$related_posts = get_field('related_post', $post->ID);

$post = $related_posts[0];
setup_postdata($post);
$GLOBALS['post'] = $post;
?>
<!-- #main-content just like the standard post -->
<div id="main-content">
    <div id="dplp-new-content">
    <?php

remove_filter('the_content', 'wpautop');
// dd($content);
echo apply_filters('the_content', $content);
?>
    </div>
</div> <!-- #main-content -->

<?php get_footer();?>