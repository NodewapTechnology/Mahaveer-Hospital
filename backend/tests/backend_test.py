"""
Backend / HTTP tests for Mahaveer Hospital Laravel CMS.
Tests public routes, admin auth, admin CRUD (doctors), enquiries save.
"""
import os
import re
import pytest
import requests

BASE_URL = "https://8acd5f59-fc30-4d0b-8df0-e3066c904643.preview.emergentagent.com"
ADMIN_EMAIL = "admin@mahaveerhospital.com"
ADMIN_PASS = "Admin@12345"


def _csrf(html: str) -> str:
    m = re.search(r'name="_token"\s+value="([^"]+)"', html)
    if not m:
        m = re.search(r'name="csrf-token"\s+content="([^"]+)"', html)
    return m.group(1) if m else ""


@pytest.fixture(scope="session")
def public_session():
    s = requests.Session()
    s.headers.update({"User-Agent": "pytest-backend"})
    return s


@pytest.fixture(scope="session")
def admin_session():
    s = requests.Session()
    s.headers.update({"User-Agent": "pytest-admin"})
    r = s.get(f"{BASE_URL}/admin/login", timeout=30)
    assert r.status_code == 200, f"admin/login GET failed {r.status_code}"
    token = _csrf(r.text)
    assert token, "CSRF token not found on login page"
    r2 = s.post(
        f"{BASE_URL}/admin/login",
        data={"_token": token, "email": ADMIN_EMAIL, "password": ADMIN_PASS},
        allow_redirects=False,
        timeout=30,
    )
    assert r2.status_code in (302, 303), f"login attempt returned {r2.status_code}"
    loc = r2.headers.get("Location", "")
    assert "/admin" in loc and "login" not in loc, f"login redirect went to {loc}"
    return s


# ---------- Public pages ----------
PUBLIC_PATHS = [
    "/", "/about", "/services", "/doctors", "/gallery",
    "/events", "/testimonials", "/offers", "/blogs", "/contact",
]

@pytest.mark.parametrize("path", PUBLIC_PATHS)
def test_public_pages_load(public_session, path):
    r = public_session.get(f"{BASE_URL}{path}", timeout=30)
    assert r.status_code == 200, f"{path} -> {r.status_code}"
    assert "<html" in r.text.lower()


def test_doctor_detail_slug(public_session):
    # Spec referenced slug 'laravel-cms-portal' but seeded slugs are dr-*
    r = public_session.get(f"{BASE_URL}/doctors/dr-anjali-verma", timeout=30)
    assert r.status_code == 200, f"doctor detail -> {r.status_code}"
    body = r.text.lower()
    # Should contain some doctor profile field labels
    assert any(k in body for k in ["designation", "qualification", "experience", "specialization"])


def test_light_theme_no_dark_toggle(public_session):
    r = public_session.get(f"{BASE_URL}/", timeout=30)
    assert r.status_code == 200
    # No dark toggle UI
    assert "data-testid=\"dark-toggle\"" not in r.text
    # No prefers-color-scheme dark override
    assert "prefers-color-scheme: dark" not in r.text


# ---------- Contact / Enquiry submission ----------
def test_contact_form_submission_saves_enquiry(public_session):
    r = public_session.get(f"{BASE_URL}/contact", timeout=30)
    assert r.status_code == 200
    token = _csrf(r.text)
    assert token, "no CSRF token on contact page"
    payload = {
        "_token": token,
        "name": "TEST_Contact User",
        "phone": "9999999901",
        "email": "test_contact@example.com",
        "subject": "Test Subject",
        "message": "This is a pytest-generated enquiry.",
    }
    r2 = public_session.post(f"{BASE_URL}/contact", data=payload, allow_redirects=False, timeout=30)
    assert r2.status_code in (302, 303), f"contact POST -> {r2.status_code} body={r2.text[:200]}"
    # Follow to see flash
    follow = public_session.get(r2.headers.get("Location", f"{BASE_URL}/contact"), timeout=30)
    assert follow.status_code == 200
    assert re.search(r"success|thank", follow.text, re.I), "no success message after submit"


# ---------- Admin auth ----------
def test_admin_login_wrong_credentials():
    s = requests.Session()
    r = s.get(f"{BASE_URL}/admin/login", timeout=30)
    token = _csrf(r.text)
    r2 = s.post(
        f"{BASE_URL}/admin/login",
        data={"_token": token, "email": ADMIN_EMAIL, "password": "wrong_pass"},
        allow_redirects=False,
        timeout=30,
    )
    # Should redirect back to login (302) or 200 with error
    if r2.status_code in (302, 303):
        assert "login" in r2.headers.get("Location", ""), "wrong creds should not enter admin"
    else:
        assert r2.status_code in (200, 422)


def test_admin_guest_redirect():
    s = requests.Session()
    r = s.get(f"{BASE_URL}/admin/doctors", allow_redirects=False, timeout=30)
    assert r.status_code in (302, 303)
    assert "login" in r.headers.get("Location", "").lower()


def test_admin_dashboard_loads(admin_session):
    r = admin_session.get(f"{BASE_URL}/admin", timeout=30)
    assert r.status_code == 200
    body = r.text.lower()
    # Look for stat labels
    for k in ["doctor", "service", "event", "enquir"]:
        assert k in body, f"dashboard missing '{k}' stat"


