# SriTravel - Vehicle Rental Management System

A modern, full-featured vehicle rental booking platform built with **Laravel 12**. It supports three user roles: **Admin**, **Driver**, and **Customer** with complete booking lifecycle management.

## ✨ Features

### **Customer Features**
- Browse available vehicles with advanced filters (type, price, date availability)
- Real-time driver availability checking
- Book vehicles with pickup/dropoff details
- View and manage personal bookings (cancel/update)
- Customer dashboard with current & past bookings
- Profile management with photo upload

### **Driver Features**
- Dedicated driver dashboard
- View today's assignments and upcoming trips
- Mark bookings as completed
- Driver profile with license & photo

### **Admin Features**
- Complete admin panel with sidebar navigation
- Manage Vehicles, Drivers, Customers
- Booking approval & status management
- Generate PDF reports (Bookings & Vehicle Usage)
- Revenue & utilization statistics
- User management (CRUD)

### **Technical Features**
- Role-based authentication & middleware
- Smart availability checking (prevents double booking)
- Image upload with old file cleanup
- PDF report generation (DomPDF)
- Responsive Tailwind CSS design
- Form validation & error handling
- Activity logging

## 🛠 Tech Stack

- **Backend**: Laravel 12, PHP 8.3
- **Frontend**: Blade Templates, Tailwind CSS, Font Awesome
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **PDF**: Barryvdh\DomPDF
- **Images**: Custom ImageUploadService
- **Date Handling**: Carbon

## 📸 Screenshots

- Homepage  (![alt text](image.png))
- Vehicle Listing with Filters (![alt text](image-4.png)) 
- Booking Form (![alt text](image-3.png))
- Admin Dashboard (![alt text](image-1.png))
- Driver Dashboard (![alt text](image-2.png))

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.3+
- Composer
- MySQL
- Node.js & npm

### Steps

1. **Clone the repository**
   
   git clone https://github.com/yourusername/sritravel.git
   cd sritravel

2. **Install dependencies**

   composer install
   npm install && npm run dev

3. **Setup environment**

   cp .env.example .env

4. **Generate application key**

   php artisan key:generate

5. **Configure database (update .env)**

   DB_DATABASE=sritravel
   DB_USERNAME=root
   DB_PASSWORD=

6. **Run migrations & seeders**

   php artisan migrate --seed
   php artisan storage:link

7. **Start the server**

   php artisan serve

### 📋 Default Login Credentials

  -Admin
   Email: admin@sritravel.com
   Password: password

  -Driver
   Email: driver@sritravel.com
   Password: password

  -Customer
   Email: customer@sritravel.com
   Password: password

### 📄 License

    This project is for educationa.