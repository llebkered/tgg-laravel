# Toad Gully Growers: Developer Guide

This guide is for developers working on the Toad Gully Growers website (toadgully.com.au). The site is a Laravel app for a plant nursery. It has a small online shop, a plant catalogue, editable pages and an admin backend.

For how staff use the backend, see [backend-guide.md](backend-guide.md). Signed-in admins can also read that guide at `/backend/guide`.

---

## Stack

| Part | Version / tool |
|---|---|
| PHP | 8.4. `composer.json` pins `config.platform.php` to 8.4.1, so packages resolve for the live server. |
| Framework | Laravel 13 |
| Database | MySQL 8.4 locally. Tests use in-memory SQLite. |
| Auth | Laravel Fortify (login, logout and password reset only) |
| Payments | Pin Payments, called directly over HTTP ([app/Libraries/Pin/PinPayments.php](../app/Libraries/Pin/PinPayments.php)) |
| Cart | `hardevine/shoppingcart`, bundled locally in `packages/shoppingcart` (see [Bundled packages](#bundled-packages)) |
| Images | Spatie Media Library 11, Intervention Image 3 |
| PDFs | `barryvdh/laravel-dompdf`, for the invoices and receipts attached to emails |
| Rich text | TinyMCE (self-hosted in `public/js/tinymce`) and UniSharp Laravel File Manager |
| CSS | Bulma 0.9, compiled with Laravel Mix 5 and Sass |
| Dev tools | Telescope, Debugbar, Ignition |

---

## Local setup

The local environment runs on **Podman** using `compose.yaml`. Docker Compose works with the same file.

### Containers

| Service | Container | Purpose | Port |
|---|---|---|---|
| `app` | `tgg-app` | PHP 8.4 + Apache, built from [docker/php/Containerfile](../docker/php/Containerfile) | http://localhost (80 → 8080) |
| `queue` | `tgg-queue` | Runs `queue:work database`. Idle unless `QUEUE_CONNECTION=database`. | |
| `db` | `tgg-db` | MySQL 8.4 | |
| `phpmyadmin` | `tgg-phpmyadmin` | phpMyAdmin | http://localhost:8081 |

### First run

```sh
cp .env.example .env            # then fill in DB_*, PIN_*, MAIL_*, BANK_*
podman compose up -d --build
podman exec -it tgg-app composer install
podman exec -it tgg-app php artisan key:generate
podman exec -it tgg-app php artisan migrate
podman exec -it tgg-app php artisan storage:link
```

The DB container reads `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` from `.env`. Inside the compose network, set `DB_HOST=db`.

There is no `DatabaseSeeder`. Seeders in `database/seeds/` are run one at a time, for example `php artisan db:seed --class=OrderStatusSeeder`. The colour, status and category tables need seeding before the backend's block and plant forms work. For real content, import a copy of the live database through phpMyAdmin.

### Making an admin

Register or create a user, then:

```sh
php artisan user:admin someone@example.com
```

This gives the user the `admin` role ([app/Console/Commands/MakeAdmin.php](../app/Console/Commands/MakeAdmin.php)). `User::isAdmin()` checks that role, and `AdminAccessMiddleware` guards every `/backend` route with it.

### Document root and the `/public` prefix

The app is served from the **project root**, not `public/`. There is an `index.php` and an `.htaccess` at the root, and `.htaccess` blocks access to `.env`. As a result:

- static files and uploaded media are at `/public/...` URLs, for example `http://localhost/public/css/app.css`
- the local `.env` sets `ASSET_URL=http://localhost/public` and `PUBLIC_STORAGE_URL=http://localhost/public/storage`. `config/filesystems.php` reads `PUBLIC_STORAGE_URL` for the public disk's URL.
- on live, `APP_URL` already ends in `/public`, so it doesn't need the override

If an image or stylesheet 404s locally, check the `/public` prefix before assuming the file is missing.

`mysymlink.php` at the root creates the `public/storage` symlink on hosts without shell access.

### Front-end assets

```sh
npm install
npm run dev        # or: npm run watch / npm run prod
```

[webpack.mix.js](../webpack.mix.js) builds:

- `public/js/app.js` from `resources/js/app.js`, `bulma.js` and `menu.js`
- `public/css/app.css` (site), `admin.css` (backend) and `print.css` from `resources/sass/`
- copies of `resources/images/*` and Fancyapps into `public/`

The toolchain is old (Mix 5, webpack 4), so it may need an older Node version. Tailwind is still listed in `package.json` but isn't used by the build.

---

## Configuration

| `.env` key | Used for |
|---|---|
| `PIN_HOST` | `test-api.pinpayments.com` for testing, `api.pinpayments.com` for real payments |
| `PIN_SECRET`, `PIN_PUBLISHABLE` | Pin keys. **There are no defaults.** If `PIN_SECRET` is missing, card payments fail with a clear error and the order isn't locked. |
| `BANK_NAME`, `BANK_BSB`, `BANK_ACCOUNT` | Bank details shown on direct-deposit invoices ([config/bank.php](../config/bank.php)) |
| `TGG_ABN` | ABN printed on invoices ([config/tgg.php](../config/tgg.php)) |
| `TGG_SALES_EMAIL` | Gets a BCC of every customer order email, plus staff alerts. Defaults to `sales@toadgully.com.au`. |
| `RECIPIENT_EMAIL`, `RECIPIENT_NAME` | Who gets contact form messages ([config/recipient.php](../config/recipient.php)). The defaults are placeholders, so set them. |
| `QUEUE_CONNECTION` | `sync` sends emails during the request. `database` queues them for the `queue` container or a worker. |
| `MAIL_*` | SMTP for all outgoing mail |
| `ASSET_URL`, `PUBLIC_STORAGE_URL` | Local `/public` prefix (see above) |

> **The live server has its own private `.env`.** `.env.remote` in the working copy is gitignored and doesn't reflect production. Don't use it to work out how live is configured.

### Site options

Runtime settings that staff can toggle are stored in the `options` table and read with the `option()` helper ([app/helpers.php](../app/helpers.php), [app/Models/Option.php](../app/Models/Option.php)):

```php
option('maintenance');               // read
option(['maintenance' => true]);     // write
```

The keys currently in use are `maintenance` (see [Maintenance mode](#maintenance-mode)) and `shop`. The `shop` toggle's route still exists, but its button is commented out in the backend.

---

## Code map

```
app/
  Actions/            ChargeOrder (card payments), RefreshCart, Fortify actions
  Console/Commands/   user:admin
  Enums/              OrderStatus, ChargeStatus
  Events/ Listeners/  OrderPaid / OrderInvoiced → queued customer emails
  Http/
    Controllers/          Public site (home, products, ferns, paulownia, contact, cart)
    Controllers/Checkout/ One controller per checkout step
    Controllers/Backend/  Admin backend
    Middleware/           AdminAccessMiddleware, ShowMaintenancePage
    Requests/             Checkout and contact form validation
  Libraries/Pin/      Thin Pin Payments HTTP client
  Mail/               All outgoing emails
  Models/             Eloquent models
  Support/            ImageResizer
docs/                 Staff guide and this guide
packages/shoppingcart Bundled cart package
resources/views/
  backend/            Admin screens (Bulma)
  checkout/           Checkout steps
  emails/             Email templates (text and PDF)
routes/web.php        All routes
```

---

## How the site works

### Pages

The `pages` table holds each page's title, body, meta fields and gallery. Most public controllers load "their" page by slug, for example `Page::where('slug', 'products')`. The slugs `/`, `products`, `ferns`, `paulownia`, `contact-us`, `cart`, `checkout` and `thankyou` must exist, and staff are warned not to rename them.

`BackendPageController::edit` treats the page with **id 1** as the home page and shows the block editor instead of the normal page form.

### Home page blocks

[HomeController](../app/Http/Controllers/HomeController.php) shows one published **hero** block, chosen at random, followed by the published non-hero blocks ordered by `weight`. Block colours come from the `textcolours` and `backgroundcolours` tables, which store CSS class names. `ImageResizer::blockBackground` resizes background images to 1366×768.

### Products and the cart

A `Product` has many `Variation`s. The cart holds variations, not products. A variation can be bought only when **all** of these are true:

- `variation.is_published`
- `product.published`
- `product.stocked`

[CartController](../app/Http/Controllers/CartController.php) checks this when an item is added. Cart items keep the name and price from when they were added, so [RefreshCart](../app/Actions/RefreshCart.php) runs at the start of checkout. It removes items that can no longer be bought, updates changed names and prices, and returns a message telling the customer what changed.

### Checkout

Checkout uses one controller per step under `app/Http/Controllers/Checkout/`. The current order and customer ids are kept in the session (`order`, `customer`).

| Step | Route | Controller | What happens |
|---|---|---|---|
| 1. Contact | `GET/POST /checkout` | `ContactController` | Refreshes the cart. Creates the `Customer` and the `Order` (status **InCart**) with a JSON snapshot of the cart and its totals. |
| 2. Delivery | `GET/POST /checkout/delivery` | `DeliveryController` | Saves the address on the order. |
| 3a. Card | `GET/POST /checkout/card` | `CardPaymentController` | Charges the card through `ChargeOrder`. On success the order becomes **Paid** and the `OrderPaid` event fires. |
| 3b. Direct deposit | `GET /checkout/directdeposit` | `DirectDepositController` | The order becomes **Invoiced** and the `OrderInvoiced` event fires. This is blocked while a card payment is in progress. |
| Done | `GET /checkout/thankyou` | `ThankYouController` | Needs a paid order. Safe to refresh. |

`InteractsWithCheckout` holds the shared helpers. `alreadyPaid()` sends a back button press or a resubmitted form to the thank-you page instead of charging again.

### Card payments and double-charge protection

[ChargeOrder](../app/Actions/ChargeOrder.php) makes sure an order is never charged twice:

1. It **claims** the order with one atomic `UPDATE … SET payment_started_at = now()`. This only succeeds if the order isn't settled and isn't already claimed. A double click finds the order already claimed and gets `ChargeStatus::AlreadyClaimed`.
2. It calls Pin. The HTTP timeout is 60 seconds.
3. Then, depending on the result:
   - **201**: the order is marked Paid and the Pin `charge_token` is saved.
   - **4xx** (e.g. card declined): nothing was charged, so the claim is cleared and the customer can try again.
   - **5xx, a timeout or no reply**: the outcome is unknown. The order **stays claimed**, the error is logged, `PaymentUnconfirmedMail` goes to sales, and the customer is told not to try again.

An order is shown as needing attention ("payment unconfirmed") when `payment_started_at` is more than `Order::PAYMENT_TIMEOUT_MINUTES` (2) old and the order isn't settled. See `Order::paymentNeedsChecking()` and the matching query scope. Staff resolve it in the backend through [OrderPaymentController](../app/Http/Controllers/Backend/OrderPaymentController.php):

- **markPaid** sets the order to Paid, can record a charge token, and can send the receipt
- **release** clears `payment_started_at` so the customer can pay again

Both use the same atomic `paymentNeedsChecking()` scope, so two staff clicking at once can't both act.

Each charge is sent to Pin with `Order #<id>:` at the start of its description and `metadata[order_id]`, so charges can be found by order in Pin.

**Check with Pin.** The order screen's "Card payment in Pin" panel ([pin-charges.blade.php](../resources/views/backend/order/pin-charges.blade.php)) shows on orders with a `charge_token` or `payment_started_at`. Clicking **Check with Pin** reloads the order with `?check_pin=1`, and [FindOrderCharges](../app/Actions/FindOrderCharges.php) then asks Pin:

- with a `charge_token`, it fetches that charge (`GET /1/charges/{token}`)
- otherwise it searches charges by the order's email, from the day before the payment started to two days after (`GET /1/charges/search`), and flags charges matching the order total or its `order_id` metadata

Pin is only asked when staff click the button, so opening an order never waits on Pin. Errors, timeouts (20 seconds) and a missing key are shown in the panel and reported, and the rest of the order screen still works.

### Order statuses

`OrderStatus` is an int-backed enum ([app/Enums/OrderStatus.php](../app/Enums/OrderStatus.php)). `Order::$order_status_id` is cast to it, and the ids match the `order_statuses` table.

| Id | Case | Notes |
|---|---|---|
| 1 | InCart | Created at checkout step 1 |
| 2 | Invoiced | Direct deposit chosen |
| 3 | Paid | |
| 4 | Shipped | |
| 5 | OnHold | |
| 6 | Cancelled | |
| 7 | Refunded | |

There are two helper lists:

- `OrderStatus::open()` returns InCart, Invoiced and Paid. Used for the "open orders" counts.
- `OrderStatus::settled()` returns Paid, Shipped, Cancelled and Refunded. These orders can never be charged and never show as payment unconfirmed.

`Order::isPaid()` is true **only** for status Paid. Before using it to mean "money has been received", check whether `settled()` is what you actually need.

### GST

Prices include GST. GST is 1/11 of the total: use `Order::gstIncluded($total)` and `$order->gstAmount()`, not the stored `gst` column. Orders placed before October 2026 stored 1/10. The migration `2026_10_24_000000_correct_gst_on_orders` fixed them and kept the old figure in `gst_as_invoiced`.

### Emails

| Mailable | Trigger | To |
|---|---|---|
| `OrderPaidMail` (receipt + PDF) | `OrderPaid` → `SendOrderPaidEmail` (queued) | Customer, BCC sales |
| `OrderInvoiceMail` (invoice + PDF) | `OrderInvoiced` → `SendOrderInvoiceEmail` (queued) | Customer, BCC sales |
| `OrderShippedMail` | Sent by staff from the backend | Customer, BCC sales |
| `PaymentUnconfirmedMail` | `ChargeOrder` when the outcome is unknown | Sales |
| `OrderEmailFailedMail` | A queued customer email failed every attempt | Sales |
| `ContactFormMessage` (notification) | Contact form. The message is also saved in `contacts`. | `RECIPIENT_EMAIL` |

The queued listeners share the [SendsOrderEmails](../app/Listeners/SendsOrderEmails.php) trait, which tries 3 times, 60 seconds apart, and then calls `alertSales()`. With `QUEUE_CONNECTION=sync` there are no retries, so a failure alerts sales straight away. Checkout dispatches these events inside `rescue()`, so a mail failure never breaks a completed payment.

### Maintenance mode

This is separate from `php artisan down`. Staff toggle `option('maintenance')` from the dashboard ([MaintenanceController](../app/Http/Controllers/Backend/MaintenanceController.php)). While it's on, [ShowMaintenancePage](../app/Http/Middleware/ShowMaintenancePage.php) returns `resources/views/maintenance.blade.php` with a **503** status and `Retry-After: 3600`. Admins, `/backend/*`, login, logout and password reset routes are let through.

### Backend

Every backend route is under `/backend` behind `AdminAccessMiddleware`. It sends guests to `/login` and non-admins to `/`. The backend views use Bulma and `resources/views/backend/layouts/main.blade.php`. The left menu is `backend/partials/sidenav.blade.php`.

`/backend/guide` renders `docs/backend-guide.md` with `Str::markdown` and the CommonMark heading permalink extension, which gives headings ids that match the guide's contents links. Edit the Markdown file to change it.

### Media

Spatie Media Library stores files on the `public` disk (`storage/app/public`). Products use the `featured_image` and `gallery` collections, and pages use `gallery`. Thumbnails come from the models' media conversions. `ImageResizer` handles the resizing that isn't done by the media library: page images and block backgrounds.

---

## Testing

```sh
php artisan test
```

- PHPUnit 12, using the `Unit` and `Feature` suites in `tests/`.
- [phpunit.xml](../phpunit.xml) uses in-memory SQLite, the array mailer, the sync queue and a dummy `PIN_SECRET`. Tests never use your `.env` database or mail settings.
- Tests that touch Pin fake it with `Http::fake()` and `Http::preventStrayRequests()`, so no real HTTP request can leave a test. See [CardPaymentTest](../tests/Feature/Http/Controllers/CardPaymentTest.php) for the `fakePin()` helper.
- `User::factory()->admin()` makes an admin for backend tests.
- `tests/Browser` holds old Laravel Dusk tests. Dusk isn't installed, so they don't run.

Because tests run on SQLite, avoid MySQL-only SQL in queries and migrations, or guard it by driver.

The suite should stay green before every deploy.

---

## Bundled packages

`packages/shoppingcart` is a copy of `hardevine/shoppingcart` 3.4, added as a Composer `path` repository because no upstream release supports Laravel 13 yet. The only change is `^13` in its `illuminate/*` requirements. When upstream supports Laravel 13, remove the `repositories` entry from `composer.json`, require the release and delete the folder. See [packages/shoppingcart/LOCAL-COPY.md](../packages/shoppingcart/LOCAL-COPY.md).

---

## Deploying

Deployment isn't automated and there's no CI. The site owner deploys by hand. When deploying:

1. Run the tests locally.
2. Upload the code, including `docs/`, which the backend Help page reads at runtime.
3. Run `composer install --no-dev --optimize-autoloader` on the server, or upload `vendor/` built for **PHP 8.4**.
4. Run `php artisan migrate --force` if there are new migrations.
5. Build assets with `npm run prod` and upload `public/css`, `public/js` and `public/images` if they changed.
6. Clear caches: `php artisan optimize:clear`, then `php artisan config:cache` if you use config caching.

Live `.env` checklist:

- `APP_ENV=production` and `APP_DEBUG=false`
- `PIN_HOST=api.pinpayments.com` and live `PIN_SECRET` and `PIN_PUBLISHABLE` keys
- `BANK_*`, `TGG_ABN`, `TGG_SALES_EMAIL`, `RECIPIENT_EMAIL` and working `MAIL_*`
- if `QUEUE_CONNECTION=database`, a running queue worker. Otherwise use `sync`.


