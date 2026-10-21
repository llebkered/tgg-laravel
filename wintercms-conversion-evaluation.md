# WinterCMS Conversion Evaluation — Toad Gully Gardens

**Evaluated:** March 2026  
**Source:** Laravel 10 / PHP 8.1+  
**Target:** WinterCMS (built on Laravel, plugin/theme architecture)

---

## 1. Project Overview

Toad Gully Gardens is a Laravel 10 e-commerce application selling plants (ferns, paulownia, products). It features:

- A **multi-step checkout** with Pin Payments credit card processing and direct deposit option
- A **custom-built backend** admin panel for managing orders, products, plants, pages, blocks, variations, and users
- **Jetstream + Fortify** for frontend authentication (2FA support)
- **Spatie MediaLibrary** for image handling with multiple conversion sizes
- **hardevine/shoppingcart** for session-based cart management
- **Blade templating** with Tailwind CSS and Bulma CSS
- **Laravel Mix** (Webpack) for asset compilation

---

## 2. What is WinterCMS?

WinterCMS is a CMS platform forked from OctoberCMS, itself built on Laravel. Key architectural differences from standard Laravel:

| Concept | Laravel | WinterCMS |
|---|---|---|
| Feature packaging | Service Providers / packages | **Plugins** (`Plugin.php` + `updates/`, `models/`, `controllers/`) |
| Routing | `routes/web.php` | CMS Pages + `routes.php` inside plugins |
| Frontend views | Blade templates + layouts | **Themes** with CMS Pages, Layouts, Partials (Twig or Blade) |
| Backend / Admin | Custom or Voyager / Nova | **Built-in Storm UI** (list/form controllers) |
| Media management | Spatie MediaLibrary / custom | **Built-in Media Manager** |
| Authentication | Fortify / Jetstream / Sanctum | Built-in or **RainLab.User** plugin |
| Components | N/A | **PHP Components** attached to CMS pages |
| Settings | Config files / DB options | **System > Settings** backend area |

---

## 3. Current Application Inventory

### 3.1 Models (15)
| Model | Key Features | WinterCMS Equivalent |
|---|---|---|
| `User` | Extends `TCG\Voyager\Models\User`, Fortify 2FA, Sanctum tokens | WinterCMS `Backend\Models\User` or `RainLab.User` plugin |
| `Product` | Spatie MediaLibrary (featured_image: large/medium/thumb conversions) | Plugin model + WinterCMS `attachMany` / built-in media |
| `Plant` | Spatie MediaLibrary (featured_image: medium crop) | Plugin model + WinterCMS media |
| `Page` | Spatie MediaLibrary (gallery: large/medium/thumb) | WinterCMS CMS Pages or `RainLab.Pages` plugin |
| `Block` | Hero/non-hero content blocks, weight ordering | Plugin model or `RainLab.Pages` static components |
| `PlantCategory` | Standard model | Plugin model |
| `Variation` | Belongs to Product | Plugin model |
| `Order` | Belongs to OrderStatus, Customer; HasOne Address | Plugin model |
| `OrderStatus` | Lookup table | Plugin model |
| `Address` | HasOne to Order | Plugin model |
| `Customer` | BelongsTo Order | Plugin model |
| `Cart` | Session-based (shoppingcart package) | Reuse package or plugin model |
| `Contact` | Contact form submissions | Plugin model |
| `Textcolour` / `Backgroundcolour` | UI colour picker options | Plugin models or System Settings |

### 3.2 Controllers
**Frontend (7):**
`HomeController`, `ContactController`, `FernsController`, `PaulowniaController`, `ProductController`, `CartController`, `CheckoutController`

**Custom Backend (12):**
`BackendController`, `BackendAuthController`, `BackendPageController`, `BackendUserController`, `BackendBlockController`, `BackendOrderController`, `BackendPlantController`, `BackendProductController`, `BackendVariationController`, `MediaLibraryController`, `PageGalleryController`, `ProductGalleryController`

### 3.3 Views
- **Layouts:** `app.blade.php`, `admin.blade.php`, `guest.blade.php`
- **Partials:** header, navbar, footer, flash-message, carousel, cart-button, front-block, front-hero, head-meta, contact-form, pagination (12 files)
- **Sections:** home, contact, ferns, paulownia, products (index + show), cart, checkout (index, delivery, card, charge, directdeposit, thankyou), dashboard, backend (multiple), emails, PDF

### 3.4 Migrations (26)
Users, password_resets, 2FA columns, pages, posts, categories, options, failed_jobs, personal_access_tokens, sessions, plants, addresses, variations, carts, contacts, customers, orders, plant_categories, products, order_statuses, shoppingcart, blocks, textcolours, backgroundcolours, media

