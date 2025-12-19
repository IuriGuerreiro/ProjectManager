# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 11 application for managing projects, trainings, teams, and users (Gestor de projetos, formações e equipas). The application uses PHP 8.2+ and includes Vite for frontend asset compilation.

## Authentication

This application uses Laravel Breeze for authentication with the following features:
- **Open user registration** with email verification required
- **Password reset** via email (emails logged to `storage/logs/laravel.log` in development)
- **Remember Me** functionality for persistent login
- **Role-based user management** through the admin interface
- All routes are protected with `auth` and `verified` middleware

### Email Setup

**Development:** Set `MAIL_MAILER=log` in `.env` to log emails to `storage/logs/laravel.log`.

**Production:** Configure SMTP settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

### First User Creation

Create the first admin user via artisan tinker:
```bash
docker-compose exec app php artisan tinker
```
Then:
```php
$user = new App\Models\Users();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('password');
$user->email_verified_at = now();
$user->save();
```

Or register through the web interface at `/register` and verify email from logs.

## Development Commands

### Docker Setup (Recommended)

Start all services (MySQL database, Laravel app, and Vite dev server):
```bash
docker-compose up -d              # Start all containers in background
docker-compose exec app composer install  # Install PHP dependencies
docker-compose exec app cp .env.example .env  # Create environment file
docker-compose exec app php artisan key:generate  # Generate app key
docker-compose exec app php artisan migrate      # Run migrations
docker-compose down               # Stop all containers
docker-compose logs -f app        # View application logs
```

The application will be available at:
- Laravel app: http://localhost:8005
- Vite dev server: http://localhost:5173
- MySQL: localhost:3306

### Local Installation & Setup (Without Docker)
```bash
composer install          # Install PHP dependencies
npm install              # Install Node.js dependencies
cp .env.example .env     # Create environment file
php artisan key:generate # Generate application key
php artisan migrate      # Run database migrations
```

Note: For local setup, you'll need PHP 8.2+, Composer, Node.js, and MySQL installed.

### Development
```bash
npm run dev              # Start Vite dev server with hot reload
php artisan serve        # Start Laravel development server (default: http://127.0.0.1:8000)
```

### Building & Testing
```bash
npm run build            # Build production assets with Vite
php artisan pint         # Run Laravel Pint code formatter
vendor/bin/phpunit       # Run all PHPUnit tests
vendor/bin/phpunit tests/Unit           # Run unit tests only
vendor/bin/phpunit tests/Feature        # Run feature tests only
vendor/bin/phpunit --filter=testName    # Run specific test
```

### Database
```bash
php artisan migrate              # Run pending migrations
php artisan migrate:fresh        # Drop all tables and re-run migrations
php artisan migrate:fresh --seed # Fresh migration with seeders
php artisan db:seed              # Run database seeders
```

### Other Useful Commands
```bash
php artisan tinker       # Interactive REPL for Laravel
php artisan route:list   # List all registered routes
php artisan cache:clear  # Clear application cache
php artisan config:clear # Clear configuration cache
php artisan view:clear   # Clear compiled view files
```

## Architecture Overview

### Core Domain Structure

The application manages four main entities with many-to-many relationships:

1. **Projects** - Tracked with tasks, assigned to users and teams
2. **Trainings** (Formações) - Educational programs with formers and participants
3. **Teams** (Equipas) - Groups of users that can be assigned to projects
4. **Users** - System users with roles, assigned to projects, tasks, teams, and trainings

### Key Relationships

- **Projects ↔ Users**: Many-to-many via `projects_users` pivot table
- **Projects ↔ Teams**: Many-to-many via `teams_projects` pivot table
- **Projects → Tasks**: One-to-many relationship
- **Tasks ↔ Users**: Many-to-many via `task_users` pivot table
- **Teams ↔ Users**: Many-to-many via `teams_users` pivot table
- **Trainings ↔ Users**: Many-to-many via `training_users` pivot table
- **Trainings ↔ Formers**: Many-to-many via `training_formers` pivot table
- **Users ↔ Roles**: Many-to-many via `user_roles` pivot table

### Model Conventions

All models use:
- `SoftDeletes` trait - Records are soft-deleted, not permanently removed
- `HasFactory` trait - For database seeding and testing
- Explicit `$fillable` properties for mass assignment protection

### Controller Architecture

Controllers follow a resource pattern with these common methods:
- `index()/list()` - List all records
- `create()` - Show create form
- `store()` - Save new record
- `view($id)` - Show single record
- `edit($id)` - Show edit form
- `update($id)` - Update existing record
- `delete($id)` - Soft delete record

Pivot relationship controllers (e.g., `ProjectUsersController`, `TasksUsersController`, `TeamProjectController`) handle attaching/detaching related records.

### Routing Patterns

All routes are defined in `routes/web.php` with named routes. Common patterns:
- `/entity` - List view
- `/entity/create` - Create form
- `/entity/view/{id}` - Detail view
- `/entity/edit/{id}` - Edit form
- `/entity/delete/{id}` - Delete action (GET-based, not RESTful)
- POST routes for `store` and `update` operations

Note: The application uses GET requests for delete operations rather than DELETE HTTP methods.

### View Structure

