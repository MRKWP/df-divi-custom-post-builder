<?php
namespace MRKWP\Custom_Post_Builder;

/**
 * Themes Helper class.
 */
class Themes
{

    //container.
    protected $container;

    /**
     * Constructor.
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Check Dependancies
     */
    public function checkDependancies()
    {
        $themes = array(
            'Divi',
        );

        foreach ($themes as $theme) {
            $this->checkDependancy($theme);
        }
    }

    /**
     * Check if dependant theme is active. If not show an admin notice.
     */
    public function checkDependancy($theme)
    {
        if (is_admin()) {
            $currentTheme = wp_get_theme();

            // Parent theme matches
            if ($currentTheme->get('Name') == $theme) {
                return;
            }

            // check for child theme.
            if ($currentTheme->parent()) {
                if ($currentTheme->parent()->get('Name') == $theme) {
                    return;
                }
            }
            
            $container = $this->container;

            add_action(
                'admin_notices', function () use ($theme, $container) {
                    $class = 'notice notice-error is-dismissible';
                    $message = sprintf('<b>%s</b> requires <b>%s</b> theme to be installed and activated.', $container['plugin_name'], $theme);

                    printf('<div class="%1$s"><p>%2$s</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', $class, $message);
                }
            );
        }
    }
}
