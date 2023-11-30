# Laravel Task Management API

## Overview

## Features

- CRUD operations for tasks:
    - Create new tasks
    - Retrieve all tasks
    - Retrieve a single task by ID
    - Update existing tasks
    - Delete tasks

## Getting Started

### Prerequisites

- PHP >= 7.3
- Composer
- MySQL or a similar database system

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
   php artisan serve
