# Mobile Menu Bar

**A WordPress plugin that adds a polished, app-style bottom navigation bar for mobile visitors**—without writing code. Pick a look, tune your colors, wire up links and icons, and your site gets thumb-friendly navigation that feels native on phones and small tablets.

---

## English overview

### Why use it?

Most WordPress themes are built for desktop first. On phones, important actions (home, cart, account, search) often sit far from the thumb zone or hide inside hamburger menus. **Mobile Menu Bar** fixes that with a **fixed bottom bar** that only appears on **viewports up to 768px wide**, so desktop layouts stay unchanged while mobile users get **fast, familiar navigation** similar to iOS/Android apps.

### What you can do

| Area | Capability |
|------|------------|
| **Items** | **3–5** navigation items; each has **Font Awesome 6** icon class, **label**, **URL**, optional **badge** (e.g. notification count), and **per-item on/off** so you can hide slots without deleting them. |
| **Visual design** | **10 distinct UI styles**: Classic Bottom Bar, iOS Glassmorphism, Floating Pill, Material Design, Gradient Wave, Neumorphism, Minimal Line, Bubble Pop, Neon Glow, and Card Slide—each with its own layout, shadows, and motion feel. |
| **Colors** | **Primary**, **secondary**, **background**, **icon**, and **active** colors via the admin color picker; the plugin injects **CSS custom properties** so themes stay consistent with your palette. **Ready-made color palettes** in the admin speed up branding. |
| **Admin experience** | Tabbed settings: **General**, **Menu items**, **Styles**, **Colors**, and **Live-style preview**; settings save through **AJAX** with **nonces** and capability checks (`manage_options`). |
| **Front-end behavior** | **Current-route highlighting** when the item URL matches the page; **ripple** on tap; **auto `padding-bottom` on `body`** so content is not hidden behind the bar; **scroll-aware hide/show** for floating styles (e.g. pill & bubble); **touch** handling; optional **haptic feedback** via the Vibration API where supported; **online/offline** CSS class on the bar. |
| **i18n & RTL** | **RTL-aware** styling (e.g. badge placement) for right-to-left sites. Labels are yours—use any language. Default samples ship in Persian; admin UI is Persian-oriented. |
| **Typography** | **Vazirmatn (Vazir)** loads from **jsDelivr** for clean Persian/Arabic text in labels; you can point to another font in `public/css/vazir-font.css` if you prefer. |
| **Quality & security** | **Sanitized** settings (`sanitize_hex_color`, `esc_url_raw`, `sanitize_text_field`, etc.), **AJAX nonce** verification, and **WordPress-friendly** enqueueing. Markup supports **keyboard** use (Enter/Space) and basic **accessibility** attributes on items. |

### Typical use cases

- **WooCommerce / shops**: quick access to home, categories, cart, and account.  
- **Blogs & magazines**: home, search, saved posts, profile.  
- **Portfolios & business sites**: contact, services, gallery, about.  
- **Any site** that wants **one primary mobile CTA row** without theme edits or child-theme CSS marathons.

### Requirements

- **WordPress** 5.0+  
- **PHP** 7.0+  
- **Font Awesome** is loaded from CDN for icons (ensure your caching/CDN policy allows it).

### Quick install

1. Zip the `mobile-menu-bar` folder or clone this repo into `wp-content/plugins/`.  
2. Activate **Mobile Menu Bar** under **Plugins**.  
3. Open **Mobile Menu** in the admin menu and configure tabs; **save** after changes.

### License

**GPL v2 or later** — same as WordPress.

### Author