### 3.5 Packages / Dependencies
| Package | Purpose | WinterCMS Status |
|---|---|---|
| `laravel/framework ^10` | Core Framework | ❌ Replaced by WinterCMS core |
| `laravel/fortify ^1.6` | Auth backend | ❌ Replace with WinterCMS auth / RainLab.User |
| `laravel/jetstream ^3.1` | Auth UI + 2FA | ❌ Replace with WinterCMS auth / RainLab.User |
| `laravel/sanctum ^3.2` | API tokens | ⚠️ Evaluate need; WinterCMS has its own API auth |
| `spatie/laravel-medialibrary ^10` | Image uploads/conversions | ❌ Replace with WinterCMS built-in Media Manager |
| `spatie/laravel-honeypot ^4.3` | Spam protection | ⚠️ Adapt or use WinterCMS AJAX form protection |
| `spatie/laravel-ignition ^2` | Error pages (dev) | ⚠️ Dev only; WinterCMS has Debugbar support |
| `hardevine/shoppingcart ^3.1` | Session cart | ✅ Likely compatible (Laravel-based) |
| `barryvdh/laravel-dompdf ^2` | PDF invoices | ✅ Likely compatible |
| `barryvdh/laravel-debugbar ^3.6` | Dev toolbar | ✅ Compatible |
| `laravel/telescope` | Dev request logging | ⚠️ Partially compatible; may have conflicts |
| `intervention/image ^2.5` | Image manipulation | ✅ Compatible |
| `intervention/imagecache ^2.5` | Image caching | ✅ Compatible |
| `laravel-validation-rules/credit-card ^1.8` | Card validation | ✅ Compatible (validation rules are framework-agnostic) |
| `unisharp/laravel-filemanager` | File browser | ❌ Drop; replaced by WinterCMS Media Manager |
| `appstract/laravel-options ^5.2` | DB-stored options | ⚠️ Replace with WinterCMS System Settings |
| `guzzlehttp/guzzle ^7` | HTTP client | ✅ Compatible |
| `doctrine/dbal ^3.6` | DB abstraction | ✅ Compatible |

---

## 4. Proposed WinterCMS Plugin Architecture

The application logic should be split into purpose-built plugins:

```
plugins/
  toadgully/
    core/          # Pages, Blocks, Colours, Settings, helpers
    shop/          # Products, Plants, PlantCategories, Variations, Cart, Checkout, Orders
    contact/       # Contact form, ContactMail notification
themes/
  toadgully/       # All frontend layouts, pages, partials, assets
```

### Plugin: `ToadGully.Core`
- `Page` and `Block` models
- `Textcolour` and `Backgroundcolour` models
- System settings (ABN, etc.)
- Global helpers (`app/helpers.php`)

### Plugin: `ToadGully.Shop`
- `Product`, `Variation`, `Plant`, `PlantCategory` models
- `Order`, `OrderStatus`, `Address`, `Customer` models
- Backend list/form controllers for all shop entities
- Cart component (wrapping shoppingcart package)
- Multi-step checkout components + Pin Payments integration
- PDF invoice generation

### Plugin: `ToadGully.Contact`
- `Contact` model
- Contact form component
- Mail notifications

### Theme: `ToadGully`
- CMS layouts (replacing `app.blade.php`)
- CMS pages (replacing routes + controller `index()` returns)
- CMS partials (replacing Blade partials)
- Tailwind / Bulma assets (can still use Mix or switch to Vite)

---

## 5. Conversion Work Items by Area

### 5.1 Authentication — HIGH EFFORT
**Current:** Jetstream + Fortify with 2FA, profile photo, Sanctum API tokens. `User` model also extends `TCG\Voyager\Models\User` (a Voyager remnant that must be removed).

**Required:**
- Remove Jetstream, Fortify, Sanctum, and Voyager User dependency entirely
- Install and configure **RainLab.User** plugin for frontend customer accounts, OR use WinterCMS's built-in backend authentication only if customers don't have accounts
- Re-assess whether customer-facing login is needed (current codebase shows it may be unused — checkout is guest-based)
- Recreate 2FA if required for backend admin users (WinterCMS backend supports 2FA natively)
- Migrate the Fortify Actions (`CreateNewUser`, `UpdateUserProfileInformation`, etc.) to equivalent RainLab.User event handlers

**Estimated effort: 3–5 days**

---

### 5.2 Custom Backend Admin — HIGH EFFORT (largest single task)
**Current:** 12 custom backend controllers with bespoke Blade admin views under `resources/views/backend/`.

**Required:**
- WinterCMS provides a full backend framework using **Storm UI** (list + form controllers with YAML config)
- Each backend controller gets rebuilt as a WinterCMS `Backend\Classes\Controller` with:
  - `config_list.yaml` — column definitions
  - `config_form.yaml` — field definitions
  - Associated `_list.htm` and `_form.htm` partials (minimal, mostly auto-generated)
- Behaviours available: `ListController`, `FormController`, `RelationController`
- Media galleries (PageGalleryController, ProductGalleryController) are replaced by built-in `FileUpload` and `MediaFinder` form widgets
- No need to recreate `BackendAuthController` — WinterCMS handles backend auth natively

**Entities to convert:**  
Orders, Products, Plants, PlantCategories, Variations, Pages, Blocks, Users

**Estimated effort: 6–10 days**

---

### 5.3 Media Management — MEDIUM EFFORT
**Current:** Spatie MediaLibrary with `registerMediaCollections()` defining image conversions (large/medium/thumb) for Product, Plant, and Page models.

**Required:**
- Remove `spatie/laravel-medialibrary` entirely
- Remove `unisharp/laravel-filemanager` (replaced by WinterCMS Media Manager)
- Replace each `HasMedia` / `InteractsWithMedia` model trait with WinterCMS's `attachMany` or `attachOne` file relations
- Recreate image resizing/cropping using WinterCMS's built-in `Resizer` utility or Intervention Image
- Update all blade views that access `$model->getFirstMediaUrl('collection', 'conversion')` to WinterCMS file model accessors

**Estimated effort: 2–3 days**

---

### 5.4 Frontend Views / Theme — MEDIUM EFFORT
**Current:** Blade templates with `@extends`, `@section`, `@yield`, `@include`, `@component` directives.

