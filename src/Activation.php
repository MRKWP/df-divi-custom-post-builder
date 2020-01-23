<?php

namespace MRKWP\Custom_Post_Builder;

/**
 * Activation class.
 */
class Activation
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Plugin activation.
     */
    public function install()
    {
        //Custom Post Types
        $this->container['custom_posts']->register();
        flush_rewrite_rules();
    }
}
