# Nativo Blog

David Gaitan's Laravel Code Test.

## Requirements

Technologies that needs to be used for developing the code:
- Laravel version 5.7 https://laravel.com/docs/5.7
- Twitter bootstrap min version 3.3 with Flex layout is preferable
- Jquery
- HTML/CSS
- Mysql or Mariadb
- Please share the code via git once ready

## How to install it?

1. Clone this project in your local computer
2. Run `composer install` (php 7.4 is required since it is a Laravel 5.)
3. Copy `.env` file. `cp .env.example .env`
4. Generate app key `php artisan key:generate`
5. Create a mysql database and connect it using laravel .env. By Default it will look for a `root` user and a password named `nativoblog`. See .env to change values.
6. Run migrations by `php artisan migrate`
7. Seed the database by running `php artisan db:seed`
8. Run server `php artisan serve`
9. Go to `localhost:8000` and use `taylor@otwell.com` and `secret` as password to login as an admin. See `database/seeds/DatabaseSeeder.php` file to check for other user types. All users use `secret` as password.

### Bonus
I added some tests to ensure the behavior of permissions in users (I decided build a simple solution instead of using a library to handle it).
`./vendor/bin/phpunit`

### Task description:
The test project is a simple blog creation and management application with different user
types having different access. This project will give us an idea about your Laravel skills
and code quality. Major efforts in css styling is not required. Basic usage of twitter
bootstrap and jquery is required.

1) 3 different types of users are needed 1) Blogger 2) Supervisor 3) Admin. The fields
for users are first name, last name, email, user type, last login. Please add any additional
fields as you seem necessary.

2) The fields for blogs are blog name and description. Please add any additional fields as
you seem necessary.

3) Create a login and registration page. By default all new users are added as ‘Blogger’.

4) Create a database seeder for the initial ‘Admin’ account

5) Each user will have different access according to their user type. Admins have full
access and can view, search, add, edit, delete users and blogs. Supervisors can view,
search, add, edit, delete their own blogs and for the ‘Blogger’ users assigned under them.
Bloggers can view, search, add, edit, delete their own blogs.

A `Blogger` will have following access:
- `Blogger dashboard`
The dashboard will list their personal details, last login and the number of blogs that they have created.
They can update their personal details via a bootstrap modal.

- `Blogs page`
This page lists all the blogs created by the user with pagination of 20. It must have ability to search
content for the blogs via a search field. The bloggers can create, edit, delete blogs from this page.

An `Admin` will have following access:
- `Admin dashboard`
The dashboard will list their personal details. They can update their personal details via a bootstrap
modal. The dashboard will also list the total number of blogs and users by user types.

- `Users page`
This page will list all the users with pagination of 20. Admins can create, edit, delete users from this
page. The admin users can filter users by user types. Admins can assign multiple ‘Blogger’ users to a

- `Supervisor` user account. A `Blogger` can also be under multiple `Supervisor` users.
`Supervisors page`

This page will list out all the `Supervisor` users and the `Blogger` users that are under them.
`Blogs page`

This page will list out blogs from all the users including ‘Admin’, ‘Supervisor’ and ‘Blogger’ users
with pagination of 20. The admins can add, edit, delete any of the listed blogs as well as search the
blogs.

A `Supervisor` will have following access:
- `Supervisor dashboard`
The dashboard will list their personal details. They can update their personal details via a bootstrap
modal. The dashboard will also list the total number of blogs and users that are assigned to them as
`Blogger`.

- `Users page`
This page will list out all the ‘Blogger’ users assigned to the supervisor account. They can only view
these details but can’t change anything.

- `Blogs page`
This page will list out blogs created by them and from the ‘Blogger’ users that are assigned under them
with the pagination of 20. The supervisors can add, edit, delete any of the listed blogs as well as search
the blogs.

Please do use the laravel auth, validator, eloquent ORM and pagination modules. Feel
free to use any additional modules as may seem necessary.