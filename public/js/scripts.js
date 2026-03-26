(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        var menuBar = $('.mmb-mobile-menu-bar');
        
        // Debug: نمایش رنگ‌های انتخاب شده
        if (typeof mmbColors !== 'undefined') {
            console.log('%c🎨 Mobile Menu Bar - تنظیمات رنگ:', 'background: #667eea; color: white; padding: 5px 10px; border-radius: 5px;');
            console.log('Primary Color:', mmbColors.primary);
            console.log('Secondary Color:', mmbColors.secondary);
            console.log('Background Color:', mmbColors.background);
            console.log('Icon Color:', mmbColors.icon);
            console.log('Active Color:', mmbColors.active);
        }
        
        // اطمینان از نمایش منو در ابتدا
        if (menuBar.length) {
            menuBar.css({
                'transform': 'translateY(0)',
                'visibility': 'visible',
                'opacity': '1'
            }).addClass('mmb-loaded');
        }
        
        // شناسایی صفحه فعلی و هایلایت کردن آیتم مربوطه
        var currentUrl = window.location.href;
        
        $('.mmb-menu-item').each(function() {
            var itemUrl = $(this).attr('href');
            
            if (currentUrl.indexOf(itemUrl) !== -1 && itemUrl !== '#' && itemUrl !== '') {
                $(this).addClass('mmb-active');
            }
        });
        
        // انیمیشن کلیک
        $('.mmb-menu-item').on('click', function(e) {
            // حذف کلاس active از همه آیتم‌ها
            $('.mmb-menu-item').removeClass('mmb-active');
            
            // اضافه کردن کلاس active به آیتم کلیک شده
            $(this).addClass('mmb-active');
            
            // انیمیشن ripple
            var $this = $(this);
            var $ripple = $('<span class="mmb-ripple"></span>');
            var x = e.pageX - $this.offset().left;
            var y = e.pageY - $this.offset().top;
            
            $ripple.css({
                left: x,
                top: y,
                width: 10,
                height: 10
            });
            
            $this.append($ripple);
            
            setTimeout(function() {
                $ripple.remove();
            }, 600);
        });
        
        // مخفی کردن منو هنگام اسکرول به پایین (اختیاری)
        var lastScrollTop = 0;
        var scrollTimeout;
        var isScrolling = false;
        
        // اطمینان از نمایش اولیه منو
        menuBar.css('bottom', '');
        
        $(window).on('scroll', function() {
            clearTimeout(scrollTimeout);
            isScrolling = true;
            
            scrollTimeout = setTimeout(function() {
                var scrollTop = $(window).scrollTop();
                
                // برای استایل‌های خاص که از bottom استفاده می‌کنند
                var isFloatingStyle = menuBar.hasClass('mmb-style-3') || menuBar.hasClass('mmb-style-8');
                
                // فقط اگر کاربر به مقدار قابل توجهی اسکرول کرده باشد
                if (scrollTop > lastScrollTop && scrollTop > 200) {
                    // اسکرول به پایین - مخفی کردن منو
                    if (isFloatingStyle) {
                        menuBar.css('bottom', '-200px');
                    } else {
                        menuBar.css('transform', 'translateY(100%)');
                    }
                } else if (scrollTop < lastScrollTop - 50) {
                    // اسکرول به بالا - نمایش منو
                    if (isFloatingStyle) {
                        menuBar.css('bottom', '20px');
                    } else {
                        menuBar.css('transform', 'translateY(0)');
                    }
                } else if (scrollTop <= 100) {
                    // در بالای صفحه - همیشه نمایش
                    if (isFloatingStyle) {
                        menuBar.css('bottom', '20px');
                    } else {
                        menuBar.css('transform', 'translateY(0)');
                    }
                }
                
                lastScrollTop = scrollTop;
                isScrolling = false;
            }, 150);
        });
        
        // جلوگیری از اسکرول پس‌زمینه هنگام تاچ روی منو
        if ($('.mmb-mobile-menu-bar').length) {
            $('.mmb-mobile-menu-bar')[0].addEventListener('touchmove', function(e) {
                e.stopPropagation();
            }, { passive: true });
        }
        
        // مدیریت رویدادهای لمسی برای احساس بهتر
        var touchStartY = 0;
        
        $('.mmb-menu-item').on('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
            $(this).addClass('touching');
        });
        
        $('.mmb-menu-item').on('touchend', function() {
            $(this).removeClass('touching');
        });
        
        $('.mmb-menu-item').on('touchmove', function(e) {
            var touchY = e.touches[0].clientY;
            if (Math.abs(touchY - touchStartY) > 10) {
                $(this).removeClass('touching');
            }
        });
        
        // تنظیم ارتفاع body برای جلوگیری از پوشانده شدن محتوا
        function adjustBodyPadding() {
            var menuHeight = $('.mmb-mobile-menu-bar').outerHeight();
            if (menuHeight && $(window).width() <= 768) {
                $('body').css('padding-bottom', menuHeight + 'px');
            } else {
                $('body').css('padding-bottom', '0');
            }
        }
        
        // اجرا با تاخیر کوتاه برای اطمینان از بارگذاری کامل
        setTimeout(function() {
            adjustBodyPadding();
            
            // اطمینان از نمایش منو
            var isFloatingStyle = menuBar.hasClass('mmb-style-3') || menuBar.hasClass('mmb-style-8');
            
            if (isFloatingStyle) {
                menuBar.css({
                    'bottom': '20px',
                    'visibility': 'visible',
                    'opacity': '1'
                });
            } else {
                menuBar.css({
                    'transform': 'translateY(0)',
                    'visibility': 'visible',
                    'opacity': '1'
                });
            }
        }, 100);
        
        $(window).on('resize', function() {
            adjustBodyPadding();
        });
        
        // پشتیبانی از Accessibility
        $('.mmb-menu-item').attr('role', 'button');
        $('.mmb-menu-item').attr('tabindex', '0');
        
        // پشتیبانی از کیبورد برای Accessibility
        $('.mmb-menu-item').on('keypress', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                e.preventDefault();
                $(this).click();
            }
        });
        
        // Vibration API برای بازخورد لمسی (اگر پشتیبانی شود)
        $('.mmb-menu-item').on('click', function() {
            if ('vibrate' in navigator) {
                navigator.vibrate(10); // ویبره خیلی کوتاه
            }
        });
        
        // تشخیص حالت آنلاین/آفلاین
        window.addEventListener('online', function() {
            $('.mmb-mobile-menu-bar').removeClass('mmb-offline');
        });
        
        window.addEventListener('offline', function() {
            $('.mmb-mobile-menu-bar').addClass('mmb-offline');
        });
        
        // Performance optimization - استفاده از Intersection Observer
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        menuBar.addClass('mmb-visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            
            if (menuBar.length) {
                observer.observe(menuBar[0]);
            }
        }
    });
    
})(jQuery);

