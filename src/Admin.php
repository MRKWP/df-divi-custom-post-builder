<?php
namespace MRKWP\Custom_Post_Builder;

/**
 * Admin related functionality.
 */
class Admin {
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * Admin init hook. Register your hooks here.
     */
    public function init() {
        $this->container['menu']->adminMenu();
    }

    public function customPostScripts($hook) {
        global $post;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ($post->post_type == 'df_post_builder') {
                wp_enqueue_script('df-custom-post-builder-enabler', MRKWP_DIVI_CUSTOM_POST_BUILDER_URL . '/resources/js/divi-post-enabler.js', ['et-builder-failure-notice'], false, true);
            }
        }
    }
}
