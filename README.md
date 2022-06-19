# Description
Sample tasks
 Createa new Laravel project using the CLI and composer
 Setup a SQLite database file in the database folder and configure Laravel for using it.
 Create a new model and migration with the following structure: News { title, content, user_id, created_at, updated_at }
 Create a new controller with CRUD functions for the news object and add routes to it.
 Create a Feature-Test foreach CRUD endpoint and validate the JSON result and response.
 Create a factory for the news object and fake content using Faker.
 Create a new event NewsCreated and fire it everytime a new news object is
created from the controller.
 Create a CRON job deleting all news entries older than 14 days which runs every day.
 Add your first belongsTo relation between the news and user object using the user_id column of the News.
 Add Laravel's default authentication to your routes and update your Feature-Tests using the $this->actingAs($user)->get(...) method.
 Assign every new news entry to the current user $request->user() will return the current user.
Sample tasks 1
📐

# Installation
* PHP 8.0+

```git clone git@github.com:b059ae/sdui.git && cd sdui```

```composer install```

```cp .env.example .env```

Specify DB connection in .env file. The easiest way is to use sqlite.

```touch database/database.sqlite```

Add absolute path to .env file DB_DATABASE

```php artisan key:generate```

```php artisan migrate```

# Tests

```php artisan test```

# Run
```php artisan serve```

Open [http://localhost:8000/](http://localhost:8000/)

# Console commands

## Create user

```docker-compose exec app php artisan create:user user@foo.com password```

## Delete news older than X days

```docker-compose exec app php artisan news:delete --days=14```

# Endpoints

## News

### Store
```
POST http://localhost:8000/api/news
Content-Type: application/json
Accept: application/json
Authorization: Bearer AUTH_TOKEN

{
  "title": "any title",
  "content": "any content"
}
```

### Update
```
PUT http://localhost:8000/api/news/:id
Content-Type: application/json
Accept: application/json
Authorization: Bearer AUTH_TOKEN

{
  "title": "new title",
  "content": "new content"
}
```

### Index
```
GET http://localhost:8000/api/news
Content-Type: application/json
Accept: application/json
Authorization: Bearer AUTH_TOKEN
```

### Show
```
GET http://localhost:8000/api/news/:id
Content-Type: application/json
Accept: application/json
Authorization: Bearer AUTH_TOKEN
```

### Delete
```
DELETE http://localhost:8000/api/news/:id
Content-Type: application/json
Accept: application/json
Authorization: Bearer AUTH_TOKEN
```
