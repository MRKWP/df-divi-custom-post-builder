<?php

namespace MRKWP\Custom_Post_Builder;

/**
 * Class to register WordPress shortcodes.
 */
class Shortcodes
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Register shortcodes.
     */
    public function add()
    {
        // Add shortcodes here
        add_shortcode('df_acf_field', array($this->container['acf_shortcode'], 'render'));
        add_shortcode('df_post_meta_field', array($this->container['acf_shortcode'], 'render'));
        add_shortcode('df_post_field', array($this->container['custom_posts'], 'post_field'));
        add_shortcode('df_post_meta_as_list_item', array($this->container['custom_posts'], 'post_meta_as_list_item'));
    }
}
