<?php
namespace MRKWP_CPB_Divi_Modules\PostExcerptModule;

use ET_Builder_Module;

class PostExcerptModule extends ET_Builder_Module
{

    public $slug       = 'et_pb_df_cpb_post_excerpt';
    public $vb_support = 'on';
    protected $container;
    protected $defaults;

    public function __construct($container)
    {
        $this->container = $container;
        $this->set_defaults();
        parent::__construct();
    }



    protected $module_credits = array(
    'module_uri' => 'https://www.diviframework.com',
    'author'     => 'Divi Framework',
    'author_uri' => 'https://www.diviframework.com',
    );

    public function init()
    {
        parent::init();
        $this->name = esc_html__('DF Post Excerpt', $this->container['plugin_slug']);

        $this->settings_modal_toggles['advanced']['toggles']['post_excerpt'] = esc_html__('Post Excerpt', 'et_builder');

        $this->advanced_fields = array(
        'fonts'  => array(
        'post_excerpt'   => array(
        'label'    => esc_html__('Post Excerpt', 'et_builder'),
        'css'      => array(
         'main'        => "{$this->main_css_element}",
                    ),
        ),
        ),
        );
    }


    public function get_fields()
    {
        return array();
    }

    public function render( $attrs, $content = null, $render_slug )
    {
        $post = $this->container->get_post();

        return sprintf(
            '<div class="%s">%s</div>',
            $this->module_classname($render_slug),
            $post->post_excerpt
        );
    }

    public function set_defaults()
    {
        $this->defaults = array();
    }

    public function get_default($key)
    {
        return isset($this->defaults[$key]) ? $this->defaults[$key] : '';
    }
}