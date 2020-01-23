<?php
get_header();
?>
<!-- #main-content just like the standard post -->
<div id="main-content">
    <div id="dplp-new-content">
    <?php

    // check if there is an override on the page.
    $templateId = get_post_meta($post->ID, 'cpb_template_id', true);
    // dump($templateId);exit;

    if(!$templateId){   
        $templateIdOption = sprintf('df_%s_add_id', $post->post_type);
        $templateId = get_option($templateIdOption);
    }
    // Load a default et_pb_layout - We'll grab the actual post content later...
    $content_post = get_post($templateId);
    $content = $content_post->post_content;
//    echo do_shortcode($content);
    remove_filter('the_content', 'wpautop');

    echo apply_filters('the_content', $content_post->post_content);
    ?>
    </div>   
</div> <!-- #main-content -->

<?php get_footer(); ?>