<?php
// don't load directly
if (!defined('ABSPATH')) {
    die('-1');
}

class W_Node_Products
{
    // private $loader;

    // public function __construct()
    // {
    //     $this->loader = new W_Node_Loader();
    // }

    // public function init()
    // {
    //     $this->define_hooks();
    //     $this->loader->run();
    // }

    // private function define_hooks()
    // {
    //     // if ($this->export_state()) {
    //     $this->loader->add_action('admin_enqueue_scripts', $this, 'rest_enqueue_script');
    //     // }
    // }




    // public function export_state()
    // {
    //     return (bool) get_option('export_state');
    // }




    // function rest_enqueue_script()
    // {
    //     wp_enqueue_script(
    //         'products-rest-api',
    //         plugin_dir_url(__FILE__) . 'js/products/rest-api.js',
    //         array('wp-api'),
    //         null,
    //         true // Load in footer
    //     );
    // }

    private function wc_export_callback(){
        $api_host = get_option('wc_export');
        ?>
            <input
                type="text"
                class="regular-text"
                id="w_node_api_host"
                name="w_node_api_host"
                value="<?php echo esc_attr($api_host); ?>" 
            />
        <?php
    }
}
