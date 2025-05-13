<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class W_Node_Admin
{

    private $loader;

    private $current_tab;

    private $tabs;



    public function __construct()
    {
        $this->loader = new W_Node_Loader();

        $this->tabs = array(
            // 'general' => __('Configuration', 'w_node'),
            'posts' => __('Posts', 'w_node'),
            'products' => __('Products', 'w_node')
        );

        //apply for filter to allow for custom tabs
        $this->tabs = apply_filters('w_node_admin_tabs', $this->tabs);

        //set current tab
        $this->current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'posts';
        if (!array_key_exists($this->current_tab, $this->tabs)) {
            $this->current_tab = 'posts';
        }

        $this->current_tab = apply_filters('w_node_active_tab', $this->current_tab);
    }


    public function init()
    {
        $this->define_admin_hooks();
        $this->loader->run();
    }

    public function define_admin_hooks()
    {
        $this->loader->add_action('admin_menu', $this, 'add_admin_menu');
        $this->loader->add_action('admin_init', $this, 'register_settings');
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts');
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_styles');

        $this->loader->add_action('wp_enqueue_scripts', $this, 'chatbot_scripts');

    }

    public function register_settings()
    {

        register_setting('w_node_general', 'wc_export', 'checkbox');

        // General settings
        add_settings_section(
            'w_node_general_section',
            'Genral W-Node settings',
            null,
            'w_node_general'
        );

        // add_settings_field(
        //     'wc_export',
        //     'Enable',
        //     array($this, 'wc_export_callback'),
        //     'w_node_general',
        //     'w_node_general_section'
        // );
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'W-Node',
            'W-Node',
            'manage_options',
            'w_node',
            array($this, 'render_admin_page')
        );
    }


    function render_admin_page()
    {
?>
        <div class="main">
            <form method="post" action="options.php">
                <?php
                settings_fields('w_node_general');
                do_settings_sections('w_node_general');
                ?>
            </form>

            <div class="w_node-admin-tabs">
                <nav class="nav-tab-wrapper">
                    <?php foreach ($this->tabs as $tab_id => $tab_name) : ?>
                        <a href="?page=w_node&tab=<?php echo esc_attr($tab_id);  ?>" class="nav-tab <?php echo $this->current_tab === $tab_id ? 'nav-tab-active' : ''; ?>">
                            <?php echo esc_html($tab_name); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>

            <div class="wrap">
                <tbody id="content-wrapper">
                    <?php $this->render_tab_content() ?>
                </tbody>
            </div>
        </div>
    <?php
    }
    function render_tab_content()
    {
        switch ($this->current_tab) {
            case 'posts':
                $this->render_posts_tab();
                break;
            case 'products':
                $this->render_products_tab();
                break;
                // default: 
                // $this->render_posts_tab();
        }
    }


    function render_general_tab() {}

    public function render_posts_tab()
    {
        $woocommerce_active = function_exists('WC');

    ?>
        <div class="wrap" id="wp_admin">
            <?php if (!$woocommerce_active) : ?>
                <div class="w_node-notice-warning">
                    <p><?php _e('WooCommerce is not active. Activate WooCommerce to export products.', 'w_node'); ?></p>
                </div>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped posts">
                    <thead>
                        <tr>
                            <th scope="col" id="cb" class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                                <input id="cb-select-all-1" type="checkbox">
                            </th>
                            <th scope="col" class="manage-column column-title column-primary sortable desc">
                                <span>Title</span>
                            </th>
                            <th scope="col" class="manage-column column-author">
                                <span>Author</span>
                            </th>
                            <th scope="col" class="manage-column column-categories">
                                <span>Category</span>
                            </th>
                            <th scope="col" class="manage-column column-tags">
                                <span>Tags</span>
                            </th>
                            <th scope="col" class="manage-column column-date">
                                <span>Date</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="posts-wrapper">
                        <!-- Posts will be added here by JavaScript -->
                    </tbody>
                </table>
                <button id="export-posts" class="button button-secondary">Export Posts</button>
            <?php endif; ?>
        </div>
    <?php
    }


    public function render_products_tab()
    {
        // Check if WooCommerce is active
        $woocommerce_active = function_exists('WC');
    ?>
        <div class="wrap" id="wp_admin">
            <div class="w_node-card">
                <?php if (!$woocommerce_active) : ?>
                    <div class="w_node-notice w_node-notice-warning">
                        <p>WooCommerce is not active. Activate WooCommerce to export products.</p>
                    </div>
                <?php else : ?>
            </div>
            <table class="wp-list-table widefat fixed striped products">
                <thead>
                    <tr>
                        <th scope="col" id="cb" class="manage-column column-cb check-column">
                            <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                            <input id="cb-select-all-1" type="checkbox">
                        </th>
                        <th scope="col" class="manage-column column-title column-primary sortable desc">
                            <span>Title</span>
                        </th>
                        <th scope="col" class="manage-column column-author">
                            <span>Author</span>
                        </th>
                        <th scope="col" class="manage-column column-categories">
                            <span>Category</span>
                        </th>
                        <th scope="col" class="manage-column column-tags">
                            <span>Tags</span>
                        </th>
                        <th scope="col" class="manage-column column-date">
                            <span>Date</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="products-wrapper">
                    <!-- js dynamic -->


                </tbody>
            </table>
            <button id="export-products" class="button button-secondary">Export Products</button>
        <?php endif; ?>
        </div>
<?php
    }


    // public function wc_export_callback() {}
    function chatbot_scripts() {
        wp_enqueue_script(
            'chatbot-script',
            W_NODE_PLUGIN_URL  . 'assets/js/chatbot/index.js',
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

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'posts-api',
            W_NODE_PLUGIN_URL . 'assets/js/posts/index.js',
            array('wp-api'),
        );

        wp_enqueue_script(
            'products-api',
            W_NODE_PLUGIN_URL . 'assets/js/products/index.js',
            array('wp-api'),
        );
    }
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'custom-admin-style',
            W_NODE_PLUGIN_URL . 'assets/css/custom.css',
            array()
        );
    }
}
