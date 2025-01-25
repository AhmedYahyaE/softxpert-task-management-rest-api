# Softxpert Task Management System REST API

This is a RESTful API for a Task Management System built using Laravel 11. It provides various functionalities such as task creation, updates, task dependencies, filtering tasks, and role-based access control (RBAC). The API uses Laravel Sanctum for stateless authentication and Spatie Laravel Permission package for role-based permissions.

## Technical Features

This appliction features stateless authentication using Laravel Sanctum, RBAC using Spatie Laravel Permission package, API Versioning, API Resource classes, Resource Collection classes, Database Transactions, PHP Enums, Design Patterns (Repository pattern, Service pattern, etc.), Factories & Seeders, Form Request classes, Exception & Error Handling, Policy classes, clean Git branching and commit messages, Docker containerization, Unit Tests, and Task Filtering, Task Dependencies management.
API endpoints tested using Postman.

## Installation Instructions

Follow the steps below to set up and run the application locally.

### Steps to Install

1. **Clone the repository**:
    ```bash
    git clone https://github.com/AhmedYahyaE/softxpert-task-management-rest-api.git
    cd softxpert-task-management-rest-api-main
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Set up the environment file**:
    Copy `.env.example` to `.env`:
    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**:  
    This step generates a unique application key for encryption:  
    ```bash
    php artisan key:generate
    ```

5. **Configure the database**:
    Open the `.env` file and set your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

6. **Migrate the database**:
    Run the migrations to create the necessary tables:
    ```bash
    php artisan migrate
    ```

7. **Seed the database**:
    ```bash
    php artisan db:seed
    ```

8. **Install frontend dependencies**:
    ```bash
    npm install
    ```

9. **Build Vite assets** (for frontend):
    ```bash
    npm run build
    ```

10. **Start the Laravel development server**:
    ```bash
    php artisan serve
    ```

Now, your application should be running locally at `http://localhost:8000`. To experiment with the application, login through the POST /api/v1/login endpoint using the two (different) role users:
- A 'manager' role user: Email: ahmed.yahya@email.com, Password: 123456
- A 'user' role user: Email: ayman.fathy@email.com, Password: 123456

## Task Management API:

Note : Make sure to include the "Accept: application/json" Header with all your requests.

Check my Postman Collection of the API on: https://www.postman.com/ahmed-yahya/my-public-portfolio-postman-workspace/collection/yb4gae4/softxpert-task-management-rest-api

## Task Attachments:

Check the ERD of the database file, API Postman Collection files in [Task Attachments](<Task Attachments>) directory.

N.B. Initial Docker containerization is implemented in [Docker Containerization](<Docker Containerization>) directory.
