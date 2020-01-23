<?php

namespace MRKWP\Custom_Post_Builder;

/**
 * Class defines custom post types.
 */
class CustomPosts
{

    protected $container;

    private $label, $args;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function register()
    {
        // register your custom post and taxonomy here.
        $postsDir = MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/post-types';
        include_once $postsDir . '/df_post_builder.php';
    }

    /**
     * Post Types
     */
    public function getPublicPostTypes()
    {
        $registeredPostTypes = get_post_types(array('public' => true), 'object');
        $postTypes = array();

        foreach ($registeredPostTypes as $registeredPostType) {
            $postTypes[$registeredPostType->name] = $registeredPostType->label;
        }

        return $postTypes;
    }

    public function enableDiviBuilder($postTypes)
    {
        $postTypes[] = 'df_post_builder';

        return $postTypes;
    }

    public function changePostBuilderTemplate($singleTemplate)
    {
        global $post;

        if ($post->post_type == 'df_post_builder') {
            $related_posts = get_field('related_post', $post->ID);
            if (isset($related_posts[0])) {
                $this->container->setRelatedPost($related_posts[0]);
            }

            return MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/divi/custom_posts/single-df_post_builder.php';
        }

        return $singleTemplate;
    }

    // df_post_field shortcode
    public function post_field($atts)
    {
        $post = $this->container->get_post();
        return isset($post->{$atts['name']}) ? $post->{$atts['name']} : '';
    }

    public function post_meta_as_list_item($attrs)
    {
        $post = $this->container->get_post();
        $value = get_post_meta($post->ID, $attrs['meta_key'], true);
        if (!$value) {
            return '';
        }

        return sprintf('<li><strong>%s</strong> %s</li>', $attrs['label'], $value);
    }

    public function add_meta_boxes()
    {

        $publicPosts = $this->container['custom_posts']->getPublicPostTypes();

        foreach ($publicPosts as $post_type => $label) {
            if(!in_array($post_type, array('df_post_builder'))) {
                add_meta_box('cpb-metabox', 'Custom Post Builder', array($this, 'show_metabox'), $post_type, 'advanced', 'high');
            }
        }
    }

    public function show_metabox()
    {
        global $pagenow;
        wp_nonce_field(plugin_basename($this->container['plugin_file']), 'cpb_fields');

        if ($pagenow == 'post-new.php') {
            $templateId = false;
        } else {
            global $post;
            $templateId = get_post_meta($post->ID, 'cpb_template_id', true);
        }

        $libraryItems = $this->container['divi']->getLibraryItemList();

        echo '<label class="textinput" for="cpb_template_id">Override Template:</label>&nbsp;&nbsp;';
        echo "<select name='cpb_template_id'>";
        echo "<option value=''>Select Template</option>";
        foreach ($libraryItems as $postId => $title) {    
            echo sprintf(
                '<option value="%s" %s>%s</option>', 
                $postId,
                $templateId == $postId ? 'selected' : '',
                $title
            );
        }
        echo "</select>";

        echo "<p class='description'>Select a divi library item to override the selected custom post builder template. This will only when if Custom post builder is rendering the post type.</p>";
        
    }


    public function save_meta_data($id)
    {
        /* --- security verification --- */
        if (!isset($_POST['cpb_fields']) || !wp_verify_nonce($_POST['cpb_fields'], plugin_basename($this->container['plugin_file']))) {
            return $id;
        } // end if

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $id;
        } // end if


        if (!current_user_can('edit_page', $id)) {
            return $id;
        }

        update_post_meta($id, 'cpb_template_id', $_POST['cpb_template_id']);    
    }

}
