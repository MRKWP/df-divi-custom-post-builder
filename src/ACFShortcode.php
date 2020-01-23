<?php

namespace MRKWP\Custom_Post_Builder;

class ACFShortcode
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Render ACF shortcode.
     */
    public function render($attrs)
    {
        $defaults = array(
        'format_as' => 'raw',
        'class_name' => '',
        );
        $attrs = wp_parse_args($attrs, $defaults);

        ob_start();
        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/shortcodes/acf.php';
        return ob_get_clean();
    }

    /**
     * Default formatter filter.
     */
    public function default_formatters($callbacks)
    {
        $container = $this->container;

        $callbacks['raw'] = function ($fieldValue, $attrs) use ($container) {
            return $fieldValue;
        };

        $callbacks['unordered_list'] = function ($fieldValue, $attrs) use ($container) {
            return $container['field_formatter']->unorderedList($fieldValue, $attrs);
        };

        $callbacks['image_slider'] = function ($fieldValue, $attrs) use ($container) {
            return $container['field_formatter']->imageSlider($fieldValue, $attrs);
        };

        $callbacks['image_grid'] = function ($fieldValue, $attrs) use ($container) {
            return $container['field_formatter']->imageGrid($fieldValue, $attrs);
        };

        $callbacks['button'] = function ($fieldValue, $attrs) use ($container) {
            return $container['field_formatter']->button($fieldValue, $attrs);
        };

        $callbacks['image'] = function ($fieldValue, $attrs) use ($container) {
            return $container['field_formatter']->image($fieldValue, $attrs);
        };

        return $callbacks;
    }

    /**
     * Format Field.
     */
    public function formatField($fieldValue, $attrs)
    {
        $callbacks = apply_filters('df_acf_formatter_callbacks', array());

        if (isset($callbacks[$attrs['format_as']])) {
            return $callbacks[$attrs['format_as']]($fieldValue, $attrs);
        }

        return $fieldValue;
    }

    public function render_divi_module($attrs)
    {
        $defaults = array(
        'module_class' => '',
        'addition_attributes' => '',
        'format_as' => '',
        'field' => '',
        );

        $attrs = wp_parse_args($attrs, $defaults);
        $shortcode = sprintf("[df_acf_field field='%s' format_as='%s' class_name='%s' %s]", $attrs['field'], $attrs['format_as'], $attrs['module_class'], $attrs['addition_attributes']);
        return do_shortcode($shortcode);
    }
}
