# RespiraCare

RespiraCare is a web app for monitoring patients with chronic obstructive pulmonary disease (COPD). Patients record their vital signs and symptoms every day. Clinicians review the trends, follow up on patients whose readings are out of range, and manage appointments. Administrators manage accounts, site content and incoming enquiries.

It was built by Team 188 for FIT3047 (Monash University) on CakePHP 5, Tailwind CSS and Flowbite.

---

## Contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Getting started](#getting-started)
- [Configuration](#configuration)
- [Project structure](#project-structure)
- [Data model](#data-model)
- [Business rules](#business-rules)
- [Development workflow](#development-workflow)
- [Branches and deployment](#branches-and-deployment)

---

## Features

The app has three roles. After login, each role is sent to its own dashboard and layout. If a user opens a page their role is not allowed to see, the app returns **404 Not Found** rather than 403, so it does not reveal that the page exists.

### Patient

- **Daily check-in dashboard.** The day has four measurement slots: morning, midday, afternoon and evening. The dashboard shows which slots are done today, the next confirmed appointment, and the latest readings.
- **Vital-sign logging.** Patients record SpO₂, heart rate, temperature, respiratory rate, peak flow and blood pressure. Each reading needs at least one value, and all values are range-checked.
- **Skip a slot.** A patient can mark a slot as skipped. This saves a placeholder record and sends an automatic reminder to the patient's assigned clinician.
- **Symptom logging.** Patients choose one or more symptom types (for example shortness of breath, wheezing or coughing) and record a severity, a time and notes.
- **Bookings.** Patients request an appointment with a clinician and choose a 30, 45, 60 or 90 minute slot. Time slots that are already taken are greyed out.
- **Resources.** Patients can read published educational articles, videos, PDFs, guides and external links.
- **Reminders.** An in-app inbox. The latest five reminders also appear in the navbar.

### Clinician

- **Dashboard.** Shows the clinician's assigned patients (searchable), today's appointments, the reminder count and an **urgent patient** count (see [Business rules](#business-rules)).
- **Patient detail.** Shows 7-day charts of heart rate, SpO₂, temperature and respiratory rate (ApexCharts), plus paginated measurement and symptom tables with date and symptom filters.
- **Booking management.** Clinicians confirm or decline booking requests. The patient gets an email automatically either way.
- **Resources.** Clinicians create, edit and archive educational content in a rich-text editor (CKEditor 5).
- **Reminders.** Clinicians can send reminders to patients and other users.

### Administrator

- **Dashboard.** Shows totals for patients, clinicians and contact messages, 6-month trend charts for new patients and messages, and a searchable contact-message table.
- **User management.** Admins create, edit and delete patient, clinician and admin accounts, including profile pictures, and assign each patient to a clinician.
- **Patients, clinicians and bookings.** Admins see list views across the whole system and can add measurements and symptoms on a patient's behalf.
- **Contact messages.** Admins work through messages from the public contact form and move each one through the statuses `new`, `pending`, `replied` and `closed`.
- **Symptom types.** Admins maintain the list of symptoms that patients can pick from.
- **Content blocks.** Admins edit site-wide text and images (site title, logos, landing-page copy) without changing code, using the [`ugie-cake/cakephp-content-blocks`](https://packagist.org/packages/ugie-cake/cakephp-content-blocks) plugin.

### Public (not logged in)

- Landing, About, Help and Contact pages.
- A contact form protected by Cloudflare Turnstile. If the sender's email belongs to an existing patient, the message is linked to that patient.
- Login and **password reset by emailed 6-digit code**. The code is valid for 10 minutes.

### Shared

- **"Back" button that follows the user's own path through the app.** The last 10 pages visited are kept in the session, and `/go-back` returns to the previous one.
- Light and dark mode.
- Search, filter and pagination on tables update in place over AJAX, without reloading the page.

---

## Tech stack

| Layer | Technology |
| --- | --- |
| Backend | PHP ≥ 8.2, CakePHP 5.3, CakePHP Authentication 4 |
| Database | MySQL / MariaDB (the dump was produced on MariaDB 11.8) |
| Frontend | Tailwind CSS 3, Flowbite, ApexCharts, CKEditor 5 |
| Bot protection | Cloudflare Turnstile (login, password reset, contact form) |
| Email | CakePHP Mailer (SMTP in production) |
| Content management | `ugie-cake/cakephp-content-blocks` |
| Tooling | Composer, npm, PHPUnit, PHP_CodeSniffer, PHPStan / Psalm |

---

## Getting started

These steps assume a local **XAMPP** install on Windows. Any PHP 8.2+ setup with MySQL or MariaDB works the same way.

### 1. Prerequisites

- PHP 8.2 or newer with the `intl`, `mbstring`, `pdo_mysql` and `openssl` extensions
- Composer 2
- Node.js 18 or newer and npm
- MySQL 8 or MariaDB 10.6 or newer

### 2. Clone and install dependencies

```bash
git clone https://github.com/monash-yluo/fit3047_RespiraCare.git
cd fit3047_RespiraCare

composer install
npm install
```

`composer install` runs CakePHP's installer, which creates `config/app_local.php` from the example file and sets folder permissions.

### 3. Create the database

Create an empty database, for example `respiracare_db`, then import the full dump. It contains the schema and sample data:

```bash
mysql -u root -p respiracare_db < "config/schema/fit3047_respira(use this to import all data).sql"
```

You can also import it from phpMyAdmin. Only use that file. `respiraCare (readonly dont use anymore).sql` is an old version kept for reference.

### 4. Configure the app

Edit `config/app_local.php`. See [Configuration](#configuration) for the database, Turnstile and email settings.

### 5. Build the CSS

Tailwind compiles `webroot/css/tailwind-input.css` into `webroot/css/admin-app.css`:

```bash
npm run watch
```

Leave it running while you edit templates. The compiled CSS file is committed, so you only need this step when you change styles.

### 6. Run the app

You can run it in either of two ways:

- **XAMPP / Apache.** Put the project under `htdocs` and open `http://localhost/team188-app_fit3047/`. The root `.htaccess` rewrites requests to `webroot/`.
- **Built-in server:**
  ```bash
  bin/cake server -p 8765
  ```
  Then open `http://localhost:8765`.

### Sample accounts

The SQL dump includes these users. Ask the team for their passwords, or set a new one with the password-reset flow or by updating the hash directly.

| Role | Email |
| --- | --- |
| Admin | `admin@dev.u26s1188.iedev.org` |
| Clinician | `alice@dev.u26s1188.iedev.org`, `emily@dev.u26s1188.iedev.org` |
| Patient | `john@dev.u26s1188.iedev.org`, `jane@dev.u26s1188.iedev.org`, `charlie@dev.u26s1188.iedev.org` |

---

## Configuration

All secrets and environment-specific settings go in `config/app_local.php`. Git ignores this file, so never commit it. `config/app_local.example.php` is the template.

### Database

```php
'Datasources' => [
    'default' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'respiracare_db',
    ],
],
```

### Cloudflare Turnstile (required)

The login, password-reset and contact forms all check a Turnstile token. **If the keys are missing, nobody can log in.**

```php
'Turnstile' => [
    'siteKey'   => 'your-site-key',
    'secretKey' => 'your-secret-key',
],
```

For local development you can use Cloudflare's [test keys](https://developers.cloudflare.com/turnstile/troubleshooting/testing/), which always pass:

```php
'Turnstile' => [
    'siteKey'   => '1x00000000000000000000AA',
    'secretKey' => '1x0000000000000000000000000000000AA',
],
```

### Email

The app sends email for booking confirmations and declines and for password-reset codes. In development, use `DebugTransport`, which logs messages instead of sending them. In production, configure an SMTP transport:

```php
'EmailTransport' => [
    'default' => [
        'className' => 'Smtp',
        'host' => 'mail.example.com',
        'port' => 465,
        'username' => '...',
        'password' => '...',
        'tls' => true,
    ],
],
'Email' => [
    'default' => [
        'transport' => 'default',
        'from' => ['noreply@example.com' => 'RespiraCare'],
    ],
],
```

### Other settings

| Setting | Where | Notes |
| --- | --- | --- |
| `debug` | `app_local.php` / `DEBUG` env | Must be `false` in production. |
| `App.fullBaseUrl` | `APP_FULL_BASE_URL` env | **Required when `debug` is false.** `HostHeaderMiddleware` rejects requests whose Host header does not match it. |
| `App.defaultTimezone` | `APP_DEFAULT_TIMEZONE` env | Defaults to `Australia/Sydney`. |
| `Security.salt` | `SECURITY_SALT` env | Generated by `composer install`. |

---

## Project structure

```
config/
  app.php, app_local.php      App configuration (app_local is git-ignored)
  routes.php                  Custom routes, redirects for disabled actions, fallbacks
  schema/                     SQL dumps (import the "use this" file)
  Seeds/                      ContentBlocks seed data
src/
  Application.php             Middleware stack and authentication setup
  Controller/                 One controller per module (see below)
  Middleware/
    HostHeaderMiddleware      Validates the Host header in production
    ContentBlocksRoleMiddleware  Limits the ContentBlocks plugin to admins
  Model/
    Table/                    Associations and validation rules
    Entity/                   Entities and accessors
    Validation/TimeWindowValidation.php  Shared date-window validators
templates/
  layout/                     admin / clinician / patient / landing / error layouts
  element/                    Navbars, sidebars, buttons, flash messages, table widgets
  element/table/entity_tables/  Table partials re-rendered by AJAX requests
  email/                      HTML and text email templates
  <Controller>/               Page templates
webroot/
  css/tailwind-input.css      Tailwind source; compiled into admin-app.css
  js/                         Dark mode, sidebar and landing-page scripts
  img/users/                  Uploaded profile pictures (git-ignored)
tests/                        PHPUnit fixtures and test cases
```

### Controllers

| Controller | Purpose |
| --- | --- |
| `UsersController` | Login and logout, password reset by email code, admin user CRUD with avatars |
| `AdminsController` | Admin dashboard with statistics and charts |
| `CliniciansController` | Admin clinician list; clinician dashboard |
| `PatientsController` | Admin patient list, clinician's patient list, patient detail and charts, patient dashboard |
| `PatientMeasurementsController` | Vital-sign records, including skipping a slot |
| `SymptomLogsController` | Symptom records with symptom-type tagging |
| `SymptomTypesController` | Admin management of the symptom list |
| `BookingsController` | Booking requests, confirm and decline with email, booked-slot JSON feed |
| `RemindersController` | In-app messages between users; marked as read when opened |
| `ResourcesController` | Educational content, filtered by type and status |
| `ContactMessagesController` | Public contact form and admin triage |
| `AdminContentBlocksController` | Admin UI for editable site content |
| `AiInsightsController` | Per-patient risk notes (routes currently redirected away in `config/routes.php`) |
| `PagesController` | Home, About, Help and Contact |
| `AppController` | Shared role check (`checkRole`), identity and navbar reminders, back-navigation history |

---

## Data model

```
users ─┬─ 1:1 ─ patients ─┬─ patient_measurements
       │                  ├─ symptom_logs ── M:N ── symptom_types
       │                  ├─ bookings
       │                  ├─ ai_insights
       │                  └─ contact_messages (optional link)
       ├─ 1:1 ─ clinicians ─┬─ patients (assigned clinician)
       │                    └─ bookings
       └─ reminders (sender / receiver)

resources, content_blocks: standalone tables
```

| Table | Key columns |
| --- | --- |
| `users` | `first_name`, `last_name`, `email` (unique, used for login), `password` (bcrypt), `role`, `phone`, `image_path` |
| `patients` | `user_id`, `clinician_id`, `dob`, `sex`, `notes` |
| `clinicians` | `user_id`, `description` |
| `patient_measurements` | `measured_at`, `spo2`, `heart_rate`, `temperature`, `respiratory_rate`, `peak_flow`, `blood_pressure_systolic`, `blood_pressure_diastolic`, `notes` |
| `symptom_logs` | `logged_at`, `severity`, `description`, `notes` |
| `bookings` | `patient_id`, `clinician_id`, `scheduled_date`, `duration`, `status`, `notes` |
| `reminders` | `sender_id`, `receiver_id`, `message`, `is_read` |
| `resources` | `title`, `type`, `content`, `url_link`, `status`, `published_date` |
| `contact_messages` | `first_name`, `last_name`, `email`, `category`, `status`, `message`, `notes` |
| `ai_insights` | `patient_id`, `risk_level`, `description` |

---

## Business rules

### Measurement validation

| Field | Allowed range |
| --- | --- |
| SpO₂ | 50 – 100 % |
| Heart rate | 0 – 200 bpm |
| Temperature | 20 – 50 °C |
| Respiratory rate | 0 – 100 breaths/min |
| Peak flow | 0 – 1000 L/min |
| Systolic BP | 0 – 300 mmHg |
| Diastolic BP | 0 – 200 mmHg (must be lower than systolic) |

- At least one value must be filled in.
- `measured_at` cannot be in the future and cannot be more than 5 years ago. Symptom logs (`logged_at`) follow the same rule.

### Daily measurement slots

| Slot | Readings recorded between |
| --- | --- |
| Morning | 00:00 – 11:59 |
| Midday | 12:00 – 15:59 |
| Afternoon | 16:00 – 19:59 |
| Evening | 20:00 – 23:59 |

When a patient skips a slot, the app saves an empty measurement at the slot's nominal time (08:00, 12:00, 16:00 or 20:00 Sydney time) and sends a system reminder to the patient's clinician.

### Urgent patients (clinician dashboard)

A patient counts as urgent if **any** of their recorded measurements meets one of these conditions:

- SpO₂ < 80 %
- Systolic BP > 140 mmHg or diastolic BP > 90 mmHg
- Temperature > 40 °C
- Heart rate > 110 bpm or < 50 bpm

### Bookings

- The appointment must be in the future and no more than 1 year ahead.
- Duration is 30, 45, 60 or 90 minutes.
- A clinician cannot have two overlapping bookings. `/bookings/get-booked-slots/{clinicianId}` returns the taken time ranges (JSON) so the booking form can grey out those slots.
- Status is `pending`, `confirmed` or `declined`. Confirming or declining sends an email to the patient.

### Other rules

- **Patients:** the date of birth cannot be in the future or more than 120 years ago.
- **Users:** the email must be unique, and phone numbers use the Australian `+61` format.
- **Resources:** the type is Article, Video, PDF, External Link or Guide, and the status is `active`, `draft` or `archived`. Patients only see `active` resources.

---

## Development workflow

```bash
composer test        # PHPUnit
composer cs-check    # PHP_CodeSniffer (CakePHP standard)
composer cs-fix      # Fix code-style issues automatically
npm run watch        # Recompile Tailwind on change
```

The tests use the `test` datasource, which defaults to SQLite at `tmp/tests.sqlite` unless `DATABASE_TEST_URL` is set.

### Conventions

- **Access control.** Call `$this->checkRole([...])` at the top of every action. It throws a 404 for roles that are not listed.
- **Patient-owned records.** For records that belong to a patient, find the patient ID with `getPatientId()` and filter by it. Never trust an ID from the request.
- **AJAX tables.** Actions that serve AJAX tables check `$this->request->is('ajax')` and render the matching partial from `templates/element/table/entity_tables/`.
- **Disabling generated actions.** To turn off an action that bake generated, add a 301 redirect in `config/routes.php` rather than deleting the method.

---

## Branches and deployment

| Branch | Purpose |
| --- | --- |
| `main` | Main line of development |
| `dev` | Development server |
| `review` | Build for client and marker review |
| `prod` | Production |

Each deployed branch is checked out at `/srv/cpusers/u26s1188/<branch>` on the hosting server.

Before deploying to a new server:

1. Create `config/app_local.php` with production database, SMTP and Turnstile credentials, and set `debug` to `false`.
2. Set `APP_FULL_BASE_URL` to the public URL.
3. Make sure `tmp/`, `logs/`, `webroot/img/users/` and `webroot/content-blocks/uploads/` are writable by the web server.

---

## License

This is coursework for FIT3047 at Monash University. The CakePHP application skeleton is MIT-licensed.
