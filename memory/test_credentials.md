# Test Credentials — Mahaveer Hospital CMS

## Admin Panel
- **URL**: https://website-theme-1.preview.emergentagent.com/admin/login
- **Email**: `admin@mahaveerhospital.com`
- **Password**: `Admin@12345`

## Database (local)
- **DB Name**: `mahaveer_cms`
- **User**: `laravel`
- **Password**: `laravel_secret`
- **Host**: `127.0.0.1:3306`

## Notes
- Admin can be created via /app/laravel/database/seeders (AdminSeeder). Re-seed with `php artisan db:seed --class=AdminSeeder`.
- Password is hashed with bcrypt; change via a `php artisan tinker` snippet if forgotten.
