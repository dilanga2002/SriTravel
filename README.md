# SriTravel - Vehicle Rental Management System

A modern **vehicle rental booking platform** built with **Laravel 12**, featuring three user roles: Admin, Driver, and Customer.

## ✨ Features

- Advanced vehicle search with date-based availability
- Real-time driver availability checking
- Complete booking management (create, update, cancel)
- Role-based dashboards for all users
- PDF report generation (Bookings & Vehicle Usage)
- Profile management with photo upload
- Responsive Tailwind CSS design

## 🛠 Tech Stack

- Laravel 12 + PHP 8.3
- MySQL Database
- Tailwind CSS + Blade
- Barryvdh DomPDF
- Laravel Notifications

## 📸 Screenshots

![Homepage](screenshots/01-homepage.png)
![Vehicles](screenshots/02-vehicles.png)
![Booking Form](screenshots/03-booking.png)
![Admin Dashboard](screenshots/04-admin-dashboard.png)
![Driver Dashboard](screenshots/05-driver-dashboard.png)

## 🚀 Installation

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve

Default Credentials:

Admin: admin@sritravel.com / password
Driver: driver@sritravel.com / password
Customer: customer@sritravel.com / password

📁 Project Structure

app/Http/Controllers/Admin/ → Admin Panel
app/Http/Controllers/ → Customer & Driver Logic
resources/views/ → Blade Templates


Made with ❤️ for portfolio & learning purposes.
