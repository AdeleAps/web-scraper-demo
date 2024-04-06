A simple web scraper that gathers data from [Hacker News](https://news.ycombinator.com/).

Tech stack: Laravel, Vue.js, Tailwind, mySQL Docker and Jetstream with Inertia as scaffolding.

Prerequisites:

To run the environment, I'm using Laravel Sail, which is a nifty tool, but it only works on MacOS and Linux. If you're using Windows, I apologize - you will have to install [WSL2](https://learn.microsoft.com/en-us/windows/wsl/about).

P.S. This is my first time working with Vue, I'm open to any and all critiques. :)

./vendor/bin/sail up
./vendor/bin/sail artisan migrate