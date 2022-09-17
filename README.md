
# Sanctum Auth boilerplate

A small boilerplate based on Breeze with some modifications



## FAQ

#### Isn't Laravel starter authentication kits enough?

this is just a placeholder for future open source projects, restructered with the repository pattern, for extra customization, you have `App\Repositories\AuthenticationRepository` to extend based on the need or different approach!.





## Installation

clone the repo 

`git clone git@github.com:benounnas/Sanctum-Authentication-Boilerplate.git`

Laravel uses `composer` as php package manager, make sure you install it to run `composer install`

`cd` to the project and run the following commands:

copy the env example file : `copy .env.example .env` (windows), `cp .env.example .env` (Linux/Mac)

set your `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` credentials.

make sure that `QUEUE_CONNECTION` is `database`

start migrationg your database by ` php artisan migrate`

generate your app key by `php artisan key:generate`

start your server by `php artisan serve`






## API Reference

#### Register user

```http
  POST /api/register
```

| Fields | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**. and must be unique  |
| `password` | `string` | **Required**.  minimum 8 letters, one letter uppercase at least,<br> contain at least one number, symbol |
| `password_confirmation` | `string` | **Required**  |
| `first_name` | `string` | **Required**.  |
| `last_name` | `string` | **Required**.  |
| `phone_number` | `string` | Optional.  |

#### Login user

```http
  POST /api/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**.   |
| `password` | `string` | **Required**.  |



#### Forgot password email endpoint

```http
  POST /api/forgot-password
```
Make sure you set the mail env variables & **the command** `php artisan queue:work` **is running!**

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**. and must be registered   |


#### Reset password from the email received

```http
  POST /api/reset-password
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**. and must be unique  |
| `token` | `string` | **Required**. and must match the `token` query param sent in the email (`mydomain.com?token=..`) |
| `password` | `string` | **Required**.  minimum 8 letters, one letter uppercase at least,<br> contain at least one number, symbol |
| `password_confirmation` | `string` | **Required**  |

#### Logout user

```http
  POST /api/logout
```

