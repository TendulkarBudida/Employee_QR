# Employee QR Code Scanner and Management System

## Project Overview

This project is a web-based Employee QR Code Scanner and Management System designed for Technip Energies. It allows authorized users to scan employee QR codes and retrieve employee details quickly and efficiently. The system also includes user authentication and a CRUD (Create, Read, Update, Delete) interface for managing employee data.

## Features

1. User Authentication
2. QR Code Scanning
3. Employee Information Retrieval
4. CRUD Operations for Employee Data
5. Responsive Design

## File Structure

```
project_root/
│
├── php/
│   ├── index.php
│   ├── db_connection.php
│   ├── logout.php
│   └── qr.php
│
├── js/
│   └── script_qr.js
│
├── css/
│   ├── style_login.css
│   ├── style_qr.css
│   └── style_crud.css
│
└── README.md
```

## Detailed Description

### 1. User Authentication (index.php)

- Provides a secure login interface for authorized users.
- Validates user credentials against the database.
- Uses session management for maintaining user login state.

### 2. Database Connection (db_connection.php)

- Establishes a connection to the MySQL database.
- Uses parameterized configuration for easy deployment across different environments.

### 3. QR Code Scanning and Employee Information (qr.php)

- Integrates HTML5 QR code scanner.
- Allows manual input of employee code.
- Retrieves and displays employee information based on the scanned/entered code.
- Includes a responsive design for various device sizes.

### 4. QR Code Scanning Script (script_qr.js)

- Implements the QR code scanning functionality using the HTML5 QR code library.
- Automatically submits the form with the scanned employee code.

### 5. Logout Functionality (logout.php)

- Handles user logout by destroying the session and redirecting to the login page.

### 6. Styling

- `style_login.css`: Styles the login page with a modern, responsive design.
- `style_qr.css`: Provides styling for the QR scanning and employee information display page.
- `style_crud.css`: Styles the CRUD interface (not provided in the given files, but mentioned).

## How to Use

1. **Setup**:
   - Place all files in your web server directory.
   - Configure your database settings in `db_connection.php`.
   - Ensure you have a MySQL database set up with the required tables (`adm_access` for user authentication and `emp_details` for employee information).

2. **Accessing the System**:
   - Navigate to the `index.php` file in your web browser.
   - Log in using your authorized credentials.

3. **Scanning QR Codes**:
   - After logging in, you'll be redirected to the QR scanning page (`qr.php`).
   - Use the QR scanner to scan an employee's QR code, or manually enter the employee code in the provided form.

4. **Viewing Employee Information**:
   - Once a QR code is scanned or an employee code is entered, the system will display the employee's details.

5. **CRUD Operations**:
   - Access the CRUD interface through the navigation menu (implementation details not provided in the given files).

6. **Logging Out**:
   - Use the "Log Out" option in the navigation menu to securely end your session.