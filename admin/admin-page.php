<?php
if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('mmb_settings', array());
$enabled = isset($settings['enabled']) ? $settings['enabled'] : true;
$style = isset($settings['style']) ? $settings['style'] : 'style-1';
$menu_items = isset($settings['menu_items']) ? $settings['menu_items'] : array();
?>

<div class="wrap mmb-admin-wrap">
    <h1><i class="fas fa-mobile-alt"></i> تنظیمات Mobile Menu Bar</h1>
    
    <div class="mmb-admin-container">
        <!-- تب‌ها -->
        <div class="mmb-tabs">
            <button class="mmb-tab-btn active" data-tab="general">تنظیمات عمومی</button>
            <button class="mmb-tab-btn" data-tab="items">آیتم‌های منو</button>
            <button class="mmb-tab-btn" data-tab="styles">استایل‌ها</button>
            <button class="mmb-tab-btn" data-tab="colors">رنگ‌ها</button>
            <button class="mmb-tab-btn" data-tab="preview">پیش‌نمایش</button>
        </div>
        
        <form id="mmb-settings-form" method="post">
            <?php wp_nonce_field('mmb_save_settings', 'mmb_nonce'); ?>
            
            <!-- تب تنظیمات عمومی -->
            <div class="mmb-tab-content active" data-tab="general">
                <h2>تنظیمات عمومی</h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">فعال‌سازی منو</th>
                        <td>
                            <label class="mmb-switch">
                                <input type="checkbox" name="mmb_settings[enabled]" value="1" <?php checked($enabled, true); ?>>
                                <span class="mmb-slider"></span>
                            </label>
                            <p class="description">منوی موبایل را فعال یا غیرفعال کنید</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- تب آیتم‌های منو -->
            <div class="mmb-tab-content" data-tab="items">
                <h2>آیتم‌های منو (3 تا 5 آیتم)</h2>
                <p class="description">حداقل 3 و حداکثر 5 آیتم می‌توانید اضافه کنید</p>
                
                <!-- لیست آیکون‌های پرکاربرد -->
                <div class="mmb-popular-icons">
                    <strong>آیکون‌های پرکاربرد:</strong>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-home" title="خانه"><i class="fas fa-home"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-search" title="جستجو"><i class="fas fa-search"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-shopping-cart" title="سبد خرید"><i class="fas fa-shopping-cart"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-user" title="کاربر"><i class="fas fa-user"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-heart" title="علاقه‌مندی"><i class="fas fa-heart"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-bell" title="اعلان"><i class="fas fa-bell"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-plus-circle" title="افزودن"><i class="fas fa-plus-circle"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-bars" title="منو"><i class="fas fa-bars"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-comment" title="پیام"><i class="fas fa-comment"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-cog" title="تنظیمات"><i class="fas fa-cog"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-camera" title="دوربین"><i class="fas fa-camera"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-map-marker-alt" title="مکان"><i class="fas fa-map-marker-alt"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-phone" title="تماس"><i class="fas fa-phone"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-envelope" title="ایمیل"><i class="fas fa-envelope"></i></button>
                    <button type="button" class="mmb-icon-btn" data-icon="fas fa-star" title="ستاره"><i class="fas fa-star"></i></button>
                    <a href="https://fontawesome.com/icons" target="_blank" class="mmb-more-icons">مشاهده همه آیکون‌ها <i class="fas fa-external-link-alt"></i></a>
                </div>
                
                <div id="mmb-menu-items">
                    <?php foreach ($menu_items as $index => $item): ?>
                        <div class="mmb-menu-item-card">
                            <div class="mmb-item-header">
                                <span class="mmb-item-number">آیتم <?php echo $index + 1; ?></span>
                                <label class="mmb-switch">
                                    <input type="checkbox" name="mmb_settings[menu_items][<?php echo $index; ?>][enabled]" value="1" <?php checked(isset($item['enabled']) ? $item['enabled'] : false, true); ?>>
                                    <span class="mmb-slider"></span>
                                </label>
                            </div>
                            
                            <div class="mmb-item-body">
                                <div class="mmb-form-group">
                                    <label>آیکون (Font Awesome)</label>
                                    <div class="mmb-icon-input-wrapper">
                                        <input type="text" name="mmb_settings[menu_items][<?php echo $index; ?>][icon]" value="<?php echo esc_attr(isset($item['icon']) ? $item['icon'] : ''); ?>" placeholder="fas fa-home" class="mmb-icon-input">
                                        <span class="mmb-icon-preview">
                                            <i class="<?php echo esc_attr(isset($item['icon']) && !empty($item['icon']) ? $item['icon'] : 'fas fa-circle'); ?>"></i>
                                        </span>
                                    </div>
                                    <p class="description">مثال: fas fa-home, fas fa-search, fas fa-user</p>
                                </div>
                                
                                <div class="mmb-form-group">
                                    <label>برچسب</label>
                                    <input type="text" name="mmb_settings[menu_items][<?php echo $index; ?>][label]" value="<?php echo esc_attr(isset($item['label']) ? $item['label'] : ''); ?>" placeholder="خانه">
                                </div>
                                
                                <div class="mmb-form-group">
                                    <label>لینک</label>
                                    <input type="text" name="mmb_settings[menu_items][<?php echo $index; ?>][url]" value="<?php echo esc_url(isset($item['url']) ? $item['url'] : ''); ?>" placeholder="https://example.com یا #">
                                    <p class="description">می‌توانید # برای لینک بدون عمل استفاده کنید</p>
                                </div>
                                
                                <div class="mmb-form-group">
                                    <label>Badge (اختیاری)</label>
                                    <input type="text" name="mmb_settings[menu_items][<?php echo $index; ?>][badge]" value="<?php echo esc_attr(isset($item['badge']) ? $item['badge'] : ''); ?>" placeholder="3">
                                    <p class="description">نمایش شماره اعلان کنار آیکون</p>
                                </div>
                            </div>
                            
                            <?php if ($index >= 3): ?>
                            <button type="button" class="mmb-remove-item"><i class="fas fa-trash"></i> حذف</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" id="mmb-add-item" class="button button-secondary"><i class="fas fa-plus"></i> افزودن آیتم جدید</button>
            </div>
            
            <!-- تب استایل‌ها -->
            <div class="mmb-tab-content" data-tab="styles">
                <h2>انتخاب استایل UI/UX</h2>
                <p class="description">یکی از 10 استایل زیر را انتخاب کنید</p>
                
                <div class="mmb-styles-grid">
                    <?php
                    $styles = array(
                        'style-1' => array('name' => 'Classic Bottom Bar', 'desc' => 'منوی کلاسیک با انیمیشن ساده'),
                        'style-2' => array('name' => 'iOS Glassmorphism', 'desc' => 'شیشه‌ای شبیه iOS با blur'),
                        'style-3' => array('name' => 'Floating Pill', 'desc' => 'شناور با فرم گرد'),
                        'style-4' => array('name' => 'Material Design', 'desc' => 'متریال دیزاین با سایه'),
                        'style-5' => array('name' => 'Gradient Wave', 'desc' => 'گرادیانت موجی'),
                        'style-6' => array('name' => 'Neumorphism', 'desc' => 'نیومورفیسم با سایه نرم'),
                        'style-7' => array('name' => 'Minimal Line', 'desc' => 'مینیمال با خط'),
                        'style-8' => array('name' => 'Bubble Pop', 'desc' => 'حباب‌های شناور'),
                        'style-9' => array('name' => 'Neon Glow', 'desc' => 'نئون با درخشش'),
                        'style-10' => array('name' => 'Card Slide', 'desc' => 'کارتی با اسلاید')
                    );
                    
                    foreach ($styles as $style_key => $style_info):
                    ?>
                        <label class="mmb-style-card <?php echo $style === $style_key ? 'selected' : ''; ?>">
                            <input type="radio" name="mmb_settings[style]" value="<?php echo esc_attr($style_key); ?>" <?php checked($style, $style_key); ?>>
                            <div class="mmb-style-preview mmb-preview-<?php echo esc_attr($style_key); ?>">
                                <div class="mmb-style-preview-menu">
                                    <div class="mmb-style-preview-item">
                                        <div class="mmb-style-preview-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <span class="mmb-style-preview-label">خانه</span>
                                    </div>
                                    <div class="mmb-style-preview-item">
                                        <div class="mmb-style-preview-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <span class="mmb-style-preview-label">جستجو</span>
                                    </div>
                                    <div class="mmb-style-preview-item">
                                        <div class="mmb-style-preview-icon">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <span class="mmb-style-preview-label">افزودن</span>
                                    </div>
                                    <div class="mmb-style-preview-item">
                                        <div class="mmb-style-preview-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span class="mmb-style-preview-label">پروفایل</span>
                                    </div>
                                </div>
                            </div>
                            <h3><?php echo esc_html($style_info['name']); ?></h3>
                            <p><?php echo esc_html($style_info['desc']); ?></p>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- تب رنگ‌ها -->
            <div class="mmb-tab-content" data-tab="colors">
                <h2>تنظیمات رنگ</h2>
                <p class="description">یک پلت رنگی آماده انتخاب کنید یا رنگ‌ها را دستی تنظیم کنید</p>
                
                <!-- پلت‌های رنگی آماده -->
                <div class="mmb-color-palettes-section">
                    <h3>پلت‌های رنگی آماده</h3>
                    <div class="mmb-color-palettes">
                        <?php
                        $color_palettes = array(
                            'default' => array(
                                'name' => 'پیش‌فرض (بنفش)',
                                'icon' => '🎨',
                                'style' => 'مدرن',
                                'primary' => '#667eea',
                                'secondary' => '#764ba2',
                                'background' => '#ffffff',
                                'icon' => '#333333',
                                'active' => '#667eea'
                            ),
                            'ocean' => array(
                                'name' => 'اقیانوس (آبی)',
                                'icon' => '🌊',
                                'style' => 'آرام و حرفه‌ای',
                                'primary' => '#2E86DE',
                                'secondary' => '#54A0FF',
                                'background' => '#F1F9FF',
                                'icon' => '#2C3E50',
                                'active' => '#0097E6'
                            ),
                            'sunset' => array(
                                'name' => 'غروب (نارنجی)',
                                'icon' => '🌅',
                                'style' => 'گرم و دوستانه',
                                'primary' => '#FF6348',
                                'secondary' => '#FF9F43',
                                'background' => '#FFF5F0',
                                'icon' => '#5F3E32',
                                'active' => '#EE5A24'
                            ),
                            'forest' => array(
                                'name' => 'جنگل (سبز)',
                                'icon' => '🌲',
                                'style' => 'طبیعی و تازه',
                                'primary' => '#26DE81',
                                'secondary' => '#20BF6B',
                                'background' => '#F0FFF4',
                                'icon' => '#2D3436',
                                'active' => '#05C46B'
                            ),
                            'luxury' => array(
                                'name' => 'لوکس (طلایی)',
                                'icon' => '👑',
                                'style' => 'لوکس و شیک',
                                'primary' => '#D4AF37',
                                'secondary' => '#C9A961',
                                'background' => '#2C2C2C',
                                'icon' => '#F5F5DC',
                                'active' => '#FFD700'
                            ),
                            'romantic' => array(
                                'name' => 'رمانتیک (صورتی)',
                                'icon' => '💕',
                                'style' => 'شاد و دلنشین',
                                'primary' => '#FD79A8',
                                'secondary' => '#FDCB6E',
                                'background' => '#FFF5F7',
                                'icon' => '#2D3436',
                                'active' => '#E84393'
                            ),
                            'corporate' => array(
                                'name' => 'سازمانی (خاکستری)',
                                'icon' => '💼',
                                'style' => 'رسمی و حرفه‌ای',
                                'primary' => '#34495E',
                                'secondary' => '#596275',
                                'background' => '#ECF0F1',
                                'icon' => '#2C3E50',
                                'active' => '#2C3E50'
                            ),
                            'vibrant' => array(
                                'name' => 'پرانرژی (رنگین‌کمان)',
                                'icon' => '🎉',
                                'style' => 'شاد و پرانرژی',
                                'primary' => '#FF6B6B',
                                'secondary' => '#4ECDC4',
                                'background' => '#FFFBF0',
                                'icon' => '#2C3E50',
                                'active' => '#FF6B6B'
                            ),
                            'minimal' => array(
                                'name' => 'مینیمال (سیاه و سفید)',
                                'icon' => '⚫',
                                'style' => 'ساده و مدرن',
                                'primary' => '#000000',
                                'secondary' => '#333333',
                                'background' => '#FFFFFF',
                                'icon' => '#000000',
                                'active' => '#000000'
                            ),
                            'dark' => array(
                                'name' => 'تاریک (دارک مود)',
                                'icon' => '🌙',
                                'style' => 'شیک و مدرن',
                                'primary' => '#BB86FC',
                                'secondary' => '#03DAC6',
                                'background' => '#1E1E1E',
                                'icon' => '#E0E0E0',
                                'active' => '#BB86FC'
                            )
                        );
                        
                        foreach ($color_palettes as $palette_id => $palette) {
                            ?>
                            <div class="mmb-palette-card" data-palette="<?php echo esc_attr($palette_id); ?>" data-primary="<?php echo esc_attr($palette['primary']); ?>" data-secondary="<?php echo esc_attr($palette['secondary']); ?>" data-background="<?php echo esc_attr($palette['background']); ?>" data-icon="<?php echo esc_attr($palette['icon']); ?>" data-active="<?php echo esc_attr($palette['active']); ?>">
                                <div class="mmb-palette-colors">
                                    <span class="mmb-palette-color" style="background-color: <?php echo esc_attr($palette['primary']); ?>"></span>
                                    <span class="mmb-palette-color" style="background-color: <?php echo esc_attr($palette['secondary']); ?>"></span>
                                    <span class="mmb-palette-color" style="background-color: <?php echo esc_attr($palette['background']); ?>"></span>
                                    <span class="mmb-palette-color" style="background-color: <?php echo esc_attr($palette['icon']); ?>"></span>
                                    <span class="mmb-palette-color" style="background-color: <?php echo esc_attr($palette['active']); ?>"></span>
                                </div>
                                <div class="mmb-palette-info">
                                    <div class="mmb-palette-icon"><?php echo $palette['icon']; ?></div>
                                    <div class="mmb-palette-text">
                                        <h4><?php echo esc_html($palette['name']); ?></h4>
                                        <p><?php echo esc_html($palette['style']); ?></p>
                                    </div>
                                </div>
                                <div class="mmb-palette-checkmark">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <!-- تنظیمات دستی رنگ -->
                <div class="mmb-manual-colors-section">
                    <h3>تنظیمات دستی رنگ</h3>
                    <p class="description">رنگ‌ها را به صورت دستی تنظیم کنید</p>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="primary_color">رنگ اصلی</label>
                                <p class="description">رنگ اصلی منو (برای گرادیانت‌ها)</p>
                            </th>
                            <td>
                                <input type="text" id="primary_color" name="mmb_settings[primary_color]" value="<?php echo esc_attr(isset($settings['primary_color']) ? $settings['primary_color'] : '#667eea'); ?>" class="mmb-color-picker">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="secondary_color">رنگ ثانویه</label>
                                <p class="description">رنگ ثانویه (برای گرادیانت‌ها)</p>
                            </th>
                            <td>
                                <input type="text" id="secondary_color" name="mmb_settings[secondary_color]" value="<?php echo esc_attr(isset($settings['secondary_color']) ? $settings['secondary_color'] : '#764ba2'); ?>" class="mmb-color-picker">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="background_color">رنگ پس‌زمینه</label>
                                <p class="description">رنگ پس‌زمینه منو</p>
                            </th>
                            <td>
                                <input type="text" id="background_color" name="mmb_settings[background_color]" value="<?php echo esc_attr(isset($settings['background_color']) ? $settings['background_color'] : '#ffffff'); ?>" class="mmb-color-picker">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="icon_color">رنگ آیکون</label>
                                <p class="description">رنگ آیکون‌های غیرفعال</p>
                            </th>
                            <td>
                                <input type="text" id="icon_color" name="mmb_settings[icon_color]" value="<?php echo esc_attr(isset($settings['icon_color']) ? $settings['icon_color'] : '#333333'); ?>" class="mmb-color-picker">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="active_color">رنگ فعال</label>
                                <p class="description">رنگ آیکون و نشانگر فعال</p>
                            </th>
                            <td>
                                <input type="text" id="active_color" name="mmb_settings[active_color]" value="<?php echo esc_attr(isset($settings['active_color']) ? $settings['active_color'] : '#667eea'); ?>" class="mmb-color-picker">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- تب پیش‌نمایش -->
            <div class="mmb-tab-content" data-tab="preview">
                <h2>پیش‌نمایش</h2>
                <p class="description">پیش‌نمایش منوی موبایل در حالت موبایل</p>
                
                <div class="mmb-preview-container">
                    <div class="mmb-phone-mockup">
                        <div class="mmb-phone-screen">
                            <div id="mmb-live-preview">
                                <p style="text-align: center; padding: 20px; color: #999;">
                                    برای مشاهده پیش‌نمایش، ابتدا تنظیمات را ذخیره کنید.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mmb-submit-section">
                <button type="submit" class="button button-primary button-large">
                    <i class="fas fa-save"></i> ذخیره تنظیمات
                </button>
                <span class="mmb-save-status"></span>
            </div>
        </form>
    </div>
</div>

