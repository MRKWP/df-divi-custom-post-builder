<?php
namespace MRKWP_CPB_Divi_Modules\ACFFieldModule;

use ET_Builder_Module;

class ACFFieldModule extends ET_Builder_Module
{

    protected $container;
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviframework.com',
        'author'     => 'Divi Framework',
        'author_uri' => 'https://www.diviframework.com',
    );


    public function __construct($container)
    {
        $this->name       = esc_html__('DF - ACF Field', 'et_builder');
        $this->slug       = 'et_pb_df_acf_field_module';
        $this->container = $container;
        parent::__construct();
    }

    public function init()
    {
        $this->whitelisted_fields = array_keys($this->fields);

        /*
           * Prefix the slug with et_pb
           */
        if (strpos($this->slug, 'et_pb_') !== 0) {
            $this->slug = 'et_pb_'.$this->slug;
        }

        $defaults = array(
            'is_background_image_static' => 'on',
        );

        foreach ($this->fields as $field => $options) {
            if (isset($options['default'])) {
                $defaults[$field] = $options['default'];
            }
        }

        $this->field_defaults = $defaults;
    }

 

    /**
     * Get the fields.
     */
    public function get_fields()
    {
        $this->fields = array();

        $this->fields['select_field'] = array(
            'label' => esc_html__('Select field from dropdown.', 'et_builder'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('Off', 'et_builder'),
                'on' => esc_html__('On', 'et_builder'),
            ),
            'affects' => array(
                'field',
                'field_name'
            ),
            'description' => esc_html__('When enabled, it allows to select select field from dropdown. When disabled, you can enter the field name.', 'et_builder'),
            'default' => 'on',
        );


        $this->fields['field'] = array(
                'label'           => esc_html__('ACF Field Name', 'et_builder'),
                'type'            => 'select',
                'options' => $this->container['acf']->getCustomFields(),
                'description'     => esc_html__('Name of your ACF field.', 'et_builder'),
                'depends_show_if' => 'on',
        );

        $this->fields['field_name'] = array(
                'label'           => esc_html__('ACF Field Name', 'et_builder'),
                'type'            => 'text',
                'description'     => esc_html__('Enter name of your ACF field.', 'et_builder'),
                'depends_show_if' => 'off',
        );

        $format_as = apply_filters('df_acf_formatter_callbacks', array());

        $this->fields['format_as'] = array(
            'label'           => esc_html__('Field Formatter', 'et_builder'),
            'type'            => 'select',
            'options' => array_combine(array_keys($format_as), array_keys($format_as)),
            'description'     => esc_html__('Name of the field formatter.', 'et_builder'),
        );


        $this->fields['module_class'] = array(
                'label'           => esc_html__('CSS Class', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'tab_slug'        => 'custom_css',
                'option_class'    => 'et_pb_custom_css_regular',
        );

        $this->fields['addition_attributes'] = array(
                'label'           => esc_html__('Additional shortcode attributes', 'et_builder'),
                'type'            => 'text',
        );

        $this->fields['admin_label'] = array(
            'label'       => __('Admin Label', 'et_builder'),
            'type'        => 'text',
            'description' => __('This will change the label of the module in the builder for easy identification.', 'et_builder'),
            );


        return $this->fields;
    }


    /**
     * Shortcode callback.
     */
    public function render($attrs, $content = null, $function_name)
    {
        $defaults = array(
            'field_name' => '',
            'field' => '',
            'select_field' => 'on',
        );
        $attrs = wp_parse_args($attrs, $defaults);

        if ($attrs['select_field'] == 'off') {
            $attrs['field'] = $attrs['field_name'];
        }

        return $this->container['acf_shortcode']->render_divi_module($attrs);
    }
}
