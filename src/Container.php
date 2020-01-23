<?php
namespace MRKWP\Custom_Post_Builder;

use Pimple\Container as PimpleContainer;

/**
 * DI Container.
 */
class Container extends PimpleContainer {
    public static $instance;

    protected $post;

    /**
     * Constructor
     */
    public function __construct() {
        $this->initObjects();
    }

    /**
     * Init hook.
     */
    public function actionInit() {
        // $this['api']->register();
    }

    /**
     * Flush local storage items.
     *
     * @return [type] [description]
     */
    public function flushLocalStorage() {
        echo "<script>" .
            "localStorage.removeItem('et_pb_templates_et_pb_df_acf_field_module');" .
            "localStorage.removeItem('et_pb_templates_et_pb_df_acf_button');" .
            "localStorage.removeItem('et_pb_templates_et_pb_df_custom_post_meta_field');" .
            "localStorage.removeItem('et_pb_templates_et_pb_df_cpb_post_content');" .
            "localStorage.removeItem('et_pb_templates_et_pb_df_cpb_post_excerpt');" .
            "localStorage.removeItem('et_pb_templates_et_pb_df_acf_gallery');" .
            "</script>";
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Container();
        }

        return self::$instance;
    }

    public function get_post() {
        global $post;
        return isset($this->post) ? $this->post : $post;
    }

    /**
     * Define dependancies.
     */
    public function initObjects() {
        $this['custom_posts'] = function ($container) {
            return new CustomPosts($container);
        };

        $this['activation'] = function ($container) {
            return new Activation($container);
        };

        $this['shortcodes'] = function ($container) {
            return new Shortcodes($container);
        };

        $this['acf_shortcode'] = function ($container) {
            return new ACFShortcode($container);
        };

        $this['acf'] = function ($container) {
            return new Acf($container);
        };

        $this['field_formatter'] = function ($container) {
            return new FieldFormatter($container);
        };

        $this['api'] = function ($container) {
            return new API($container);
        };

        $this['admin'] = function ($container) {
            return new Admin($container);
        };

        $this['menu'] = function ($container) {
            return new Menu($container);
        };

        $this['divi_modules'] = function ($container) {
            return new DiviModules($container);
        };

        $this['divi'] = function ($container) {
            return new Divi($container);
        };

        $this['plugins'] = function ($container) {
            return new Plugins($container);
        };

        $this['themes'] = function ($container) {
            return new Themes($container);
        };

        $this['template'] = function ($container) {
            return new Template($container);
        };
    }

    /**
     * Start the plugin
     */
    public function run() {
        add_action('plugins_loaded', [$this['plugins'], 'checkDependancies']);
        add_action('plugins_loaded', [$this['themes'], 'checkDependancies']);

        $this['custom_posts']->register();

        add_action('customize_register', [$this['divi'], 'layoutPicker']);

        //add default formatters.
        add_filter('df_acf_formatter_callbacks', [$this['acf_shortcode'], 'default_formatters']);

        // divi module register.
        add_action('et_builder_ready', [$this['divi_modules'], 'register'], 1);
        add_action('divi_extensions_init', [$this['divi_modules'], 'register_extensions']);

        $this['shortcodes']->add();

        // override the post template if enabled in the divi layout customizer.
        add_filter('single_template', [$this['divi'], 'changePostTypeTemplate'], 1, 1);
        add_filter('single_template', [$this['custom_posts'], 'changePostBuilderTemplate']);

        add_action('admin_enqueue_scripts', [$this['admin'], 'customPostScripts'], 10, 1);
        add_filter('et_builder_post_types', [$this['custom_posts'], 'enableDiviBuilder']);

        add_action('admin_head', [$this, 'flushLocalStorage']);

        add_filter('template_include', [$this['template'], 'template_include'], 10000);

        add_action('add_meta_boxes', [$this['custom_posts'], 'add_meta_boxes']);
        add_action('save_post', [$this['custom_posts'], 'save_meta_data']);

        // remove divi frontend builder styles since we don't want them.
        add_action('wp_print_styles', [$this['divi_modules'], 'wp_print_styles']);

    }

    public function setRelatedPost($post) {
        $this->post = $post;
    }
}
