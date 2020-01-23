<?php

function mrkwp_post_builder_init()
{
    register_post_type(
        'df_post_builder', array(
        'labels'            => array(
            'name'                => __('Posts Builder', 'df-divi-custom-post-builder'),
            'singular_name'       => __('Post Builder', 'df-divi-custom-post-builder'),
            'all_items'           => __('All Posts Builder', 'df-divi-custom-post-builder'),
            'new_item'            => __('New Post Builder', 'df-divi-custom-post-builder'),
            'add_new'             => __('Add New', 'df-divi-custom-post-builder'),
            'add_new_item'        => __('Add New Post Builder', 'df-divi-custom-post-builder'),
            'edit_item'           => __('Edit Post Builder', 'df-divi-custom-post-builder'),
            'view_item'           => __('View Post Builder', 'df-divi-custom-post-builder'),
            'search_items'        => __('Search Posts Builder', 'df-divi-custom-post-builder'),
            'not_found'           => __('No Posts Builder found', 'df-divi-custom-post-builder'),
            'not_found_in_trash'  => __('No Posts Builder found in trash', 'df-divi-custom-post-builder'),
            'parent_item_colon'   => __('Parent Post Builder', 'df-divi-custom-post-builder'),
            'menu_name'           => __('Posts Builder', 'df-divi-custom-post-builder'),
        ),
        'public'            => true,
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_in_nav_menus' => true,
        'supports'          => array( 'title', 'editor' ),
        'has_archive'       => true,
        'rewrite'           => true,
        'query_var'         => true,
        'menu_icon'         => 'dashicons-admin-post',
        'show_in_rest'      => true,
        'rest_base'         => 'df_post_builder',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        )
    );
}
add_action('init', 'mrkwp_post_builder_init');

function mrkwp_post_builder_updated_messages($messages)
{
    global $post;

    $permalink = get_permalink($post);

    $messages['df_post_builder'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf(__('Post Builder updated. <a target="_blank" href="%s">View Post Builder</a>', 'df-divi-custom-post-builder'), esc_url($permalink)),
        2 => __('Custom field updated.', 'df-divi-custom-post-builder'),
        3 => __('Custom field deleted.', 'df-divi-custom-post-builder'),
        4 => __('Post Builder updated.', 'df-divi-custom-post-builder'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf(__('Post Builder restored to revision from %s', 'df-divi-custom-post-builder'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Post Builder published. <a href="%s">View Post Builder</a>', 'df-divi-custom-post-builder'), esc_url($permalink)),
        7 => __('Post Builder saved.', 'df-divi-custom-post-builder'),
        8 => sprintf(__('Post Builder submitted. <a target="_blank" href="%s">Preview Post Builder</a>', 'df-divi-custom-post-builder'), esc_url(add_query_arg('preview', 'true', $permalink))),
        9 => sprintf(
            __('Post Builder scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Post Builder</a>', 'df-divi-custom-post-builder'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)),
            esc_url($permalink)
        ),
        10 => sprintf(__('Post Builder draft updated. <a target="_blank" href="%s">Preview Post Builder</a>', 'df-divi-custom-post-builder'), esc_url(add_query_arg('preview', 'true', $permalink))),
    );

    return $messages;
}
add_filter('post_updated_messages', 'mrkwp_post_builder_updated_messages');
