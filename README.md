## Steps: 
1. Clone github repo and 'cd repo folder'
2. composer install
3. cp .env.example .env
4. php artisan key:generate
5. ./vendor/bin/sail up(you can add alias for sail). 
6. ./vendor/bin/sail artisan migrate --seed

Create/update/delete methods are available only for authorized users.
Only author can update/delete post/comment.

## Heroku: https://crud-news-app.herokuapp.com/
## Postman collection: https://www.getpostman.com/collections/39e3b352814f2231f12c 
