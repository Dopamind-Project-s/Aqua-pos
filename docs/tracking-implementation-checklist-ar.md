# بدء التنفيذ الفعلي: إعداد التتبع عبر GTM

## 1) متغيرات البيئة المطلوبة
أضف القيم التالية في `.env`:

```env
GTM_CONTAINER_ID=GTM-XXXXXXX
GOOGLE_SITE_VERIFICATION=google-site-verification-token
MS_CLARITY_PROJECT_ID=xxxxxxxxxx
```

## 2) ما تم تنفيذه في الكود
- حقن كود **Google Tag Manager** (Head + Noscript) من خلال `GTM_CONTAINER_ID`.
- إضافة `google-site-verification` meta tag تلقائيًا عند توفير القيمة.
- إضافة **Microsoft Clarity** script عند توفير `MS_CLARITY_PROJECT_ID`.
- إرسال `page_context` إلى `dataLayer` في كل صفحة.
- إرسال `generate_lead` event إلى `dataLayer` بعد نجاح إرسال أي نموذج طلب.

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
