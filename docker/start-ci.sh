#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f env ]; then
  cp env .env
fi

until php -r '
  mysqli_report(MYSQLI_REPORT_OFF);
  $host = getenv("DB_HOST") ?: "db";
  $port = (int) (getenv("DB_PORT") ?: 3306);
  $user = "ci4user";
  $pass = "ci4pass";
  $db = "lab_ci4";
  $conn = @new mysqli($host, $user, $pass, $db, $port);
  if ($conn->connect_error) {
    exit(1);
  }
  $conn->close();
' >/dev/null 2>&1; do
  echo "Waiting for database connection..."
  sleep 2
done

if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist
fi

mkdir -p writable/cache writable/session writable/logs writable/uploads
chown -R www-data:www-data writable

php spark migrate --all --no-interaction
php spark db:seed InitialSeeder --no-interaction

apache2-foreground
