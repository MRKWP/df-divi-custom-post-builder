<?php
namespace MRKWP_CPB_Divi_Modules\PostContentModule;

use ET_Builder_Module;

class PostContentModule extends ET_Builder_Module
{

    public $slug       = 'et_pb_df_cpb_post_content';
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
        $this->name = esc_html__('DF Post Content', $this->container['plugin_slug']);

        $this->options_toggles['advanced']['toggles']['post_content'] = esc_html__('Post Content', 'et_builder');

        $this->advanced_fields = array(
        'fonts'  => array(
        'post_content'   => array(
        'label'    => esc_html__('Post Content', 'et_builder'),
        'css'      => array(
         'main'        => "{$this->main_css_element}",
                    ),
        ),
        ),
        );
    }


    public function get_fields()
    {
        $fields = array();

        $fields['preserve_line_breaks'] = array(
        'label' => esc_html__('Preserve Line Breaks', 'et_builder'),
        'type' => 'yes_no_button',
        'options' => array(
        'off' => esc_html__('Off', 'et_builder'),
        'on' => esc_html__('On', 'et_builder'),
        ),
        'description' => esc_html__('Preserve Line Breaks', 'et_builder'),
        'default' => $this->get_default('preserve_line_breaks'),
        );
        

        return $fields;
    }

    public function render( $attrs, $content = null, $render_slug )
    {
        $attrs = wp_parse_args($this->props, $attrs);
        $attrs = wp_parse_args($attrs, $this->defaults);
        $post = $this->container->get_post();

        $content = $post->post_content;

        if(!is_admin()) {
            $content = do_shortcode($content);
        }


        if($attrs['preserve_line_breaks'] == 'on') {
            $content = wpautop($content, true);
        }

        return sprintf(
            '<div class="%s">%s</div>',
            $this->module_classname($render_slug),
            $content
        );
    }

    public function set_defaults()
    {
        $this->defaults = array(
        'preserve_line_breaks' => 'off',
        );
    }

    public function get_default($key)
    {
        return isset($this->defaults[$key]) ? $this->defaults[$key] : '';
    }
}