**Alireza Aminzadeh** — [ariacoder.ir](https://ariacoder.ir)

---

## فارسی — راهنمای نصب و استفاده

پلاگین وردپرس Mobile Menu Bar یک منوی موبایل مدرن و جذاب با 10 استایل مختلف UI/UX است.

## 🚀 نصب

### روش 1: نصب از طریق پیشخوان وردپرس

1. فایل پلاگین را zip کنید
2. به `پیشخوان > افزونه‌ها > افزودن` بروید
3. روی `بارگذاری افزونه` کلیک کنید
4. فایل zip را انتخاب و بارگذاری کنید
5. پلاگین را فعال کنید

### روش 2: نصب دستی

1. کل پوشه `mobile-menu-bar` را در مسیر `/wp-content/plugins/` کپی کنید
2. به `پیشخوان > افزونه‌ها` بروید
3. پلاگین را فعال کنید

## ⚙️ تنظیمات

بعد از فعال‌سازی:

1. به منوی `Mobile Menu` در پیشخوان بروید
2. تنظیمات را انجام دهید:

### تب تنظیمات عمومی
- منو را فعال/غیرفعال کنید

### تب آیتم‌های منو
- حداقل 3 و حداکثر 5 آیتم اضافه کنید
- برای هر آیتم:
  - **آیکون**: از Font Awesome استفاده کنید (مثال: `fas fa-home`)
  - **برچسب**: نام آیتم را وارد کنید
  - **لینک**: URL مقصد را وارد کنید
  - **Badge**: (اختیاری) عدد نوتیفیکیشن

### تب استایل‌ها
یکی از 10 استایل زیر را انتخاب کنید:

1. **Classic Bottom Bar** - منوی کلاسیک
2. **iOS Glassmorphism** - شیشه‌ای شبیه iOS
3. **Floating Pill** - شناور با فرم گرد
4. **Material Design** - متریال دیزاین
5. **Gradient Wave** - گرادیانت موجی
6. **Neumorphism** - نیومورفیسم
7. **Minimal Line** - مینیمال با خط
8. **Bubble Pop** - حباب‌های شناور
9. **Neon Glow** - نئون با درخشش
10. **Card Slide** - کارتی با اسلاید

### تب رنگ‌ها
رنگ‌های زیر را تنظیم کنید:
- رنگ اصلی
- رنگ ثانویه
- رنگ پس‌زمینه
- رنگ آیکون
- رنگ فعال

### تب پیش‌نمایش
پیش‌نمایش منو را مشاهده کنید

## 🎨 آیکون‌های پیشنهادی Font Awesome

```
fas fa-home          - خانه
fas fa-search        - جستجو
fas fa-shopping-cart - سبد خرید
fas fa-user          - پروفایل
fas fa-heart         - علاقه‌مندی
fas fa-bell          - اعلان‌ها
fas fa-plus-circle   - افزودن
fas fa-camera        - دوربین
fas fa-comment       - پیام
fas fa-gear          - تنظیمات
```

مشاهده کامل آیکون‌ها: https://fontawesome.com/icons

## 📱 نکات مهم

- منو **فقط در موبایل** (زیر 768 پیکسل) نمایش داده می‌شود
- برای تست، از Developer Tools مرورگر استفاده کنید
- بعد از هر تغییر، حتماً تنظیمات را ذخیره کنید

## 🔧 ساختار فایل‌ها

```
mobile-menu-bar/
├── mobile-menu-bar.php       # فایل اصلی پلاگین
├── readme.txt                # توضیحات برای مخزن وردپرس
├── includes/
│   └── class-mobile-menu-bar.php  # کلاس اصلی
├── admin/
│   ├── admin-page.php        # صفحه تنظیمات
│   ├── admin-style.css       # استایل پنل
│   └── admin-script.js       # اسکریپت پنل
└── public/
    ├── css/
    │   └── styles.css        # استایل‌های عمومی (10 مدل)
    └── js/
        └── scripts.js        # اسکریپت عمومی
```

## 🎯 ویژگی‌ها

✅ 10 استایل مختلف UI/UX  
✅ 3-5 آیتم قابل تنظیم  
✅ آیکون‌های Font Awesome  
✅ سفارشی‌سازی کامل رنگ  
✅ نمایش Badge  
✅ انیمیشن‌های جذاب  
✅ پشتیبانی از RTL  
✅ ریسپانسیو  
✅ استاندارد وردپرس  
✅ کد تمیز و بهینه  

## 🐛 عیب‌یابی

### منو نمایش داده نمی‌شود
- بررسی کنید که پلاگین فعال باشه
- از Developer Tools مطمئن شوید که در حالت موبایل هستید
- Cache مرورگر را پاک کنید

### آیکون‌ها نمایش داده نمی‌شوند
- کد آیکون را از Font Awesome چک کنید
- مطمئن شوید Font Awesome بارگذاری شده

### رنگ‌ها تغییر نمی‌کنند
- تنظیمات را دوباره ذخیره کنید
- Cache سایت را پاک کنید

## 📞 پشتیبانی

برای هرگونه سوال یا مشکل:
- ایمیل: support@example.com
- وبسایت: https://example.com

## 📄 لایسنس

GPL v2 or later

## 🔤 فونت‌ها

پلاگین از **فونت وزیر** استفاده می‌کند که یک فونت فارسی زیبا و خوانا است.

### ویژگی‌های فونت وزیر:
- ✅ طراحی مدرن و خوانا
- ✅ پشتیبانی کامل از زبان فارسی
- ✅ وزن‌های مختلف (Light, Regular, Medium, Bold)
- ✅ بهینه‌سازی شده برای وب (WOFF2)
- ✅ لایسنس آزاد (SIL Open Font License)

### بارگذاری فونت:
فونت از CDN jsDelivr بارگذاری می‌شود که:
- سرعت بالا
- در دسترس بودن جهانی
- Cache شدن خودکار
- بدون نیاز به فایل محلی

### تغییر فونت (اختیاری):
اگر می‌خواهید از فونت دیگری استفاده کنید:
1. فایل `public/css/vazir-font.css` را ویرایش کنید
2. لینک فونت دلخواه را جایگزین کنید
3. در فایل‌های CSS نام فونت را تغییر دهید

## 🌟 توسعه‌دهنده

توسعه یافته بر اساس استانداردهای WordPress Coding Standards

---

**نسخه:** 3.5.1  
**نیازمندی:** WordPress 5.0+, PHP 7.0+

