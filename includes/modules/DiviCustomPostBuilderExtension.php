<?php
namespace MRKWP_CPB_Divi_Modules;

use DiviExtension;

class DiviCustomPostBuilderExtension extends DiviExtension
{
    protected $container;

    /**
     * The gettext domain for the extension's translations.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $gettext_domain ;

    /**
     * The extension's WP Plugin name.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $name = 'et_pb_df_custom_post_builder';

    /**
     * The extension's version
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $version ;

    /**
     * Constructor.
     *
     * @param string $name
     * @param array  $args
     */
    public function __construct($container)
    {
        $this->gettext = $container['plugin_slug'];
        $this->version = $container['plugin_version'];
        $this->plugin_dir     = $container['plugin_dir'] . '/';
        $this->plugin_dir_url = $container['plugin_url'] . '/';

        $this->container = $container;
        parent::__construct($this->name, []);
    }
}
