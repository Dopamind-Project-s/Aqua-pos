# بدء التنفيذ الفعلي: إعداد التتبع عبر GTM

## 1) متغيرات البيئة المطلوبة
أضف القيم التالية في `.env`:

```env
GTM_CONTAINER_ID=GTM-XXXXXXX
GOOGLE_SITE_VERIFICATION=google-site-verification-token
MS_CLARITY_PROJECT_ID=xxxxxxxxxx
```

## 2) ما تم تنفيذه في الكود
- [x] حقن كود **Google Tag Manager** (Head + Noscript) من خلال `GTM_CONTAINER_ID` أو إعدادات الأدمن.
- [x] إضافة `google-site-verification` meta tag تلقائيًا عند توفير القيمة.
- [x] إضافة **Microsoft Clarity** script عند توفير Project ID.
- [x] إرسال `page_context` إلى `dataLayer` في كل صفحة.
- [x] إرسال `generate_lead` event إلى `dataLayer` بعد نجاح إرسال أي نموذج طلب.
- [x] ربط حالة الإعدادات + مؤشرات Leads داخل **Admin Dashboard**.
- [x] إضافة قسم إعدادات Tracking داخل **Admin Settings**.

## 3) إعداد GTM (داخل الحساب)

### Tags
1. **GA4 Configuration**
   - Measurement ID من GA4
   - Trigger: All Pages

2. **GA4 Event - generate_lead**
   - Event Name: `generate_lead`
   - Parameters: `form_type`, `source_page`
   - Trigger: Custom Event = `generate_lead`

3. **Google Ads Conversion**
   - Conversion ID / Label من Google Ads
   - Trigger: Custom Event = `generate_lead`

4. **Meta Pixel (Custom HTML أو Template)**
   - Base Pixel: All Pages
   - Lead Event: عند `generate_lead`

### Variables
- Data Layer Variable: `form_type`
- Data Layer Variable: `source_page`

## 4) فحص الجودة (QA)
1. GTM Preview -> تأكد ظهور `page_context` عند فتح الصفحة.
2. أرسل نموذج Contact/Support/Demo.
3. تأكد ظهور `generate_lead` مع القيم:
   - `form_type` = `contact_request` أو `support_request` أو `demo_request`
   - `source_page` = الصفحة المصدر
4. تحقق من:
   - GA4 DebugView
   - Google Ads Tag diagnostics
   - Meta Pixel Helper

## 5) تعريف التحويلات
- في GA4: ضع `generate_lead` كـ Conversion.
- في Google Ads: اربط نفس الحدث كـ Primary Conversion.
- في Meta Ads: اعتمد Lead event للحملات.

## 6) To-Do List (Done / Remaining)

### تم إنجازه
- [x] إضافة حقول إعدادات التتبع في الأدمن (GTM, GA4, Ads, Pixel, Search Console, Clarity).
- [x] عرض تقدم تنفيذ التتبع داخل Dashboard (Done/Pending).
- [x] تقارير Leads داخل Dashboard (Today, 7d, 30d + by type + top source page).
- [x] ربط generate_lead من الطلبات الداخلية لتغذية GTM.

### المتبقي (تنفيذ داخل أدوات Google/Meta)
- [ ] إنشاء GA4 Configuration Tag داخل GTM.
- [ ] إنشاء GA4 Event Tag للحدث `generate_lead`.
- [ ] إنشاء Google Ads Conversion Tag وربطه بـ `generate_lead`.
- [ ] إنشاء/تفعيل Meta Pixel Base + Lead event داخل GTM.
- [ ] تعريف variables في GTM: `form_type`, `source_page`.
- [ ] فحص GTM Preview + GA4 DebugView + Pixel Helper قبل النشر.
- [ ] تعيين `generate_lead` كـ Conversion في GA4.
- [ ] تعيين التحويل كـ Primary Conversion في Google Ads.
- [ ] تجهيز تقرير دوري Search Console للكلمات المفتاحية وإرساله لفريق SEO.
