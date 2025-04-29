<?php

/**
 * Plugin Name:       W-Node
 * Description:       Custom Pluging for learning goals
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 // Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
define('W_NODE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('W_NODE_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once W_NODE_PLUGIN_DIR .  'includes/class-w-node.php';

function w_node_init(){
    $w_node = W_Node::get_instance();
    $w_node->init(); 
}

// Hook initialization to WordPress init
add_action('plugins_loaded', 'w_node_init');
