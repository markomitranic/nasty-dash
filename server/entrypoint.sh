#!/bin/bash
set -e

cd /app/src
echp "[Waiting] Installing vendors."
composer install

while ! mysqladmin ping --host=${MYSQL_HOST} --user=${MYSQL_USERNAME} --password=${MYSQL_PASSWORD} --silent; do
	echo "[Waiting] Still waiting for MySQL to get ready."
	sleep 3
done

exec "$@"
