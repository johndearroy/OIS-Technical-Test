## About Project

<strong>Project Title:</strong> 
```OIS-Technical-Test```

<strong>Author:</strong> ```Dear Roy```

<strong>Version:</strong> ```1.0.0```

<strong>Stack:</strong> [Laravel 8](https://laravel.com/), [VueJs](https://vuejs.org/), [MySQL](https://www.mysql.com/), [TailwindCSS](https://tailwindcss.com/)

### Screenshot
<p align="center">
    <img src="https://i.ibb.co/RbfKT9D/ois.png">
</p>


## Project requirements:

1. You need to create a CRUD for bank account
2. Frontend will be in VueJS
3. All the operations will be conducted through API connecting the Laravel
backend
4. Frontend and backend will be fully separate, all the communications
between them will be through API only
5. When Create Account is clicked from 5.1.1, 5.1.2 form will be opened,
either in a modal or a different page
6. Same form will be used for both create/update operations based on the
parameters passed to it
7. Bank dropdown field data in the form will come from the
financial_organizations source lookup table (5.4). This table can be
created manually in the database or through a Migration/Seeder
Combination
8. Account dropdown data will be fixed as mentioned in the account_type
column of bank_accounts table schema
9. Data will be saved/updated into bank_accounts table (5.4)


## Installation Guide
Please install [Composer](https://getcomposer.org/) and other essential tools for setting up the environment to run and/or create a Laravel project.
If your computer already has PHP, MySQL or XAMPP and Composer installed then follow the instructions bellow:
* Clone the project ```git clone git@github.com:johndearroy/OIS-Technical-Test.git```
* Navigate to the project directory ```cd OIS-Technical-Test```
* Run ```cp .env.example .env``` or manually copy the ```.env.example``` to ```.env``` at the root
* Configure the database credentials
`````yaml
DB_DATABASE=<YOUR_DATABASE_NAME>
DB_USERNAME=<YOUR_DATABASE_USERNAME>
DB_PASSWORD=<YOUR_DATABASE_PASSWORD>
`````
* Run ```composer install```
* Run ```npm install && npm run dev``` [N.B: Make sure you have nodejs installed on your machine]
* Run ```php artisan key:generate```
* Run ```php artisan migrate --seed``` or ```php artisan migrate:fresh --seed```
* Finally run ```php artisan serve``` and navigate to "http://127.0.0.1:8000/" at your browser.
* If you seeded the data properly by command ```php artisan migrate --seed``` then you can now login as admin by using the following credentials:

```yaml
Username / Email: admin@admin.com
Password: password
```
* And for login as normal User, please register a user first from "http://127.0.0.1:8000/register"
and login.

