# Specijal Web Application

## 🔧 Project Description
This is a secure, responsive single-page application (SPA) for managing products, orders, users, categories, and reviews. It uses a RESTful API with JWT-based authentication and role-based access control.

## 📦 Technologies Used
- PHP (FlightPHP Framework)
- MySQL
- JavaScript (AJAX)
- HTML/CSS + Bootstrap
- JWT for Authentication
- PDO (Database Access)
- OpenAPI (Swagger Docs)

## 🧱 Features
- SPA with dynamic view loading (no page reloads)
- Full CRUD operations for 5 entities
- Role-based access: Admin vs User
- Client-side and server-side validation
- JWT authentication (login/register)
- OpenAPI Swagger documentation

## 🔐 Test Users
- Admin: `admin@specijal.com` / `admin123`
- User: `user@specijal.com` / `user123`

## 🔗 Deployment
> ⚠️ This project is not deployed due to last-minute technical issues. All functionality has been completed, tested locally, and is available in this repository.

## 🚀 How to Run Locally
1. Import `database/specijal_db.sql` into your local MySQL
2. Update database credentials in `backend/config/Database.php`
3. Serve backend via:
   ```bash
   php -S localhost:8000 -t backend
