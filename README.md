# SriTravel - Vehicle Rental Management System

A modern, full-featured **vehicle rental booking platform** built with **Laravel 12**. Supports three user roles: Admin, Driver, and Customer.

## ✨ Features

- Advanced vehicle search with date availability filter
- Real-time driver availability checking
- Complete booking management (Create, Update, Cancel)
- Role-based dashboards (Customer, Driver, Admin)
- PDF Report Generation (Bookings & Vehicle Usage)
- Profile photo upload system
- Responsive Tailwind CSS design

## 🛠 Tech Stack

- Laravel 12 + PHP 8.3
- MySQL
- Tailwind CSS
- Barryvdh DomPDF
- Laravel Breeze Authentication

## 📸 Screenshots

![Homepage](image.png)
![Vehicles](image-4.png)
![Booking Form](image-3.png)
![Admin Dashboard](image-1.png)
![Driver Dashboard](image-2.png)

## 🚀 Installation

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
