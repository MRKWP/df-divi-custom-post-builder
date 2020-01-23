<?php
namespace MRKWP\Custom_Post_Builder;

use ET_Builder_Module;

class PostMetaFieldModule extends ET_Builder_Module
{

    protected $container;

    public function __construct($container)
    {
        $this->name = esc_html__('DF - Custom Post Meta Field', 'et_builder');
        $this->slug = 'et_pb_df_custom_post_meta_field';
        $this->container = $container;
        parent::__construct();
    }

    public function init()
    {
        $this->whitelisted_fields = array_keys($this->fields);

        if (strpos($this->slug, 'et_pb_') !== 0) {
            $this->slug = 'et_pb_' . $this->slug;
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

        $this->fields['field_name'] = array(
        'label' => esc_html__('Field Name', 'et_builder'),
        'type' => 'text',
        'description' => esc_html__('Enter the post meta field name.', 'et_builder'),
        );

        $format_as = apply_filters('df_acf_formatter_callbacks', array());

        $this->fields['format_as'] = array(
        'label' => esc_html__('Field Formatter', 'et_builder'),
        'type' => 'select',
        'options' => array_combine(array_keys($format_as), array_keys($format_as)),
        'description' => esc_html__('Name of the field formatter.', 'et_builder'),
        );

        $this->fields['module_class'] = array(
        'label' => esc_html__('CSS Class', 'et_builder'),
        'type' => 'text',
        'option_category' => 'configuration',
        'tab_slug' => 'custom_css',
        'option_class' => 'et_pb_custom_css_regular',
        );

        $this->fields['addition_attributes'] = array(
        'label' => esc_html__('Additional shortcode attributes', 'et_builder'),
        'type' => 'text',
        );

        $this->fields['admin_label'] = array(
        'label' => __('Admin Label', 'et_builder'),
        'type' => 'text',
        'description' => __('This will change the label of the module in the builder for easy identification.', 'et_builder'),
        );

        return $this->fields;
    }

    /**
     * Shortcode callback.
     */
    public function shortcode_callback($attrs, $content = null, $function_name)
    {
        $defaults = array(
        'field_name' => '',
        'field' => '',
        'select_field' => 'off',
        );
        $attrs = wp_parse_args($attrs, $defaults);

        if ($attrs['select_field'] == 'off') {
            $attrs['field'] = $attrs['field_name'];
        }

        return $this->container['acf_shortcode']->render_divi_module($attrs);
    }
}
