<?php

namespace MRKWP\Custom_Post_Builder;

/**
 * WordPress Menu Hook class.
 */
class Menu
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


    /**
     * Register admin menu
     */
    public function adminMenu()
    {
        // \add_action('admin_menu', array($this->container['settings'], 'main'));
    }

    public function admin_submenu()
    {
        ob_start();
        include $this->container['plugin_dir'] . '/resources/views/admin-submenu.php';
        echo ob_get_clean();
    }
}
