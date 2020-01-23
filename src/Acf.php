<?php

namespace MRKWP\Custom_Post_Builder;

class Acf
{
    protected $container;
    protected $fields;


    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getCustomFields($type = '')
    {
        if (!function_exists('acf')) {
            return array();
        }
        
        $version = acf()->settings['version'];

        if (version_compare($version, '5.0', '>=')) {
            $fields = $this->getAcfFields($type);
        }

        if (!isset($fields)) {
            return array();
        }

        $acfFields = array();

        foreach ($fields as $field) {
            // dump($field);
            if (!$type || ($type == $field['type'])) {
                $acfFields[$field['key']] = sprintf('[%s] %s', $field['group_name'], $field['label']);
            }
        }

        return array_merge(['-' => 'Select One'], $acfFields);
    }


    public function getAcfFields($type = '')
    {
        add_action('pre_get_posts', array( $this, 'disableWMPL' ));
        $field_groups = acf_get_field_groups();
        remove_action('pre_get_posts', array( $this, 'disableWMPL' ));

        $acfFields = array();

        foreach ($field_groups as $field_group) {
            if (function_exists('\\acf_get_fields')) {
                $fields = acf_get_fields($field_group['ID']);
            } else {
                $fields = acf_get_fields_by_id($field_group['ID']);
            }
    
            if ($fields) {
                foreach ($fields as $i => $field) {
                    if (!$type || ($type == $field['type'])) {
                        $fields[$i]['group_name'] = $field_group['title'];
                    }
                }
                $acfFields = array_merge($acfFields, $fields);
            }
        }

    

        return $acfFields;
    }


    /**
     * Field Groups for all languages.
     */
    public function disableWMPL($query)
    {
        $query->set('suppress_filters', true);
    }
}
