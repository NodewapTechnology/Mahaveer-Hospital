# Mahaveer Hospital — Laravel 11 CMS

## Original Problem Statement
User's original request (Hindi/Hinglish): rebuild the healthcare website into a fully-dynamic, admin-managed Laravel 11 + MySQL CMS. Iteration 2 requests: (a) fully responsive across mobile/tablet/desktop, (b) NO green colors in fonts, (c) modern & unique premium frontend design, (d) desktop menu with only 4 primary items (Home/About/Services/Doctors) — remaining items inside "More" dropdown, (e) Call & Book buttons must be icon-only circular in header, (f) admin-uploaded logo only, NO text-based logo fallback (use SVG mark instead), (g) English↔Hindi language toggle everywhere, (h) admin panel must have a Language Translations module, (i) professional fonts throughout.

## Architecture
- **Framework**: Laravel 11.54 (PHP 8.2)
- **Database**: MariaDB 10.11 (`mahaveer_cms`) — supervisor `mariadb`
- **Frontend**: Blade + hand-crafted CSS. **Fraunces** (display serif) + **Manrope** (body sans). Palette: midnight aubergine (#3b1f4a) · warm coral (#d64a3a) · mustard (#e5a530) · cream (#fbf6ef). Zero green in text/font/border. WhatsApp icon is the only green element (background only).
- **Admin**: Custom Blade layout, aubergine ink sidebar, ivory main area — palette aligned with frontend.
- **Runtime**: PHP built-in server on port 3000 (via `/app/frontend/package.json` → `php -S 0.0.0.0:3000 -t /app/laravel/public /app/laravel/server.php`)
- **Supervisor**: `frontend` (Laravel), `mariadb` (added in iteration 2), plus platform defaults.

## Files & Layout
```
/app/laravel/
├── app/Http/Controllers/
│   ├── Frontend/ (Home, About, Service, Doctor, Gallery, Event, Testimonial, Offer, Blog, Contact)
│   └── Admin/    (Auth, Dashboard, Banner, About, Service, Doctor, Gallery, Event, Testimonial, Offer, Blog, Faq, ContactDetail, SocialLink, SeoSetting, WebsiteSetting, Enquiry, Translation, AdminBase)
├── app/Models/   (Admin, Banner, AboutPage, Service, Doctor, GalleryItem, Event, Testimonial, Offer, Blog, Faq, ContactDetail, SocialLink, SeoSetting, WebsiteSetting, Enquiry, UiTranslation)
├── app/Helpers/I18n.php   (record-level + UI dictionary with cache & DB overrides)
├── database/migrations/   (cms tables, translations JSON, ui_translations dictionary)
├── resources/views/frontend/  (public pages + partials/header, partials/footer)
├── resources/views/admin/     (all CRUD views + translations/)
├── public/css/site.css + public/css/admin.css + public/js/site.js
└── routes/web.php
```

## Iteration History

### v1 (2026-01-07)
- MySQL schema for 16 CMS tables + admins + enquiries
- Public frontend: Home, About, Services, Doctors, Gallery, Events, Testimonials, Offers, Blogs, Contact
- Admin panel with CRUD for all modules + Enquiries management
- Multi-language schema (`translations` JSON on each content model)
- Backend 36/36, Frontend Playwright all pass.

### v2 (2026-01-09) — Design & i18n polish
- **Responsive fix**: header condensed to 4 primary + More dropdown; hamburger up to 1023px; no overflow at any viewport (verified 1440/1200/1024/768/390).
- **No green**: `--c-success` changed from #2f7a4d to burgundy #7a1f38; success alerts now use highlight-soft/primary; admin `--a-primary` moved from teal #0e5b56 to aubergine #3b1f4a. WhatsApp floating icon (background only) is the ONLY remaining green.
- **Design polish**: fonts switched to **Fraunces** (variable serif, SOFT+opsz axes) + **Manrope**; new SVG logo mark replaces text-based fallback in header and footer.
- **Header**: circular icon-only Call & Book buttons; compact EN/HI toggle; More dropdown with icon-prefixed sub-links; hamburger animates to X.
- **New admin module**: Language Translations (EN/HI) — CRUD + search + Import Defaults (36 keys seeded); auto cache-flush on write.
- Backend 45/45 (10 new tests), Frontend across 5 viewports — 100% pass, zero critical/minor issues.

## Test Credentials
See `/app/memory/test_credentials.md`

## Deferred / Backlog (P1)
- Rich-text (WYSIWYG) editor for blog/service description bodies
- Bulk import/export for gallery and testimonials via CSV
- Google reCAPTCHA on public contact form
- Email notification to admin on new enquiry
- Image thumbnail generation for gallery

## Deferred / Backlog (P2)
- Doctor OPD schedule with day-wise slots
- Online appointment booking with slot availability
- Patient portal (records, prescriptions)
- Payment integration for online consultation
