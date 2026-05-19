# E-Commerce Website - PHP Project

A complete, fully functional E-Commerce website built with **PHP, MySQL, HTML, CSS, Bootstrap, and JavaScript**.

## Features

### 1. User Authentication
- User Registration with email validation
- User Login / Logout
- Password hashing for security
- Session management

### 2. Admin Panel
- Admin Login
- Dashboard with statistics (Total Products, Orders, Users)
- Product Management (Add, Edit, Delete, View)
- Category Management (Add, Delete)
- Order Management with status updates (Pending, Shipped, Delivered)

### 3. Product Management
- Product listing with images
- Product categories
- Product details page
- Stock quantity tracking
- Product search and filtering

### 4. Shopping Cart
- Add products to cart (JavaScript + PHP)
- Remove items from cart
- Update quantities
- Cart persistence using sessions
- Calculate total bill

### 5. Order System
- Checkout page
- Order placement with database transaction
- Order history for users
- Order status tracking
- Order details with product information

### 6. Frontend Pages
- Responsive Home Page
- Product Listing Page
- Product Detail Page
- Shopping Cart
- Checkout Page
- User Orders Page
- About/Contact Page

### 7. Database
- 7 tables: users, admin, categories, products, orders, order_details, cart
- Proper relationships and constraints
- Foreign key relationships

## Technologies Used

| Technology | Purpose |
|-----------|---------|
| PHP | Backend server-side logic |
| MySQL | Database management |
| HTML/CSS | Frontend structure and styling |
| Bootstrap 5 | Responsive UI framework |
| JavaScript | Client-side interactivity |

## Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web Server (Apache/Nginx) or PHP Built-in Server

### Step 1: Database Setup
```bash
# Import the database
mysql -u root -p < ecommerce.sql
```

Or manually create the database:
```bash
mysql -u root -p
CREATE DATABASE ecommerce;
USE ecommerce;
# Run the SQL commands from ecommerce.sql
```

### Step 2: Configure Database Connection
Edit `includes/db.php` and update the database credentials:
```php
$host = 'localhost';
$db   = 'ecommerce';
$user = 'root';
$pass = 'your_password';
```

### Step 3: Start the Web Server
Using PHP Built-in Server:
```bash
cd ecommerce_project
php -S localhost:8000
```

Or use Apache/Nginx with the project folder as document root.

### Step 4: Access the Application
- **User Frontend**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin/login.php

## Default Admin Credentials
- **Username**: admin
- **Password**: admin123

## Project Structure

```
ecommerce_project/
├── admin/                      # Admin panel pages
│   ├── login.php              # Admin login
│   ├── dashboard.php          # Admin dashboard
│   ├── products.php           # Product management
│   ├── categories.php         # Category management
│   └── orders.php             # Order management
├── includes/                   # Shared includes
│   ├── db.php                 # Database connection
│   ├── header.php             # Header template
│   └── footer.php             # Footer template
├── assets/                     # Static files
│   ├── css/
│   │   └── style.css          # Custom CSS
│   ├── js/
│   │   └── main.js            # JavaScript functions
│   └── images/                # Product images
├── index.php                   # Home page
├── register.php                # User registration
├── login.php                   # User login
├── logout.php                  # User logout
├── product_detail.php          # Product details
├── cart.php                    # Shopping cart
├── cart_action.php             # Cart AJAX handler
├── checkout.php                # Checkout page
├── orders.php                  # User orders
├── about.php                   # About/Contact page
├── ecommerce.sql              # Database schema
└── README.md                   # This file
```

## Database Schema

### users
- id, username, password, email, created_at

### admin
- id, username, password

### categories
- id, name

### products
- id, name, price, image, description, category_id, stock_quantity

### orders
- id, user_id, total_bill, status, created_at

### order_details
- id, order_id, product_id, quantity, price

## Usage Guide

### For Users
1. **Register**: Create a new account on the registration page
2. **Browse Products**: View all products on the home page
3. **View Details**: Click on a product to see full details
4. **Add to Cart**: Add products to your shopping cart
5. **Checkout**: Proceed to checkout and place order
6. **Track Orders**: View your order history and status

### For Admins
1. **Login**: Access admin panel at `/admin/login.php`
2. **Dashboard**: View statistics and quick overview
3. **Manage Products**: Add, edit, or delete products
4. **Manage Categories**: Create and manage product categories
5. **Manage Orders**: Update order status and track shipments

## Security Features
- Password hashing using PHP's password_hash()
- SQL prepared statements to prevent SQL injection
- Session-based authentication
- CSRF protection through form handling
- Input validation and sanitization

## Error Handling
- Database connection error handling
- Form validation on both client and server side
- Try-catch blocks for transaction management
- User-friendly error messages

## Additional Requirements Met
✓ Proper CRUD Operations (Create, Read, Update, Delete)
✓ Form Validation
✓ Clean UI Design with Bootstrap
✓ Proper Database Connectivity
✓ Use of Sessions
✓ Error Handling
✓ Well-organized folder structure
✓ Complete source code included
✓ SQL database file included
✓ Responsive design

## Troubleshooting

### Database Connection Error
- Verify MySQL is running: `sudo service mysql status`
- Check credentials in `includes/db.php`
- Ensure database exists: `mysql -u root -p -e "SHOW DATABASES;"`

### Permission Issues
- Make sure the web server has write permissions to the project folder
- Check file permissions: `chmod -R 755 ecommerce_project/`

### Session Issues
- Ensure PHP session.save_path is writable
- Check PHP configuration: `php -i | grep session`

## Support
For issues or questions, please review the code comments or contact the development team.

---
**Project Version**: 1.0  
**Last Updated**: May 2026  
**Status**: Fully Functional ✓
