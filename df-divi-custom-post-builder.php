<?php
/**
 * Plugin Name:     Custom Post Builder for Divi
 * Plugin URI:      http://www.mrkwp.com/
 * Description:     Build single's layout for custom post type using divi builder
 * Author:          M R K Development Pty Ltd
 * Author URI:      http://www.mrkwp.com/
 * Text Domain:     df-divi-custom-post-builder
 * Domain Path:     /languages
 * Version:         4.0.0
 *
 * @package DF_DIVI_CUSTOM_POST_BUILDER
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('MRKWP_DIVI_CUSTOM_POST_BUILDER_VERSION', '4.0.0');
define('MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR', __DIR__);
define('MRKWP_DIVI_CUSTOM_POST_BUILDER_URL', plugins_url('/' . basename(__DIR__)));

require_once MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/vendor/autoload.php';
require_once MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR . '/functions.php';

$container                   = \MRKWP\Custom_Post_Builder\Container::getInstance();
$container['plugin_name']    = 'Custom Post Builder for Divi';
$container['plugin_version'] = MRKWP_DIVI_CUSTOM_POST_BUILDER_VERSION;
$container['plugin_file']    = __FILE__;
$container['plugin_dir']     = MRKWP_DIVI_CUSTOM_POST_BUILDER_DIR;
$container['plugin_url']     = MRKWP_DIVI_CUSTOM_POST_BUILDER_URL;
$container['plugin_slug']    = 'df-divi-custom-post-builder';

// activation hook.
register_activation_hook(__FILE__, [$container['activation'], 'install']);

$container->run();
