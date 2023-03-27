<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://tangentsolutions.co.za/wp-content/uploads/2021/09/tangent_logo_full_colour_400_1x.png" width="400" alt="Laravel Logo"></a></p>
 
## Set up instruction

After cloning the project, navigate into the project directory and run composer to install all the required packages

`cd tangent-test`
`composer install`

 ### 1. Database
 
  - Create .env file byt copying contents of `env.example` file

  `cp .env.example .env`
  
  - Open your local mysql server and create a mysql database called `tangent`

  - Run migrations

 `php artisan migrate`

  - Seed the database 

  `php artisan db:seed`
  
  ### 2. Unit tests
  
  - Run all tests

`php artisan test`


  ### 3. Run the application

  - Serve the application locally.
  
  `php artisan serve`

  - Open the link : [localhost](http://localhost:8000/)

  ### 4. Swagger API documentation.

  `php artisan l5-swagger:generate`

  - Documentation link : [link to documentation]([http://localhost:8000/](http://localhost:8000/api/documentation))

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
