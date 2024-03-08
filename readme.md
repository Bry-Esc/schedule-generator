How to install:

1. Ensure you have PHP 8.1+ installed.

2. Move into the project directory:

   ```
   cd timetable-generator
   ```

3. Install the required dependencies by running:

   ```
   composer install
   ```

4. Create an environment file:

   ```
   cp .env.example .env
   ```

5. Generate the application key:

   ```
   php artisan key:generate
   ```

6. Create a local database and update the `.env` file with the database credentials.

7. Run the database migration to set up the necessary tables:

   ```
   php artisan migrate
   ```

8. Seed the application with initial data:

   ```
   php artisan db:seed
   ```

9. Access the application URL in your web browser. If prompted for a password, use the default password: `admin`.

10. Start the queue to enable timetable generation:

    ```
    php artisan queue:listen --timeout=0
    ```
