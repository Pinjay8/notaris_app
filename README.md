# Laravel 11 Basic Setup

Proyek ini dibangun menggunakan **Laravel 11**.  
Berikut adalah langkah-langkah dasar untuk menjalankan aplikasi ini di local development.

---

## 🚀 Persiapan

Pastikan sudah terinstall:

-   PHP >= 8.2
-   Composer
-   MySQL / MariaDB
-   Node.js & NPM (jika ada frontend asset)

---

## ⚙️ Instalasi

1.  **Clone Repository**
    `
    git clone https://github.com/username/repository.git
    cd repository
    composer install
    npm install   # jika menggunakan vite/laravel mix
    `
    cp .env.example .env
    php artisan key:generate
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=root
    DB_PASSWORD=
    php artisan migrate:fresh --seed

2.  **Run Development Server**
    `php artisan serve`
    `npm run dev`
