# Restaurant Delivery API - Laravel App

This Laravel application provides APIs for restaurant delivery 
services. It allows you to manage restaurants, menus and orders.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [API Documentation](#api-documentation)
- [Contributor](#contributor)
- [License](#license)

## Prerequisites

Before setting up the Laravel project, ensure that you have the following software installed on your machine:

- PHP (>= 8.1)
- Composer
- MySQL
- Laravel CLI

## Installation

To install the Laravel app, follow these steps:

1. Clone the repository:

```bash
   git clone https://github.com/arhinful/restaurant-delivery-api-laravel.git
```
2. Navigate to the project directory:
```bash
   cd restaurant-delivery-api
```
3. Install the dependencies using Composer:
```bash
   composer install
```
## Configuration

The Laravel app requires some configuration settings to run correctly. Here's what you need to do:

1. Copy the `.env.example` file and rename it to `.env`:
```bash
   cp .env.example .env
```
2. Generate an application key:
```bash
   php artisan key:generate
```
   This will set the `APP_KEY` value in your `.env` file.

3. Configure your database settings in the `.env` file:
```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
```
   Replace `your_database`, `your_username`, and `your_password` with your actual database credentials.

## Database Setup

To set up the database for your Laravel app, follow these steps:

1. Create a new database in your MySQL server.

2. Migrate the database tables:
```bash
   php artisan migrate
```
This will create the necessary tables in your database .

3. You can populate your database to have dummy data for testing 
by seeding.
```bash
   php artisan db:seed
```

## Running the Application

To run the Laravel app locally, use the following command:
```bash
php artisan serve
```
This will start a local development server at `http://127.0.0.1:8000`.
You can access the API endpoints using `http://127.0.0.1:8000/docs`.

## API Documentation

The API documentation for the restaurant delivery endpoints can be found at `<your_app_url>/docs`. This documentation provides detailed information about each API endpoint, request/response formats, and authentication requirements.

Postman collection file can be found in the directory:
`public/docs/openapi.yaml` or can be downloaded from the docs page

OpenAI spec file can be found in the directory:
`public/docs/collection.json` or can be downloaded from the docs page


## Contributor
#### Name: ARHINFUL EMMANUEL
#### Linkedin: https://www.linkedin.com/in/arhinful-emmanuel

