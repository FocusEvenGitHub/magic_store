# Magic Store Project

## Requirements

- Docker
- Docker Compose

---

## Setup

1. Copy `.env.example` to `.env` and update the environment variables.
2. Run: `docker-compose up --build` and `composer require vlucas/phpdotenv`
3. Import the database from `database/init.sql`.

---

## Usage

Open your browser and go to [http://localhost:8080](http://localhost:8080).

---

## Libraries Used

- **PHPMailer**
- **PhpSpreadsheet**
- **vlucas/phpdotenv**

---

## Project Structure

- **docker-compose.yml**: Docker Compose configuration for the web server and MySQL.
- **Dockerfile**: Builds the PHP Apache container.
- **public/**: Contains the entry point `index.php`, CSS, and JavaScript files.
- **app/**: Holds controllers, models, and views (MVC structure).
- **config/**: Database connection configuration.
- **utils/**: Utility classes for email sending, Excel importing, and XML processing.
- **database/**: SQL file (`init.sql`) to initialize the database.
- **.env**: Environment configuration file.
- **README.md**: This file.
