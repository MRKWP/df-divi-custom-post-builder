<?php

namespace MRKWP\Custom_Post_Builder;

/**
 * Class to register custom API endpoints.
 */
class API
{
    
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


    /**
     * Register the API calls.
     * wp_ajax_ and wp_ajax_nopriv
     */
    public function register()
    {
    }



    /**
     * Helper response method.
     */
    public function respond($data, $code)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        wp_die();
    }
}