**Required:**
- Create a WinterCMS **Theme** directory structure:
  ```
  themes/toadgully/
    layouts/default.htm   ← replaces layouts/app.blade.php
    pages/                ← one .htm file per route (home, contact, ferns, products, etc.)
    partials/             ← header, navbar, footer, etc.
    assets/css, js, images/
  ```
- WinterCMS supports **Blade** in themes (via `{% partial %}`, `{% page %}`, `{% content %}` tags) or **Twig** syntax
- Most Blade syntax (`@if`, `@foreach`, `{{ }}`) works in WinterCMS Blade themes
- `@extends` / `@section` is replaced by the WinterCMS layout system
- Asset references (`asset()`, `mix()`) need updating to `{{ theme.path }}/assets/...`
- Flash messages can use WinterCMS's built-in `{% flash %}` tag
- Pagination: WinterCMS provides its own pagination partial

**Estimated effort: 3–5 days**

---

### 5.5 Frontend Controllers → CMS Components — MEDIUM EFFORT
**Current:** Standard Laravel controllers returning views with data.

**Required:**
- Each public-facing page gets a **CMS Component** (a PHP class extending `Cms\Classes\ComponentBase`)
- Component `onRun()` replaces controller `index()`/`show()` methods
- Example: `ProductController::index()` → `Shop\Components\ProductList::onRun()`
- Routing is handled by CMS page URL patterns (e.g., `/product/:slug`)
- AJAX form handlers (`@contact.store`) become component `onSubmit()` methods

**Components needed:**
`ProductList`, `ProductDetail`, `PlantList`, `CartView`, `CheckoutContact`, `CheckoutDelivery`, `CheckoutCard`, `CheckoutThankYou`, `ContactForm`, `HomeBlocks`

**Estimated effort: 4–6 days**

---

### 5.6 Cart & Checkout — MEDIUM-HIGH EFFORT
**Current:** Multi-step checkout across 6 views using sessions, with Pin Payments credit card processing (`App\Libraries\Pin\PinPayments`), DomPDF invoice, and email notifications.

**Required:**
- `hardevine/shoppingcart` is Laravel-based and should be compatible; register it in the plugin's `Plugin::register()`
- The custom `App\Libraries\Pin\PinPayments` class can be moved into the plugin's `classes/` folder
- Each checkout step becomes a CMS page + component with AJAX handlers
- Session handling works the same way
- The `PDF` facade (DomPDF) needs to be re-registered or replaced with the full class reference
- Mail classes (`OrderPaid`, `OrderInvoice`, `OrderSentMail`) move to plugin `mail/` folder and are registered in `Plugin::registerMailTemplates()`
- Credit card validation rules (`laravel-validation-rules/credit-card`) should remain compatible

**⚠️ Security Note:** The `config/pin.php` file contains what appear to be hardcoded API credentials (secret key and publishable key). These must be moved to `.env` variables before conversion — this is a pre-condition regardless of platform.

**Estimated effort: 4–6 days**

---

### 5.7 Migrations — LOW EFFORT
**Current:** 26 migration files in `database/migrations/`.

**Required:**
- Each plugin registers its own migrations in `Plugin::boot()` or in the `updates/` folder + `version.yaml`
- Migration files can be copied largely as-is; only the file naming convention changes (`XXXX_XX_XX_XXXXXX_description.php` → placed in `plugins/toadgully/shop/updates/`)
- WinterCMS manages its own system tables; avoid conflicts with table names like `users`, `backend_users`, `sessions`
- The `create_posts_table` migration appears unused — verify and remove if so

**Estimated effort: 1–2 days**

---

### 5.8 Asset Pipeline — LOW EFFORT
**Current:** Laravel Mix (Webpack 4) with Tailwind CSS 1.x, Bulma 0.9, Sass, Vue 2 template compiler.

**Required:**
- Laravel Mix can continue to be used in WinterCMS themes (it is a standard Webpack wrapper)
- Alternatively, migrate to **Vite** (recommended for modern WinterCMS projects)
- Move `webpack.mix.js`, `tailwind.config.js`, and `resources/` assets into the theme directory
- Update compiled output paths to `themes/toadgully/assets/`
- Consider upgrading Tailwind CSS from 1.x to 3.x during migration (breaking changes)
- Vue 2 EOL — upgrade to Vue 3 if any Vue components are used
- `@tailwindcss/ui` is deprecated; replace with `@tailwindcss/forms` / `@tailwindcss/typography`

**Estimated effort: 1–2 days**

---

### 5.9 Email / Notifications — LOW EFFORT
**Current:** 3 mail classes (`ContactMail`, `OrderInvoice`, `OrderPaid`, `OrderSentMail`) and 1 notification (`ContactFormMessage`).

**Required:**
- Register mail templates in `Plugin::registerMailTemplates()` returning an array of view paths
- Move mail Blade views to `plugins/toadgully/contact/views/mail/` etc.
- `Mail::send()` and `Mail::to()` calls remain identical
- Notification class (`ContactFormMessage`) can be moved to plugin `notifications/` folder and used as-is

**Estimated effort: 0.5–1 day**

---

### 5.10 Configuration — LOW EFFORT
**Current:** Custom config files: `tgg.php` (ABN), `pin.php` (payment gateway), `bank.php`, `cart.php`, `hooks.php`, `recipient.php`

**Required:**
- Plugin-level config is registered via `Plugin::registerSettings()` for admin-editable settings
- Simple `.env`-backed config files can remain as-is and be loaded via `Config::get()`
- `appstract/laravel-options` (DB key-value store) should be replaced with WinterCMS's **System Settings** models, which provide the same capability natively with backend UI

