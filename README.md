<div align="center">

# Justo Sierra Academic Engagement Platform

### Portfolio Demo

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

Multi-role platform for academic engagement, community service, internships, vacancies, and student applications.

</div>

## Overview

This portfolio demo centralizes the interaction between students, participating companies, and university administrators. It provides role-specific dashboards for opportunity discovery, applications, vacancy management, document workflows, and process tracking.

All names, accounts, companies, vacancies, and records included in this repository are fictional demonstration data.

## Features

### Students

- Registration and secure authentication
- Academic profile, profile photo, and CV management
- Vacancy search and filtering
- Application submission and status tracking
- Multi-stage community service workflow

### Companies

- Registration and company profile management
- Vacancy creation, editing, duplication, and closing
- Applicant review, status updates, and internal notes
- Applicant export to CSV
- Vacancy view and conversion metrics

### Administrators

- Separate student-services and engagement roles
- Student, company, vacancy, and application management
- Company validation and catalog workflow
- CSV bulk import and operational exports
- Search, filters, pagination, and dashboards

## Security Implemented

- Password hashing with PHP's password API
- PDO prepared statements
- CSRF protection on key forms
- Session regeneration after authentication
- Role-based access control
- Login attempt limiting and temporary lockout
- File type, extension, and size validation
- HTML output escaping

## Project Structure

```text
admin/          Administration areas
companies/      Company portal
students/       Student portal
config/         Environment, database, and security configuration
controllers/    Shared controllers
views/          Shared views
assets/         Stylesheets
database/       Sanitized demo schema and seed data
```

## Requirements

- PHP 8.1 or newer
- MySQL 8 or MariaDB 10.4 or newer
- Apache with `mod_headers` enabled
- PHP extensions: PDO MySQL and Fileinfo

## Local Installation

1. Clone the repository inside your local web server directory.
2. Import `database/demo_schema.sql` with phpMyAdmin or the MySQL client.
3. Copy `.env.example` to `.env`.
4. Update the database values in `.env` if necessary.
5. Start Apache and MySQL.
6. Open the project URL, for example `http://localhost/Justo-Sierra2-Demo/`.

## Demo Accounts

All demo accounts use the password `Demo123!`.

| Role | Email or username |
| --- | --- |
| Student | `student@demo.local` or `DEMO001` |
| Company | `company@demo.local` |
| Engagement administrator | `admin.engagement@demo.local` |
| Student-services administrator | `admin.students@demo.local` |

These credentials are public and intended only for local demonstration. Replace or remove them before deploying the application.

## Privacy

The original academic data, credentials, uploaded CVs, profile photos, and institutional documents are not included. Runtime upload folders are retained with `.gitkeep` files and ignored by Git.

## Author

**Ernesto Gomez Romero**  
Computer Systems Engineering Graduate

[LinkedIn](https://www.linkedin.com/in/ernesto-g%C3%B3mez-romero-4398a541a/) | [Email](mailto:ernestogomez.ing@gmail.com)
