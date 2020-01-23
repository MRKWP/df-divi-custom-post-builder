<?php

if (function_exists('acf_add_local_field_group')) :
    acf_add_local_field_group(array (
    'key' => 'group_59840e6d0b343',
    'title' => 'Posts Builder',
    'fields' => array (
        array (
            'key' => 'field_59840e7fe1793',
            'label' => 'Related Post',
            'name' => 'related_post',
            'type' => 'relationship',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array (
            ),
            'taxonomy' => array (
            ),
            'filters' => array (
                0 => 'search',
                1 => 'post_type',
                2 => 'taxonomy',
            ),
            'elements' => '',
            'min' => '',
            'max' => '',
            'return_format' => 'object',
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'df_post_builder',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
    ));
endif;
