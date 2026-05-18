# Team188 Fit3047 Application

This is a CakePHP 5-based respiratory health management system. It supports three roles (admin, clinician, patient) and provides user management, patient management, bookings, measurements, symptom logs, resources, reminders, contact messages, and AI insights.

## Feature Overview

- Roles and access: centralized role checks in AppController; unauthorized access returns 404.
- Shared navigation: injects identity and recent reminders into all views; supports history-based back navigation.
- Core modules: users, patients, clinicians, bookings, measurements, symptom logs, resources, reminders, contact messages, AI insights, content blocks.

## Controllers Overview

| Controller | Main Purpose | Key Actions/Notes |
| --- | --- | --- |
| AdminsController | Admin dashboard | Contact message/patient/clinician stats; chart data; AJAX table partials |
| AdminContentBlocksController | Content blocks | ContentBlocks plugin; admin-only; includes symptom type list |
| AiInsightsController | AI insights CRUD | Patient-bound basic CRUD |
| BookingsController | Booking management | Admin list; patient/clinician lists; status change and email notify |
| CliniciansController | Clinician management | Admin list/delete; clinician dashboard with patients/reminders/urgent/today |
| ContactMessagesController | Contact messages | Public contact form (Turnstile); admin review and status updates |
| ErrorController | Error pages | Renders 4xx/5xx via Error template path |
| PagesController | Static pages | home/about/help/contact pages |
| PatientMeasurementsController | Measurement records | Patient list/detail; admin view; validation and permission checks |
| PatientsController | Patient management | Admin list/detail; clinician views; charts and paginated tables |
| RemindersController | In-app reminders | Role-based filtering; mark-as-read; send reminders |
| ResourcesController | Resource content | Filtered lists; typed resources with optional external links |
| SymptomLogsController | Symptom logs | Patient/admin CRUD; date and symptom filters |
| SymptomTypesController | Symptom types | Admin add/delete types |
| UsersController | Users and auth | Login/reset; admin user management; create patient/clinician with avatars |

## Models Overview

### Tables and Associations

- Users: base account data; one-to-one with Patients and Clinicians.
- Patients: belongs to Users and Clinicians; has AiInsights, Bookings, ContactMessages, PatientMeasurements, SymptomLogs.
- Clinicians: belongs to Users; has Bookings and Patients.
- Bookings: belongs to Patients and Clinicians.
- PatientMeasurements: belongs to Patients.
- SymptomLogs: belongs to Patients; many-to-many with SymptomTypes.
- SymptomTypes: many-to-many with SymptomLogs.
- Resources: resource content table.
- Reminders: belongs to Users as sender/receiver.
- ContactMessages: optionally belongs to Patients.
- AiInsights: belongs to Patients.

### Key Validation Rules

- Users: unique email; phone in +61 format; role in admin/clinician/patient.
- Patients: DOB not in future and within 120 years; duration in 30/45/60/90.
- Bookings: scheduled date in future and within 1 year; no overlaps per clinician per day; status restricted.
- PatientMeasurements: range checks per metric; measured_at not in future and within 5 years.
- SymptomLogs: logged_at not in future and within 5 years; severity required.
- Resources: type and status restricted.
- ContactMessages: category and status restricted.
- Reminders: sender/receiver associated to Users.
- AiInsights: risk_level and description required.

## Views Overview

### Page Templates (templates/)

- Views are grouped by controller (for example Users, Patients, Clinicians, Bookings, Resources).
- Role-specific dashboards and list pages for admin/clinician/patient.
- Patient-facing views for symptoms, measurements, and bookings.

### Layouts

- admin, clinician, patient: role-specific layouts.
- landing: login and static pages.
- base/default/ajax/error: common layouts and error pages.

### Elements and Components

- Reusable navbar/sidebar/flash/button components.
- Table widgets for search, filters, pagination, and empty states.
- entity_tables contains reusable table partials per module.

### Email Templates

- Text/HTML templates for booking confirm/decline and reset code emails.

## Local Development

1. Install dependencies
	- PHP: composer install
	- Front-end: npm install
2. Start the dev server
	- bin/cake server -p 8765
3. Watch assets
	- npm run watch

## Notes

- Configure database and secrets in config/app_local.php.
- Database bootstrap SQL lives under config/schema.
