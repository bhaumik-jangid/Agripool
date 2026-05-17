# AgriPool — Agricultural Transport Sharing Platform

A smart transport-sharing platform where farmers can create transport
requests, get matched with nearby farmers going to the same market,
share truck space, split transportation costs, track shipments, and
allow drivers and admins to manage deliveries.

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.3)
- **Frontend:** Blade Templates + Bootstrap 5 + Lucide Icons
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **Email:** Laravel Mail (Gmail SMTP)
- **ORM:** Eloquent

## Installation

```bash
git clone <repo>
cd agripool
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configure `.env` with your database and Gmail credentials, then:

```bash
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

## Test Accounts (password: `password`)

| Role   | Email                  | Status   |
|--------|------------------------|----------|
| Admin  | admin@agripool.com     | Active   |
| Farmer | ramesh@farmer.com      | Active   |
| Farmer | sunita@farmer.com      | Active   |
| Farmer | priya@farmer.com       | Active   |
| Driver | mohan@driver.com       | Approved |
| Driver | rajan@driver.com       | Approved |
| Driver | suresh@driver.com      | Pending  |

## Syllabus Coverage

| Unit | Topic | Status |
|------|-------|--------|
| I    | MVC, Laravel, Artisan | ✅ |
| II   | Routing, Responses, Redirects | ✅ |
| III  | Controllers, Blade, Middleware | ✅ |
| IV   | Request Data, Email, Sessions | ✅ |
| V    | Form Validation, CSRF | ✅ |
| VI   | Eloquent ORM, Migrations, REST API | ✅ |