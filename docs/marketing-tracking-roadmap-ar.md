# خطة تنفيذ التتبع والتسويق الرقمي (Meta + Google)

## الهدف
بناء نظام تتبع متكامل للموقع يشمل:
- **Google Tag Manager (GTM)** لإدارة الوسوم بدون تعديل كود مباشر كل مرة.
- **GA4** لقياس السلوك والتحويلات.
- **Google Ads Conversion Tracking** لتتبع التحويل حتى النهاية.
- **Google Search Console** لمراقبة الظهور والـSEO والكلمات المفتاحية.
- **Meta Pixel** (ومستقبلاً Conversions API) لحملات فيسبوك/إنستغرام.
- **Heatmap** عبر Clarity أو Hotjar لفهم سلوك المستخدم داخل الصفحات.

## ماذا يعني كل عنصر (بشكل عملي)

### 1) Google Tag Manager
يربط كل أدوات التتبع من مكان واحد: GA4 + Google Ads + Meta Pixel + Heatmap.
الفائدة: نشر وتعديل التتبع بسرعة، مع Versioning وPreview قبل النشر.

### 2) Google Search Console
لمتابعة:
- الظهور في نتائج جوجل (Impressions)
- النقرات وCTR
- ترتيب الكلمات (Queries)
- مشاكل الفهرسة وCore Web Vitals

### 3) Meta Pixel
لمتابعة:
- PageView
- Lead / CompleteRegistration / Purchase (حسب نموذج العمل)
- إعادة الاستهداف وبناء جماهير إعلانية أدق

### 4) Heatmap (Clarity أو Hotjar)
يفيد في:
- أماكن النقر
- عمق التمرير
- نقاط الخروج
- Session Recordings لتحسين UX ورفع التحويل

---

## متى نضيف كل جزء؟ (خطة زمنية)

## المرحلة 0 — قبل التنفيذ (يوم 0–1)
1. تحديد أهداف التحويل النهائية (Macro + Micro).
2. عمل Tracking Plan بسيط (اسم الحدث، متى يشتغل، أين يظهر).
3. تجهيز صلاحيات الحسابات: Google, GTM, GA4, Ads, Search Console, Meta Business.

## المرحلة 1 — الأساسيات التقنية (الأسبوع 1)
1. تركيب GTM Container على كل صفحات الموقع.
2. تفعيل GA4 عبر GTM (Base tag + page_view).
3. تفعيل Google Ads conversion linker.
4. تفعيل Search Console وربط sitemap.xml.
5. إضافة Meta Pixel الأساسي عبر GTM.

**مخرج المرحلة:**
- كل زيارات الموقع تظهر في GA4.
- Search Console يبدأ جمع البيانات.
- Pixel يستقبل PageView.

## المرحلة 2 — تتبع التحويل الكامل (الأسبوع 2)
1. تعريف التحويل النهائي في الموقع (مثلاً: إرسال نموذج، شراء، حجز).
2. إنشاء أحداث في Data Layer أو Triggers دقيقة داخل GTM.
3. إرسال نفس الحدث إلى:
   - GA4 conversion
   - Google Ads conversion
   - Meta Pixel event
4. اختبار شامل عبر Tag Assistant + GA4 DebugView + Pixel Helper.

**مخرج المرحلة:**
- تتبع "حتى النهاية" فعّال (End-to-end conversion tracking).

## المرحلة 3 — SEO Data Loop (الأسبوع 3–4)
1. متابعة تقرير Performance في Search Console.
2. استخراج الكلمات المفتاحية الفعلية (Queries).
3. مشاركة قائمة الكلمات مع مسؤول/دكتور الـSEO أسبوعيًا.
4. ربط كلمات SEO بصفحات هبوط وحملات مدفوعة.

**مخرج المرحلة:**
- دورة واضحة: Search Console -> Keywords -> SEO/Content updates.

## المرحلة 4 — Heatmap + CRO (الأسبوع 4–5)
1. تركيب Clarity (سريع ومجاني غالبًا) أو Hotjar.
2. تحديد الصفحات الحرجة (Landing, Pricing, Checkout/Lead form).
3. مراجعة heatmaps أسبوعيًا.
4. توثيق 3–5 تحسينات UX وتنفيذ A/B إن أمكن.

**مخرج المرحلة:**
- قرارات تحسين مبنية على سلوك حقيقي، لا افتراضات.

## المرحلة 5 — التحسين والتوسعة (مستمر)
1. توسيع الأحداث (scroll depth, CTA clicks, file_download, video engagement).
2. التفكير بإضافة Meta Conversions API لتقليل فقدان البيانات.
3. تحسين Attribution وميزانيات الحملات حسب ROAS/CPL.

---

## To-Do List تنفيذية

## أ. إعداد الحسابات والصلاحيات
- [ ] إنشاء/تأكيد GTM Account + Container.
- [ ] منح صلاحيات Admin/Publish للأشخاص المعنيين.
- [ ] إنشاء GA4 Property وربطه بالموقع.
- [ ] ربط Google Ads مع GA4.
- [ ] تفعيل Search Console (Domain Property).
- [ ] تجهيز Meta Business Manager + Pixel.

## ب. تنفيذ GTM
- [ ] تركيب كود GTM في الموقع.
- [ ] إضافة GA4 Configuration Tag.
- [ ] إضافة Conversion Linker.
- [ ] إضافة Meta Pixel tag.
- [ ] إضافة Clarity/Hotjar tag.
- [ ] تفعيل Environments (إن كان هناك staging/production).

## ج. التتبع والتحويلات
- [ ] تعريف الأحداث الأساسية: page_view, form_start, form_submit, purchase/lead.
- [ ] توحيد أسماء الأحداث بين المنصات.
- [ ] إعداد Google Ads Conversion Actions.
- [ ] وضع التحويلات المهمة كـPrimary في Google Ads.
- [ ] اختبار منع التكرار (Deduplication) قدر الإمكان.

## د. SEO + كلمات مفتاحية
- [ ] إرسال sitemap.xml.
- [ ] فحص Coverage وPage indexing errors.
- [ ] استخراج Top Queries أسبوعيًا.
- [ ] إعداد تقرير شهري: impressions, clicks, avg position, CTR.

## هـ. QA ومراقبة الجودة
- [ ] اختبار كل Tag في Preview mode قبل أي نشر.
- [ ] التحقق من الأحداث في GA4 DebugView.
- [ ] التحقق من Meta Pixel firing.
- [ ] توثيق أي Bug + إصلاحه قبل إطلاق الحملات.

## و. التقارير والمتابعة
- [ ] Dashboard أسبوعي (GA4 + Ads + Meta + Search Console).
- [ ] اجتماع مراجعة أسبوعي 30 دقيقة.
- [ ] قائمة تحسينات CRO شهرية من heatmap.

---

## ملاحظات تشغيلية مهمة
- لا تبدأ حملات بميزانية كبيرة قبل التأكد من عمل التحويلات بدقة.
- أي حدث مهم لازم يكون له: تعريف + Trigger واضح + اختبار + مالك مسؤول.
- اجعل GTM هو المصدر الوحيد للوسوم قدر الإمكان لتجنب التضارب.
- بعد 2–4 أسابيع من جمع البيانات، يتم ضبط استراتيجية الكلمات المفتاحية بدقة أعلى.
