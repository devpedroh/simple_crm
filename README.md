# 📌 Basic Registration System

A simple system for managing customers, suppliers, products, and sales, built with **Laravel 11**, **Vue.js 2**, and **Vuetify 2**.

## 🚀 Technologies Used
- **Backend:** Laravel 11
- **Frontend:** Vue.js 2 + Vuetify 2
- **Database:** MySQL / SQLite / PostgreSQL (configurable by user)

## 📥 Installation Guide

### 1️⃣ Clone the repository
```sh
git clone https://github.com/devpedroh/simple_crm.git
cd simple_crm
```

### 2️⃣ Install dependencies
#### Backend (Laravel)
```sh
composer install
```

#### Frontend (Vue.js)
```sh
npm install
```

### 3️⃣ Configure the environment
1. Copy the example environment file:
   ```sh
   cp .env.example .env
   ```
2. Open `.env` and configure the **database connection** (MySQL, PostgreSQL, or SQLite):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_user
   DB_PASSWORD=your_password
   ```
3. Generate the application key:
   ```sh
   php artisan key:generate
   ```

### 4️⃣ Run migrations and seed the database
```sh
php artisan migrate --seed
```

### 5️⃣ Start the development servers
#### Backend (Laravel)
```sh
php artisan serve
```
#### Frontend (Vue.js)
```sh
npm run dev
```

## ✅ Features
- CRUD operations for **customers, suppliers, products, and sales**
- Responsive interface with Vuetify 2
- Simple and easy-to-use UI
- Fully configured database migrations and seeders

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).

---

💡 **Developed by [Pedro Henrique](https://github.com/devpedroh/)**

