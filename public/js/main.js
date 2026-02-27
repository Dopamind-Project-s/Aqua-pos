(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });


    // Hero Header carousel
    $(".header-carousel").owlCarousel({
        animateOut: 'slideOutDown',
        items: 1,
        autoplay: true,
        smartSpeed: 1000,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
    });


    // International carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        items: 1,
        smartSpeed: 1500,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });


    // testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:1
            },
            1200:{
                items:1
            }
        }
    });

    
    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


})(jQuery);


// Mega menu interactions (mobile accordion + mobile open/close)
document.addEventListener('DOMContentLoaded', function () {
    var megaMenu = document.getElementById('productsMegaMenu');

    if (!megaMenu) {
        return;
    }

    var trigger = megaMenu.querySelector('.mega-menu__trigger');
    var categoryItems = megaMenu.querySelectorAll('.mega-menu__category');
    var categoryButtons = megaMenu.querySelectorAll('.mega-menu__category-toggle');

    var isMobile = function () {
        return window.matchMedia('(max-width: 991.98px)').matches;
    };

    var closeMegaMenu = function () {
        megaMenu.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
    };

    trigger.addEventListener('click', function (event) {
        if (!isMobile()) {
            return;
        }

        event.preventDefault();
        var openState = megaMenu.classList.toggle('is-open');
        trigger.setAttribute('aria-expanded', openState ? 'true' : 'false');
    });

    categoryButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (!isMobile()) {
                return;
            }

            var category = button.closest('.mega-menu__category');
            var isOpen = category.classList.toggle('is-open');

            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });

    document.addEventListener('click', function (event) {
        if (!isMobile()) {
            return;
        }

        if (!megaMenu.contains(event.target)) {
            closeMegaMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (!isMobile()) {
            closeMegaMenu();
            categoryItems.forEach(function (item) {
                item.classList.remove('is-open');
            });
            categoryButtons.forEach(function (button) {
                button.setAttribute('aria-expanded', 'false');
            });
        }
    });
});

