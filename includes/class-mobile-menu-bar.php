<?php
/**
 * کلاس اصلی پلاگین Mobile Menu Bar
 */

if (!defined('ABSPATH')) {
    exit;
}

class Mobile_Menu_Bar {
    
    private $settings;
    
    public function __construct() {
        $this->settings = get_option('mmb_settings', array());
    }
    
    public function run() {
        // اضافه کردن منو به صفحه مدیریت
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // ثبت تنظیمات
        add_action('admin_init', array($this, 'register_settings'));
        
        // بارگذاری استایل‌ها و اسکریپت‌های مدیریت
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // بارگذاری استایل‌ها و اسکریپت‌های عمومی
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_assets'));
        
        // نمایش منوی موبایل در فوتر
        add_action('wp_footer', array($this, 'render_mobile_menu'));
        
        // AJAX برای ذخیره تنظیمات
        add_action('wp_ajax_mmb_save_settings', array($this, 'ajax_save_settings'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Mobile Menu Bar',
            'Mobile Menu',
            'manage_options',
            'mobile-menu-bar',
            array($this, 'render_admin_page'),
            'dashicons-smartphone',
            30
        );
    }
    
    public function register_settings() {
        register_setting('mmb_settings_group', 'mmb_settings');
    }
    
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_mobile-menu-bar') {
            return;
        }
        
        // Font Awesome - با اولویت بالا
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
        
        // فونت وزیر
        wp_enqueue_style('mmb-vazir-font', MMB_PLUGIN_URL . 'public/css/vazir-font.css', array(), MMB_VERSION);
        
        // رفع مشکل Font Awesome
        wp_enqueue_style('mmb-fa-fix', MMB_PLUGIN_URL . 'admin/font-awesome-fix.css', array('font-awesome'), MMB_VERSION);
        
        // Color Picker
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        // استایل مدیریت
        wp_enqueue_style('mmb-admin-style', MMB_PLUGIN_URL . 'admin/admin-style.css', array('mmb-vazir-font', 'mmb-fa-fix'), MMB_VERSION);
        
        // اسکریپت مدیریت
        wp_enqueue_script('mmb-admin-script', MMB_PLUGIN_URL . 'admin/admin-script.js', array('jquery', 'wp-color-picker'), MMB_VERSION, true);
        
