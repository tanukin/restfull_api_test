RESTful API Laravel
===
### Getting Started
Download the project to your host machine
#### Prerequisites
```
docker CE
docker-compose
```
#### Installing
```
composer install
```
#### Usage
```
docker-comose up -d
docker exec appRestfull php artisan migrate
```
#### Fake data
```
php artisan db:seed
```

#### Route list
Request method|URI|api authentication (passport)
------|----|-----------
GET| api/v1/products|
POST| api/v1/products|yes
GET| api/v1/products/{product}|
PUT| api/v1/products/{product}|yes
DELETE| api/v1/products/{product}|yes
GET| api/v1/products/{product}/reviews|     
POST| api/v1/products/{product}/reviews|yes
GET| api/v1/products/{product}/reviews/{review}|     
DELETE| api/v1/products/{product}/reviews/{review}|yes
PUT| api/v1/products/{product}/reviews/{review}|yes
