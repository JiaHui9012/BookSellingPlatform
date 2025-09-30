# Book Selling Platform

A Laravel-based book selling platform with role-based access control using Spatie Laravel Permission and handling media files using Spatie Media. 

## Requirements

- PHP >= 8.1 (https://windows.php.net/download/)
- Composer (https://getcomposer.org/download/)
- MySQL
- Laravel 10+


## Installation

1. Clone the repository / Download and unzip the files

```bash
git clone https://github.com/JiaHui9012/BookSellingPlatform.git
cd BookSellingPlatform
```

2. Install dependencies

```bash
composer install
```

3. Create Database

```bash
CREATE DATABASE book_selling_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Setup environment file

```bash
cp .env.example .env
```
Configure your database, mail, and other settings inside .env.

5. Generate application key

```bash
php artisan key:generate
```

6. Run migrations & seeders

```bash
php artisan migrate --seed
```
- This will create database required tables.

- Seeders will automatically create:
    - Default admin user 
        - username: admin_1
        - password: 1234qweR

    - Roles: Admin, Seller, User(Buyer)

    - Permissions

7. Link Storage (for images/media)

```bash
php artisan storage:link
```

8. Run the application

```bash
php artisan serve
```
Visit: http://localhost:8000

## User Roles

**Admin**

- Manage users

- Manage categories & Assign book categories

- Approve/Reject sellers

**Seller**

- Manage own books

- Upload covers

- Set stock & price

**User (Buyer)**

- View books

(Future: place orders, wishlist, etc.)

## For More

View [Book Selling Platform Documentation](https://docs.google.com/document/d/1Um8Fbbmbd8Ov936dxeHyrtzELO4GNJ0y8I8TDgpn9nE/edit?usp=sharing)

