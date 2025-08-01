# Basic Task Management System (Laravel Filament + REST API)

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![Filament](https://img.shields.io/badge/Filament-3-D82462?style=for-the-badge)
![Pest](https://img.shields.io/badge/Pest-✓-CC243D?style=for-the-badge&logo=pest)

A simple task management application built with Laravel. This project features a powerful Admin Panel built with **Filament** and a secure REST API utilizing **Laravel Sanctum**.

This project was created as a case study to implement best practices in Laravel application development, including clean architecture, authorization, testing, and API documentation.

---
## ✨ Key Features
- **Admin Panel**: A comprehensive administrator interface to manage Tasks, Categories, and Priorities using **Laravel Filament**.
- **REST API**: Secure API endpoints for CRUD operations on tasks.
- **Authentication**: Token-based authentication system using **Laravel Sanctum**.
- **Authorization**: Use of **Laravel Policies** to ensure users can only access their own data.
- **Validation**: Separate request validation using **Form Requests**.
- **Testing**: Comprehensive feature tests using **Pest** to ensure API reliability.
- **API Documentation**: Interactive documentation automatically generated using **Swagger (OpenAPI)**.

---
## 🚀 Tech Stack
- **Backend**: Laravel 11
- **Admin Panel**: Filament 3
- **API Authentication**: Laravel Sanctum
- **Database**: MySQL and SQLite for testing)
- **Testing Framework**: Pest

---
## 🛠️ Installation & Setup
Here are the steps to get this project running locally.

**Prerequisites:**
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- A database (MySQL/PostgreSQL)

**Steps:**
1.  **Clone this repository:**
    ```bash
    git clone [https://github.com/YOUR_USERNAME/YOUR_REPOSITORY.git](https://github.com/YOUR_USERNAME/YOUR_REPOSITORY.git)
    cd YOUR_REPOSITORY](https://github.com/rrafliadytm/basic-task-management-system-app.git)
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Setup Environment File:**
    Copy the `.env.example` file to `.env` and configure your database connection.
    ```bash
    cp .env.example .env
    ```
4. **Open the `.env` file and set your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.**
   Example
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=task_management_sytem
    DB_USERNAME=root
    DB_PASSWORD=
   ```

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations & Seeders:**
    This command will create all database tables and fill them with initial data (admin user, categories, etc.).
    ```bash
    php artisan migrate --seed
    ```

6.  **Run the development server:**
    ```bash
    php artisan serve
    or
    composer run dev
    ```
    The application is now running at `http://localhost:8000`.

---
## ⚙️ Usage

### Admin Panel (Filament)
- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@email.com`
- **Password**: `12345678`

### REST API
To interact with the API, you must first authenticate to get a token.

1.  **Login**: Send a `POST` request to `http://localhost:8000/api/login` with your previous `email` and `password`.
2.  **Use the Token**: Copy the token you receive and include it in the header of your subsequent requests:
    `Authorization: Bearer <YOUR_TOKEN>`

---
## 📚 API Documentation (Swagger)
Complete and interactive API documentation is available after you run the server.
- **URL**: `http://localhost:8000/api/documentation`

---
## ✅ Running Tests
This project includes automated tests to ensure that all API functionalities work correctly.

To run the entire test suite, use the command:
```bash
php artisan test
```
