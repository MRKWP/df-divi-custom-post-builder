<?php

namespace MRKWP\Custom_Post_Builder;

class FieldFormatter
{
    protected $container;


    public function __construct($container)
    {
        $this->container = $container;
    }


    /**
     * Format as unordered list.
     */
    public function unorderedList($options, $attrs)
    {
        ob_start();
        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/formatters/unordered_list.php';
        return ob_get_clean();
    }

    /**
     * Button
     */
    public function button($file, $attrs)
    {
        $defaults = array(
            'button_target' => 'blank',
            'button_label' => 'Download',
        );
        $attrs = wp_parse_args($attrs, $defaults);

        ob_start();
        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/formatters/button.php';
        return ob_get_clean();
    }


    /**
     * Image
     */
    public function image($image, $attrs)
    {
        $attrs = wp_parse_args(
            $attrs, array(
            'animation' => 'off',
            'use_border_color' => 'off',
            'border_color' => '#ffffff',
            'show_in_lightbox' => 'off',
            )
        );


        ob_start();
        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/formatters/image.php';
        return ob_get_clean();
    }

    /**
     * Image grid.
     */
    public function imageGrid($images, $attrs)
    {
        $attrs = wp_parse_args(
            $attrs, array(
                'animation' => 'off',
                'use_border_color' => 'off',
                'border_color' => '#ffffff',
                'show_in_lightbox' => 'on',
                'items_per_row' => 3,
                'use_size' => 'off',
                'size' => '',
            )
        );

        global $post;
        if (isset($attrs['fields']) && $attrs['fields']) {
            $images = array();
            $fields = explode(',', $attrs['fields']);
            foreach ($fields as $field) {
                $images[] = get_field($field, $post);
            }
        }
        ob_start();
        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/formatters/image_grid.php';
        return ob_get_clean();
    }

    /**
     * Image Slider.
     */
    public function imageSlider($images, $attrs)
    {
        $sliderOptions = array();

        if (isset($attrs['slider_options'])) {
            $options = explode(';', $attrs['slider_options']);

            foreach ($options as $option) {
                list($key, $value) = explode('=', $option, 2);
                $sliderOptions[$key] = $value;
            }
        }

        // main slider defaults.
        $sliderDefaults = array(
            'admin_label' => "Slider",
            'show_arrows' => "on",
            'show_pagination' => "on",
            'auto' => "on",
            'auto_ignore_hover' => "off",
            'parallax' => "off",
            'parallax_method' => "off",
            'remove_inner_shadow' => "off",
            'background_position' => "default",
            'background_size' => "default",
            'hide_content_on_mobile' => "off",
            'hide_cta_on_mobile' => "off",
            'show_image_video_mobile' => "off",
            'custom_button' => "off",
            'button_letter_spacing' => "0",
            'button_use_icon' => "default",
            'button_icon_placement' => "right",
            'button_on_hover' => "on",
            'button_letter_spacing_hover' => "0",
        );
        $sliderOptions = wp_parse_args($sliderOptions, $sliderDefaults);

        // slide options.

        ob_start();
        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/formatters/image_slider.php';
        return ob_get_clean();
    }
}