Blade templates are organized by entity in `resources/views/`:
- `layouts/` - Main layout files (`app.blade.php`, `index.blade.php`)
- `users/`, `projects/`, `tasks/`, `teams/`, `trainings/`, `formers/` - Entity-specific views
- Each entity folder typically contains: `index.blade.php`, `create.blade.php`, `edit.blade.php`, `view.blade.php`
- Special views for relationship management (e.g., `addRoles.blade.php`, `addProjectToTeam.blade.php`)

### Database Considerations

- Database uses timestamped migrations starting from 2024-06-04
- Initial migration created `colaborator` tables which were later migrated to use the main `users` table
- All entity tables include `deleted_at` for soft deletes
- Project status tracked via separate `pm_status` table
- Migration history shows evolution from colaborator-based to user-based assignments

### Frontend Assets

- Vite handles asset compilation
- Entry points: `resources/css/app.css` and `resources/js/app.js`
- Uses `laravel-vite-plugin` for Laravel integration
- Axios included for HTTP requests

## Project-Specific Notes

### Naming Inconsistencies
- Some controller names use inconsistent casing (e.g., `userController` vs `UserController`, `TasksusersController` vs `TasksUsersController`)
- Model naming varies: `Teams`, `Trainings`, `Formers` use plural while `Project`, `Task`, `User` use singular
- Pivot models exist as separate classes: `ProjectsUsers`, `TaskUsers`, `Teams_users`, `Teams_projects`, `TrainingUsers`, `TrainingFormers`, `UserRoles`

### Language Mix
- The codebase mixes English and Portuguese terminology
- "Formers" = trainers/instructors (formadores in Portuguese)
- "Trainings" = educational programs/courses (formações in Portuguese)

## Docker Configuration

### Services
- **ProjectManager-db**: MySQL 8.0 database container
  - Database: `project_manager`
  - User: `project_user`
  - Password: `project_password`
  - Port: 3306

- **app**: Laravel application container
  - PHP 8.2-CLI
  - Runs on port 8005
  - Auto-connects to ProjectManager-db

- **node**: Node.js 20 container for Vite
  - Runs Vite dev server on port 5173
  - Hot module replacement enabled

### Database Credentials
The .env.example file is configured to work with Docker out of the box. Database connection:
- Host: `ProjectManager-db` (in Docker) or `127.0.0.1` (local)
- Port: `3306`
- Database: `project_manager`
- Username: `project_user`
- Password: `project_password`

## Performance Optimization

### Current Optimizations
- **PHP opcache enabled**: Caches compiled PHP code for faster execution
  - `opcache.enable=1`
  - `opcache.max_accelerated_files=10000`
  - `opcache.memory_consumption=256`
  - `opcache.validate_timestamps=1` (revalidates on every request in development)

### CRITICAL: WSL2 File System Performance Issue

**Problem:** If your project is located on a Windows drive mounted in WSL2 (e.g., `/mnt/c/`, `/mnt/d/`, `/mnt/f/`), you will experience SEVERE performance degradation. File I/O operations are 10-50x slower when accessing Windows filesystems from WSL2.

**Solution:** Move your project to WSL2's native filesystem for dramatically better performance.

#### How to Move Project to WSL2:

1. **Backup your current work** (if you have uncommitted changes):
   ```bash
   cd /mnt/f/Projects/Programmes/WebApps/Gestor-de-projetos-formacoes-e-equipas
   git status
   git add . && git commit -m "Backup before move"
   ```

2. **Clone/move to WSL2 native filesystem**:
   ```bash
   # Create projects directory in WSL2 home
   mkdir -p ~/projects

   # Option A: If using git, clone fresh
   cd ~/projects
   git clone <your-repo-url> Gestor-de-projetos-formacoes-e-equipas

   # Option B: If no git, copy the files
   cp -r /mnt/f/Projects/Programmes/WebApps/Gestor-de-projetos-formacoes-e-equipas ~/projects/
   ```

3. **Navigate to new location**:
   ```bash
   cd ~/projects/Gestor-de-projetos-formacoes-e-equipas
   ```

4. **Rebuild containers** (volumes will now mount from WSL2 filesystem):
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

**Performance Comparison:**
- Windows mount (`/mnt/f/`): ~2-5 seconds per page load
- WSL2 native (`~/projects/`): ~100-300ms per page load

### Additional Performance Tips

- Use `composer install --optimize-autoloader` for production
- Run `php artisan config:cache` and `php artisan route:cache` in production
- Enable browser caching for static assets
- Consider using Redis for cache and sessions in production

## Authentication Routes

**Public Routes:**
- `GET /` - Redirects to login
- `GET /login` - Login page
- `POST /login` - Authenticate user
- `GET /register` - Registration page
- `POST /register` - Create new user
- `GET /forgot-password` - Password reset request
- `POST /forgot-password` - Send reset link
- `GET /reset-password/{token}` - Password reset form
- `POST /reset-password` - Reset password

**Protected Routes (require auth + email verification):**
- All application routes (`/dashboard`, `/Project`, `/task`, `/users`, `/teams`, `/trainings`, `/formers`)
- `GET /profile` - Edit profile
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete account
- `POST /logout` - Logout

**Email Verification:**
- `GET /verify-email` - Email verification prompt
- `GET /verify-email/{id}/{hash}` - Verify email link
- `POST /email/verification-notification` - Resend verification email
