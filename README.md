# Translation Service API

## Setup Instructions

### Prerequisites
- PHP 8.x
- Composer
- Laravel 8+
- MySQL Database
- Postman or any API testing tool

### Installation Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/DS-dk/translation-service.git
   cd translation-service
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Create a `.env` file from the example:
   ```sh
   cp .env.example .env
   ```
4. Set up the database connection in `.env`:
   ```sh
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
5. Run database migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```
6. Generate application key:
   ```sh
   php artisan key:generate
   ```
7. Start the development server:
   ```sh
   php artisan serve
   ```

## API Endpoints

### Authentication
- **Login:** `POST /api/login`
- **Logout:** `POST /api/logout`

### Transactions
- **List Transactions:** `GET /api/transactions`
- **Create Transaction:** `POST /api/transactions`
- **Update Transaction:** `PUT /api/transactions/{id}`
- **Delete Transaction:** `DELETE /api/transactions/{id}`

## Design Choices
- **Sanctum Authentication:** All API routes are secured using Laravel Sanctum.
- **Validation:** Request validation is implemented in controllers for data integrity.
- **Eloquent ORM:** Used for database interactions.
- **Factory & Seeders:** Used for generating fake data for testing.
- **Middleware:** Applied to protect routes and ensure only authenticated users can access them.

## Notes
- Ensure you have your `.env` file properly configured.
- API requests must include the authentication token in the headers.
- Run `php artisan db:seed` to populate test data in the database.

---
Feel free to contribute by submitting pull requests or opening issues!

