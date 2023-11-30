# Laravel Task Management API

## Overview

## Features
- CRUD operations for tasks:
    - Create new tasks
    - Retrieve all tasks
    - Excel and CSV exports for task lists
    - Retrieve a single task by ID
    - Update existing tasks
    - Delete tasks
- User Roles and permissions:
    - Tasks can only be created or updated by managers and admins
    - Managers can only update or delete own tasks
    - Managers and admins can assign other users to their tasks
    - Users can view tasks that have been assigned to them
    - Users can update task status for tasks they have been assigned to.
- Team Feature:
    - Managers and Admin can create teams
    - Managers can only assign tasks to users in the teams they lead
    - Managers can hand over leadership of team to other managers
- API endpoints:
    - RestAPI end points for all task operations(list,view,update,delete) can be accessed via '/api' suffix in url
    - Token based authentication using Laravel Sanctum Package
- Feature Tests:
    - Pest Php feature tests included

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL or a similar database system

###Dependencies
- laravel/framework
- spatie/laravel-permission
- yajra/laravel-datatables
- livewire/livewire
- masmerise/livewire-toaster
- laravel/sanctum
- pestphp/pest

### Installation

1. **Clone the Repository**
   
   ```bash
   git clone https://github.com/vasishth80987/task-manager.git
   cd task-manager
   
2. **Install Dependencies**

   ```bash
   composer install
   npm install

3. **Set Configurations in .env**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Change Mailtrap settings to check mail sent out by the app

4. **Run Database Scripts**

   ```bash
   php artisan migrate
   php artisan db:seed

5. **Start Server**

   ```bash
    php artisan serve --host=localhost --port=80

6. **Running Tests**

   ```bash
    php artisan test

### Login Credentials ###
**Admin** \
email: admin@example.com \
password: password \

**Managers** \
email: manager1@example.com \
password: password \
email: manager2@example.com \
password: password \

**Users** \
email: dev1@example.com \
password: password \
email: dev2@example.com \
password: password \
