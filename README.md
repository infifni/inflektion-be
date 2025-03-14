## Instructions for running locally
1. Clone the repository
2. Copy .env.local to .env
3. Run ```docker compose -f compose.dev.yaml up -d```
4. Run ```docker compose -f compose.dev.yaml exec workspace bash```
5. Inside container run ```composer install``` and ```php artisan migrate``` to install dependencies and migrate the database.
6. Create client credentials ```php artisan passport:client --password```
7. Exit container with ```exit```
8. Run ```docker compose -f compose.dev.yaml up -d``` to start php-fpm
9. Use client id and secret for obtaining access token (API usage).
10. Postman collection https://bold-robot-966407.postman.co/workspace/Infifni-team~da334426-03cf-434b-b87c-97eff38ebe6c/collection/1272319-06451c0f-b328-42fd-a37a-83f41976b446?action=share&creator=1272319&active-environment=1272319-68c0afb2-5443-49ae-baf3-90dc1397515c
11. Unit tests can be run from container with ```php artisan test```