        wp_localize_script('mmb-admin-script', 'mmbAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mmb_admin_nonce')
        ));
    }
    
    public function enqueue_public_assets() {
        if (!$this->settings || !isset($this->settings['enabled']) || !$this->settings['enabled']) {
            return;
        }
        
        // Font Awesome - با اولویت بالا
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
        
        // فونت وزیر
        wp_enqueue_style('mmb-vazir-font', MMB_PLUGIN_URL . 'public/css/vazir-font.css', array(), MMB_VERSION);
        
        // رفع مشکل Font Awesome در فرانت
        wp_enqueue_style('mmb-public-fa-fix', MMB_PLUGIN_URL . 'public/css/font-awesome-fix.css', array('font-awesome'), MMB_VERSION);
        
        // استایل عمومی
        wp_enqueue_style('mmb-public-style', MMB_PLUGIN_URL . 'public/css/styles.css', array('mmb-vazir-font', 'mmb-public-fa-fix'), MMB_VERSION);
        
        // اسکریپت عمومی
        wp_enqueue_script('mmb-public-script', MMB_PLUGIN_URL . 'public/js/scripts.js', array('jquery'), MMB_VERSION, true);
        
        // ارسال تنظیمات رنگ به JavaScript برای debug
        wp_localize_script('mmb-public-script', 'mmbColors', array(
            'primary' => isset($this->settings['primary_color']) ? $this->settings['primary_color'] : '#667eea',
            'secondary' => isset($this->settings['secondary_color']) ? $this->settings['secondary_color'] : '#764ba2',
            'background' => isset($this->settings['background_color']) ? $this->settings['background_color'] : '#ffffff',
            'icon' => isset($this->settings['icon_color']) ? $this->settings['icon_color'] : '#333333',
            'active' => isset($this->settings['active_color']) ? $this->settings['active_color'] : '#667eea'
        ));
        
        // متغیرهای CSS سفارشی
        $custom_css = $this->generate_custom_css();
        wp_add_inline_style('mmb-public-style', $custom_css);
    }
    
    public function generate_custom_css() {
        $primary = isset($this->settings['primary_color']) ? $this->settings['primary_color'] : '#667eea';
        $secondary = isset($this->settings['secondary_color']) ? $this->settings['secondary_color'] : '#764ba2';
        $background = isset($this->settings['background_color']) ? $this->settings['background_color'] : '#ffffff';
        $icon_color = isset($this->settings['icon_color']) ? $this->settings['icon_color'] : '#333333';
        $active_color = isset($this->settings['active_color']) ? $this->settings['active_color'] : '#667eea';
        
        return "
            /* رنگ‌های سفارشی کاربر */
            :root {
                --mmb-primary-color: {$primary};
                --mmb-secondary-color: {$secondary};
                --mmb-background-color: {$background};
                --mmb-icon-color: {$icon_color};
                --mmb-active-color: {$active_color};
            }
            
            /* اعمال مستقیم رنگ‌ها به منو */
            .mmb-mobile-menu-bar {
                --mmb-primary-color: {$primary};
                --mmb-secondary-color: {$secondary};
                --mmb-background-color: {$background};
                --mmb-icon-color: {$icon_color};
                --mmb-active-color: {$active_color};
            }
            
            /* رنگ آیکون‌ها */
            .mmb-menu-item {
                color: {$icon_color} !important;
            }
            
            /* رنگ آیکون فعال */
            .mmb-menu-item.mmb-active {
                color: {$active_color} !important;
            }
            
            /* رنگ پس‌زمینه برای استایل‌هایی که background دارند */
            .mmb-style-1 .mmb-menu-container,
            .mmb-style-2 .mmb-menu-container,
            .mmb-style-3 .mmb-menu-container,
            .mmb-style-4 .mmb-menu-container,
            .mmb-style-5 .mmb-menu-container,
            .mmb-style-6 .mmb-menu-container,
            .mmb-style-7 .mmb-menu-container,
            .mmb-style-9 .mmb-menu-container,
            .mmb-style-10 .mmb-menu-container {
                background: {$background} !important;
            }
            
            /* رنگ گرادیانت برای استایل Glassmorphism */
            .mmb-style-5 .mmb-menu-container {
                background: rgba(" . $this->hex2rgb($background) . ", 0.7) !important;
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }
            
            /* رنگ گرادیانت برای استایل Gradient Wave */
            .mmb-style-6 .mmb-menu-container {
                background: linear-gradient(135deg, {$primary}, {$secondary}) !important;
            }
            
            /* رنگ background برای استایل Bubble Pop */
            .mmb-style-8 .mmb-menu-item {
                background: {$background} !important;
            }
            
            .mmb-style-8 .mmb-menu-item.mmb-active {
                background: {$active_color} !important;
                color: #fff !important;
            }
            
            /* رنگ hover */
            .mmb-menu-item:hover {
                color: {$active_color} !important;
            }
            
            /* رنگ badge */
            .mmb-badge {
                background: {$active_color} !important;
                color: #fff !important;
            }
            
            /* رنگ ripple effect */
            .mmb-ripple {
                background: {$active_color} !important;
                opacity: 0.3;
            }
        ";
    }
    
    // تبدیل hex به rgb
    private function hex2rgb($hex) {
        $hex = str_replace('#', '', $hex);
        
        if (strlen($hex) === 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        
        return "$r, $g, $b";
    }
    
    public function render_admin_page() {
        require_once MMB_PLUGIN_DIR . 'admin/admin-page.php';
    }
    
    public function render_mobile_menu() {
        // Debug: بررسی وجود تنظیمات
        if (!$this->settings) {
            echo '<!-- MMB Debug: No settings found -->';
            return;
        }
        
        if (!isset($this->settings['enabled'])) {
            echo '<!-- MMB Debug: Enabled setting not found -->';
            return;
        }
        
        if (!$this->settings['enabled']) {
            echo '<!-- MMB Debug: Menu is disabled -->';
            return;
        }
        
        $style = isset($this->settings['style']) ? $this->settings['style'] : 'style-1';
        $menu_items = isset($this->settings['menu_items']) ? $this->settings['menu_items'] : array();
        
        echo '<!-- MMB Debug: Menu items count: ' . count($menu_items) . ' -->';
        
        // فیلتر کردن آیتم‌های فعال
        $active_items = array_filter($menu_items, function($item) {
            return isset($item['enabled']) && $item['enabled'];
        });
        
        echo '<!-- MMB Debug: Active items count: ' . count($active_items) . ' -->';
        
        if (empty($active_items)) {
            echo '<!-- MMB Debug: No active items -->';
            return;
        }
        
        echo '<!-- MMB Debug: Rendering menu with style: ' . esc_attr($style) . ' -->';
        
        echo '<div class="mmb-mobile-menu-bar mmb-' . esc_attr($style) . '" style="display: block !important;">';
        echo '<div class="mmb-menu-container">';
        
        foreach ($active_items as $index => $item) {
            $icon = isset($item['icon']) ? $item['icon'] : 'fas fa-circle';
            $label = isset($item['label']) ? $item['label'] : '';
            $url = isset($item['url']) ? $item['url'] : '#';
            $badge = isset($item['badge']) ? $item['badge'] : '';
            
            echo '<a href="' . esc_url($url) . '" class="mmb-menu-item">';
            echo '<div class="mmb-icon-wrapper">';
            echo '<i class="' . esc_attr($icon) . '"></i>';
            if (!empty($badge)) {
                echo '<span class="mmb-badge">' . esc_html($badge) . '</span>';
            }
            echo '</div>';
            if (!empty($label)) {
                echo '<span class="mmb-label">' . esc_html($label) . '</span>';
            }
            echo '</a>';
        }
        
        echo '</div>';
        echo '</div>';
        
        echo '<!-- MMB Debug: Menu rendered successfully -->';
    }
    
    public function ajax_save_settings() {
        check_ajax_referer('mmb_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $settings = isset($_POST['settings']) ? $_POST['settings'] : array();
        
        // اعتبارسنجی و پاکسازی داده‌ها
        $cleaned_settings = $this->sanitize_settings($settings);
        
        update_option('mmb_settings', $cleaned_settings);
        
        wp_send_json_success('Settings saved successfully');
    }
    
    private function sanitize_settings($settings) {
        $cleaned = array();
        
        $cleaned['enabled'] = isset($settings['enabled']) ? (bool)$settings['enabled'] : false;
        $cleaned['style'] = isset($settings['style']) ? sanitize_text_field($settings['style']) : 'style-1';
        $cleaned['primary_color'] = isset($settings['primary_color']) ? sanitize_hex_color($settings['primary_color']) : '#667eea';
        $cleaned['secondary_color'] = isset($settings['secondary_color']) ? sanitize_hex_color($settings['secondary_color']) : '#764ba2';
        $cleaned['background_color'] = isset($settings['background_color']) ? sanitize_hex_color($settings['background_color']) : '#ffffff';
        $cleaned['icon_color'] = isset($settings['icon_color']) ? sanitize_hex_color($settings['icon_color']) : '#333333';
        $cleaned['active_color'] = isset($settings['active_color']) ? sanitize_hex_color($settings['active_color']) : '#667eea';
        
        $cleaned['menu_items'] = array();
        if (isset($settings['menu_items']) && is_array($settings['menu_items'])) {
            foreach ($settings['menu_items'] as $item) {
                $cleaned['menu_items'][] = array(
                    'icon' => isset($item['icon']) ? sanitize_text_field($item['icon']) : '',
                    'label' => isset($item['label']) ? sanitize_text_field($item['label']) : '',
                    'url' => isset($item['url']) ? esc_url_raw($item['url']) : '',
                    'enabled' => isset($item['enabled']) ? (bool)$item['enabled'] : false,
                    'badge' => isset($item['badge']) ? sanitize_text_field($item['badge']) : ''
                );
            }
        }
        
        return $cleaned;
    }
}

