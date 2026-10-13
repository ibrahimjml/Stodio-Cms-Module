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

| ![Admin Dashboard](https://i.postimg.cc/v84Xv7Vb/Screenshot-2026-10-12-214219.png) | ![User Management](https://i.postimg.cc/yN536RY0/Screenshot-2026-10-12-214314.png) |
|:---:|:---:|
| ![Role Management](https://i.postimg.cc/fy7Vvg7g/Screenshot-2026-10-12-214329.png) | ![Audit log](https://i.postimg.cc/X74XxskG/Screenshot-2026-10-13-175707.png) |
| ![Module Management](https://i.postimg.cc/PqPbXThY/Screenshot-2026-10-12-214155.png) | 


## Create an administrator

Create a superuser by running:

```bash
php artisan stodio:user:create
```

Follow the prompts to enter a first name, last name, username, email address, and password. Then open `/admin/login` on your local application and sign in. To synchronize ACL permissions and seed the Acl module's roles and permissions, run:

```bash
php artisan stodio:acl:sync
php artisan module:seed Acl
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
php artisan module:migrate:rollback ModuleName
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
