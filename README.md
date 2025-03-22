# Simple Task Manager

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- Docker & Docker Compose (optional, for containerized database)

## Installation


1. Install PHP dependencies:
```bash
composer install
```

2. Install Node.js dependencies:
```bash
npm install
```

3. Set up environment file:
```bash
cp .env.example .env
```

4. Set up encryption key:
```bash
php artisan key:generate  # Important: This generates the application encryption key
```

> **Note**: The `key:generate` command is crucial as it creates the application encryption key required for secure operations. If you see a `MissingAppKeyException` error when running the application, this means the key wasn't generated properly. You can fix this by running `php artisan key:generate` again.

5. Configure your database:

   Option A: Local Database
   - Update the database configuration in your `.env` file with your database credentials

   Option B: Docker Database (MySQL)
   - Start the MySQL container:
     ```bash
     docker compose up -d
     ```
   - Update your `.env` file with these credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=task_manager_db
     DB_USERNAME=root
     DB_PASSWORD=root
     ```

6. Run migrations:
```bash
php artisan migrate
```

## Development

To start the development server:

```bash
composer run dev
```
## Building for Production

1. Build frontend assets:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan optimize
```

## Docker Database Management

If you're using the Docker-based database setup, here are some useful commands:

```bash
# Start the database container
docker compose up -d

# Stop the database container
docker compose down

# View container logs
docker compose logs mysql

# Stop the container and remove the volume (will delete all data)
docker compose down -v
```