**Estimated effort: 0.5–1 day**

---

## 6. What Carries Over Unchanged

| Item | Notes |
|---|---|
| Business logic in models | Can be copied with namespace updates |
| Validation rules | Identical API |
| `app/helpers.php` | Move to plugin, register in `Plugin::register()` autoload |
| Pin Payments library | Move to plugin `classes/Pin/` |
| Guzzle HTTP calls | Identical API |
| SQL-level queries | Identical via Eloquent |
| PDF generation logic | DomPDF compatible, update facade reference |
| `.env` variables | Same format; add Winter-specific vars |
| Mail view HTML/CSS | Minor syntax adjustments only |

---

## 7. Known Risks and Issues

### 🔴 High Risk
1. **`User` model extends `TCG\Voyager\Models\User`** — Voyager is not installed/active but the class inheritance remains. This will break in WinterCMS. Must be removed and replaced with the appropriate WinterCMS user base class before proceeding.
2. **Multi-step checkout session state** — The checkout flow uses PHP sessions across multiple pages. This is replicated in WinterCMS but requires careful mapping of component AJAX handlers and redirect flows.
3. **Jetstream 2FA removal** — If backend admin users rely on 2FA, WinterCMS must be configured to enable its own built-in 2FA for backend users.

### 🟡 Medium Risk
4. **Spatie MediaLibrary → WinterCMS Media** — The image URL structure changes completely. Existing stored media paths in the database will be invalid. A data migration script would need to re-associate uploaded files.
5. **Laravel Telescope** — May conflict with WinterCMS's routing or backend. Evaluate whether it is needed in production; it should be dev-only and may need removal.
6. **`hardevine/shoppingcart` session instance names** — Verify the package registers cleanly within a WinterCMS plugin's service provider.

### 🟢 Low Risk
7. **Tailwind CSS 1.x** — Outdated; migration to Tailwind 3.x will require class-name updates across all templates.
8. **Bulma CSS** — No changes needed for the CSS itself; it is a static dependency.
9. **Laravel Mix version** — Mix 5 is outdated. Consider upgrading to Mix 6+ or Vite during migration.

---

## 8. Effort Summary

| Area | Effort | Complexity |
|---|---|---|
| WinterCMS project setup + plugin scaffolding | 1 day | Low |
| Theme creation + layout/partial migration | 3–5 days | Medium |
| Model migration (namespaces, relations, media) | 2–3 days | Medium |
| Media management (Spatie → WinterCMS) | 2–3 days | Medium |
| Migrations into plugins | 1–2 days | Low |
| Authentication replacement | 3–5 days | High |
| Custom backend → Storm UI rebuild | 6–10 days | High |
| Frontend controllers → CMS components | 4–6 days | Medium |
| Cart & checkout flow | 4–6 days | Medium-High |
| Email / notifications | 0.5–1 day | Low |
| Asset pipeline + CSS cleanup | 1–2 days | Low |
| Package compatibility testing | 1–2 days | Medium |
| QA, testing, data migration | 3–5 days | Medium |
| **Total estimate** | **~31–51 days** | |

> Estimates assume a single developer familiar with both Laravel and WinterCMS. A developer with experience in both platforms could be toward the lower bound.

---

## 9. Recommended Approach

### Option A — Full Conversion (Recommended if long-term CMS benefits are valued)
Migrate to WinterCMS entirely using the plugin/theme architecture described above. This gives you the built-in backend, media manager, and CMS page editing capability.

**Best for:** Ongoing content management by non-developers, editor UX, long-term maintainability.

### Option B — Partial Conversion (Hybrid)
Keep the Laravel application largely intact but add WinterCMS as the frontend CMS layer only (via `october/rain` or adapting backend). This is fragile and not recommended.

### Option C — Stay on Laravel, Modernise Instead
Upgrade Laravel to the latest version, replace the custom backend with **Filament** or **Nova**, and replace Jetstream with standalone Fortify + custom views. This avoids the WinterCMS learning curve while still modernising the stack.

**Best for:** If e-commerce functionality is the primary concern and a full CMS is not needed.

---

## 10. Pre-Migration Checklist (Before Any Conversion Work)

- [ ] Remove `TCG\Voyager\Models\User` from User model — replace with `Illuminate\Foundation\Auth\User as Authenticatable`
- [ ] Move hardcoded API credentials out of `config/pin.php` and into `.env`
- [ ] Audit whether frontend customer login/registration is actually used (routes suggest Jetstream is partially disabled)
- [ ] Confirm whether `create_posts_table` migration is still required
- [ ] Upgrade PHP to 8.2+ (WinterCMS 1.2+ recommended)
- [ ] Back up database with all media files before starting
- [ ] Verify `hardevine/shoppingcart` compatibility with WinterCMS's service container
- [ ] Decide on Tailwind CSS upgrade path (1.x → 3.x) and document breaking changes

---

## 11. Step-by-Step Migration Process

This section describes the full process starting from a clean WinterCMS installation.

---

### Phase 0 — Pre-Migration Preparation (on the existing Laravel project)

Complete all items in the Pre-Migration Checklist (Section 10) before touching WinterCMS.

