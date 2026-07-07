# Mahaveer Hospital — Laravel 11 CMS

## Original Problem Statement
Convert the existing React-based Mahaveer Hospital website into a fully dynamic **PHP Laravel 11 + MySQL** CMS with a complete admin panel to manage all frontend content. Requirements:
- Modules: Dashboard, Banners, About, Services, Doctors, Gallery, Events, Testimonials, Offers, Blogs/News, FAQs, Contact Details, Social Media Links, SEO Settings, Website Settings.
- Doctor module: Name, Photo, Designation, Qualification, Experience, Specialization, Description, Available Timing, Contact Details, Status.
- Frontend: light theme only (existing dark mode removed).
- Contact/Enquiry form data stored in MySQL, manageable from admin (list, search, status update).
- Session-based admin login.

## Architecture
- **Framework**: Laravel 11.54 (PHP 8.2)
- **Database**: MariaDB 10.11 (`mahaveer_cms`)
- **Frontend**: Blade templates + hand-crafted light-theme CSS (Fraunces + Manrope, teal + saffron palette) + Bootstrap 5 grid + Font Awesome 6
- **Admin**: Custom Blade layout with dark ink sidebar, ivory main area
- **Runtime**: PHP built-in server on port 3000 (via `/app/frontend/package.json` -> yarn start -> php -S)
- **Static assets**: Router at `/app/laravel/server.php` passes existing files under `public/` to the built-in server and everything else to `public/index.php`.

## Files & Layout
```
/app/laravel/
├── app/Http/Controllers/
│   ├── Frontend/ (Home, About, Service, Doctor, Gallery, Event, Testimonial, Offer, Blog, Contact)
│   └── Admin/    (Auth, Dashboard, Banner, About, Service, Doctor, Gallery, Event, Testimonial, Offer, Blog, Faq, ContactDetail, SocialLink, SeoSetting, WebsiteSetting, Enquiry, AdminBase)
├── app/Models/   (Admin, Banner, AboutPage, Service, Doctor, GalleryItem, Event, Testimonial, Offer, Blog, Faq, ContactDetail, SocialLink, SeoSetting, WebsiteSetting, Enquiry)
├── database/migrations/ 2026_01_01_000000_create_cms_tables.php
├── database/seeders/DatabaseSeeder.php
├── resources/views/frontend/ + resources/views/admin/
├── public/css/site.css + public/css/admin.css + public/js/site.js + public/js/admin.js
└── routes/web.php
```

## Implemented (2026-01-07)
- [x] MySQL schema for 16 CMS tables + admins + enquiries
- [x] Public frontend: Home, About, Services (list/detail), Doctors (list/detail), Gallery, Events (list/detail), Testimonials, Offers (list/detail), Blogs (list/detail), Contact (with form submission)
- [x] Dynamic header (nav, site logo/name, contact CTA) and footer (contact, socials, quick links, copyright)
- [x] Sticky floating 24/7 Emergency call CTA
- [x] Warm ivory + healing teal + saffron gold light theme, Fraunces + Manrope typography, no dark mode
- [x] Admin panel with sidebar navigation for all 16 modules + enquiries
- [x] Admin CRUD for Banners, Services, Doctors, Gallery, Events, Testimonials, Offers, Blogs, FAQs, Social Links, SEO Settings (edit only)
- [x] Admin single-record edit for About page, Contact Details, Website Settings
- [x] Admin Enquiries: list with search & status filter, view detail, update status + notes, delete
- [x] Admin dashboard with real-time counters and latest enquiries
- [x] File uploads (images) for banners, about, services, doctors, gallery, events, offers, blogs, SEO OG images, website logo & favicon
- [x] Featured-doctor logic (only one doctor can be featured at a time)
- [x] Automatic slug generation with uniqueness for Services, Doctors, Events, Offers, Blogs
- [x] Session-based admin auth (custom `admin` guard, `App\Models\Admin`)
- [x] TrustProxies configured for Emergent K8s ingress (HTTPS asset URLs work)
- [x] Dummy seed data: 1 admin, 5 doctors, 6 services, 6 testimonials, 4 events, 4 offers, 3 blogs, 8 gallery, 5 FAQs, 4 socials, 10 SEO records

## Test Results (Iteration 1)
- Backend: 100% (36/36 pytest tests pass)
- Frontend: 100% (Playwright UI walkthrough of public site, contact form, admin login, dashboard, doctors, enquiries all pass)
- Light theme validated, admin auth working, contact→enquiry→admin pipeline verified end-to-end

## Deferred / Backlog (P1)
- Rich-text (WYSIWYG) editor for blog/service description bodies (currently raw HTML textarea)
- Bulk import/export for gallery and testimonials via CSV
- Google reCAPTCHA on public contact form for spam protection
- Email notification to admin on new enquiry
- Multi-language (Hindi / English toggle)
- Image thumbnail generation for gallery

## Deferred / Backlog (P2)
- Doctor OPD schedule with day-wise time slots
- Online appointment booking with slot availability
- Patient portal (records, prescriptions)
- Payment integration for online consultation

## Test Credentials
See `/app/memory/test_credentials.md`
