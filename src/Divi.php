<?php
namespace MRKWP\Custom_Post_Builder;

/**
 * Divi - General
 */
class Divi
{
    
    protected $container;


    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Layout picker for Divi Theme Customisation.
     */
    public function layoutPicker($wp_customize)
    {
        $customPosts = $this->container['custom_posts']->getPublicPostTypes();

        $iter = 1;
        
        // add layout picker for each post type.
        foreach ($customPosts as $slug => $label) {
            //Checkbox for whether to override post template
            $id = sprintf("df_%s_layout_id", $slug);

            $wp_customize->add_panel(
                $id, array(
                'priority' => 9,
                'capability' => 'edit_theme_options',
                'title' => __(sprintf('Choose Default %s Layout', $label)),
                'description' => __('Customize the login of your website.'),
                )
            );

            $lbSection = sprintf('df_lb_%s_section', $slug);

            $wp_customize->add_section(
                $lbSection, array(
                'priority' => 5,
                'title' => __(sprintf('Which layout for %s custom post?', $label)),
                'panel' => $id,
                )
            );

            $layout_checkbox = sprintf('%s_layout_checkbox', $slug);

            $wp_customize->add_setting(
                $layout_checkbox, array(
                'default' => false,
                'type' => 'option',
                'capability' => 'edit_theme_options',
                )
            );

            
            $wp_customize->add_control(
                $layout_checkbox, array(
                'section'   => $lbSection,
                'label'     => 'Override template?',
                'priority' => 10,
                'type'      => 'checkbox',
                'settings' => $layout_checkbox,
                )
            );

            $addId = sprintf('df_%s_add_id', $slug);

            $wp_customize->add_setting(
                $addId, array(
                'default' => 'false',
                'type' => 'option',
                'transport'   => 'refresh',
                'capability' => 'edit_theme_options',
                )
            );

            $wp_customize->add_control(
                new LatestETLayoutsControl(
                    $wp_customize,
                    $addId,
                    array(
                    'label' => __(sprintf('%s Layout', $label)),
                    'section' => $lbSection,
                    'type' => 'et_pb_layout_dropdown',
                    'priority' => $iter + 5,
                    'settings' => $addId
                    )
                )
            );

            $iter++;
        }
    }


    /**
     * Override the post type if selected.
     */
    public function changePostTypeTemplate($singleTemplate)
    {
        global $post;

        $layout_checkbox = sprintf('%s_layout_checkbox', $post->post_type);

        if (true == get_option($layout_checkbox)) {
            $singleTemplate = MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/divi/custom_posts/single-post.php';
        }

        return $singleTemplate;
    }


    public function getLibraryItemList()
    {
        // et_pb_layout

        global $wpdb;

        $sql = sprintf('select ID, post_title from %sposts where post_status="publish" and post_type="et_pb_layout";', $wpdb->prefix);

        $results = $wpdb->get_results($sql);

        $list = array();

        if($results) {
            foreach($results as $postItem){
                $list[$postItem->ID] = $postItem->post_title;
            }
        }

        return $list;
    }
}