```bash
# Fix the User model — open app/Models/User.php and change:
# class User extends \TCG\Voyager\Models\User
# to:
# class User extends \Illuminate\Foundation\Auth\User as Authenticatable

# Move credentials out of config/pin.php into .env
# PIN_HOST=test-api.pinpayments.com
# PIN_SECRET=your-secret-key
# PIN_PUBLISHABLE=your-publishable-key

# Dump a clean database backup
mysqldump -u root -p toadgully > toadgully_pre_migration.sql

# Copy all uploaded media files
cp -r storage/app/public /tmp/tgg_media_backup
```

---

### Phase 1 — Fresh WinterCMS Installation

```bash
# Create the new project via Composer
composer create-project wintercms/winter toadgully-winter

cd toadgully-winter

# Copy your .env from the Laravel project and update:
# APP_KEY=  (regenerate)
# DB_DATABASE=toadgully_winter  (use a new database for the conversion)

php artisan key:generate

# Run WinterCMS core migrations (creates system tables)
php artisan winter:up

# Create the first backend admin user
php artisan winter:passwd admin admin@example.com
```

Visit `/backend` to confirm the backend loads. The frontend will show the default WinterCMS demo theme.

---

### Phase 2 — Install Required WinterCMS Marketplace Plugins

Install these via the WinterCMS backend (Settings > Updates > Install Plugins) or via `composer require`:

#### Required Plugins

| Plugin | Marketplace Handle | Purpose |
|---|---|---|
| Winter.Pages | `winter/wn-pages-plugin` | Static page content management for Pages/Blocks |
| RainLab.User | `rainlab/user-plugin` | Frontend user accounts (if needed) |
| Winter.Translate | `winter/wn-translate-plugin` | Optional: multilingual support |
| Winter.Sitemap | `winter/wn-sitemap-plugin` | Auto-generate sitemap.xml |
| Winter.GoogleAnalytics | `winter/wn-googleanalytics-plugin` | Optional: analytics integration |

```bash
composer require winter/wn-pages-plugin
composer require rainlab/user-plugin

php artisan winter:up
```

#### Composer Packages to add to WinterCMS `composer.json`

These replace the dropped Laravel-specific packages and are added to the new project:

```bash
# Keep these (compatible):
composer require hardevine/shoppingcart
composer require barryvdh/laravel-dompdf
composer require intervention/image
composer require intervention/imagecache
composer require guzzlehttp/guzzle
composer require laravel-validation-rules/credit-card

# Dev tools:
composer require barryvdh/laravel-debugbar --dev
```

**Do NOT install:** `laravel/jetstream`, `laravel/fortify`, `laravel/sanctum`, `spatie/laravel-medialibrary`, `unisharp/laravel-filemanager`, `appstract/laravel-options`, `laravel/telescope`

---

### Phase 3 — Scaffold the Custom Plugins

Create the three plugin directories using the WinterCMS scaffold command:

```bash
php artisan create:plugin ToadGully.Core
php artisan create:plugin ToadGully.Shop
php artisan create:plugin ToadGully.Contact
```

This generates the skeleton structure for each:

```
plugins/toadgully/
  core/
    Plugin.php
    updates/
      version.yaml
  shop/
    Plugin.php
    updates/
      version.yaml
  contact/
    Plugin.php
    updates/
      version.yaml
```

---

### Phase 4 — Migrate Migrations into Plugins

Copy migration files from the Laravel project's `database/migrations/` into the appropriate plugin's `updates/` folder and register them in `version.yaml`.

#### ToadGully.Core migrations:
- `create_pages_table`
- `create_posts_table` (verify if needed, else skip)
- `create_blocks_table`
- `create_textcolours_table`
- `create_backgroundcolours_table`
- `create_options_table`

#### ToadGully.Shop migrations:
- `create_plants_table`
- `create_plant_categories_table`
- `create_products_table`
- `create_variations_table`
- `create_orders_table`
- `create_order_statuses_table`
- `create_addresses_table`
- `create_customers_table`
- `create_carts_table`
- `create_shoppingcart_table`
- `create_media_table` (only if not replaced by WinterCMS system_files)

#### ToadGully.Contact migrations:
- `create_contacts_table`

#### Handled by WinterCMS core (do NOT migrate these):
- `create_users_table` → WinterCMS has its own `backend_users` table
- `create_password_resets_table` → managed by WinterCMS
- `create_sessions_table` → managed by WinterCMS
- `create_failed_jobs_table` → managed by WinterCMS
- `create_personal_access_tokens_table` → not needed

**`version.yaml` example for ToadGully.Shop:**

```yaml
1.0.0:
  - First version of the Shop plugin
  - create_plants_table.php
  - create_plant_categories_table.php
  - create_products_table.php
  - create_variations_table.php
  - create_orders_table.php
  - create_order_statuses_table.php
  - create_addresses_table.php
  - create_customers_table.php
  - create_shoppingcart_table.php
```

Run `php artisan winter:up` after setting up each plugin to apply its migrations.

---

### Phase 5 — Migrate Models into Plugins

Copy each model from `app/Models/` into the relevant plugin's `models/` directory and update:

1. **Namespace:** `App\Models\X` → `ToadGully\Shop\Models\X`
2. **Remove:** `use HasFactory;` and `use Illuminate\Database\Eloquent\Factories\HasFactory;`
3. **Remove:** `use Spatie\MediaLibrary\HasMedia;`, `use Spatie\MediaLibrary\InteractsWithMedia;`, `registerMediaCollections()`
4. **Add:** WinterCMS file attachments in place of MediaLibrary

**Example — Product model conversion:**

