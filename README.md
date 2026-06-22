# 🧵 FaizFashion — Tailor Order Management System

<p align="center">
  <img src="public/images/logo.svg" alt="FaizFashion Logo" width="80">
</p>

<p align="center">
  <strong>A modern web-based management system for tailoring businesses</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

---

## 📋 Table of Contents

- [About the Project](#-about-the-project)
- [Key Features](#-key-features)
- [Technology Stack](#-technology-stack)
- [Prerequisites](#-prerequisites)
- [Installation Guide](#-installation-guide)
- [Usage](#-usage)
- [License](#-license)
- [Contact](#-contact)

---

## 📖 About the Project

**FaizFashion Management System** is a professional, full-featured web application built to streamline day-to-day operations for tailors, seamstresses, and small fashion boutiques. It replaces manual record-keeping with a clean digital workflow — from registering new customers and recording their body measurements, to tracking every order from intake through completion.

The system is designed for **shop owners and admin staff** who need a reliable, easy-to-use tool to manage their customer database, keep accurate measurement records for different clothing categories (tops and bottoms), and maintain full visibility over pending and completed orders. Built with Laravel 12 and a polished Tailwind CSS interface, it delivers a smooth, responsive experience on both desktop and mobile devices.

---

## ✨ Key Features

- **Admin Dashboard** — At-a-glance statistics (total customers, pending orders, completed orders, total orders), interactive monthly trend chart, status breakdown doughnut chart, and a recent pending orders table.
- **Customer Management** — Full CRUD for customer profiles including name, gender, phone number, and address. Search by name and filter by gender or clothing category.
- **Body Measurement Records** — Store per-customer, per-category measurements. Tops (Atasan): panjang, lingkar badan, lingkar pinggang, punggung, panjang lengan. Bottoms (Bawahan): panjang pinggang, pinggul, pisak, pangkal paha. Each size record supports free-text notes.
- **Order Lifecycle** — Create orders for existing or new customers in a single flow. Orders move from **Pending** to **Selesai** (completed) with one click.
- **Order History** — Dedicated history view for completed orders with search, pagination, and detail pages.
- **Quick Order Creation** — Two modes: select an existing customer and their saved measurements, or create a brand-new customer with measurements and order in one transaction.
- **Interactive Alerts** — SweetAlert2 confirmations on destructive actions and toast notifications for success/error feedback.
- **Responsive Design** — Mobile-first layout with collapsible sidebar, smooth transitions, and Alpine.js interactivity.
- **Role-Based Access** — Admin middleware ensures only authorized users can access the system.

---

## 🛠 Technology Stack

| Layer           | Technologies                                                                                                                          |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| **Backend**     | [Laravel 12](https://laravel.com/) · PHP 8.2+                                                                                         |
| **Frontend**    | [Tailwind CSS 3](https://tailwindcss.com/) · [Alpine.js 3](https://alpinejs.dev/) · [Blade Templates](https://laravel.com/docs/blade) |
| **Database**    | MySQL 8.0+                                                                                                                            |
| **Charts**      | [Chart.js 4](https://www.chartjs.org/)                                                                                                |
| **Icons**       | [Bootstrap Icons](https://icons.getbootstrap.com/)                                                                                    |
| **Alerts**      | [SweetAlert2](https://sweetalert2.github.io/) · [realrashid/sweet-alert](https://github.com/realrashid/sweet-alert)                   |
| **Auth**        | [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)                                                                |
| **Build Tools** | [Vite 7](https://vitejs.dev/) · npm                                                                                                   |
| **Testing**     | [Pest](https://pestphp.com/)                                                                                                          |

---

## 📌 Prerequisites

Make sure the following tools are installed on your machine before proceeding:

| Tool         | Minimum Version | Purpose                              |
| ------------ | --------------- | ------------------------------------ |
| **PHP**      | 8.2+            | Runtime                              |
| **Composer** | 2.x             | PHP dependency manager               |
| **MySQL**    | 8.0+            | Database server                      |
| **Node.js**  | 20+             | Frontend build tooling               |
| **npm**      | 9+              | Package manager (ships with Node.js) |
| **Git**      | 2.x             | Version control                      |

---

## 🚀 Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/afiffaizin/MenejemenPesanan-FaizFashion.git
cd MenejemenPesanan-FaizFashion
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies & Build Assets

```bash
npm install
npm run build
```

### 4. Configure Environment Variables

```bash
cp .env.example .env
```

Open `.env` and update the database settings to match your local setup:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=menejemen_pesanan
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create the Database

Create the MySQL database manually before running migrations:

```sql
CREATE DATABASE menejemen_pesanan;
```

### 7. Run Migrations & Seed Data

```bash
php artisan migrate --seed
```

This creates all tables and seeds a default admin account. To also populate the database with 60+ realistic sample customers, sizes, and orders:

```bash
php artisan db:seed --class=SampleDataSeeder
```

### 8. Start the Development Server

```bash
php artisan serve
```

The application will be available at **[http://localhost:8000](http://localhost:8000)**.

> **Tip:** For a full development experience with hot-reload, run the Vite dev server alongside Laravel:
>
> ```bash
> # Terminal 1
> php artisan serve
>
> # Terminal 2
> npm run dev
> ```
>
> Or use the built-in composer script that starts everything concurrently:
>
> ```bash
> composer dev
> ```

---

## 💡 Usage

### Default Login Credentials

| Field        | Value             |
| ------------ | ----------------- |
| **Email**    | `admin@gmail.com` |
| **Password** | `password`        |

### Basic Workflow

1. **Log in** with the admin credentials above.
2. **Dashboard** — Review pending queue counts, monthly trends, and recent orders.
3. **Customers** — Add new customers with their body measurements, or browse/search/filter existing ones.
4. **Tambah Pesanan (Add Order)** — Create an order by selecting an existing customer and one of their saved sizes, or register a new customer with measurements and create the order in one step.
5. **Manage Orders** — Mark pending orders as completed, view order details, or delete orders.
6. **History** — Browse all completed orders with search and pagination.

### URL Reference

| URL               | Description                                |
| ----------------- | ------------------------------------------ |
| `/dashboard`      | Admin dashboard with statistics and charts |
| `/order`          | Active orders list and order creation      |
| `/orders/history` | Completed orders history                   |
| `/customer`       | Customer directory                         |
| `/customer/{id}`  | Customer detail with size records          |

---

## 📄 License

This project is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 📬 Contact

**Afif Faizin** — Developer & Maintainer

|            |                                                           |
| ---------- | --------------------------------------------------------- |
| **Email**  | [afiffaizin758@gmail.com](mailto:afiffaizin758@gmail.com) |
| **GitHub** | [github.com/afiffaizin](https://github.com/afiffaizin)    |

---

<p align="center">
  Built to empower tailoring businesses with better customer management.
</p>
