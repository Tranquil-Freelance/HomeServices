#!/bin/bash
set -e

# WordPress docker-entrypoint skips copying wp-content/*/*/ paths that already exist on disk
# (see docker-library/wordpress#506). Stale ashade / ashade-child folders then never update on deploy.
# After WordPress extracts into /var/www/html, overwrite our bundled themes from the image layer.
ashade_child_sync_bundled_themes() {
	local src="/usr/src/wordpress/wp-content/themes"
	local dest="/var/www/html/wp-content/themes"
	if [[ ! -d "${src}/ashade-child" ]]; then
		echo ">>> (skip) No bundled ashade-child in ${src}"
		return 0
	fi
	if [[ ! -d "${dest}" ]]; then
		return 0
	fi
	echo ">>> Overwriting Ashade themes from image → ${dest} (deploy-safe refresh)"
	rm -rf "${dest}/ashade" "${dest}/ashade-child"
	mkdir -p "${dest}"
	cp -a "${src}/ashade" "${src}/ashade-child" "${dest}/"
	chown -R www-data:www-data "${dest}/ashade" "${dest}/ashade-child" 2>/dev/null || true
	echo ">>> Theme sync complete ($(grep 'Version:' "${dest}/ashade-child/style.css" 2>/dev/null | head -1 || echo 'ashade-child'))"
}

(
	set +e
	sleep 2
	for _i in $( seq 1 120 ); do
		if [[ -f /var/www/html/wp-includes/version.php ]] && [[ -d /var/www/html/wp-content/themes ]]; then
			ashade_child_sync_bundled_themes
			break
		fi
		sleep 1
	done
) &

# Render private MySQL exposes 3306; blueprint `hostport` wrongly used port 10000 (probe).
if [[ -n "${WORDPRESS_DB_HOST:-}" ]]; then
  case "$WORDPRESS_DB_HOST" in
    *:10000) export WORDPRESS_DB_HOST="${WORDPRESS_DB_HOST%:10000}:3306" ;;
    *:*)     ;;
    *)       export WORDPRESS_DB_HOST="${WORDPRESS_DB_HOST}:3306" ;;
  esac
  echo ">>> WORDPRESS_DB_HOST=${WORDPRESS_DB_HOST}"
fi

# Give Render private DNS time; log clearly if MySQL hostname never appears (mislinked env / missing pserv).
if [[ -n "${WORDPRESS_DB_HOST:-}" ]]; then
	db_hostonly="${WORDPRESS_DB_HOST%%:*}"
	if [[ -n "$db_hostonly" ]]; then
		_ok=0
		for _i in $( seq 1 45 ); do
			if getent ahosts "$db_hostonly" >/dev/null 2>&1; then
				echo ">>> Database hostname resolves on private network: ${db_hostonly}"
				_ok=1
				break
			fi
			echo ">>> Waiting for DB host DNS (${db_hostonly}) attempt ${_i}/45..."
			sleep 2
		done
		if [[ "$_ok" -ne 1 ]]; then
			echo ">>> ERROR: Cannot resolve DB host '${db_hostonly}'. On Render: start the MySQL private service,"
			echo ">>> use the Internal address from its Connect tab as WORDPRESS_DB_HOST (or re-apply Blueprint fromService)."
		fi
	fi
fi

echo ">>> Ensuring writable uploads directory..."
mkdir -p /var/www/html/wp-content/uploads
chown -R www-data:www-data /var/www/html/wp-content/uploads
chmod -R 755 /var/www/html/wp-content/uploads
chown -R www-data:www-data /var/www/html/wp-content/plugins 2>/dev/null || true
chown -R www-data:www-data /var/www/html/wp-content/themes 2>/dev/null || true

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

echo ">>> Starting Apache on port ${PORT} (database is external)..."
exec docker-entrypoint.sh apache2-foreground