```php
// BEFORE (Laravel + Spatie)
class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    public function registerMediaCollections(): void { ... }
}

// AFTER (WinterCMS plugin model)
class Product extends Model
{
    public $attachOne = [
        'featured_image' => \System\Models\File::class,
    ];

    public $attachMany = [
        'gallery' => \System\Models\File::class,
    ];
}
```

**Accessing images in views:**

```php
// BEFORE
$product->getFirstMediaUrl('featured_image', 'medium')

// AFTER (WinterCMS)
$product->featured_image->getThumb(480, 480, ['mode' => 'crop'])
```

#### Model placement:

| Model | Plugin |
|---|---|
| `Page`, `Block`, `Textcolour`, `Backgroundcolour` | `ToadGully\Core\Models\` |
| `Product`, `Variation`, `Plant`, `PlantCategory`, `Order`, `OrderStatus`, `Address`, `Customer`, `Cart` | `ToadGully\Shop\Models\` |
| `Contact` | `ToadGully\Contact\Models\` |
| `User` | Use `Backend\Models\User` (WinterCMS built-in) |

---

### Phase 6 — Build Backend Controllers (Storm UI)

For each entity that needs backend management, create a WinterCMS backend controller. Use the scaffold command:

```bash
php artisan create:controller ToadGully.Shop Products
php artisan create:controller ToadGully.Shop Plants
php artisan create:controller ToadGully.Shop Orders
php artisan create:controller ToadGully.Shop Variations
php artisan create:controller ToadGully.Core Pages
php artisan create:controller ToadGully.Core Blocks
```

Each controller gets two YAML config files defining its UI with no bespoke HTML needed:

**`controllers/products/config_list.yaml`:**
```yaml
title: Products
modelClass: ToadGully\Shop\Models\Product
recordUrl: toadgully/shop/products/update/:id
columns:
    title:
        label: Title
    slug:
        label: Slug
    published:
        label: Published
        type: switch
```

**`controllers/products/config_form.yaml`:**
```yaml
fields:
    title:
        label: Title
        span: left
    slug:
        label: Slug
        span: right
        preset:
            field: title
            type: slug
    published:
        label: Published
        type: switch
    featured_image:
        label: Featured Image
        type: fileupload
        mode: image
        imageWidth: 480
        imageHeight: 480
tabs:
    fields:
        variations:
            label: Variations
            type: relation
            tab: Variations
```

Register each controller in `Plugin.php`:

```php
public function registerNavigation()
{
    return [
        'shop' => [
            'label'       => 'Shop',
            'url'         => Backend::url('toadgully/shop/products'),
            'icon'        => 'icon-leaf',
            'permissions' => ['toadgully.shop.*'],
            'order'       => 500,
            'sideMenu' => [
                'products'   => ['label' => 'Products',   'url' => Backend::url('toadgully/shop/products')],
                'plants'     => ['label' => 'Plants',     'url' => Backend::url('toadgully/shop/plants')],
                'orders'     => ['label' => 'Orders',     'url' => Backend::url('toadgully/shop/orders')],
                'variations' => ['label' => 'Variations', 'url' => Backend::url('toadgully/shop/variations')],
            ],
        ],
    ];
}
```

---

### Phase 7 — Build CMS Components

Create a component for each frontend page section. Use the scaffold command:

```bash
php artisan create:component ToadGully.Core HomeBlocks
php artisan create:component ToadGully.Shop ProductList
php artisan create:component ToadGully.Shop ProductDetail
php artisan create:component ToadGully.Shop PlantList
php artisan create:component ToadGully.Shop CartView
php artisan create:component ToadGully.Shop CheckoutContact
php artisan create:component ToadGully.Shop CheckoutDelivery
php artisan create:component ToadGully.Shop CheckoutCard
php artisan create:component ToadGully.Shop CheckoutThankYou
php artisan create:component ToadGully.Contact ContactForm
```

Each component has a PHP class and a default partial. The `onRun()` method replaces the Laravel controller method:

**`components/ProductList.php`:**
```php
namespace ToadGully\Shop\Components;

use Cms\Classes\ComponentBase;
use ToadGully\Shop\Models\Product;

class ProductList extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Product List', 'description' => 'Displays all published products'];
    }

    public function onRun()
    {
        $this->page['products'] = Product::where('published', 1)
            ->with('variations')
            ->get();
    }
}
```

Register all components in `Plugin.php`:

```php
public function registerComponents()
{
    return [
        'ToadGully\Shop\Components\ProductList'      => 'productList',
        'ToadGully\Shop\Components\ProductDetail'    => 'productDetail',
        'ToadGully\Shop\Components\PlantList'        => 'plantList',
        'ToadGully\Shop\Components\CartView'         => 'cartView',
        'ToadGully\Shop\Components\CheckoutContact'  => 'checkoutContact',
        'ToadGully\Shop\Components\CheckoutDelivery' => 'checkoutDelivery',
        'ToadGully\Shop\Components\CheckoutCard'     => 'checkoutCard',
        'ToadGully\Shop\Components\CheckoutThankYou' => 'checkoutThankYou',
    ];
}
```

---

### Phase 8 — Create the WinterCMS Theme

#### 8.1 Scaffold the theme

```bash
php artisan create:theme toadgully
```

This creates:
```
themes/toadgully/
  theme.yaml
  layouts/
  pages/
  partials/
  content/
  assets/
