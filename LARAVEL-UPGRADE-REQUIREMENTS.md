# Laravel Upgrade Requirements

## Current project state

- The application runs Laravel 10.30.1 (`laravel/framework: ^10.0`).
- Composer allows PHP `^8.1`.
- The Docker app image uses PHP 8.1 in `docker/php/Dockerfile`. The separate root `Dockerfile` uses PHP 7.4.
- `docker-compose.yml` uses MySQL 5.7.
- The project has an older Laravel Mix 5, Tailwind CSS 1, and Vue 2 frontend build toolchain.
- Existing automated tests are in `tests/`, including feature and browser tests.

## Work required to upgrade to Laravel 13

1. **Upgrade sequentially through major versions.** Plan for Laravel 10 → 11 → 12 → 13, following the upgrade guide for each major version:
   - [Laravel 11 upgrade guide](https://laravel.com/docs/11.x/upgrade)
   - [Laravel 12 upgrade guide](https://laravel.com/docs/12.x/upgrade)
   - [Laravel 13 upgrade guide](https://laravel.com/docs/13.x/upgrade)

2. **Upgrade PHP and the runtime environment.** Laravel 13 requires PHP 8.3 or later. Update the PHP constraint in `composer.json`, the Docker image used by the app, and the production server. Check that the required PHP extensions are available in each environment.

3. **Update Laravel ecosystem dependencies.** Upgrade related packages to versions compatible with each Laravel major. Notable packages in this project include:
   - Jetstream 3 and Sanctum 3, which need newer compatible major versions for Laravel 11.
   - Telescope 4, which needs a newer compatible version for Laravel 11.
   - Collision 7, which needs a newer compatible version for Laravel 11.
   - PHPUnit 10, which needs to move to PHPUnit 11 for Laravel 12, then PHPUnit 12 for Laravel 13.
   - Laravel Tinker 2, which needs a newer compatible version for Laravel 13.

   Confirm exact versions during Composer dependency resolution and review the upgrade notes for each package.

4. **Verify compatibility of other older or custom dependencies.** Pay particular attention to:
   - `unisharp/laravel-filemanager`, currently required from `dev-master`.
   - `hardevine/shoppingcart`.
   - Intervention Image 2 and Intervention Imagecache 2.
   - Spatie Laravel Media Library 10.

   These may need newer compatible releases or replacement. Image-library upgrades may require application-code changes where APIs differ.

5. **Review application code and configuration for breaking changes.** The application uses the Laravel 10 Kernel-based structure in `app/Http/Kernel.php` and `bootstrap/app.php`. Review middleware, exception handling, and application behavior against the upgrade guides; a new Laravel skeleton is not automatically required. Laravel 12 also requires Carbon 3, so review and test date/time calculations.

6. **Plan and test the database upgrade.** MySQL 5.7 is old. Plan an upgrade to a currently supported MySQL version, with a verified backup and tests of migrations and application queries against the target database.

7. **Establish a test baseline and expand regression coverage.** Run the existing tests before starting and at each major upgrade step. Verify important user journeys, especially checkout, carts, authentication, and file uploads.

8. **Check the frontend toolchain separately.** Laravel Mix 5, Tailwind CSS 1, and Vue 2 are old, but are not automatically Laravel 13 blockers. Verify that the asset build and browser behavior still work. Consider frontend modernization as a separate decision.

## Suggested approach

Start with a baseline test run and a Composer compatibility check. Upgrade one Laravel major at a time, resolve package and application-code incompatibilities at each step, and test the application and database before moving to the next major. Do not deploy until the production PHP runtime, required extensions, database, asset build, and key user journeys have been verified.