// Theme + language + direction controls
(function () {
    var THEME_KEY = 'aqua_theme';
    var LANG_KEY = 'aqua_lang';
    var defaultLang = 'en';

    var translations = {
        en: {
            'topbar.location': 'Find A Location',
            'nav.home': 'Home',
            'nav.about': 'About',
            'nav.services': 'Services',
            'nav.products': 'Products',
            'nav.pages': 'Pages',
            'nav.appointment': 'Appointment',
            'nav.features': 'Features',
            'nav.blog': 'Our Blog',
            'nav.team': 'Our Team',
            'nav.testimonial': 'Testimonial',
            'nav.notfound': '404 Page',
            'nav.contact': 'Contact Us',
            'nav.book': 'Book Appointment',
            'blog.nav.blogs': 'Blogs',
            'blog.hero.badge1': 'Aqua Insights',
            'blog.hero.titleBlog': 'Professional Blog Articles',
            'blog.hero.titleNews': 'Latest Industry News',
            'blog.hero.desc1': 'Professional content that helps you improve sales, customer experience, and branch operations efficiently.',
            'blog.hero.badge2': 'Smart Retail',
            'blog.hero.title2': 'POS Strategies for Growth',
            'blog.hero.desc2': 'Practical lessons and proven tactics from retail and restaurant operations to improve performance and profitability.',
            'blog.nav.news': 'News',
            'blog.nav.category': 'Category',
            'blog.nav.allCategories': 'All Categories',
            'blog.nav.noCategories': 'No categories available',
            'blog.nav.time': 'Time',
            'blog.defaultImage': 'No image available',
            'blog.readMore': 'Read More',
            'blog.noPosts': 'No posts found.',
            'blog.loadMore': 'Load More',
            'blog.filterByCategory': 'Filter by Category',
            'blog.latest': 'Latest Posts',
            'blog.related': 'Similar Posts',
            'demo.badge': 'Aqua POS Demo',
            'demo.title': 'Book a Personalized POS Demo',
            'demo.subtitle': 'Discover how Aqua POS transforms operations with faster billing, smart inventory, and branch-level control in one connected platform.',
            'demo.whatYouGet': 'What you’ll get in the demo',
            'demo.benefit1': 'Live walkthrough of POS, inventory, and reports',
            'demo.benefit2': 'Branch setup, roles, and permissions flow',
            'demo.benefit3': 'Implementation timeline and pricing options',
            'demo.formTitle': 'Request Product Demo',
            'demo.formSubtitle': 'Share your business details and a product specialist will contact you shortly.',
            'demo.fullName': 'Full Name',
            'demo.email': 'Email',
            'demo.phone': 'Phone',
            'demo.company': 'Company',
            'demo.country': 'Country',
            'demo.branches': 'Branches',
            'demo.productInterest': 'Product Interest',
            'demo.preferredContactTime': 'Preferred Contact Time',
            'demo.notes': 'Notes',
            'demo.submit': 'Submit Demo Request',
            'demo.feature1Title': 'Built for multi-branch businesses',
            'demo.feature1Desc': 'Operate all branches from a unified dashboard with full cashier control.',
            'demo.feature2Title': 'Advanced inventory management',
            'demo.feature2Desc': 'Monitor stock in real time and receive proactive low-stock alerts.',
            'demo.feature3Title': 'Local onboarding & support',
            'demo.feature3Desc': 'Dedicated assistance for setup, staff training, and smooth go-live.',
            'partners.eyebrow': 'Strategic Ecosystem',
            'partners.title': 'Enterprise Partnerships That Scale',
            'partners.subtitle': 'We collaborate with high-impact brands and technology leaders to deliver seamless, scalable, and future-ready solutions.',
            'partners.metric1': 'Trusted Alliances',
            'partners.metric2': 'Integrated Ecosystem',
            'partners.metric3': 'Growth-Focused Delivery',
            'partners.gridTitle': 'Our Partner Network',
            'partners.gridSubtitle': 'Select from strategic partners helping clients accelerate digital operations.',
            'partners.countLabel': 'Partners',
            'partners.emptyTitle': 'No partners yet',
            'partners.emptySubtitle': 'We are currently onboarding exceptional partners. Please check back soon.',
            'partners.visitWebsite': 'Visit Website',
            'partners.defaultDescription': 'Trusted partner supporting our ecosystem with reliable services.',
            'controls.dark': 'Dark',
            'controls.light': 'Light',
            'mega.restaurant': 'Restaurant',
            'mega.retail': 'Retail',
            'mega.hotel': 'Hotel',
            'mega.enterprise': 'Enterprise',
            'mega.restaurantPos': 'Restaurant POS',
            'mega.restaurantPosDesc': 'Smart table, order and kitchen workflows.',
            'mega.qrOrdering': 'QR Ordering',
            'mega.qrOrderingDesc': 'Contactless menu and payment journey.',
            'mega.inventoryHub': 'Inventory Hub',
            'mega.inventoryHubDesc': 'Centralized stock sync across all stores.',
            'mega.loyaltyCrm': 'Loyalty CRM',
            'mega.loyaltyCrmDesc': 'Member tiers, rewards and campaigns.',
            'mega.propertyPms': 'Property PMS',
            'mega.propertyPmsDesc': 'Bookings, front desk and room operations.',
            'mega.spaWellness': 'Spa & Wellness',
            'mega.spaWellnessDesc': 'Appointments and service bundles in one place.',
            'mega.biAnalytics': 'BI Analytics',
            'mega.biAnalyticsDesc': 'Executive dashboards with live insights.',
            'mega.apiIntegrations': 'API Integrations',
            'mega.apiIntegrationsDesc': 'Secure integrations with ERP and finance tools.'
        },
        ar: {
            'topbar.location': 'ابحث عن موقع',
            'nav.home': 'الرئيسية',
            'nav.about': 'من نحن',
            'nav.services': 'الخدمات',
            'nav.products': 'المنتجات',
            'nav.pages': 'الصفحات',
            'nav.appointment': 'حجز موعد',
            'nav.features': 'المميزات',
            'nav.blog': 'مدونتنا',
            'nav.team': 'فريقنا',
            'nav.testimonial': 'آراء العملاء',
            'nav.notfound': 'صفحة 404',
            'nav.contact': 'اتصل بنا',
            'nav.book': 'احجز موعد',
            'blog.nav.blogs': 'المدونة',
            'blog.hero.badge1': 'رؤى أكوا',
            'blog.hero.titleBlog': 'مقالات احترافية في المدونة',
            'blog.hero.titleNews': 'آخر أخبار القطاع',
            'blog.hero.desc1': 'محتوى احترافي يساعدك على تحسين المبيعات وتجربة العميل وإدارة الفروع بكفاءة أعلى.',
            'blog.hero.badge2': 'تجزئة ذكية',
            'blog.hero.title2': 'استراتيجيات نمو لنقاط البيع',
            'blog.hero.desc2': 'دروس عملية وتكتيكات مجرّبة من قطاعي التجزئة والمطاعم لرفع الأداء وزيادة الربحية.',
            'blog.nav.news': 'الأخبار',
            'blog.nav.category': 'التصنيف',
            'blog.nav.allCategories': 'كل التصنيفات',
            'blog.nav.noCategories': 'لا توجد تصنيفات متاحة',
            'blog.nav.time': 'الوقت',
            'blog.defaultImage': 'لا توجد صورة',
            'blog.readMore': 'اقرأ المزيد',
            'blog.noPosts': 'لا توجد منشورات حالياً.',
            'blog.loadMore': 'تحميل المزيد',
            'blog.filterByCategory': 'التصفية حسب التصنيف',
            'blog.latest': 'أحدث المنشورات',
            'blog.related': 'منشورات مشابهة',
            'demo.badge': 'عرض أكوا بوس',
            'demo.title': 'احجز عرضًا مخصصًا لنظام نقاط البيع',
            'demo.subtitle': 'اكتشف كيف يطوّر أكوا بوس عملياتك عبر تسريع الفوترة وإدارة المخزون والتحكم بالفروع من منصة واحدة.',
            'demo.whatYouGet': 'ما الذي ستحصل عليه في العرض',
            'demo.benefit1': 'جولة مباشرة على نقاط البيع والمخزون والتقارير',
            'demo.benefit2': 'شرح إعداد الفروع والأدوار والصلاحيات',
            'demo.benefit3': 'خطة تنفيذ واضحة وخيارات التسعير',
            'demo.formTitle': 'طلب عرض المنتج',
            'demo.formSubtitle': 'شاركنا تفاصيل نشاطك وسيقوم مختص المنتجات بالتواصل معك قريبًا.',
            'demo.fullName': 'الاسم الكامل',
            'demo.email': 'البريد الإلكتروني',
            'demo.phone': 'الهاتف',
            'demo.company': 'الشركة',
            'demo.country': 'الدولة',
            'demo.branches': 'عدد الفروع',
            'demo.productInterest': 'المنتج المطلوب',
            'demo.preferredContactTime': 'الوقت المفضل للتواصل',
            'demo.notes': 'ملاحظات',
            'demo.submit': 'إرسال طلب العرض',
            'demo.feature1Title': 'مصمم للشركات متعددة الفروع',
            'demo.feature1Desc': 'إدارة جميع الفروع من لوحة واحدة مع تحكم كامل بالكاشير.',
            'demo.feature2Title': 'إدارة متقدمة للمخزون',
            'demo.feature2Desc': 'متابعة المخزون لحظيًا مع تنبيهات فورية عند انخفاض الكميات.',
            'demo.feature3Title': 'تهيئة ودعم محلي',
            'demo.feature3Desc': 'دعم متخصص للإعداد والتدريب والانطلاق بثقة.',
            'partners.eyebrow': 'منظومة استراتيجية',
            'partners.title': 'شراكات مؤسسية تقود النمو',
            'partners.subtitle': 'نتعاون مع علامات مؤثرة ورواد تقنيين لتقديم حلول سلسة وقابلة للتوسع وجاهزة للمستقبل.',
            'partners.metric1': 'تحالفات موثوقة',
            'partners.metric2': 'منظومة متكاملة',
            'partners.metric3': 'تنفيذ يركز على النمو',
            'partners.gridTitle': 'شبكة شركائنا',
            'partners.gridSubtitle': 'اختر من شركائنا الاستراتيجيين الذين يساعدون العملاء على تسريع التحول الرقمي.',
            'partners.countLabel': 'شريك',
            'partners.emptyTitle': 'لا يوجد شركاء حالياً',
            'partners.emptySubtitle': 'نعمل حالياً على ضم شركاء مميزين. يرجى زيارة الصفحة قريبًا.',
            'partners.visitWebsite': 'زيارة الموقع',
            'partners.defaultDescription': 'شريك موثوق يدعم منظومتنا بخدمات احترافية مستقرة.',
            'controls.dark': 'داكن',
            'controls.light': 'فاتح',
            'mega.restaurant': 'المطاعم',
            'mega.retail': 'التجزئة',
            'mega.hotel': 'الفنادق',
            'mega.enterprise': 'المؤسسات',
            'mega.restaurantPos': 'نقطة بيع المطاعم',
            'mega.restaurantPosDesc': 'إدارة الطاولات والطلبات والمطبخ بذكاء.',
            'mega.qrOrdering': 'الطلب عبر QR',
            'mega.qrOrderingDesc': 'رحلة طلب ودفع بدون تلامس.',
            'mega.inventoryHub': 'مركز المخزون',
            'mega.inventoryHubDesc': 'مزامنة مركزية للمخزون عبر الفروع.',
            'mega.loyaltyCrm': 'ولاء العملاء CRM',
            'mega.loyaltyCrmDesc': 'شرائح العملاء والمكافآت والحملات.',
            'mega.propertyPms': 'إدارة المنشأة PMS',
            'mega.propertyPmsDesc': 'الحجوزات والاستقبال وتشغيل الغرف.',
            'mega.spaWellness': 'السبا والعافية',
            'mega.spaWellnessDesc': 'المواعيد وباقات الخدمات في منصة واحدة.',
            'mega.biAnalytics': 'تحليلات BI',
            'mega.biAnalyticsDesc': 'لوحات تنفيذية برؤى فورية.',
            'mega.apiIntegrations': 'تكاملات API',
            'mega.apiIntegrationsDesc': 'تكامل آمن مع أنظمة ERP والمالية.'
        }
    };

    var setTheme = function (theme) {
        var body = document.body;
        var themeIcon = document.getElementById('themeIcon');
        var themeLabel = document.getElementById('themeLabel');
        var lang = localStorage.getItem(LANG_KEY) || defaultLang;

        body.classList.add('theme-fade');
        if (theme === 'dark') {
            body.classList.add('dark-mode');
            if (themeIcon) themeIcon.textContent = '☀';
            if (themeLabel) themeLabel.textContent = lang === 'ar' ? translations.ar['controls.light'] : translations.en['controls.light'];
        } else {
            body.classList.remove('dark-mode');
            if (themeIcon) themeIcon.textContent = '🌙';
            if (themeLabel) themeLabel.textContent = lang === 'ar' ? translations.ar['controls.dark'] : translations.en['controls.dark'];
        }
        setTimeout(function () {
            body.classList.remove('theme-fade');
        }, 300);
        localStorage.setItem(THEME_KEY, theme);
    };

    var setLanguage = function (lang) {
        var html = document.documentElement;
        var langLabel = document.getElementById('languageLabel');
        var currentTheme = localStorage.getItem(THEME_KEY) || 'light';

        html.setAttribute('lang', lang);
        html.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');

        document.querySelectorAll('[data-i18n]').forEach(function (el) {
            var key = el.getAttribute('data-i18n');
            if (translations[lang][key]) {
                el.textContent = translations[lang][key];
            }
        });

        if (langLabel) {
            langLabel.textContent = lang === 'ar' ? 'EN' : 'AR';
        }

        localStorage.setItem(LANG_KEY, lang);
        setTheme(currentTheme);
    };

    document.addEventListener('DOMContentLoaded', function () {
        var savedTheme = localStorage.getItem(THEME_KEY) || 'light';
        var savedLang = localStorage.getItem(LANG_KEY) || defaultLang;
        var themeToggle = document.getElementById('themeToggle');
        var languageToggle = document.getElementById('languageToggle');

        setLanguage(savedLang);
        setTheme(savedTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                var currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
                setTheme(currentTheme === 'dark' ? 'light' : 'dark');
            });
        }

        if (languageToggle) {
            languageToggle.addEventListener('click', function () {
                var currentLang = document.documentElement.getAttribute('lang') || defaultLang;
                setLanguage(currentLang === 'ar' ? 'en' : 'ar');
            });
        }
    });
})();
