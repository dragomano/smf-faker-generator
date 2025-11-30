## SMF Faker Generator

This package is designed to populate database tables with fake SMF and Light Portal data.

### Usage

* Extract the package files into any directory.
* Get the API on the website https://www.pexels.com/api/api-key/ (for generating random images).
* Configure the database connection parameters in the `.env` file (see the example in `.env.example`).
* Specify `PEXELS_API_KEY` there.
* Select what to generate in the `database/seeders/DatabaseSeeder.php` file.
* Run the following commands in the console:

    `composer install`

    `php artisan migrate:fresh --seed`

* Create snapshots for specific tables or for the entire database:

    `php artisan snapshot:create --table=smf_boards`
    
    `php artisan snapshot:create`

* After that, you can import the required data into your real forum database.
