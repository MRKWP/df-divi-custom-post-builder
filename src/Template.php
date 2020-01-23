<?php

namespace MRKWP\Custom_Post_Builder;

/**
 *
 */
class Template
{

    protected $container;
    protected $baseDir;

    public function __construct($container)
    {
        $this->container = $container;
        $this->baseDir = $container['plugin_dir'] . '/resources/views/df-job/';
    }

    public function template_include($template)
    {

        if (is_single()) {
            global $post;
            $layout_checkbox = sprintf('%s_layout_checkbox', $post->post_type);
            if (true == get_option($layout_checkbox)) {
                return MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/divi/custom_posts/single-post.php';
            }

        }

        return $template;
    }

}