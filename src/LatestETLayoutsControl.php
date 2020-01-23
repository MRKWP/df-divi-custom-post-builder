<?php

namespace MRKWP\Custom_Post_Builder;

use WP_Customize_Control;
use WP_Query;

/**
 * Control which shows latest et layout as dropdowns.
 */
class LatestETLayoutsControl extends WP_Customize_Control
{

    public $type = 'et_pb_layout_dropdown';
    public $post_type = 'et_pb_layout';
    
        
    public function render_content()
    {
        $latest = new WP_Query(
            array(
            'post_type'   => $this->post_type,
            'post_status' => 'publish',
            'orderby'     => 'date',
            'order'       => 'DESC',
            'posts_per_page' => -1,

            )
        );

        include MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/resources/views/et_layouts/layout_dropdown.php';
    }
}
