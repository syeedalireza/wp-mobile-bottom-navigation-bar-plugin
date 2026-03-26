jQuery(document).ready(function($) {
    
    // تب‌ها
    $('.mmb-tab-btn').on('click', function() {
        var tab = $(this).data('tab');
        
        $('.mmb-tab-btn').removeClass('active');
        $(this).addClass('active');
        
        $('.mmb-tab-content').removeClass('active');
        $('.mmb-tab-content[data-tab="' + tab + '"]').addClass('active');
    });
    
    // انتخاب استایل
    $('.mmb-style-card').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Style card clicked'); // Debug
        
        // حذف selected از همه
        $('.mmb-style-card').removeClass('selected');
        
        // اضافه کردن selected به کارت کلیک شده
        $(this).addClass('selected');
        
        // چک کردن radio button
        var $radio = $(this).find('input[type="radio"]');
        $radio.prop('checked', true);
        
        console.log('Style selected:', $radio.val()); // Debug
        
        // انیمیشن کوتاه
        $(this).css('transform', 'scale(0.95)');
        setTimeout(() => {
            $(this).css('transform', '');
        }, 150);
    });
    
    // بررسی استایل انتخاب شده در بارگذاری
    $('.mmb-style-card input[type="radio"]:checked').closest('.mmb-style-card').addClass('selected');
    
    // Color Picker
    $('.mmb-color-picker').wpColorPicker();
    
    // ============================================
    // پلت‌های رنگی آماده
    // ============================================
    
    $('.mmb-palette-card').on('click', function() {
        var $card = $(this);
        
        // حذف selected از همه کارت‌ها
        $('.mmb-palette-card').removeClass('selected');
        
        // اضافه کردن selected به کارت کلیک شده
        $card.addClass('selected selecting');
        
        // گرفتن رنگ‌ها از data attributes
        var primary = $card.data('primary');
        var secondary = $card.data('secondary');
        var background = $card.data('background');
        var icon = $card.data('icon');
        var active = $card.data('active');
        
        console.log('Palette selected:', {
            primary: primary,
            secondary: secondary,
            background: background,
            icon: icon,
            active: active
        });
        
        // تنظیم رنگ‌ها در input fields
        $('#primary_color').val(primary).trigger('change');
        $('#secondary_color').val(secondary).trigger('change');
        $('#background_color').val(background).trigger('change');
        $('#icon_color').val(icon).trigger('change');
        $('#active_color').val(active).trigger('change');
        
        // بروزرسانی WordPress Color Picker
        $('#primary_color').wpColorPicker('color', primary);
        $('#secondary_color').wpColorPicker('color', secondary);
        $('#background_color').wpColorPicker('color', background);
        $('#icon_color').wpColorPicker('color', icon);
        $('#active_color').wpColorPicker('color', active);
        
        // حذف انیمیشن
        setTimeout(function() {
            $card.removeClass('selecting');
        }, 500);
        
        // نمایش پیام
        showNotification('✨ پلت رنگی اعمال شد!', 'success');
    });
    
    // بررسی رنگ‌های فعلی و نمایش پلت مطابق (اختیاری)
    function checkCurrentPalette() {
        var currentPrimary = $('#primary_color').val();
        var currentSecondary = $('#secondary_color').val();
        var currentBackground = $('#background_color').val();
        var currentIcon = $('#icon_color').val();
        var currentActive = $('#active_color').val();
        
        $('.mmb-palette-card').each(function() {
            var $card = $(this);
            if ($card.data('primary').toLowerCase() === currentPrimary.toLowerCase() &&
                $card.data('secondary').toLowerCase() === currentSecondary.toLowerCase() &&
                $card.data('background').toLowerCase() === currentBackground.toLowerCase() &&
                $card.data('icon').toLowerCase() === currentIcon.toLowerCase() &&
                $card.data('active').toLowerCase() === currentActive.toLowerCase()) {
                $card.addClass('selected');
            }
        });
    }
    
    // بررسی در بارگذاری صفحه
    setTimeout(checkCurrentPalette, 500);
    
    // تابع نمایش نوتیفیکیشن
    function showNotification(message, type) {
        var $notification = $('<div class="mmb-notification mmb-notification-' + type + '">' + message + '</div>');
        $('body').append($notification);
        
        setTimeout(function() {
            $notification.addClass('show');
        }, 10);
        
        setTimeout(function() {
            $notification.removeClass('show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 2000);
    }
    
    // اگر کاربر دستی رنگ‌ها را تغییر داد، selected را از پلت‌ها حذف کن
    $('.mmb-color-picker').on('change', function() {
        // با تاخیر کوتاه برای اینکه اول رنگ تنظیم شود
        setTimeout(function() {
            var currentPrimary = $('#primary_color').val();
            var currentSecondary = $('#secondary_color').val();
            var currentBackground = $('#background_color').val();
            var currentIcon = $('#icon_color').val();
            var currentActive = $('#active_color').val();
            
            var matchFound = false;
            
            $('.mmb-palette-card').each(function() {
                var $card = $(this);
                if ($card.data('primary').toLowerCase() === currentPrimary.toLowerCase() &&
                    $card.data('secondary').toLowerCase() === currentSecondary.toLowerCase() &&
                    $card.data('background').toLowerCase() === currentBackground.toLowerCase() &&
                    $card.data('icon').toLowerCase() === currentIcon.toLowerCase() &&
                    $card.data('active').toLowerCase() === currentActive.toLowerCase()) {
                    matchFound = true;
                    $card.addClass('selected');
                } else {
                    $card.removeClass('selected');
                }
            });
        }, 100);
    });
    
    // پیش‌نمایش آیکون
    $(document).on('input', '.mmb-icon-input', function() {
        var icon = $(this).val().trim();
        var $preview = $(this).closest('.mmb-icon-input-wrapper').find('.mmb-icon-preview i');
        
        if (icon) {
            $preview.attr('class', icon);
        } else {
            $preview.attr('class', 'fas fa-circle');
        }
    });
    
    // پیش‌نمایش اولیه آیکون‌ها هنگام بارگذاری صفحه
    $('.mmb-icon-input').each(function() {
        var icon = $(this).val().trim();
        var $preview = $(this).closest('.mmb-icon-input-wrapper').find('.mmb-icon-preview i');
        
        if (icon) {
            $preview.attr('class', icon);
        }
    });
    
    // انتخاب آیکون از لیست پرکاربرد
    var $activeIconInput = null;
    
    $(document).on('focus', '.mmb-icon-input', function() {
        $activeIconInput = $(this);
        $('.mmb-icon-btn').removeClass('active');
    });
    
    $('.mmb-icon-btn').on('click', function(e) {
        e.preventDefault();
        var iconClass = $(this).data('icon');
        
        if ($activeIconInput && $activeIconInput.length) {
            $activeIconInput.val(iconClass).trigger('input').focus();
            $('.mmb-icon-btn').removeClass('active');
            $(this).addClass('active');
            
            // به روزرسانی فوری پیش‌نمایش
            var $preview = $activeIconInput.closest('.mmb-icon-input-wrapper').find('.mmb-icon-preview i');
            $preview.attr('class', iconClass);
        } else {
            // اگر هیچ input فعالی نیست، از اولین input استفاده کن
            var $firstInput = $('.mmb-icon-input').first();
            if ($firstInput.length) {
                $firstInput.val(iconClass).trigger('input').focus();
                $activeIconInput = $firstInput;
                
                var $preview = $firstInput.closest('.mmb-icon-input-wrapper').find('.mmb-icon-preview i');
                $preview.attr('class', iconClass);
            }
        }
    });
    
    // افزودن آیتم جدید
    var itemCount = $('#mmb-menu-items .mmb-menu-item-card').length;
    
    $('#mmb-add-item').on('click', function() {
        if (itemCount >= 5) {
            alert('حداکثر 5 آیتم می‌توانید اضافه کنید');
            return;
        }
        
        var newItem = `
            <div class="mmb-menu-item-card">
                <div class="mmb-item-header">
                    <span class="mmb-item-number">آیتم ${itemCount + 1}</span>
                    <label class="mmb-switch">
                        <input type="checkbox" name="mmb_settings[menu_items][${itemCount}][enabled]" value="1" checked>
                        <span class="mmb-slider"></span>
                    </label>
                </div>
                
                <div class="mmb-item-body">
                    <div class="mmb-form-group">
                        <label>آیکون (Font Awesome)</label>
                        <div class="mmb-icon-input-wrapper">
                            <input type="text" name="mmb_settings[menu_items][${itemCount}][icon]" value="" placeholder="fas fa-home" class="mmb-icon-input">
                            <span class="mmb-icon-preview">
                                <i class="fas fa-circle"></i>
                            </span>
                        </div>
                        <p class="description">مثال: fas fa-home, fas fa-search, fas fa-user</p>
                    </div>
                    
                    <div class="mmb-form-group">
                        <label>برچسب</label>
                        <input type="text" name="mmb_settings[menu_items][${itemCount}][label]" value="" placeholder="خانه">
                    </div>
                    
                    <div class="mmb-form-group">
                        <label>لینک</label>
                        <input type="text" name="mmb_settings[menu_items][${itemCount}][url]" value="" placeholder="https://example.com یا #">
                        <p class="description">می‌توانید # برای لینک بدون عمل استفاده کنید</p>
                    </div>
                    
                    <div class="mmb-form-group">
                        <label>Badge (اختیاری)</label>
                        <input type="text" name="mmb_settings[menu_items][${itemCount}][badge]" value="" placeholder="3">
                    </div>
                </div>
                
                <button type="button" class="mmb-remove-item"><i class="fas fa-trash"></i> حذف</button>
            </div>
        `;
        
        $('#mmb-menu-items').append(newItem);
        itemCount++;
        updateItemNumbers();
    });
    
    // حذف آیتم
    $(document).on('click', '.mmb-remove-item', function() {
        if (itemCount <= 3) {
            alert('حداقل 3 آیتم باید داشته باشید');
            return;
        }
        
        $(this).closest('.mmb-menu-item-card').remove();
        itemCount--;
        updateItemNumbers();
    });
    
    function updateItemNumbers() {
        $('#mmb-menu-items .mmb-menu-item-card').each(function(index) {
            $(this).find('.mmb-item-number').text('آیتم ' + (index + 1));
        });
    }
    
    // ذخیره تنظیمات با AJAX
    $('#mmb-settings-form').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submitted'); // Debug
        
        // اعتبارسنجی: بررسی اینکه حداقل فیلدهای ضروری پر شده باشند
        var hasEmptyRequired = false;
        $('#mmb-menu-items .mmb-menu-item-card').each(function() {
            var $card = $(this);
            var icon = $card.find('input[name$="[icon]"]').val();
            var label = $card.find('input[name$="[label]"]').val();
            var url = $card.find('input[name$="[url]"]').val();
            
            // اگر لینک خالی است، # بگذار
            if (!url || url.trim() === '') {
                $card.find('input[name$="[url]"]').val('#');
            }
        });
        
        var formData = new FormData(this);
        
        // گرفتن استایل انتخاب شده
        var selectedStyle = $('input[name="mmb_settings[style]"]:checked').val();
        if (!selectedStyle) {
            selectedStyle = $('.mmb-style-card.selected input[type="radio"]').val();
        }
        if (!selectedStyle) {
            selectedStyle = 'style-1'; // پیش‌فرض
        }
        
        console.log('Selected style:', selectedStyle); // Debug
        
        var settings = {
            enabled: formData.get('mmb_settings[enabled]') === '1',
            style: selectedStyle,
            primary_color: formData.get('mmb_settings[primary_color]'),
            secondary_color: formData.get('mmb_settings[secondary_color]'),
            background_color: formData.get('mmb_settings[background_color]'),
            icon_color: formData.get('mmb_settings[icon_color]'),
            active_color: formData.get('mmb_settings[active_color]'),
            menu_items: []
        };
        
        console.log('Settings object:', settings); // Debug
        
        // جمع‌آوری آیتم‌های منو
        $('#mmb-menu-items .mmb-menu-item-card').each(function(index) {
            var item = {
                icon: $(this).find('input[name$="[icon]"]').val(),
                label: $(this).find('input[name$="[label]"]').val(),
                url: $(this).find('input[name$="[url]"]').val(),
                badge: $(this).find('input[name$="[badge]"]').val(),
                enabled: $(this).find('input[name$="[enabled]"]').is(':checked')
            };
            settings.menu_items.push(item);
        });
        
        console.log('Menu items count:', settings.menu_items.length); // Debug
        
        $('.mmb-save-status').removeClass('success error').text('در حال ذخیره...');
        
        $.ajax({
            url: mmbAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'mmb_save_settings',
                nonce: mmbAdmin.nonce,
                settings: settings
            },
            success: function(response) {
                console.log('AJAX Response:', response); // Debug
                
                if (response.success) {
                    $('.mmb-save-status').addClass('success').html('<i class="fas fa-check-circle"></i> تنظیمات با موفقیت ذخیره شد');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    $('.mmb-save-status').addClass('error').html('<i class="fas fa-times-circle"></i> خطا در ذخیره تنظیمات');
                    console.error('Error:', response); // Debug
                }
            },
            error: function(xhr, status, error) {
                $('.mmb-save-status').addClass('error').html('<i class="fas fa-times-circle"></i> خطا در ارتباط با سرور');
                console.error('AJAX Error:', status, error, xhr); // Debug
            }
        });
    });
});

