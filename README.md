
## Booster Rating System Code Challenege

Setup:

- Clone files to your local machine: git clone https://github.com/mhurst/booster_ratings_challenge.git
- Create new MySql database
- Configure .env file to match the newly created database
- Configure .env file for email services
- Run npm install and composer install
- Run laravel migrations: php artisan migrate
- Run laravel seeder: php artisan db:seed --class=FundraisersSeeder
    - This should give you some dummy data to play with.
- Run php artisan serve to start the server

Alot of the system depends upon the one email to go out. So if you don't setup an email properly the system will not work.
