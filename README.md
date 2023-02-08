# tenants-admin
Administration web app as CRUD for multidatabase multi tenant applications, that use the [spatie/laravel-multitenancy](https://spatie.be/docs/laravel-multitenancy/v3/introduction) v2 package.


This is a boilerplate application build on top of laravel and [filament](https://filamentphp.com/) to manage the spatie/laravel-multitenancy [tenants table](https://github.com/spatie/laravel-multitenancy/blob/main/database/migrations/landlord/create_landlord_tenants_table.php.stub).

## Requirements

This project was created with laravel experience developers in  mind, also it is tested and deployed in a linux environment. Of course, it can run on windows, but you will provably need to do some tweaks.

The usage of this application requires you to understand how [spatie/laravel-multitenancy](https://spatie.be/docs/laravel-multitenancy/v3/introduction) package works, taking in mind that this package will modify the database used by the [landlord conection](https://spatie.be/docs/laravel-multitenancy/v3/installation/using-multiple-databases#content-configuring-the-database-connections) of your multitenant laravel application.

This app is developed and used with the next software and libraries:
    
    - php>=8.0 with:
        php-fpm php-sqlite3 php-mysql php-xml php-xmlrpc php-curl php-gd php-imagick php-cli php-dev php-imap php-mbstring php-opcache php-soap php-zip php-intl php-bcmath php-bz2 php-xdebug php-ctype php-gmp php-bcmath php-dev    
    - composer    
    - nodejs +16.4
    - npm
    - Mariadb +10.5
    
    


## Installation



Ideally you should clone this repo nex to your multitenant laravel project folder.

```bash
  git clone git@github.com:kamansoft/tenants-admin.git
```

Then, assuming that your multi-tenant project is called "multitenant-laravel-project" and the root directory in which you cloned the repo (above command) its called "some-projects-folder" you should have a tree like this:


```bash
some-projects-folder
  ├── multitenant-laravel-project
  └── tenants-admin
```


As in any other laravel app you must set up your databse conetion at the .env file. Using the same values you seted up in your multitenant laravel project at the [landlord conection](https://spatie.be/docs/laravel-multitenancy/v3/installation/using-multiple-databases#content-configuring-the-database-connections).

Then just install php dependencies with composer, javascript dependencies with  npm and build the frontend of the app with the following commands:

```bash
#/some-projects-folder/tenants-admin
    composer install
    npm install
    npm run dev
```
    
