# Movie quotes API
This is the backend API for the Movie Quotes application. The API provides endpoints for users to interact with the front-end application.

Users can:
-   Register and authorize themselves, including via Google registration
-   Browse through a collection of movie quotes
-   Like or comment on quotes
-   Add their own quotes from their movies
-   Manage their personal page for movies - delete/edit/add movie or quote
-   Update their profile details, such as changing their username or adding/changing their profile picture

## Table of contents
- [Prerequisites](#prerequisites)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Development](#development)
- [Migrations](#migrations)
- [Database diagram](#database-diagram)

## Prerequisites
- PHP@ 8.2.5
- MYSQL@ 8.0.32
- npm@9.5.0
- composer@2.6
- tailwind@3.3.1


## Tech stack
- [Laravel@10.x](https://laravel.com/docs/10.x) - Back-end framework
- [Spatie Translatable](https://github.com/spatie/laravel-translatable) - Package for translation
- [tailwindcss](https://tailwindcss.com/docs/installation) - CSS framework
- [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) - Authentication
- [Swagger](https://swagger.io/) - API documentation
- [Laravel Socialite](https://laravel.com/docs/8.x/socialite) - Social authentication
- [Laravel Broadcasting](https://laravel.com/docs/8.x/broadcasting) - Real-time notifications

## Getting started

1.First of all, clone the Movie Quotes repository from GitHub:

```bash
https://github.com/RedberryInternship/elene-javakhishvili-movie-quotes-back.git
```
2.Install dependencies:
```bash
composer install
```
3.After you have installed all the PHP dependencies, it's time to install all the JS dependencies:
```bash
npm install
```
and also:
```bash
npm run dev
```
4.Now we need to set our env file. Go to the root of your project and execute this command.
```bash
cp .env.example .env
```
Update the .env file with your database credentials:

MYSQL:

>DB_CONNECTION=mysql

>DB_HOST=127.0.0.1

>DB_PORT=3306

>DB_DATABASE=*****

>DB_USERNAME=*****

>DB_PASSWORD=*****

Gmail SMTP:

>MAIL_DRIVER=smtp

>MAIL_HOST=smtp.gmail.com

>MAIL_PORT=465

>MAIL_USERNAME=*****

>MAIL_PASSWORD=*****

>MAIL_ENCRYPTION=ssl

>MAIL_FROM_NAME=*****

Credentials for OAuth provider
>GOOGLE_CLIENT_ID=*****

>GOOGLE_CLIENT_SECRET=*****

>GOOGLE_REDIRECT=*****

Pusher Channels credentials
>PUSHER_APP_ID=your-pusher-app-id

>PUSHER_APP_KEY=your-pusher-key

>PUSHER_APP_SECRET=your-pusher-secret

>PUSHER_APP_CLUSTER=mt1

Others
>APP_URL=your-url

>SESSION_DOMAIN=

>FRONTEND_URL=frontend-url

>SANCTUM_STATEFUL_DOMAINS=stateful-domains

>BROADCAST_DRIVER=pusher

5.Generate a new application key

```bash
php artisan key:generate
```

## Migrations

if you've completed getting started section, then migrating database if fairly simple process, just execute:

```bash
php artisan migrate
```

## Development

You can run Laravel's built-in development server by executing:

```bash
php artisan  serve
```
```bash
npm run  dev
```

## Database diagram

![diagram](https://i.ibb.co/DkR0KV8/draw-SQL-movie-quotes-export-2023-06-28.png)
See the [Diagram](https://i.ibb.co/DkR0KV8/draw-SQL-movie-quotes-export-2023-06-28.png)