# RideAlly Summer Training Project Version Two

A role-based Content Management System developed using PHP, MySQL, Bootstrap 5, and MVC Architecture.

## Project Overview

RideAlly CMS is a web-based content management platform designed to streamline article publishing and collaborative content creation. The system enables users with different roles to interact with the application according to their assigned permissions.

The project demonstrates the practical implementation of the MVC (Model–View–Controller) architectural pattern using core PHP without external frameworks. It was developed as part of summer training to strengthen understanding of backend development concepts, routing mechanisms, authentication systems, database integration, and role-based access control.

## Live Demo

Website URL:

https://rideallycms.infinityfreeapp.com/public/

## Technology Stack

* PHP (Core PHP)
* MySQL
* Bootstrap 5
* HTML5
* CSS3
* JavaScript
* MVC Architecture
* Apache (XAMPP)
* Git and GitHub
* InfinityFree Hosting

## Project Architecture

This application follows the MVC (Model–View–Controller) architectural pattern.

### Model

Responsible for database interaction and business logic.

Location:

```text
app/models/
```

Examples:

* User.php
* Post.php
* Category.php
* Comment.php

### View

Responsible for presenting data to users through the interface.

Location:

```text
app/views/
```

Examples:

* Authentication pages
* Dashboard pages
* Public pages
* Layout components

### Controller

Acts as an intermediary between Models and Views.

Location:

```text
app/controllers/
```

Examples:

* HomeController
* AuthController
* PostController
* DashboardController
* CategoryController
* UserController
* CommentController

### Core Components

Contains application infrastructure and reusable functionality.

Location:

```text
core/
```

Examples:

* Router
* Helper functions

## Folder Structure

```text
RideAlly-CMS/
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│
├── config/
│   └── database.php
│
├── core/
│   ├── Router.php
│   └── helpers.php
│
├── public/
│   ├── assets/
│   ├── index.php
│   └── .htaccess
│
└── .htaccess
```

## Key Features

### Public Features

* View published articles
* Browse posts by category
* Search articles
* Read complete articles
* User registration
* User login

### Authentication Features

* Secure login system
* Password hashing
* Session management
* Logout functionality

### Dashboard Features

* Personalized dashboard
* Statistics overview
* Navigation based on user roles

### Post Management

* Create new posts
* Edit existing posts
* Delete posts
* Approve submitted posts
* Reject posts
* Publish workflow support

### Category Management

* Create categories
* Edit categories
* Delete categories
* Organize posts efficiently

### User Management

* View users
* Create users
* Edit user details
* Delete users
* Role assignment

### Comment System

* Add comments on posts
* Store and display user feedback

## User Roles

### Administrator

Permissions:

* Full access to the system
* Manage users
* Manage posts
* Manage categories
* Approve or reject articles
* Access administrative dashboard

### Editor

Permissions:

* Review submitted posts
* Approve or reject articles
* Edit published content
* Manage categories

### Author

Permissions:

* Create posts
* Edit own posts
* Delete own posts
* Access author dashboard

### User

Permissions:

* Register account
* Login to the platform
* View articles
* Submit comments

## Demo Credentials

### Administrator

Email:

```text
admin@rideally.com
```

Password:

```text
admin123
```

### Editor

Email:

```text
editor@rideally.com
```

Password:

```text
editor123
```

### Author

Email:

```text
author@rideally.com
```

Password:

```text
author123
```

### User

Email:

```text
user@rideally.com
```

Password:

```text
user123
```

## Installation Guide

### Local Setup

1. Clone the repository.

```bash
git clone https://github.com/KeshavKrishnaMIT/rideally-cms-php-mvcrideally-cms-php-mvc.git
```

2. Move the project folder into XAMPP htdocs.

3. Start Apache and MySQL using XAMPP.

4. Create a MySQL database.

```text
cms_dbnew
```

5. Import the provided SQL file.

6. Open the application.

```text
http://localhost/mini_pro_rideally_v2/public/
```

## Production Deployment

The project has been successfully deployed on InfinityFree hosting.

Production URL:

```text
https://rideallycms.infinityfreeapp.com/public/
```

The deployment includes:

* Live MySQL database integration
* Environment-aware configuration
* Dynamic routing support
* Public accessibility

## Learning Outcomes

This project provided hands-on experience with:

* MVC application design
* Core PHP development
* Database design and integration
* Session-based authentication
* Role-based authorization
* URL routing mechanisms
* Hosting and deployment workflows
* Version control using Git and GitHub
* Debugging production environments

## Developer Information

Developed by:

```text
Keshav Krishna Singh
B.Tech Student
Summer Training Project
```

## Project Title

```text
RideAlly Summer Training Project Version Two
```

This project was developed for academic learning purposes to demonstrate the implementation of a role-based content management system using PHP MVC architecture and modern web development practices.
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/b7a2d72f-84a1-425f-8614-71cda56c5b6e" />
