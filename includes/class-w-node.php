<?php

if (!defined('ABSPATH')) {
    exit;
}


class W_Node
{

    private static $instance = null;

    public $posts = null;

    public $admin = null;

    public static function get_instance(){
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        if (!session_id()) {
            session_start();
        }
    }

    public function init(){
        $this->load_dependencies();
        $this->initialize_admin();
        // $this->initialize_posts();
    }

    private function load_dependencies() {
        // Core functionality
        require_once W_NODE_PLUGIN_DIR . 'includes/class-w-node-loader.php';
        require_once W_NODE_PLUGIN_DIR . 'includes/class-w-node-posts.php';
        // require_once W_NODE_PLUGIN_DIR . 'includes/class-w-node-products.php';

        // Admin page
        require_once W_NODE_PLUGIN_DIR . 'includes/class-w-node-admin.php';
    }

    private function initialize_admin() {
        $this->admin = new W_Node_Admin();
        $this->admin->init();
    }

    // private function initialize_posts() {
    //     $this->posts = new W_Node_Posts();
    //     $this->posts->init();
    // }
}