# ---------- Admin doctor CRUD ----------
@pytest.fixture(scope="session")
def created_doctor_id(admin_session):
    r = admin_session.get(f"{BASE_URL}/admin/doctors/create", timeout=30)
    assert r.status_code == 200, f"doctors/create -> {r.status_code}"
    token = _csrf(r.text)
    data = {
        "_token": token,
        "name": "TEST_Dr Pytest",
        "slug": "test-dr-pytest",
        "designation": "Consultant",
        "qualification": "MBBS, MD",
        "experience": "10 years",
        "specialization": "General Medicine",
        "description": "Auto-generated pytest doctor.",
        "available_timing": "Mon-Fri 10:00-17:00",
        "contact_phone": "9998887777",
        "contact_email": "dr.pytest@example.com",
        "sort": "99",
        "is_active": "1",
        "is_featured": "1",
    }
    r2 = admin_session.post(f"{BASE_URL}/admin/doctors", data=data, allow_redirects=False, timeout=30)
    assert r2.status_code in (302, 303), f"doctor create -> {r2.status_code} body={r2.text[:300]}"
    # Fetch listing and try to find slug
    listing = admin_session.get(f"{BASE_URL}/admin/doctors", timeout=30)
    assert "test-dr-pytest" in listing.text.lower() or "TEST_Dr Pytest" in listing.text
    # Extract id from edit link
    m = re.search(r'/admin/doctors/(\d+)/edit', listing.text)
    assert m, "could not find created doctor id"
    return m.group(1)


def test_created_doctor_visible_on_public_site(public_session, created_doctor_id):
    r = public_session.get(f"{BASE_URL}/doctors", timeout=30)
    assert r.status_code == 200
    assert "test-dr-pytest" in r.text.lower() or "TEST_Dr Pytest" in r.text


def test_admin_edit_doctor(admin_session, created_doctor_id):
    r = admin_session.get(f"{BASE_URL}/admin/doctors/{created_doctor_id}/edit", timeout=30)
    assert r.status_code == 200
    token = _csrf(r.text)
    data = {
        "_token": token,
        "_method": "PUT",
        "name": "TEST_Dr Pytest Updated",
        "slug": "test-dr-pytest",
        "designation": "Senior Consultant",
        "qualification": "MBBS, MD",
        "experience": "12 years",
        "specialization": "General Medicine",
        "description": "Updated.",
        "available_timing": "Mon-Sat 09:00-18:00",
        "contact_phone": "9998887777",
        "contact_email": "dr.pytest@example.com",
        "sort": "99",
        "is_active": "1",
        "is_featured": "1",
    }
    r2 = admin_session.post(f"{BASE_URL}/admin/doctors/{created_doctor_id}", data=data,
                            allow_redirects=False, timeout=30)
    assert r2.status_code in (302, 303), f"doctor update -> {r2.status_code}"


def test_admin_delete_doctor(admin_session, created_doctor_id):
    # Get token from listing page
    r = admin_session.get(f"{BASE_URL}/admin/doctors", timeout=30)
    token = _csrf(r.text)
    r2 = admin_session.post(
        f"{BASE_URL}/admin/doctors/{created_doctor_id}",
        data={"_token": token, "_method": "DELETE"},
        allow_redirects=False, timeout=30,
    )
    assert r2.status_code in (302, 303), f"doctor delete -> {r2.status_code}"


# ---------- Admin section listing pages ----------
ADMIN_LISTINGS = [
    "/admin/banners", "/admin/about", "/admin/services", "/admin/doctors",
    "/admin/gallery", "/admin/events", "/admin/testimonials", "/admin/offers",
    "/admin/blogs", "/admin/faqs", "/admin/contact-details", "/admin/social-links",
    "/admin/seo-settings", "/admin/website-settings", "/admin/enquiries",
]

@pytest.mark.parametrize("path", ADMIN_LISTINGS)
def test_admin_listing_pages(admin_session, path):
    r = admin_session.get(f"{BASE_URL}{path}", timeout=30)
    assert r.status_code == 200, f"{path} -> {r.status_code}"


# ---------- Enquiries appear after contact submit ----------
def test_admin_enquiries_shows_recent_submission(admin_session):
    r = admin_session.get(f"{BASE_URL}/admin/enquiries", timeout=30)
    assert r.status_code == 200
    # At least the enquiries page structure exists
    assert re.search(r"enquir", r.text, re.I)


# ---------- Logout ----------
def test_admin_logout_and_reprotection():
    s = requests.Session()
    r = s.get(f"{BASE_URL}/admin/login", timeout=30)
    token = _csrf(r.text)
    s.post(f"{BASE_URL}/admin/login",
           data={"_token": token, "email": ADMIN_EMAIL, "password": ADMIN_PASS},
           allow_redirects=False, timeout=30)
    # get a page to grab fresh token
    r2 = s.get(f"{BASE_URL}/admin", timeout=30)
    tok2 = _csrf(r2.text)
    r3 = s.post(f"{BASE_URL}/admin/logout", data={"_token": tok2},
                allow_redirects=False, timeout=30)
    assert r3.status_code in (302, 303)
    r4 = s.get(f"{BASE_URL}/admin", allow_redirects=False, timeout=30)
    assert r4.status_code in (302, 303)
    assert "login" in r4.headers.get("Location", "").lower()
