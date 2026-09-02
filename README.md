# MediCore Hospital Management System
Modern PHP + MySQL Hospital Management System.

## Stack
- PHP 8+
- MySQL / MariaDB
- HTML5, CSS3, JavaScript
- Bootstrap 5
- Font Awesome
- PDO prepared statements
- Session-based authentication

## Included Modules
Dashboard, Patients, Doctors, Departments, Appointments, Admissions, Pharmacy, Billing, Login/Logout, Dark Mode.

## XAMPP Installation
1. Extract the folder into:
   `C:\xampp\htdocs\hospital-management-system-modern`
2. Open XAMPP and start **Apache** and **MySQL**.
3. Open phpMyAdmin.
4. Import:
   `database/hospital_management.sql`
5. Check `config/db.php`.
   Default XAMPP values:
   - host: localhost
   - database: hospital_management
   - user: root
   - password: empty
6. Open:
   `http://localhost/hospital-management-system-modern/setup.php`
7. Setup creates the first admin user.
8. Then login at:
   `http://localhost/hospital-management-system-modern/login.php`

## Default Admin
- Email: `admin@hospital.local`
- Password: `Admin@123`

Change the password after your demo/project review.

## Important
The project uses root-relative links with folder name:
`/hospital-management-system-modern/`

If you rename the project folder, update that path in:
- `includes/auth.php`
- `includes/header.php`
- `includes/sidebar.php`

## Security Included
- `password_hash()` / `password_verify()`
- Prepared PDO statements
- Session regeneration on login
- HTML escaping helper
- Protected dashboard pages

## Academic Project Notes
This starter follows the supplied Hospital Management System documentation: PHP/MySQL stack, responsive dashboard, patient/doctor/appointment/admission/billing/pharmacy modules, and modern hospital-themed UI.

## Public Patient Website Added
The project now includes a complete public-facing hospital website in addition to the staff dashboard:
- Home
- About
- Departments (database driven)
- Services
- Doctors (database driven search/filter)
- Online Appointment booking
- Testimonials
- FAQ
- Gallery
- Contact form
- More Pages / Dropdown navigation

### Public Website URL (Local)
`http://localhost/hospital-management-system-modern/`

### Staff/Admin Login
`http://localhost/hospital-management-system-modern/login.php`

Online appointment requests are inserted directly into the existing `appointments` table. If a patient phone/email does not already exist, a basic patient record is automatically created first. Contact form submissions are saved to `contact_messages`.

## Patient Portal Update
The public visitor can access only the landing page plus Patient Login/Register. After login, the patient is redirected to a private panel showing only records linked to their `patient_id`.

### Patient Flow
1. Open `http://localhost/hospital-management-system-modern/`
2. Click **Create Account** or **Patient Login**.
3. Register a patient account.
4. After login, the patient sees **My Panel** only.
5. The patient can book an appointment from the portal.
6. New requests start as `pending`.
7. Admin/staff can update the appointment from the existing admin Appointment module to `confirmed`, `completed`, or `cancelled`.
8. The patient panel automatically shows that updated status.

### If you already imported the older database
Import `database/upgrade_patient_portal.sql` once in phpMyAdmin.

### Separate Logins
- Patient Login: `/patient/login.php`
- Patient Register: `/patient/register.php`
- Patient Panel: `/patient/dashboard.php`
- Admin/Staff Login: `/login.php`