```

Update `theme.yaml`:
```yaml
name: Toad Gully Gardens
description: Toad Gully Gardens e-commerce theme
author: Toad Gully Gardens
homepage: https://toadgully.com.au
```

Activate the theme in the backend: **Settings > CMS > Frontend Theme**.

---

#### 8.2 Layout Conversion

**Create `themes/toadgully/layouts/default.htm`** — this replaces `resources/views/layouts/app.blade.php`.

WinterCMS layouts use a three-section `.htm` file format:

```
[config section — INI format]
---
[PHP section]
---
[Markup section — HTML/Twig/Blade]
```

```html
description = "Default layout"
==
<?php
function onInit() {
    // runs before page renders
}
?>
==
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{% if this.page.title %}{{ this.page.title }} | {% endif %}{{ site_name() }}</title>
    {% partial 'head-meta' %}
    <script src="{{ theme.path }}/assets/js/app.js" defer></script>
    <link href="{{ theme.path }}/assets/css/app.css" rel="stylesheet">
</head>
<body>
    {% partial 'header' %}
    {% partial 'navbar' %}
    {% flash %}
        <div class="flash-message alert alert-{{ type }}">{{ message }}</div>
    {% endflash %}
    {% page %}
    {% partial 'footer' %}
</body>
</html>
```

**Key translation notes:**

| Laravel Blade | WinterCMS Theme |
|---|---|
| `@extends('layouts.app')` | Page sets `layout = "default"` in its config section |
| `@yield('content')` | `{% page %}` in the layout |
| `@section('content') ... @endsection` | The page's markup section IS the content |
| `@include('partials.header')` | `{% partial 'header' %}` |
| `@yield('header_extras')` | `{% placeholder header_extras %}` in layout; `{% put header_extras %} ... {% endput %}` in page |
| `{{ asset('css/app.css') }}` | `{{ theme.path }}/assets/css/app.css` |
| `{{ mix('css/app.css') }}` | `{{ theme.path }}/assets/css/app.css` (compile assets first) |
| `@if / @foreach / @endif` | `{% if %} / {% for %} / {% endif %}` (Twig) or keep Blade syntax |
| `{{ csrf_field() }}` | `{{ form_token() }}` or `<input type="hidden" name="_token" value="{{ csrf_token() }}">` |

**Create `themes/toadgully/layouts/admin.htm`** — if a separate admin-facing frontend is needed (unlikely with WinterCMS backend in place).

---

#### 8.3 Partial Conversion

Copy each partial from `resources/views/partials/` to `themes/toadgully/partials/` renaming `.blade.php` → `.htm`:

| Laravel partial | WinterCMS partial | Changes needed |
|---|---|---|
| `header.blade.php` | `header.htm` | Update `asset()` → `{{ theme.path }}/assets/...` |
| `navbar.blade.php` | `navbar.htm` | Update `route('home')` → hardcoded URLs or `{{ 'home'\|page }}` |
| `footer.blade.php` | `footer.htm` | Update `asset()` references |
| `flash-message.blade.php` | Remove | Use `{% flash %}` tag in the layout instead |
| `head-meta.blade.php` | `head-meta.htm` | Minor syntax updates |
| `carousel.blade.php` | `carousel.htm` | Update image URLs from Spatie to WinterCMS file model |
| `front-block.blade.php` | `front-block.htm` | Update image URLs; passed as component variable |
| `front-hero.blade.php` | `front-hero.htm` | Update image URLs |
| `cart-button.blade.php` | `cart-button.htm` | Update route references |
| `contact-form.blade.php` | `contact-form.htm` | Convert `@csrf` → `{{ form_token() }}`; POST action → component AJAX |
| `pagination.blade.php` | Remove | Use WinterCMS `{% component 'paginator' %}` |

---

#### 8.4 Page Conversion

Each Laravel route/controller pair becomes a single WinterCMS CMS page file in `themes/toadgully/pages/`. Pages have three sections: config (INI), PHP, and markup.

**`pages/home.htm`:**
```
url = "/"
layout = "default"
title = "Home"
[homeBlocks]
==
<?php
function onRun() {
    // component onRun() handles data loading
}
?>
==
{% component 'homeBlocks' %}
```

**`pages/contact.htm`:**
```
url = "/get-in-touch"
layout = "default"
title = "Get In Touch"
[contactForm]
==
==
{% component 'contactForm' %}
```

**`pages/products.htm`:**
```
url = "/products"
layout = "default"
title = "Products"
[productList]
==
==
{% component 'productList' %}
```

**`pages/product-detail.htm`:**
```
url = "/product/:slug"
layout = "default"
title = "Product"
[productDetail]
    slug = "{{ :slug }}"
==
==
{% component 'productDetail' %}
```

**`pages/ferns.htm`:**
```
url = "/ferns"
layout = "default"
title = "Ferns"
[plantList]
    category = "ferns"
==
==
{% component 'plantList' %}
```

**`pages/paulownia.htm`:**
```
url = "/paulownia"
layout = "default"
title = "Paulownia"
[plantList]
    category = "paulownia"
