<?php
namespace MRKWP_CPB_Divi_Modules\GalleryModule;

use ET_Builder_Element;
use ET_Builder_Module_Gallery;

class GalleryModule extends ET_Builder_Module_Gallery {
    public $vb_support = 'on';

    protected $module_credits = [
        'module_uri' => 'https://www.mrkwp.com',
        'author'     => 'MRK Development Pty Ltd',
        'author_uri' => 'https://www.mrkwp.com',
    ];

    public function __construct($container) {
        $this->container = $container;
        parent::__construct();
    }

    public function get_fields() {
        $fields = parent::get_fields();

        if (isset($fields['gallery_ids'])) {
            unset($fields['gallery_ids']);
        }

        if (isset($fields['gallery_orderby'])) {
            unset($fields['gallery_orderby']);
        }

        if (isset($fields['gallery_captions'])) {
            unset($fields['gallery_captions']);
        }

        // if (isset($fields['posts_number'])) {
        //     unset($fields['posts_number']);
        // }

        if (isset($fields['orientation'])) {
            unset($fields['orientation']);
        }

        if (isset($fields['show_pagination'])) {
            unset($fields['show_pagination']);
        }

        $fields['acf_field'] = [
            'label'       => esc_html__('ACF Field', 'et_builder'),
            'type'        => 'select',
            'options'     => $this->container['acf']->getCustomFields('gallery'),
            'description' => esc_html__('Select your ACF Field.', 'et_builder'),
            'toggle_slug' => 'main_content',
        ];

        $sizes = get_intermediate_image_sizes();

        $fields['image_thumbnail_size'] = [
            'label'       => esc_html__('Thumbnail Size', 'et_builder'),
            'type'        => 'select',
            'options'     => array_combine($sizes, $sizes),
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Select the size of image thumb.', 'et_builder'),
            'default'     => 'large',
        ];

        // auto animation
        $fields['auto'] = [
            'label'           => esc_html__('Automatic Animation', 'et_builder'),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => [
                'off' => esc_html__('Off', 'et_builder'),
                'on'  => esc_html__('On', 'et_builder'),
            ],
            'affects'         => [
                'auto_speed',
                'auto_ignore_hover',
            ],
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'animation',
            'description'     => esc_html__('If you would like the slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'et_builder'),
            'default'         => 'off',
        ];

        $fields['auto_speed'] = [
            'label'           => esc_html__('Automatic Animation Speed (in ms)', 'et_builder'),
            'type'            => 'text',
            'option_category' => 'configuration',
            'depends_show_if' => 'on',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'animation',
            'description'     => esc_html__("Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'et_builder'),
            'default'         => '7000',
        ];

        return $fields;
    }

    public function get_images($args) {
        $post = $this->container->get_post();

        $attachments = get_field($args['meta_name'], $post);

        $output = [];

        if ($attachments and is_array($attachments)) {
            foreach ($attachments as $key => $val) {
                $output[] = [
                    'image_src_full'  => $val['url'],
                    'image_src_thumb' => $val['sizes'][$args['thumb_size']],
                    'title'           => $val['title'],
                    'caption'         => $val['caption'],
                    'description'     => $val['description'],
                ];
            }
        }

        return $output;
    }

    public function init() {
        parent::init();
        $this->name = esc_html__('ACF Gallery', 'et_builder');
        $this->slug = 'et_pb_df_acf_gallery';

        unset($this->advanced_fields['fonts']['pagination']);
    }

    public function render($attrs, $content = null, $render_slug) {
        $gallery_ids            = [];
        $fullwidth              = $this->props['fullwidth'];
        $show_title_and_caption = $this->props['show_title_and_caption'];
        $background_layout      = $this->props['background_layout'];
        $posts_number           = $this->props['posts_number'];
        $show_pagination        = '';
        // $gallery_orderby        = $this->props['gallery_orderby'];
        $zoom_icon_color       = $this->props['zoom_icon_color'];
        $hover_overlay_color   = $this->props['hover_overlay_color'];
        $hover_icon            = $this->props['hover_icon'];
        $auto                  = $this->props['auto'];
        $auto_speed            = $this->props['auto_speed'];
        $orientation           = '';
        $pagination_text_align = $this->get_pagination_alignment();
        $header_level          = $this->props['title_level'];

        // add this to ensure the hardcoded styles and js work.
        $this->add_classname('et_pb_gallery');

        if ('' !== $zoom_icon_color) {
            ET_Builder_Element::set_style(
                $render_slug, [
                    'selector'    => '%%order_class%% .et_overlay:before',
                    'declaration' => sprintf(
                        'color: %1$s !important;',
                        esc_html($zoom_icon_color)
                    ),
                ]
            );
        }

        if ('' !== $hover_overlay_color) {
            ET_Builder_Element::set_style(
                $render_slug, [
                    'selector'    => '%%order_class%% .et_overlay',
                    'declaration' => sprintf(
                        'background-color: %1$s;
					border-color: %1$s;',
                        esc_html($hover_overlay_color)
                    ),
                ]
            );
        }

        // get images

        $attachments = $this->get_images(
            [
                // 'gallery_orderby' => $gallery_orderby,
                'fullwidth'   => $fullwidth,
                'orientation' => '',
                'meta_name'   => $this->props['acf_field'],
                'thumb_size'  => $this->props['image_thumbnail_size'],
            ]
        );

        // wp_die(var_dump($attachments));
        if (empty($attachments)) {
            return '';
        }

        wp_enqueue_script('hashchange');

        $background_class          = "et_pb_bg_layout_{$background_layout}";
        $video_background          = $this->video_background();
        $parallax_image_background = $this->get_parallax_image_background();
        $posts_number              = 0 === intval($posts_number) ? 4 : intval($posts_number);

        \ET_Builder_Element::set_style( //next and prev links are not working by default.
            $render_slug,
            [
                'selector'    => "{$this->main_css_class} li.prev, {$this->main_css_class} li.next",
                'declaration' => sprintf('display: none !important;'),
            ]
        );

        // Module classnames
        $this->add_classname(
            [
                $background_class,
                $this->get_text_orientation_classname(),
            ]
        );

        if ('on' === $fullwidth) {
            $this->add_classname(
                [
                    'et_pb_slider',
                    'et_pb_gallery_fullwidth',
                ]
            );
        } else {
            $this->add_classname('et_pb_gallery_grid');
        }

        if ('on' === $auto && 'on' === $fullwidth) {
            $this->add_classname(
                [
                    'et_slider_auto',
                    "et_slider_speed_{$auto_speed}",
                    'clearfix',
                ]
            );
        }

        $output = sprintf(
            '<div%1$s class="%2$s">
			<div class="et_pb_gallery_items et_post_gallery clearfix" data-per_page="%3$d">',
            $this->module_id(),
            $this->module_classname($render_slug),
            esc_attr($posts_number)
        );

        $output .= $video_background;
        $output .= $parallax_image_background;

        // Images: Add CSS Filters and Mix Blend Mode rules (if set)
        if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
            $generate_css_filters_item = $this->generate_css_filters(
                $render_slug,
                'child_',
                self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
            );
        }

        foreach ($attachments as $id => $attachment) {
            $data_icon = '' !== $hover_icon
            ? sprintf(
                ' data-icon="%1$s"',
                esc_attr(et_pb_process_font_icon($hover_icon))
            )
            : '';

            $image_output = sprintf(
                '<a href="%1$s" title="%2$s">
				<img src="%3$s" alt="%2$s" />
				<span class="et_overlay%4$s"%5$s></span>
				</a>',
                esc_url($attachment['image_src_full']),
                esc_attr($attachment['title']),
                esc_url($attachment['image_src_thumb']),
                ('' !== $hover_icon ? ' et_pb_inline_icon' : ''),
                $data_icon
            );

            $output .= sprintf(
                '<div class="et_pb_gallery_item%2$s%1$s%3$s">',
                esc_attr(' ' . $background_class),
                ('on' !== $fullwidth ? ' et_pb_grid_item' : ''),
                $generate_css_filters_item
            );
            $output .= "
			<div class='et_pb_gallery_image {$orientation}'>
			$image_output
			</div>";

            if ('on' !== $fullwidth && 'on' === $show_title_and_caption) {
                if (trim($attachment['title'])) {
                    $output .= sprintf('<%2$s class="et_pb_gallery_title">%1$s</%2$s>', wptexturize($attachment['title']), et_pb_process_header_level($header_level, 'h3'));
                }
                if (trim($attachment['caption'])) {
                    $output .= "
					<p class='et_pb_gallery_caption'>
					" . wptexturize($attachment['caption']) . "
					</p>";
                }
            }
            $output .= "</div>";
        }

        $output .= "</div><!-- .et_pb_gallery_items -->";

        if (count($attachment) > 4) {
            $output .= sprintf(
                '<div class="et_pb_gallery_pagination%1$s"></div>',
                $pagination_text_align === 'justify' ? ' et_pb_gallery_pagination_justify' : ''
            );
        }

        $output .= "</div><!-- .et_pb_gallery -->";

        return $output;
    }
}
