## TOPUP - Laravel 9.x REST API

Documentation is still on progress. For now, you can fork this postman collection\
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/10197923-7744a772-779f-4fdf-b8bc-bbfe41d74afe?action=collection%2Ffork&collection-url=entityId%3D10197923-7744a772-779f-4fdf-b8bc-bbfe41d74afe%26entityType%3Dcollection%26workspaceId%3D1fe4b71c-1df1-41de-90bc-46c97f9e534e)

### Installation

 1. Clone this project\
 `git clone https://github.com/senatroxx/laravel-be-topup.git`
 2. Cd into your project folder\
 `cd laravel-be-topup`
 3. Install dependencies\
 `composer install --no-dev`\
 Or if you want continue developing this project\
 `composer install`
 5. Copy env file\
 `cp .env.example .env`
 4. Setup your database, xendit, and digiflazz via .env file
 5. Make app key\
`php artisan key:generate`
 6. Migrate database\
 `php artisan migrate`
 7. (Optional) Seed the database\
 `php artisan db:seed`
 8. Create passport key\
 `php artisan passport:install`
 