==
==
{% component 'plantList' %}
```

**Checkout pages** (`/cart`, `/checkout`, `/checkout/delivery`, `/checkout/card`, `/checkout/thankyou`) follow the same pattern, each attaching the relevant checkout component.

**Complete page file mapping:**

| Laravel route | CMS Page file | Component attached |
|---|---|---|
| `GET /` | `pages/home.htm` | `homeBlocks` |
| `GET /get-in-touch` | `pages/contact.htm` | `contactForm` |
| `POST /get-in-touch` | — | handled by `contactForm::onSubmit()` |
| `GET /ferns` | `pages/ferns.htm` | `plantList` |
| `GET /paulownia` | `pages/paulownia.htm` | `plantList` |
| `GET /products` | `pages/products.htm` | `productList` |
| `GET /product/:slug` | `pages/product-detail.htm` | `productDetail` |
| `GET /cart` | `pages/cart.htm` | `cartView` |
| `POST /cart` | — | `cartView::onAdd()` |
| `DELETE /cart/:product` | — | `cartView::onRemove()` |
| `GET /checkout` | `pages/checkout.htm` | `checkoutContact` |
| `GET /checkout/delivery` | `pages/checkout-delivery.htm` | `checkoutDelivery` |
| `GET /checkout/card` | `pages/checkout-card.htm` | `checkoutCard` |
| `GET /checkout/thankyou` | `pages/checkout-thankyou.htm` | `checkoutThankYou` |

---

#### 8.5 Asset Pipeline Setup

Move asset source files into the theme:

```bash
mkdir -p themes/toadgully/assets/src

# Copy source assets from Laravel project
cp resources/css/app.css   themes/toadgully/assets/src/
cp resources/sass/         themes/toadgully/assets/src/sass/ -r
cp resources/js/app.js     themes/toadgully/assets/src/
cp resources/images/       themes/toadgully/assets/images/ -r
cp tailwind.config.js      themes/toadgully/
```

Update `webpack.mix.js` (or create new), compiling output into `themes/toadgully/assets/`:

```js
const mix = require('laravel-mix');

mix.setPublicPath('themes/toadgully/assets')
   .sass('themes/toadgully/assets/src/sass/app.scss', 'css/app.css')
   .js('themes/toadgully/assets/src/app.js', 'js/app.js')
   .options({ processCssUrls: false });
```

Upgrade Tailwind CSS from 1.x to 3.x at this stage:

```bash
npm install tailwindcss@^3 @tailwindcss/forms @tailwindcss/typography autoprefixer
```

Update `tailwind.config.js` to Tailwind 3 format and replace deprecated `@tailwindcss/ui` with the new plugins.

---

### Phase 9 — Register Mail Templates & Settings

In `ToadGully\Contact\Plugin.php`:

```php
public function registerMailTemplates()
{
    return [
        'toadgully.contact::mail.contact'      => 'Contact form submission',
        'toadgully.shop::mail.order_invoice'   => 'Order invoice to customer',
        'toadgully.shop::mail.order_paid'      => 'Order paid notification',
        'toadgully.shop::mail.order_sent'      => 'Order dispatched notification',
    ];
}
```

Move mail view files to `plugins/toadgully/contact/views/mail/` and `plugins/toadgully/shop/views/mail/`.

In `ToadGully\Core\Plugin.php`, register backend settings (replaces `appstract/laravel-options`):

```php
public function registerSettings()
{
    return [
        'settings' => [
            'label'       => 'Toad Gully Settings',
            'description' => 'Manage site ABN, bank details and other settings.',
            'category'    => 'Toad Gully',
            'icon'        => 'icon-cog',
            'class'       => 'ToadGully\Core\Models\Settings',
            'order'       => 500,
        ]
    ];
}
```

Create `plugins/toadgully/core/models/Settings.php` extending `System\Classes\SettingsModel`.

---

### Phase 10 — Move the Pin Payments Library

```bash
mkdir -p plugins/toadgully/shop/classes/pin
cp app/Libraries/Pin/PinPayments.php plugins/toadgully/shop/classes/pin/PinPayments.php
```

Update the namespace: `App\Libraries\Pin` → `ToadGully\Shop\Classes\Pin`

Update all `CheckoutCard` component references accordingly.

---

### Phase 11 — Data Migration (Existing Site Only)

If migrating a live site with existing data:

1. **Export existing data** from the Laravel database (orders, products, plants, customers, pages, blocks)
2. **Re-import** into the new WinterCMS database after running `winter:up`
3. **Media files** — Spatie MediaLibrary stores files under `storage/app/media/` with its own path structure. These must be re-uploaded or a custom script written to:
   - Read the existing `media` table records
   - Move physical files to `storage/app/uploads/`
   - Insert corresponding records into WinterCMS's `system_files` table with correct `attachment_type` and `attachment_id` values.
4. **Pages/Blocks** — can be exported via SQL and re-imported directly; table structure is unchanged.
5. **Orders/Customers/Addresses** — import directly; table structure is unchanged.

---

### Phase 12 — QA & Go-Live Checklist

- [ ] All CMS pages render correctly with real data
- [ ] Cart add/remove works (AJAX handlers returning correct data)
- [ ] Multi-step checkout completes end-to-end in Pin Payments test mode
- [ ] PDF invoice generates and attaches to confirmation email
- [ ] Order confirmation and dispatch emails send correctly
- [ ] Backend login works; all list/form controllers display data
- [ ] Media upload works for products, plants, and pages in backend
- [ ] Contact form submits and triggers email notification
- [ ] Honeypot / spam protection active on contact form
- [ ] CSRF tokens present on all forms
- [ ] `.env` credentials confirmed (no hardcoded secrets remain)
- [ ] `APP_DEBUG=false` and `APP_ENV=production` set
- [ ] 2FA enabled for backend admin users (Settings > Backend Preferences)
- [ ] SEO meta tags rendering correctly per page
- [ ] Sitemap.xml accessible (Winter.Sitemap plugin)
- [ ] Redirect old URLs if any route slugs changed
- [ ] SSL certificate valid and HTTPS enforced

---

*Evaluation by GitHub Copilot — based on static analysis of source files only. No runtime analysis performed.*
