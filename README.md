# RideAlly Summer Training Project Version Two

A role-based Content Management System developed using PHP, MySQL, Bootstrap 5, and MVC Architecture.

## Live Demo

Website URL:

https://rideallycms.infinityfreeapp.com/public/

## Demo Credentials

### Administrator

Email:
admin@rideally.com

Password:
admin123

---

### Editor

Email:
editor@rideally.com

Password:
editor123

---

### Author

Email:
author@rideally.com

Password:
author123

---

### User

Email:
user@rideally.com

Password:
user123

---

## Project Overview

RideAlly CMS is a web-based content management platform designed to simplify article publishing, collaboration, and content moderation. The system provides role-based access control, allowing different types of users to interact with the platform according to their responsibilities.

This project was developed during summer training to gain practical experience in backend development using Core PHP and to understand how real-world applications are structured using the MVC architectural pattern.

The application demonstrates concepts such as authentication, authorization, routing, database connectivity, CRUD operations, session handling, and deployment on a production server.

---

## Technology Stack

- PHP (Core PHP)
- MySQL
- Bootstrap 5
- HTML5
- CSS3
- JavaScript
- Apache (XAMPP)
- Git and GitHub
- InfinityFree Hosting

---

## MVC Architecture

This project follows the **Model–View–Controller (MVC)** architectural pattern.

### Model

Handles database operations and business logic.

Location:

```text
app/models/
```

Examples:

- User.php
- Post.php
- Category.php
- Comment.php

### View

Responsible for presenting information to users through the interface.

Location:

```text
app/views/
```

Examples:

- Public pages
- Authentication pages
- Dashboard pages
- Layout components

### Controller

Acts as an intermediary between Models and Views.

Location:

```text
app/controllers/
```

Examples:

- HomeController
- AuthController
- DashboardController
- PostController
- CategoryController
- UserController
- CommentController

### Core Components

Contains reusable functionality and application infrastructure.

Location:

```text
core/
```

Examples:

- Router.php
- helpers.php

---

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

---

## Key Features

### Public Features

- Browse published articles
- View posts by category
- Search functionality
- Read full articles
- User registration
- User login

### Authentication Features

- Session-based authentication
- Secure password handling
- Login and logout functionality
- Role-based access restrictions

### Dashboard Features

- Personalized dashboard
- Statistics overview
- Navigation according to assigned role

### Post Management

- Create posts
- Edit posts
- Delete posts
- Approve submitted articles
- Reject articles
- Publish workflow management

### Category Management

- Create categories
- Edit categories
- Delete categories
- Organize posts effectively

### User Management

- View users
- Create users
- Edit user information
- Delete users
- Assign user roles

### Comment System

- Add comments on posts
- Store user feedback
- Display comments on articles

---

## User Roles

### Administrator

Permissions:

- Complete system access
- Manage users
- Manage categories
- Manage all posts
- Approve or reject articles
- Access administrator dashboard

### Editor

Permissions:

- Review submitted posts
- Approve or reject content
- Edit articles
- Manage categories

### Author

Permissions:

- Create posts
- Edit own posts
- Delete own posts
- Access author dashboard

### User

Permissions:

- Register an account
- Login to the system
- Browse articles
- Submit comments

---

## Installation Guide

### Local Setup

1. Clone the repository.

```bash
git clone https://github.com/KeshavKrishnaMIT/rideally-cms-php-mvcrideally-cms-php-mvc.git
```

2. Move the project folder into the XAMPP `htdocs` directory.

3. Start Apache and MySQL using XAMPP.

4. Create a database named:

```text
cms_dbnew
```

5. Import the provided SQL file into the database.

6. Open the application in your browser.

```text
http://localhost/mini_pro_rideally_v2/public/
```

---

## Production Deployment

The project has been successfully deployed using InfinityFree hosting.

Production URL:

```text
https://rideallycms.infinityfreeapp.com/public/
```

Deployment highlights:

- Environment-aware database configuration
- Shared codebase for localhost and production
- Dynamic routing support
- MySQL database integration
- Public hosting setup

---

## Learning Outcomes

Through this project, practical experience was gained in:

- Core PHP development
- MVC architecture implementation
- Database integration using MySQL
- Session management
- Authentication and authorization
- URL routing mechanisms
- CRUD operations
- Hosting and deployment workflows
- Git and GitHub version control
- Debugging production environments

---

## Developer Information

Developed by:

```text
Keshav Krishna Singh
B.Tech Student
Summer Training Project
```

---

## Project Title

```text
RideAlly Summer Training Project Version Two
```

This project was developed as part of summer training to demonstrate the implementation of a role-based Content Management System using Core PHP and MVC architecture principles.
