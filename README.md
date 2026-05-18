# BPS_GAMI

A professional web application built with PHP for managing BPS (Badan Pusat Statistik) UMKM data and administration.

## Overview

BPS_GAMI is a comprehensive management system designed for handling UMKM (Usaha Mikro, Kecil, dan Menengah) data with user authentication and role-based access control. The application provides a secure platform for data management and administrative operations.

## Features

- **User Authentication** - Secure login system with user credential management
- **Role-Based Access Control** - Admin and user role differentiation
- **UMKM Data Management** - Comprehensive database for managing UMKM information
- **Database Integration** - Built with robust database architecture for data integrity
- **Responsive Interface** - User-friendly web-based interface for seamless interaction

## Technology Stack

- **Backend** - PHP
- **Database** - MySQL
- **Database Management** - phpMyAdmin

## Prerequisites

Before you begin, ensure you have the following installed:
- PHP 7.4 or higher
- MySQL Server
- phpMyAdmin (for database management)
- Web server (Apache/Nginx)

## Installation & Setup

### 1. Database Configuration

1. Access phpMyAdmin through your web server
2. Create or use the existing `bps_umkm` database
3. Import or configure the required database tables
4. Set up the `user` table with admin/user role options

### 2. Admin Account Setup

1. Navigate to phpMyAdmin
2. Access the `user` table in the `bps_umkm` database
3. Create a new user entry
4. Set the role field to designate admin privileges
5. Configure login credentials as needed

### 3. Application Configuration

1. Clone or download the repository
2. Configure database connection parameters in the application
3. Ensure proper file permissions are set
4. Access the application through your web server

## Usage

1. Launch the application in your web browser
2. Log in with your credentials
3. Select your role (Admin/User) based on your access level
4. Navigate to the respective modules for data management

## Project Structure

```
BPS_GAMI/
├── index.php
├── config/
├── assets/
├── views/
└── database/
```

## Contributors

- **Rayyan** - Lead Developer
- **Tafftadia Imada** - Developer
- **Wildan Mukorrobin** - Developer

## License

This project is open source and available under the appropriate license.

## Support

For issues, questions, or contributions, please refer to the project repository or contact the development team.

---

**Last Updated:** May 18, 2026  
**Repository:** [rayyan-210/BPS_GAMI](https://github.com/rayyan-210/BPS_GAMI)
