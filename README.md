
## Requirements

- Docker (Docker desktop)
- Composer

## Setup instructions

- Clone the repo to your local machine (git clone repo_url)
- From project root run "composer install"
- Build images and bring up containers with:
   - docker compose build --no-cache
   - docker compose up -d
- Run migrations and seeders from a container
   - docker compose exec app php artisan migrate
   - docker compose exec app php artisan db:seed
- Clearing caches (optional)
   - docker compose exec app php artisan cache:clear
   - docker compose exec app php artisan config:clear
   - docker compose exec app php artisan route:clear
- App will be accessible on http://127.0.0.1:8000
   - Admin user:
      - username: admin@admin.com
      - password: password
  - Order import user:
      - username: sladjan@libero.it
      - password: password
- PhpMyadmin is accessible on http://127.0.0.1:8080
- Running a Queue worker manually:
    - docker compose exec app php artisan queue:work
