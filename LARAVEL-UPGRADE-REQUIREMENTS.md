# Laravel Upgrade Requirements

## Current project state

- The application runs Laravel 10.30.1 (`laravel/framework: ^10.0`).
- Composer allows PHP `^8.1`.
- The local environment runs on Podman (`podman compose`). The app image in `docker/php/Containerfile` uses PHP 8.3 (done), and `compose.yaml` uses MySQL 8.4 LTS (done). The old PHP 7.4 root `Dockerfile` has been removed.
- The production PHP and MySQL versions still need to be confirmed.
- The project has an older Laravel Mix 5, Tailwind CSS 1, and Vue 2 frontend build toolchain. `package.json` has no direct `vue` dependency, only `vue-template-compiler ^2.6`.
- Existing automated tests are in `tests/`. `phpunit.xml` runs only the Unit and Feature suites. The browser tests in `tests/Browser` use Laravel Dusk, but Dusk is not installed, so they cannot currently run.

## Work required to upgrade to Laravel 13

1. **Upgrade sequentially through major versions.** Plan for Laravel 10 → 11 → 12 → 13, following the upgrade guide for each major version:
   - [Laravel 11 upgrade guide](https://laravel.com/docs/11.x/upgrade)
   - [Laravel 12 upgrade guide](https://laravel.com/docs/12.x/upgrade)
   - [Laravel 13 upgrade guide](https://laravel.com/docs/13.x/upgrade)

2. **Upgrade PHP and the runtime environment.** Laravel 13 requires PHP 8.3 or later. Update the PHP constraint in `composer.json`, the app container image, and the production server. Check that the required PHP extensions are available in each environment.

3. **Update Laravel ecosystem dependencies.** Upgrade related packages to versions compatible with each Laravel major. Notable packages in this project include:
   - Jetstream 3 and Sanctum 3, which need newer compatible major versions for Laravel 11.
   - Telescope 4, which needs a newer compatible version for Laravel 11.
   - Collision 7, which needs a newer compatible version for Laravel 11.
   - PHPUnit 10, which needs to move to PHPUnit 11 for Laravel 12, then PHPUnit 12 for Laravel 13.
   - Laravel Tinker 2, which needs a newer compatible version for Laravel 13.
   - Laravel Fortify 1, which must be checked alongside the Jetstream upgrade.
   - Telescope is required as `"*"`. Pin it to an explicit compatible version.

   Confirm exact versions during Composer dependency resolution and review the upgrade notes for each package.

4. **Remove Doctrine DBAL before Laravel 11.** Laravel 11 drops Doctrine DBAL support. The project requires `doctrine/dbal ^3.6` directly, and `database/migrations/2017_04_11_000000_alter_post_nullable_fields_table.php` calls `DB::getDoctrineSchemaManager()`, which no longer exists. Rewrite that migration, or squash older migrations into a schema dump, and then remove `doctrine/dbal`. The same migration uses `->change()`. In Laravel 11, a column modification must restate every attribute to keep, such as nullable, default, and comment, or those attributes are dropped.

5. **Verify compatibility of other older or custom dependencies.** Pay particular attention to:
   - `unisharp/laravel-filemanager`, currently required from `dev-master`.
   - `hardevine/shoppingcart`.
   - Intervention Image 2 and Intervention Imagecache 2.
   - Spatie Laravel Media Library 10.
   - `appstract/laravel-options` 5.
   - `barryvdh/laravel-dompdf` 2 and `barryvdh/laravel-debugbar` 3.
   - `spatie/laravel-honeypot` 4 and `spatie/laravel-ignition` 2.
   - `laravel-validation-rules/credit-card` 1.8.
   - The custom Composer repositories: the `larapack.io` repository used for `hooks`, which may no longer be available, and the private `llebkered/laravel-tinymce-simple-imageupload` git package. Confirm that both still resolve.

   These may need newer compatible releases or replacement. Image-library upgrades may require application-code changes where APIs differ.

6. **Review application code and configuration for breaking changes.** The application uses the Laravel 10 Kernel-based structure in `app/Http/Kernel.php` and `bootstrap/app.php`. Review middleware, exception handling, and application behavior against the upgrade guides; a new Laravel skeleton is not automatically required. Laravel 12 also requires Carbon 3, so review and test date/time calculations.

7. **Plan and test the database upgrade.** MySQL 5.7 is old. Plan an upgrade to a currently supported MySQL version, with a verified backup and tests of migrations and application queries against the target database.

8. **Establish a test baseline and expand regression coverage.** Run the existing tests before starting and at each major upgrade step. Either install Laravel Dusk so the browser tests can run, or leave them out of the baseline. Verify important user journeys, especially checkout, carts, authentication, and file uploads.

9. **Check the frontend toolchain separately.** Laravel Mix 5, Tailwind CSS 1, and Vue 2 are old, but are not automatically Laravel 13 blockers. Verify that the asset build and browser behavior still work. Consider frontend modernization as a separate decision.

## Suggested approach

Start with a baseline test run and a Composer compatibility check. Upgrade one Laravel major at a time, resolve package and application-code incompatibilities at each step, and test the application and database before moving to the next major. Do not deploy until the production PHP runtime, required extensions, database, asset build, and key user journeys have been verified.

## Step-by-step upgrade plan

Work on a dedicated branch and commit after each step, so any step can be reverted on its own.

### Phase 0: Preparation (on Laravel 10)

1. Create an upgrade branch from `master`.
2. Take a verified backup of the production database and uploaded files (Media Library and file manager storage).
3. ~~Run `php artisan test` and record the results as the baseline.~~ Done: 32 tests passed (134 assertions) on Laravel 10 under PHP 8.3.
4. Decide whether the Dusk browser tests are in scope. If they are, install `laravel/dusk` and get them passing on Laravel 10 first.
5. Add feature tests for the key journeys if they do not exist yet: login and registration, adding to the cart, checkout, and file and image uploads.
6. ~~Confirm that the custom Composer repositories still resolve.~~ Done: `larapack.io` no longer works, and nothing required either repository, so both were removed.
7. ~~Check package support for Laravel 11 to 13.~~ Done:
   - `intervention/imagecache` was unused and abandoned, so it was removed.
   - `appstract/laravel-options` stopped at Laravel 10. It was replaced with `App\Models\Option`, bound as `option`, so the `option()` helper still works.
   - `unisharp/laravel-filemanager` is pinned to `^2.10` (v2.10.1), the last version that supports Intervention Image 2. Laravel 13 needs v2.13+, which requires Intervention Image 3, so the `Image::make()` calls in `BackendPageController` and `BackendBlockController` must be migrated before Phase 4.
   - `hardevine/shoppingcart` 3.4 supports Laravel 11.
8. ~~Remove Doctrine DBAL.~~ Done as part of the Laravel 11 update. The migration's `->change()` calls only needed `nullable`, so no other attributes had to be restated:
   - Rewrite `database/migrations/2017_04_11_000000_alter_post_nullable_fields_table.php` so that it no longer calls `getDoctrineSchemaManager()`, and make its `->change()` calls restate every column attribute to keep. Alternatively, run `php artisan schema:dump --prune` to squash the old migrations.
   - Remove `doctrine/dbal` from `composer.json`, run `composer update`, and run the tests.
9. ~~Pin `laravel/telescope`.~~ Done: `^5.0`.

### Phase 1: Runtime

10. ~~Update the app image to PHP 8.3 and remove the PHP 7.4 root `Dockerfile`.~~ Done: `docker/php/Containerfile` is on PHP 8.3, and the image builds with `podman compose build`.
11. ~~Change the `php` constraint in `composer.json` to `^8.3`.~~ Done.
12. Confirm that the production server can run PHP 8.3 with the required extensions (for example GD or Imagick, intl, mbstring, pdo_mysql, zip, and bcmath).

### Phase 2: Laravel 10 → 11

13. Work through the [Laravel 11 upgrade guide](https://laravel.com/docs/11.x/upgrade).
14. Update `laravel/framework` to `^11.0`, along with Jetstream, Fortify, Sanctum, Telescope, Collision, and the other packages to versions that support Laravel 11. Publish any new migrations, for example `php artisan vendor:publish --tag=sanctum-migrations`.
15. Keep the existing `app/Http/Kernel.php` and `app/Exceptions/Handler.php` structure. Moving to the slimmer Laravel 11 skeleton is optional and can be done later.
16. Review the other Laravel 11 changes that affect this project, especially column modifications, rate limiting, and the password rehashing behaviour.
17. Run `composer update`, clear caches with `php artisan optimize:clear`, run the migrations against a copy of the database, and run the tests. Fix the failures and commit.

**Phase 2 status:** Laravel 11.57.0 is installed. All 32 tests pass, the migrations run on an empty MySQL 8.4 database, and the config, route, and view caches build, except for the pre-existing view issue below. Changes made:
- Package versions: Jetstream 5.5, Fortify 1.41, Sanctum 4.3, Telescope 5.26, Media Library 11.23, dompdf 3.1, Carbon 3.15, and PHPUnit 10.5.
- Telescope 5 no longer loads its migrations automatically, so they were published to `database/migrations`.
- `config/sanctum.php` now uses the Sanctum 4 key `validate_csrf_token`.
- Media Library 11 uses spatie/image 3, which removed `Manipulations`. The conversions in `Product`, `Page`, and `Plant` now use `fit(Fit::Crop, w, h)`. Do not use the new `crop()`, because it cuts without scaling. Conversion sizes were checked against a test image.
- Added the `2026_10_21_000000_add_generated_conversions_to_media_table` migration. The original media migration did not have this column. The new migration does nothing if the column already exists, and otherwise moves the conversion data out of `custom_properties`.
- `config/lfm.php` sets `use_package_routes` to `false`. The package was registering a second copy of the file manager routes at `/filemanager`, which stopped `route:cache` from working. The editor uses the `/laravel-filemanager` routes in `routes/web.php`.

**Do not deploy Laravel 11.** Every 11.x release has unpatched security advisories. Their IDs are listed under `config.policy.advisories.ignore-id` in `composer.json`. Remove that list once Laravel is at 12.69 or later.

**Pre-existing issue, not caused by the upgrade:** the Fortify auth views (`auth/login`, `forgot-password`, `reset-password`, `register`, `two-factor-challenge`, and `verify-email`) and the Jetstream profile views use `<x-jet-…>` components. Jetstream 3.3.3 did not provide these either, so `/login` and `/forgot-password` already returned 500 errors before the upgrade, and `php artisan view:cache` fails. The backend login's "Forgot Password" link and the `auth` middleware's redirect to `login` both reach these broken pages. Livewire is also not installed, so the Jetstream profile and API token pages cannot work.

### Phase 3: Laravel 11 → 12

18. Work through the [Laravel 12 upgrade guide](https://laravel.com/docs/12.x/upgrade).
19. Update `laravel/framework` to `^12.0`, PHPUnit to `^11`, and the related packages.
20. Review date and time code for Carbon 3 changes, especially `diffIn*` methods, which now return signed floats.
21. Run `composer update` and the tests. Fix the failures and commit.

### Phase 4: Laravel 12 → 13

22. Work through the [Laravel 13 upgrade guide](https://laravel.com/docs/13.x/upgrade).
23. Update `laravel/framework` to `^13.0`, PHPUnit to `^12`, Laravel Tinker, and the related packages.
24. Run `composer update` and the tests. Fix the failures and commit.

### Phase 5: Database

25. ~~Upgrade the local MySQL image from 5.7.~~ Done: `compose.yaml` uses MySQL 8.4 LTS. Confirm that production will run the same version.
26. Restore a copy of the production database into it and run the migrations.
27. Run the full test suite and manually check queries that are likely to be affected, such as reports, searches, and grouped queries.

### Phase 6: Frontend and verification

28. Run the asset build (`npm run production`) and confirm that the compiled assets work in the browser.
29. Manually test the key journeys on a staging environment that matches production: authentication, cart, checkout and payment, file manager, image uploads and resizing, PDF generation, and admin pages.
30. Check the logs and Telescope for new errors and deprecation warnings.

### Phase 7: Deployment

31. Upgrade the production PHP runtime and database, or confirm that they have been upgraded, before deploying.
32. Take a fresh backup, deploy the branch, run the migrations, and clear and rebuild the caches.
33. Smoke-test the key journeys in production and keep the rollback plan ready until the release is confirmed stable.
