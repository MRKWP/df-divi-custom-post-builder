<?php
namespace MRKWP\Custom_Post_Builder;

/**
 * Plugins Helper class.
 */
class Plugins {

    //container.
    protected $container;

    /**
     * Constructor.
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * Check Dependancies
     */
    public function checkDependancies() {
        if (is_admin()) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';

            if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
                $container = $this->container;

                add_action(
                    'admin_notices', function () use ($container) {
                        $class   = 'notice notice-error is-dismissible';
                        $message = sprintf('<b>%s</b> requires <b>%s</b> plugin to be installed and activated.', $container['plugin_name'], 'Advanced Custom Fields(ACF) PRO');

                        printf('<div class="%1$s"><p>%2$s</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', $class, $message);
                    }
                );
            }
        }
    }

    /**
     * Check if dependant plugin is active. If not show an admin notice.
     */
    public function checkDependancy($plugin, $niceName) {
        if (is_admin()) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';

            if (!is_plugin_active($plugin)) {
                $container = $this->container;

                add_action(
                    'admin_notices', function () use ($niceName, $container) {
                        $class   = 'notice notice-error is-dismissible';
                        $message = sprintf('<b>%s</b> requires <b>%s</b> plugin to be installed and activated.', $container['plugin_name'], $niceName);

                        printf('<div class="%1$s"><p>%2$s</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', $class, $message);
                    }
                );
            }
        }
    }
}
