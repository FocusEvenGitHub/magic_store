# Magic Store Project
Magic Store is a simple e-commerce management system built with PHP using the MVC architecture and MySQL as the database. The project supports customer management, order processing, and email logging.

## Technologies Used

- PHP 7+
- MySQL
- Docker
- Composer
- HTML, CSS, JavaScript and jQuery

---

## Setup

1. Run:
    ```bash
    git clone https://github.com/your-username/magic-store.git
    cd magic-store
2. Copy `.env.example` to `.env` and update the environment variables.
3. Run: `composer install`.
4. Set up the Database with the following command:
    ```
    docker exec -i <your-mysql-container-id> mysql -u root -p < database/schema.sql
5. Run: `docker-compose up -d`.
4. Import the database from `database/init.sql`.

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
