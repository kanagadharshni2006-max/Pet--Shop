# Paws & Claws - Pet Shop E-Commerce

A modern, responsive e-commerce web application specifically designed for pet shops to showcase pet supplies, accessories, medicines, grooming products, and process adoptions/sales for pets.

## Features

- **Dynamic Storefront:** Explore different categories for pet products and browse available pets for adoption and sale.
- **Cart & Checkout Simulation:** Add items to cart, manage quantities, and seamlessly navigate a robust checkout flow mimicking both COD and Online payments. 
- **User Authentication:** Fully functional registration and login systems mapping directly to a MySQL database, with encrypted passwords securely maintained via sessions.
- **User Profiles:** A dashboard mapping your active profile details, order history overview, and wishlist summaries.
- **Admin Dashboard:** A robust internal panel designed to track total sales, moderate users, and manage product/pet data tables.
- **Modern UI:** Built exclusively with a soft, pet-friendly color palette, Google Fonts (Outfit, Nunito), and Bootstrap 5 for comprehensive mobile responsiveness.

## Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5 
- **Backend:** PHP 8+
- **Database:** MySQL (via PDO)

## Setup & Installation

### Requirements
- XAMPP/WAMP/MAMP (or any Apache & MySQL server stack)
- PHP 8.0 or newer

### Steps

1. **Clone/Move Project:** Place this entire repository into your local web server document root directory (e.g., `C:\xampp\htdocs\pet shop`).
2. **Start Services:** Open your XAMPP Control Panel (or equivalent) and ensure **Apache** and **MySQL** are running.
3. **Database Configuration:**
   - The project requires a database named `pet_shop`. 
   - Ensure the database connection parameters inside `includes/db.php` match your local MySQL configuration (Default: user `root` with password `pass`, or adjust as needed).
4. **Database Initialization:** 
   - A convenient script `setup.php` is included in the root directory. 
   - Navigate to `http://localhost/pet shop/setup.php` in your browser. This will automatically execute the necessary SQL to initialize the `pet_shop` database and generate the `users` table. 
   - *(Optional but recommended)* You can delete `setup.php` after running it once.
5. **Run the Application:** 
   - Access the platform by visiting `http://localhost/pet shop/index.php`.

## Project Structure

```text
├── admin/                 # Administrator Dashboard & CRUD files
│   ├── layout/            # Admin partials (sidebar, header)
│   ├── index.php          # Admin Stats & Summary
│   ├── orders.php         # Manage orders UI
│   ├── pets.php           # Manage pets UI
│   ├── products.php       # Manage products UI
│   └── users.php          # Manage users UI
├── assets/                # Static assets (CSS, JS)
│   ├── css/style.css      # Core theme stylings
│   └── js/main.js         # UI interactions
├── includes/              # Shared PHP partials
│   ├── db.php             # Establishing MySQL connection
│   ├── footer.php         # Global footer
│   └── header.php         # Global navigation 
├── cart.php               # Shopping Cart overview
├── checkout.php           # Payment processing simulation
├── index.php              # Homepage / Hero
├── login.php              # Secure login 
├── logout.php             # Closes Session
├── pets.php               # Adoption/Buy catalog
├── products.php           # Merchandise catalog
├── profile.php            # User dashboard
├── register.php           # Secure signup form
└── setup.php              # Initialization script for database
```

## License

This project is licensed under the MIT License - feel free to use and adapt this project for your own needs.
