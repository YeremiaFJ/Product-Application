Product Application
===================

Requirement:
- First install the required API service :
  - User API : https://github.com/YeremiaFJ/User-Service
  - Product API : https://github.com/YeremiaFJ/Product-Service
- Install XAMPP (https://www.apachefriends.org/download.html).
- Composer Installed (https://getcomposer.org/download/).
- Install node js (https://nodejs.org/en/download/).
- Create a virtual host that point to the public folder of the project.
How to create virtual host -> (https://stackoverflow.com/a/36572751).

How to use:
- Create .env file from '.env.example'. Change few config:
  - APP_NAME : Your app name
  - APP_URL : Your virtual host URL for this Service.
  - Remove all 'DB_' config, except DB_CONNECTION, change from mysql to sqlite
- Create database.sqlite in the database folder of the project.
- Open Controller in "app\Http\Controllers\"
  - Open ProductController.php
    - Change $this->productAPI = '[YOUR PRODUCT API virtual host URL]';
  - Open UserController.php
    - Change $this->userAPI = '[YOUR USER API virtual host URL]';
    - Change $this->productAPI = '[PRODUCT APPLICATION virtual host URL]';
- Now open command prompt, navigate to your project folder. Run these commands:
  - composer install
  - php artisan key:generate
  - npm install
  - php artisan migrate
- Now open your User API, register new account.
- After that, you should create new client. There is application name, just fill it with "Product Application". 
For the URL callback, fill it with "[PRODUCT APPLICATION virtual host URL]/callback".
- Now you can see client id and secret.
- Open UserController and you chould see client_id in retrieveAPI function. Fill that in.
- Open your web route in your user API, you should see client_id and client_secret. Fill that in.
- Done.
