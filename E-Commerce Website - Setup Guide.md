# E-Commerce Website - Setup Guide

## Complete Installation Instructions

### System Requirements
- **OS**: Linux, Windows, or macOS
- **PHP**: 7.4 or higher with PDO MySQL extension
- **MySQL**: 5.7 or higher (or MariaDB 10.3+)
- **Web Server**: Apache 2.4+ or Nginx (or use PHP built-in server)
- **Browser**: Modern browser (Chrome, Firefox, Safari, Edge)

### Step-by-Step Installation

#### 1. Download and Extract Project
```bash
# Extract the project zip file
unzip ecommerce_project.zip
cd ecommerce_project
```

#### 2. Install PHP and MySQL (if not already installed)

**On Ubuntu/Debian:**
```bash
sudo apt-get update
sudo apt-get install php php-mysql php-cli php-fpm
sudo apt-get install mysql-server
```

**On macOS (using Homebrew):**
```bash
brew install php mysql
brew services start mysql
```

**On Windows:**
- Download PHP from https://www.php.net/downloads
- Download MySQL from https://dev.mysql.com/downloads/mysql/
- Install both following their respective installers

#### 3. Start MySQL Service

**Linux:**
```bash
sudo service mysql start
# or
sudo systemctl start mysql
```

**macOS:**
```bash
brew services start mysql
```

**Windows:**
- MySQL should auto-start or start from Services

#### 4. Create Database

**Option A: Using SQL File (Recommended)**
```bash
mysql -u root -p < ecommerce.sql
```

**Option B: Manual Creation**
```bash
mysql -u root -p
```

Then in MySQL prompt:
```sql
CREATE DATABASE ecommerce;
USE ecommerce;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    description TEXT,
    category_id INT,
    stock_quantity INT DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_bill DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO admin (username, password) VALUES ('admin', 'admin123');
```

#### 5. Configure Database Connection

Edit `includes/db.php`:
```php
$host = 'localhost';
$db   = 'ecommerce';
$user = 'root';
$pass = 'your_mysql_password';  // Change this to your MySQL password
$charset = 'utf8mb4';
```

#### 6. Start Web Server

**Using PHP Built-in Server (Easiest for Development):**
```bash
php -S localhost:8000
```

**Using Apache:**
```bash
# Copy project to Apache document root
sudo cp -r ecommerce_project /var/www/html/

# Enable mod_rewrite if needed
sudo a2enmod rewrite

# Restart Apache
sudo systemctl restart apache
```

**Using Nginx:**
```bash
# Configure Nginx server block
sudo nano /etc/nginx/sites-available/ecommerce

# Add server configuration and restart
sudo systemctl restart nginx
```

#### 7. Access the Application

**User Frontend:**
- URL: http://localhost:8000
- Or: http://your-domain.com

**Admin Panel:**
- URL: http://localhost:8000/admin/login.php
- Default Username: `admin`
- Default Password: `admin123`

### Verification Checklist

- [ ] MySQL service is running
- [ ] Database `ecommerce` exists with all tables
- [ ] PHP can connect to MySQL
- [ ] Web server is running
- [ ] Can access http://localhost:8000
- [ ] Can register a new user
- [ ] Can login with admin credentials
- [ ] Can view products on home page
- [ ] Can add products to cart
- [ ] Can place an order

### Troubleshooting

#### Issue: "Connection refused" when accessing website
**Solution:**
- Check if web server is running: `php -S localhost:8000`
- Check firewall settings
- Verify port 8000 is not in use: `lsof -i :8000`

#### Issue: "SQLSTATE[HY000]: General error: 1030"
**Solution:**
- Restart MySQL: `sudo service mysql restart`
- Check disk space: `df -h`
- Check MySQL error log: `sudo tail -f /var/log/mysql/error.log`

#### Issue: "Access denied for user 'root'@'localhost'"
**Solution:**
- Verify MySQL password in `includes/db.php`
- Reset MySQL password if forgotten
- Check MySQL user permissions: `mysql -u root -p -e "SELECT user, host FROM mysql.user;"`

#### Issue: "Class 'PDO' not found"
**Solution:**
- Install PHP PDO extension: `sudo apt-get install php-pdo php-mysql`
- Restart PHP/web server

#### Issue: "Session data not persisting"
**Solution:**
- Check PHP session directory is writable: `php -i | grep session.save_path`
- Set permissions: `chmod 777 /var/lib/php/sessions`

#### Issue: "Products not showing on home page"
**Solution:**
- Verify database connection in `includes/db.php`
- Check if products table has data
- Review browser console for JavaScript errors

### Post-Installation

#### 1. Change Admin Password
```sql
UPDATE admin SET password='your_new_password' WHERE username='admin';
```

#### 2. Add Sample Products
```sql
INSERT INTO categories (name) VALUES ('Electronics');
INSERT INTO categories (name) VALUES ('Clothing');

INSERT INTO products (name, price, description, category_id, stock_quantity, image) 
VALUES ('Laptop', 999.99, 'High-performance laptop', 1, 10, 'https://via.placeholder.com/300');

INSERT INTO products (name, price, description, category_id, stock_quantity, image) 
VALUES ('T-Shirt', 19.99, 'Comfortable cotton t-shirt', 2, 50, 'https://via.placeholder.com/300');
```

#### 3. Enable HTTPS (Production)
- Get SSL certificate from Let's Encrypt
- Configure web server for HTTPS
- Update all URLs to use https://

#### 4. Set Up Email Notifications (Optional)
- Configure PHP mail or SMTP
- Add email notifications for orders

#### 5. Backup Database Regularly
```bash
mysqldump -u root -p ecommerce > backup_$(date +%Y%m%d).sql
```

### Performance Optimization

1. **Enable Caching**
   - Add Redis or Memcached for session storage
   - Implement query result caching

2. **Database Optimization**
   - Add indexes on frequently queried columns
   - Optimize database queries

3. **Frontend Optimization**
   - Minify CSS and JavaScript
   - Compress images
   - Enable gzip compression

4. **Security Hardening**
   - Use prepared statements (already implemented)
   - Add CSRF tokens to forms
   - Implement rate limiting
   - Add input validation

### Deployment to Production

1. **Choose Hosting Provider**
   - Shared hosting (cPanel, Plesk)
   - VPS (DigitalOcean, Linode)
   - Cloud (AWS, Google Cloud, Azure)

2. **Upload Files**
   - Use FTP/SFTP to upload project
   - Or use Git for version control

3. **Configure Environment**
   - Update database credentials
   - Set proper file permissions
   - Configure SSL certificate

4. **Test Thoroughly**
   - Test all user flows
   - Test admin functions
   - Test payment processing (if applicable)

### Support Resources

- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- Bootstrap Documentation: https://getbootstrap.com/docs/
- MDN Web Docs: https://developer.mozilla.org/

---

**Setup Version**: 1.0  
**Last Updated**: May 2026
