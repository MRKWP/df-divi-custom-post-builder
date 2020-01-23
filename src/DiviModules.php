<?php
namespace MRKWP\Custom_Post_Builder;

/**
 * Register divi modules
 */
class DiviModules
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Register divi modules.
     */
    public function register()
    {
        new \MRKWP_CPB_Divi_Modules\ACFButtonModule\ACFButtonModule;
        new \MRKWP_CPB_Divi_Modules\ACFFieldModule\ACFFieldModule($this->container);
        new \MRKWP_CPB_Divi_Modules\PostContentModule\PostContentModule($this->container);
        new \MRKWP_CPB_Divi_Modules\PostExcerptModule\PostExcerptModule($this->container);
        new \MRKWP_CPB_Divi_Modules\GalleryModule\GalleryModule($this->container);
    }


    public function register_extensions()
    {
        new \MRKWP_CPB_Divi_Modules\DiviCustomPostBuilderExtension($this->container);
    }

    public function wp_print_styles()
    {
        // divi frontend builder styles.
        wp_dequeue_style('et_pb_df_acf_button-styles');
        wp_dequeue_style('et_pb_df_acf_field_module-styles');
        wp_dequeue_style('et_pb_df_cpb_post_content-styles');
        wp_dequeue_style('et_pb_df_cpb_post_excerpt-style');
        wp_dequeue_style('et_pb_df_acf_gallery-styles');
        wp_dequeue_style('et_pb_df_cpb_post_excerpt-styles');
        wp_dequeue_style('et_pb_df_custom_post_builder-styles');
    }
}
