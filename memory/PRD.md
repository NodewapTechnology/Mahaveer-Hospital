# Mahaveer Hospital — Laravel 11 CMS

## Original Problem Statement
Rebuild a healthcare website into a fully-dynamic, admin-managed Laravel 11 + MySQL CMS with modern design, English↔Hindi translations, and complete admin panel. Iterations 2 and 3 focused on responsive design polish, an appointment form in the hero, and admin quality-of-life.

## Architecture
- **Framework**: Laravel 11.54 (PHP 8.2)
- **Database**: MariaDB 10.11 (`mahaveer_cms`) — supervisor program `mariadb`
- **Frontend**: Blade + hand-crafted CSS. **Fraunces** (display serif, variable axes) + **Manrope** (body sans). Palette: midnight aubergine (#3b1f4a) · warm coral (#d64a3a) · mustard (#e5a530) · cream (#fbf6ef). Zero green in text/font/border. WhatsApp icon is the only green (background).
- **Admin**: Grouped sidebar (Overview / Website Content / Settings), avatar pill topbar, TinyMCE WYSIWYG on all HTML content fields, gradient login page.
- **Runtime**: PHP built-in server on port 3000 via `/app/frontend/package.json` → supervisor `frontend`.

## Files & Layout
```
/app/laravel/
├── app/Http/Controllers/
│   ├── Frontend/ (Home, About, Service, Doctor, Gallery, Event, Testimonial, Offer, Blog, Contact)
│   └── Admin/    (Auth, Dashboard, Banner, About, Service, Doctor, Gallery, Event, Testimonial, Offer, Blog, Faq, ContactDetail, SocialLink, SeoSetting, WebsiteSetting, Enquiry, Translation, AdminBase)
├── app/Models/   (16 CMS models + Admin + Enquiry + UiTranslation)
├── app/Mail/NewEnquiryMail.php (Blade template mail/new_enquiry.blade.php)
├── app/Helpers/I18n.php   (record-level + UI dictionary with DB + cache)
├── config/mahaveer.php    (reCAPTCHA + notify email keys)
├── database/migrations/   (cms tables · translations JSON · ui_translations · village/district · recaptcha)
├── resources/views/frontend/  (public pages + partials/header, partials/footer)
├── resources/views/admin/     (all CRUD views + translations/ + enquiries/index redesign)
├── resources/views/mail/new_enquiry.blade.php
├── public/css/site.css + public/css/admin.css + public/js/site.js + public/js/admin.js
└── routes/web.php
```

## Iteration History

### v1 (2026-01-07) — Foundation
- MySQL schema for 16 CMS tables + admins + enquiries
- Public frontend: Home, About, Services, Doctors, Gallery, Events, Testimonials, Offers, Blogs, Contact
- Admin panel CRUD for all modules
- Backend 36/36, Frontend Playwright pass.

### v2 (2026-01-09) — Design & i18n polish
- Responsive header: 4 primary + More dropdown; hamburger up to 1023px; no overflow at any viewport.
- Green completely removed; palette shifted to aubergine + coral + mustard + burgundy.
- Fonts switched to Fraunces + Manrope. SVG logo mark replaces text fallback.
- Circular icon-only Call/Book, compact EN/HI toggle.
- New admin module: Language Translations (EN/HI) with search + Import Defaults.
- Backend 45/45, Frontend 5 viewports pass.

### v3 (2026-01-11) — Hero appointment form + admin polish
- **Hero doctor image card REMOVED**; replaced with premium appointment booking form (Name / Mobile / Village / District / Preferred Date — all required, HTML5 + server side).
- Beautiful native date picker with mustard-highlighted wrapper, custom calendar icon color, min=today.
- On submit: enquiry saved with `source=hero_form`, `village`, `district`, `preferred_date`; success alert appears in-card.
- Admin > **Appointments & Enquiries** page fully redesigned:
  - Three stat cards (Total / Online Appointments / Received Today)
  - Tab bar: All / Online Appointments / Contact Form / Today
  - Filter form: search + appointment-date picker + status
  - Info banner shows active date/source filter context
  - New columns: Patient, Phone (clickable), Location (village/district), Appointment Date (badge), Source, Status, Received (diffForHumans)
- CTA "Ready to take the first step" now has premium aubergine gradient card with mustard italic accent (previously white-on-cream, unreadable).
- Services grid gap increased for breathing room.
- **TinyMCE 6.8.3** WYSIWYG editor added on all HTML content forms: services, doctors, about, blogs, offers, events.
- **Google reCAPTCHA v3** support + **email notification** to admin on new enquiry (both configurable via /admin/website-settings — no .env edits needed).
- Admin design polish: grouped sidebar (Overview / Website Content / Settings), gradient mustard→coral logo mark, avatar pill in topbar, redesigned login page with radial gradient + diagonal stripe backdrop.
- Backend 65/65, Frontend 5 viewports pass, zero issues.

## Admin Access
See `/app/memory/test_credentials.md`

## Deferred / Backlog

### P1
- Home page section titles/subtitles editor (currently structural headings hardcoded in home.blade.php)
- Bulk import/export for gallery & testimonials via CSV
- Doctor OPD schedule editor with day-wise slots
- Image thumbnail generation for gallery

### P2
- Online appointment booking with slot availability + doctor selection
- Patient portal (records, prescriptions)
- Payment integration for online consultation
- SMS notifications on booking (Twilio/Fast2SMS)
- Multi-branch support

## 3rd-party Integrations
- **TinyMCE 6.8.3** via jsdelivr CDN (no API key required, community license)
- **Google reCAPTCHA v3** (optional, admin-configurable via Website Settings)
- **Laravel Mail** (currently `log` driver; production: swap to SMTP/Postmark/SES in .env)

### v4 (2026-06) — Bug-fix batch + Premium white redesign
**Environment note:** Container had been reset (PHP 8.2, Composer, MariaDB were reinstalled; DB `mahaveer_cms` re-created + migrated + seeded; `mariadb` re-added to supervisor via /etc/supervisor/conf.d/mariadb.conf; Laravel `.env` recreated).

Fixes (all verified, iteration_4 + iteration_5 PASS):
- Hero appointment form: Preferred Date now works on mobile (flatpickr disableMobile:true); **District field replaced with a dynamic Doctor <select>** populated from admin doctors (name `preferred_doctor`).
- Featured doctor bio renders HTML via `{!! !!}` (no more literal <p> tags).
- Removed **Source** from admin enquiry detail + list; removed **Translations (EN/HI)** admin menu; removed **EN/HI language toggle** from front-end header.
- Website Settings **colour pickers** fixed (swatch + hex) and now applied **site-wide** via CSS-var injection in layout (`--c-primary/--c-accent/--c-highlight`). Admin dashboard also re-themed via `--a-*` injection.
- Admin-uploaded **logo & favicon** apply across site (favicon cache-busted by updated_at).

Redesign (v4):
- **Premium WHITE theme**, **no gradients** anywhere (solid brand colours), **premium card shadows**.
- **Testimonials moved BEFORE Doctors**; testimonials become a **horizontal swipe slider on mobile**.
- **Doctors: 1 card per row on mobile**.
- **Mobile app-like UX**: fixed bottom tab bar (Home/Care/Book/Doctors/Call), larger radii, app feel.
- **CTA band** ("Ready when you are") now solid primary colour from admin.
- **White glass-morphism header** (translucent white + backdrop blur).
- New dedicated admin menu **Video Links** (`featured_videos` table) supporting **multiple** Instagram + YouTube links; previews render on home ("Watch & Follow") and open the platform on click. (Moved out of Website Settings.)

New/changed files: FeaturedVideo model + Admin\FeaturedVideoController + admin/videos views + routes; migrations 2026_01_12 (video cols on website_settings, now unused) & 2026_01_13 (featured_videos). Frontend: layout.blade.php (theme + tabbar + glass), home.blade.php (reorder + videos + doctor-grid/testi-grid), header.blade.php (lang removed). CSS: site.css v15 (white theme overrides), admin.css v8 (color picker + theme).

### v5 (2026-06) — Booking popup + Glass UI + IG thumbnails (iteration_6 PASS)
- **Booking popup modal**: header Book icon, mobile bottom-nav Book, mobile menu Book all open a glass popup with the full appointment form (name/phone/village/doctor/date). Submits -> enquiry + success toast. File: resources/views/frontend/partials/booking-modal.blade.php; JS in site.js (v12); CSS in site.css (v17). Popup header trimmed (no eyebrow/pill) so form fits + scrolls.
- **Glass cards everywhere**: translucent frosted (backdrop-blur) + premium shadow on all card families.
- **Floating rounded glass mobile header** + rounded pill bottom app-tabbar.
- **Instagram real thumbnails**: FeaturedVideo::instagramThumb() uses public /p/{code}/media endpoint with server-side + onerror branded glass fallback (no broken images). YouTube uses img.youtube.com thumb.
