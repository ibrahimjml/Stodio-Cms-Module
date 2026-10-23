# Stodio CMS

Stodio CMS is a modular content management system built with Laravel 13. Its features are organized into independent modules. The project includes two guards for administration and members, covering administration, access control, member management, activity logging, and module management.

## Requirements

- PHP 8.3 or later, with the PHP extensions required by Laravel 13 and Composer dependencies
- Composer 2
- Bun 

## Installation

1. Clone the repository and change into the project directory.
2. Install PHP dependencies, configure the environment, migrate the database, install frontend packages, and build the assets:

   ```bash
   composer run setup
   ```

   The setup script runs `composer install`, creates `.env` from `.env.example` when needed, generates the application key, runs migrations, then runs `bun install --ignore-scripts` and `bun run build`.

3. Review `.env`. SQLite is configured by default. If using another database, set `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` to match your database before running migrations.
4. Start the local development processes:

   ```bash
   composer run dev
   ```

   This starts the Laravel development server, queue listener, and Vite development server. Open the local URL shown by Laravel in the terminal.

## Screenshots

### 🔐 Authentication

| Admin Login | Member Login |
| :---: | :---: |
| ![Admin Login](https://i.postimg.cc/3JMFg9CK/Screenshot-2026-10-14-222003.png) | ![Member Login](https://i.postimg.cc/httzx7w4/Screenshot-2026-10-14-222020.png) |

### Control Panel

| Dashboard (light) | Dashboard (dark) |
| :---: | :---: |
| ![Panel light](https://i.postimg.cc/zD298mN3/Screenshot-2026-10-14-222743.png) | ![Panel dark](https://i.postimg.cc/Qt0vFwW4/Screenshot-2026-10-14-222718.png) |

### Users Management

| Users List | Users Profile |
| :---: | :---: |
| ![Users Page](https://i.postimg.cc/2662K6VS/Screenshot-2026-10-14-220118.png) | ![Users Profile](https://i.postimg.cc/HkdKtT4s/Screenshot-2026-10-14-220200.png) |

### Roles Management

| Roles List | Roles Show |
| :---: | :---: |
| ![Roles Page](https://i.postimg.cc/NM6mbvxb/Screenshot-2026-10-14-223455.png) | ![Roles Show](https://i.postimg.cc/yN9ZYC2K/Screenshot-2026-10-14-220047.png) |### Roles Management

### Audit Logs

| Audit Logs List 
| :---: 
| ![Audit Logs](https://i.postimg.cc/xCZDsBjZ/Screenshot-2026-10-14-220349.png) 

### Modules Management

| Modules List 
| :---: 
| ![Modules List](https://i.postimg.cc/k5kLKKjq/Screenshot-2026-10-14-224253.png) 


## Create an administrator

Create a superuser by running:

```bash
php artisan stodio:user:create
```

Follow the prompts to enter a first name, last name, username, email address, and password. Then open `/admin/login` on your local application and sign in. To synchronize ACL permissions and seed the Acl module's roles and permissions, run:

```bash
# sync permissions via modules config files
php artisan stodio:acl:sync
# seed permissions + roles
php artisan module:seed Acl
```
## Publish Assets for local and prod

```bash
# pass --force in prod
php artisan vendor:publish --tag=stodio-assets

```

## Modules

| Module | Purpose |
| --- | --- |
| Core | Shared layouts, components, facades, and settings |
| Admin | Administration dashboard and theme |
| Acl | User access control and permissions |
| Member | Application member management |
| Auditlog | User activity tracking |
| ModuleManagement | Module listing, activation, and migrations |

### Add and activate a module

1. Place the module in the `Modules/` directory.
2. In the admin dashboard, open **Modules** and activate it.
3. Run the module's pending migrations from the module management screen.

To keep core modules out of the admin module listing, add them to the `excluded_modules` array in `Modules/ModuleManagement/Config/config.php`.

### Create and migrate a module

```bash
php artisan module:make ModuleName
php artisan module:migrate ModuleName
```

To roll back a module's migrations:

```bash
php artisan module:migrate-rollback ModuleName
```

## Frontend commands

Install frontend dependencies and build production assets:

```bash
bun install --ignore-scripts
bun run build
```

During development, `composer run dev` starts Vite alongside the Laravel server and queue listener. To run only Vite, use `bun run dev`.

## Tests

Run the test suite with:

```bash
composer run test
```
