<?php
namespace MRKWP_CPB_Divi_Modules\ACFButtonModule;

use ET_Builder_Module_Button;

class ACFButtonModule extends ET_Builder_Module_Button
{
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviframework.com',
        'author'     => 'Divi Framework',
        'author_uri' => 'https://www.diviframework.com',
    );

   
    public function init()
    {
        parent::init();
        $this->name = esc_html__('DF - ACF Button', 'et_builder');
        $this->slug = 'et_pb_df_acf_button';
        $this->whitelisted_fields[] = 'acf_field';
   
        $this->advanced_fields['button'] = array(
                'button' => array(
                    'label' => esc_html__('Button', 'et_builder'),
                    'css' => array(
                        'main' => ".et_pb_button{$this->main_css_element}",
                        'important' => 'all',
                    ),
                    'box_shadow' => false,
                ),
            );
    }

    public function get_fields()
    {
        $fields = parent::get_fields();
        // unset($fields['button_url']);
        $fields['button_url']['type'] = 'hidden';

        $newFields = array();
        $newFields['acf_field'] = array(
            'label' => esc_html__('ACF Field Name', 'et_builder'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'description' => esc_html__('Name of your ACF file/image field', 'et_builder'),
        );

        return array_merge($newFields, $fields);
    }

    public function render($atts, $content = null, $function_name)
    {
        global $post;
        $field = \get_field($atts['acf_field'], $post);

        $field = wp_parse_args(
            array('url' => $field),
            array('url' => '')
        );
        
        $button_url = $field['url'];
        $atts['button_url'] = $button_url;
        $this->props['button_url'] = $button_url;

        $class_name = $this->get_module_order_class($function_name);
        
        $html =  parent::render($atts, $content, $function_name);
    }
}
