<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://tangentsolutions.co.za/wp-content/uploads/2021/09/tangent_logo_full_colour_400_1x.png" width="400" alt="Laravel Logo"></a></p>
 
## Set up instruction

After cloning the project run composer toinstall the packages

`composer install`

 #### Database
 
  - Create .env file byt copying contents of `env.example` file

  `cp .env.example .env`
  
  - Open your local mysql server and create a mysql database called `tangent`

  - Run migrations

 `php artisan migrate`

  - Seed the database 

  `php artisan db:seed`

  #### Run the application

  - Serve the application locally.
  
  `php artisan serve`

  - Open the link : [localhost](http://localhost:8000/)

  - Swagger API documentation.
   //TODO

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
