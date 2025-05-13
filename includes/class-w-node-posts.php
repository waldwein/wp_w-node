<?php
// don't load directly
if (!defined('ABSPATH')) {
    die('-1');
}

class W_Node_Posts{
    private $loader;

    public function __construct(){
        $this->loader = new W_Node_Loader();
    }


    public function init(){
        $this->define_hooks();
        $this->loader->run();
    }

    private function define_hooks(){
        $this->loader->add_action('admin_enqueue_scripts', $this, 'rest_enqueue_script');
        $this->loader->add_action('wp_enqueue_scripts', $this, 'chatbot_scripts');
    }


    function rest_enqueue_script(){
        wp_enqueue_script(
            'posts-rest-api',
            plugin_dir_url(__FILE__) . 'js/posts/index.js',
            array('wp-api'),
            null,
            true // Load in footer
        );
        
    }
    
    function chatbot_scripts() {
        wp_enqueue_script(
            'chatbot-script',
            plugin_dir_url(__FILE__) . 'js/chatbot/index.js',
            array(),
            null,
            true
        );

        wp_enqueue_script(
            'chatbot',
            'https://cdn.jsdelivr.net/gh/WayneSimpson/n8n-chatbot-template@ba944c3/chat-widget.js',
            array(),
            null,
            true // Load in footer
        );
    }
}
