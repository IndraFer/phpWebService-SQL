# Dockerized PHP Web Services

This repository provides a ready-to-use, fully containerized web service environment using PHP-FPM, Nginx, and your choice of a relational database (MariaDB/MySQL or PostgreSQL). 

It is designed to be highly portable and works seamlessly across various container engines and operating systems.

## 🚀 Compatibility

This setup is fully compatible with:
- **Docker Desktop** (Windows, macOS, Linux)
- **Podman** / Podman Desktop
- **OrbStack** (macOS)

## 📂 Project Structure

The project is divided into two separate stacks so you can choose the database that fits your needs:

- `webservice.my/` - Stack with **MariaDB** (MySQL compatible), **Redis**, and **phpMyAdmin**
- `webservice.pg/` - Stack with **PostgreSQL**, **Redis**, and **pgAdmin**

Both stacks include:
- **Nginx** (Web Server)
- **PHP-FPM** (Application Processor, pre-configured with required database extensions)
- **Redis** (in-memory cache / session / queue store, useful for apps in any language)
- Database data bound to the host (persists data safely across restarts)

## 🛠️ Getting Started

Follow these steps to spin up your preferred environment:

### 1. Choose Your Stack
Navigate to the directory of the database you want to use.

For MySQL/MariaDB:
```bash
cd webservice.my
```

For PostgreSQL:
```bash
cd webservice.pg
```

### 2. Configure Environment Variables
Both stacks use a `.env` file to manage database credentials securely. We provide a `.env.example` file in each folder.

Copy the example file to `.env`:
```bash
cp .env.example .env
```
*Note: You can edit the newly created `.env` file to change the default usernames, passwords, and database names.*

### 3. Run the Containers
Start the services in detached mode with the build flag (to ensure the custom PHP-FPM image is built correctly):

```bash
docker compose up -d --build
```
*(If you are using podman, you can use `podman-compose up -d --build`)*

### 4. Access the Services
Once the containers are up and running, you can access your services via your web browser:

- **Web Application (Nginx/PHP):** `http://localhost` or `https://localhost` (if SSL is configured)
- **Database Manager:** `http://localhost:8081` (phpMyAdmin or pgAdmin, depending on the stack)

## ⚙️ Environment Variables Explained

### For `webservice.my` (MariaDB + phpMyAdmin)
- `MYSQL_ROOT_PASSWORD`: The root password for MariaDB.
- `MYSQL_DATABASE`: The default database created upon initialization.
- `MYSQL_USER`: The default user created.
- `MYSQL_PASSWORD`: The password for the default user.
- `PMA_HOST`: Hostname for phpMyAdmin to connect to (default is `mariadb`).
- `PMA_USER`: Username for phpMyAdmin login.
- `PMA_PASSWORD`: Password for phpMyAdmin login.
- `REDIS_PASSWORD`: Password for Redis (`--requirepass`). Enable it by uncommenting the `command` line provided in `docker-compose.yml`.

### For `webservice.pg` (PostgreSQL + pgAdmin)
- `POSTGRES_USER`: The root/default user for PostgreSQL.
- `POSTGRES_PASSWORD`: The password for the PostgreSQL user.
- `POSTGRES_DB`: The default database created upon initialization.
- `PGADMIN_DEFAULT_EMAIL`: The email address used to log in to pgAdmin web interface.
- `PGADMIN_DEFAULT_PASSWORD`: The password used to log in to pgAdmin.
- `REDIS_PASSWORD`: Password for Redis (`--requirepass`). Enable it by uncommenting the `command` line provided in `docker-compose.yml`.

## 💾 Data Persistence
Database volumes are mounted directly to your host machine (`./mariadb_data` for MySQL, `./postgres_data` for PostgreSQL, and `./redis_data` for Redis). This ensures that your database data will not be lost if the containers are removed or rebuilt. It also makes it easy to access the data files from Windows, macOS, or Linux.

## ⚡ Using Redis

Redis is exposed on `localhost:6379` and is ready to be consumed by applications in any language (Python, Go, Node.js, PHP, etc.) as an in-memory cache, session store, or queue broker.

- **Host apps** connect to `127.0.0.1:6379` (no password by default).
- **Containers inside the stack** connect to the service name `redis` on the `app-network`.
- **Auth (optional):** add `REDIS_PASSWORD` to your `.env`, then uncomment the `command` line with `--requirepass` in `docker-compose.yml` (and the matching healthcheck line).
- Persistence is enabled via AOF (`--appendonly yes`), so cache data survives container restarts.

## 🐘 PHP Configuration
By default, the PHP configurations are set within the Dockerfile (e.g., OPcache). If you need to add custom configurations via a `php.ini` file:
1. Create a `php.ini` file in the root of your chosen stack.
2. Uncomment the line `# COPY ./php.ini /usr/local/etc/php/` inside the `dockerfile-phpfpm` file.
3. Rebuild the container: `docker compose up -d --build`.

## 🛑 Stopping the Services
To stop and remove the running containers, networks, and anonymous volumes, run:
```bash
docker compose down
```