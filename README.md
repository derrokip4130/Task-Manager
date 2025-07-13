# 🗂️ Task Management System – Internship Coding Challenge

## 📌 Project Overview

This is a task management system developed as part of the **Software Engineering Internship Challenge** for Cytonn Investments. The system allows administrators to manage users and assign tasks, while users can view and update their assigned tasks. Notifications are sent via email when new tasks are assigned.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 10 (PHP)
- **Database:** PostgreSQL
- **Frontend:** HTML, CSS, Vanilla JavaScript
- **Mail Testing:** Mailtrap (SMTP)
- **Hosting:** [optional live link here if available]

---

## 🚀 Features

### 👤 Admin
- Add, edit, and delete users
- Assign tasks with deadlines and statuses
- View task dashboard by user
- Email notification on task assignment

### 👥 User
- View personal tasks
- Update task status (Pending → In Progress → Completed)
- View task deadlines, with overdue tasks highlighted

---

## 🖥️ Screenshots

_Add 2–4 screenshots:_
- Admin dashboard
- Task assignment form
- Email preview from Mailtrap
- User task view with status updates

---

## ⚙️ Setup Instructions

1. **Clone the repo:**
   ```bash
    git clone https://github.com/derrokip4130/Task-Manager.git
    cd task-manager
    composer install

2. **Update database and mail credentials in .env file:**
    ```bash
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=task_manager
    DB_USERNAME=your_user
    DB_PASSWORD=your_password

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your_email@gmail.com
    MAIL_PASSWORD=your_app_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=your_email@gmail.com
    MAIL_FROM_NAME="${APP_NAME}"

3. **Run Migrations**
    ```bash
    php artisan migrate --seed

4. **Start server**
    ```bash
    php artisan serve

