<?php
/**
 * Plugin Name: Mobile Menu Bar
 * Plugin URI: https://ariacoder.ir
 * Description: Add a fixed bottom navigation bar for mobile visitors with ten distinct UI styles—classic bar, iOS-style glassmorphism, floating pill, Material Design, gradient wave, neumorphism, minimal line, bubble pop, neon glow, and card slide. Configure three to five items with Font Awesome icons, custom URLs, optional notification badges, and per-item visibility. Tune primary, secondary, background, icon, and active colors from a dedicated admin screen; the bar appears on viewports under 768px for an app-like experience. Includes RTL support, smooth animations, dark-theme-friendly output, accessibility-minded markup, and WordPress-standard sanitization, nonces, and coding practices.
 * Version: 3.5.1
 * Author: Alireza Aminzadeh
 * Author URI: https://ariacoder.ir
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mobile-menu-bar
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

// اگر مستقیماً فراخوانی شود، خارج شو
if (!defined('ABSPATH')) {
    exit;
}

// تعریف ثابت‌ها
define('MMB_VERSION', '3.5.1');
define('MMB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MMB_PLUGIN_URL', plugin_dir_url(__FILE__));

// بارگذاری کلاس اصلی
require_once MMB_PLUGIN_DIR . 'includes/class-mobile-menu-bar.php';

// شروع پلاگین
function mmb_run_plugin() {
    $plugin = new Mobile_Menu_Bar();
    $plugin->run();
}
add_action('plugins_loaded', 'mmb_run_plugin');

// فعال‌سازی پلاگین
register_activation_hook(__FILE__, 'mmb_activate_plugin');
function mmb_activate_plugin() {
    // تنظیمات پیش‌فرض
    $default_settings = array(
        'enabled' => true,
        'style' => 'style-1',
        'primary_color' => '#667eea',
        'secondary_color' => '#764ba2',
        'background_color' => '#ffffff',
        'icon_color' => '#333333',
        'active_color' => '#667eea',
        'menu_items' => array(
            array(
                'icon' => 'fas fa-home',
                'label' => 'خانه',
                'url' => home_url('/'),
                'enabled' => true
            ),
            array(
                'icon' => 'fas fa-search',
                'label' => 'جستجو',
                'url' => '#',
                'enabled' => true
            ),
            array(
                'icon' => 'fas fa-plus-circle',
                'label' => 'افزودن',
                'url' => '#',
                'enabled' => true
            ),
            array(
                'icon' => 'fas fa-bell',
                'label' => 'اعلان',
                'url' => '#',
                'enabled' => true,
                'badge' => '3'
            ),
            array(
                'icon' => 'fas fa-user',
                'label' => 'پروفایل',
                'url' => '#',
                'enabled' => true
            )
        )
    );
    
    if (!get_option('mmb_settings')) {
        add_option('mmb_settings', $default_settings);
    }
}

// غیرفعال‌سازی پلاگین
register_deactivation_hook(__FILE__, 'mmb_deactivate_plugin');
function mmb_deactivate_plugin() {
    // پاکسازی اگر نیاز باشد
}

