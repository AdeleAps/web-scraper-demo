A simple web scraper that gathers data from [Hacker News](https://news.ycombinator.com/).

Tech stack: Laravel, Vue.js, Tailwind, mySQL, Docker and Jetstream with Inertia as scaffolding.

## Prerequisites:

To run the environment, I'm using Laravel Sail, which is a nifty tool, but it only works on MacOS and Linux. If you're using Windows, I apologize - you will have to install [WSL2](https://learn.microsoft.com/en-us/windows/wsl/about). Also, if using Sail, I recommend setting a [shell alias](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias), so that instead of "./vendor/bin/sail", you can just use "sail".

P.S. This is my first time working with Vue, I'm open to any and all critiques. :)

## Installation: 

Fill in the database credentials in the .env file:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

CD into the project directory and run the following:

```
composer install
./vendor/bin/sail up 
./vendor/bin/sail npm install 
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev

```

Default user will already be in the database. Username is "Codnity" and password is "password".

The scraping is executed with the following artisan command from the console:

```
sail artisan app:scrape

```






