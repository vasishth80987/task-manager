# Laravel Task Management 

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
    - Tasks can only be created, updated or deleted by managers and admins.
    - Managers and admins can assign other users to tasks.
    - Managers can only update or delete their own tasks.
    - Users can only view tasks that have been assigned to them.
    - Users can update task completion status for tasks they are assigned to.
    - Laravel Policies used for authorizing user for all crud operations. 
- Team Feature:
    - Managers and Admin can create teams
    - Managers can only assign tasks to users in the teams they lead
    - Managers can hand over leadership of team to other managers
- API endpoints:
    - RestAPI end points for all task operations(list,view,update,delete) can be accessed via '/api' suffix in url
    - Token based authentication using Laravel Sanctum Package
- Front End:
    - Blade Templates used for html markups
    - Livewire components for displaying forms.
    - Bootstrap CSS for styling
- Feature Tests:
    - Pest Php feature tests(incomplete)

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL or a similar database system

###Dependencies
- laravel/framework: 
      Best open source PHP framework for web based applications. 
- spatie/laravel-permission: 
      Laravel Role & Permissions package with helper functions to create complex user authorisation groups.
- yajra/laravel-datatables: 
      Laravel package to display lists in tabular format with additional features such as search, excel sheet downloads, etc.
- livewire/livewire: 
      Dynamic UI components for laravel application to improve UX.
- masmerise/livewire-toaster: 
      UI elements for notifying user.
- laravel/sanctum: 
      Easy API authentication package for laravel.
- pestphp/pest: 
      Modern testing framework for laravel and php.

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
   php artisan migrate --database=testing 
   php artisan test

### Login Credentials ###
**Admin** \
email: admin@example.com \
password: password 

**Managers** \
email: manager1@example.com \
password: password \
email: manager2@example.com \
password: password 

**Users** \
email: dev1@example.com \
password: password \
email: dev2@example.com \
password: password 
