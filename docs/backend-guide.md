# Toad Gully Growers — Backend Guide

This guide is for staff who look after the website: processing orders, updating products and plants, and editing pages.

---

## Contents

1. [Signing in](#signing-in)
2. [Finding your way around](#finding-your-way-around)
3. [The dashboard](#the-dashboard)
4. [Orders](#orders)
5. [Products](#products)
6. [Plants](#plants)
7. [Pages](#pages)
8. [The home page and its blocks](#the-home-page-and-its-blocks)
9. [Users](#users)
10. [Maintenance mode](#maintenance-mode)
11. [Emails the site sends](#emails-the-site-sends)
12. [Quick reference](#quick-reference)

---

## Signing in

1. Go to **/login** on the website (the old address **/backend/login** still works too).
2. Enter your email and password.
3. You'll be taken to the dashboard at **/backend**.

If you've forgotten your password, use the **Forgot password** link on the login page and a reset link will be emailed to you.

Only accounts set up as administrators can open the backend. If you sign in with any other account you'll be sent back to the public home page.

To sign out, click **Log Out** at the bottom of the left-hand menu.

---

## Finding your way around

The menu on the left of every backend screen has:

| Menu item | What it's for |
|---|---|
| **TGG Dashboard** | Back to the dashboard |
| **Pages** | Edit the website's pages, including the home page |
| **Plants** | The plant catalogue (e.g. ferns) |
| **Products** | Items for sale in the shop |
| **Orders** | Customer orders |
| **Users** | Who has an account |
| **Home Page** | Opens the public website |
| **Log Out** | Signs you out |

After you save something, a green message appears at the top of the screen to confirm it worked. A red message means something went wrong, and it will say what.

---

## The dashboard

The dashboard shows:

- **Orders**: the total number of orders.
- **Open Orders**: orders that still need work, meaning they're *Invoiced* (waiting for a direct deposit) or *Paid* (ready to send). Unfinished checkouts (*In Cart*) aren't counted.
- **Site maintenance**: whether the site is open or closed to visitors (see [Maintenance mode](#maintenance-mode)).
- **The order list**: the same list as the Orders screen.

---

## Orders

### The order list

Click **Orders** in the menu. Each row shows the order number, date, customer, address, status and payment method.

- Click a column heading (**Id**, **Date**, **Customer** or **Status**) to sort by it. Click it again to reverse the order.
- Use the **Payment** buttons above the list to show only **Card**, **Direct deposit** or **Unknown** orders. Orders placed before 25 October 2026 mostly show **Unknown**, because the site didn't record the payment method then.
- A yellow **Payment unconfirmed** tag means a card payment needs checking. See [Unconfirmed card payments](#unconfirmed-card-payments).
- Click **edit** to open an order.

### Order statuses

| Status | Meaning |
|---|---|
| **In Cart** | The customer started checking out but hasn't paid. |
| **Invoiced** | The customer chose direct deposit. They've been emailed an invoice and you're waiting for the money. |
| **Paid** | Payment has been received. Ready to pack and send. |
| **Shipped** | The order has been sent. |
| **On Hold** | Paused for some reason, such as waiting on stock or a question for the customer. |
| **Cancelled** | The order won't go ahead. |
| **Refunded** | The customer's money has been returned. |

Card payments change the order to **Paid** automatically. Every other change is made by you.

### Processing a typical order

1. **Card orders** arrive as **Paid**. The customer has already been emailed a receipt.
   **Direct deposit orders** arrive as **Invoiced**. Check your bank account. Once the money arrives, open the order, leave **Email the receipt to the customer** ticked, and click **Payment received** in the blue **Waiting for direct deposit** box. The order becomes **Paid** and the customer gets a receipt saying their direct deposit was received.
2. Pack and send the order.
3. Open the order and click **Send Order Shipped Email** (see below).
4. Change the status to **Shipped** and click **Update Order**.

### Editing an order

On the order screen you can change:

- the **Order Status**
- the **Payment method**: Card, Direct deposit or Unknown. You only need this for older orders, to fill in how they were paid. New orders are set automatically.
- the customer's **name, email, phone and address**
- **Comments**: private notes for staff. Customers don't see these.

Click **Update Order** to save.

The items ordered and the total are shown for reference but can't be changed here.

> **Changing the status doesn't email the customer.** To let them know their order is on its way, use **Send Order Shipped Email**.

### Sending the "order shipped" email

1. Open the order and click **Send Order Shipped Email**.
2. Check the customer and order details shown at the top.
3. Enter the **Tracking** number, if there is one.
4. Optionally, write a **Message** to the customer.
5. Click **Send**.

The customer gets the email and a copy goes to the sales inbox. If the email can't be sent, a red message explains why and nothing is lost, so you can try again.

### Deleting an order

At the bottom of the order screen, click **Delete Order** and confirm.

> **Deleting can't be undone.** For orders that won't go ahead, it's usually better to set the status to **Cancelled** so there's still a record.

### Unconfirmed card payments

Occasionally the site sends a card payment to Pin Payments (the card processor) but never hears back, for example because the connection timed out. When that happens the site can't tell whether the card was charged, so it:

- tells the customer not to try again and that you'll be in touch
- emails the sales inbox with the order details
- blocks the order from being charged again until a staff member sorts it out
- shows a yellow **Payment unconfirmed** tag on the order list

**To resolve it:**

1. Open the order. A yellow **Card payment not confirmed** box shows when the payment was attempted, the customer's email and the amount.
2. Read the **Pin status** line in the box. The site asks Pin automatically when you open the order and tells you what it found:
   - **Charged**: Pin has one successful charge for this order. Its charge token is already filled in.
   - **2 possible charges** (or more): check the list under **Card payment in Pin** and pick the right one.
   - **Not charged**: Pin only has a failed attempt, for example a declined card.
   - **No charge found**: Pin has no successful charge to the customer's email for this amount around that time.
   - **Couldn't check**: Pin didn't answer. Sign in to the **Pin Payments dashboard** and search for the customer's email instead.

   The full list of charges Pin found is shown under **Card payment in Pin**, with the amount, time, result and token of each.
3. Then do one of these:
   The box's **What to do** line says which option to choose, and that option is marked **Recommended**.

   - **The card was charged:** check the Pin charge token (it's filled in when the status is **Charged**), leave **Email the receipt to the customer** ticked if they should get a receipt, and click **Mark as paid**. The order becomes **Paid**. If several charges were found, click **Mark paid with this charge** next to the right one in the list instead.
   - **The card wasn't charged:** click **Release the order**. The customer can then pay again. They aren't told automatically, so contact them to let them know.

Once the order is Paid, Shipped, Cancelled or Refunded, the warning disappears and the order can't be charged again.

### Checking a card payment in Pin

Any order paid by card has a **Card payment in Pin** box showing its Pin charge token. Click **Check with Pin** to see the charge's current status in Pin, for example after a refund. Older orders whose payment method is **Unknown** also have this box. If Pin has one clear successful charge for the order, **Check with Pin** sets its payment method to **Card** automatically. If it finds nothing, the order may have been paid by direct deposit; set the payment method yourself if you know. Charges made from 25 October 2026 onwards also start with the order number in Pin, e.g. "Order #123", so you can search for them by order number in the Pin dashboard.

---

## Products

Products are the items for sale in the shop. Each product has one or more **variations**, such as different sizes, and each variation has its own price.

### Adding a product

1. Click **Products**, then **Add new product**.
2. Fill in:
   - **Title**: the product name customers see.
   - **Slug**: the part of the web address for this product, e.g. `tree-fern` gives `/product/tree-fern`. Use lowercase letters and hyphens, with no spaces.
   - **Product Code**: your own reference code.
   - **Description**: formatted text, written in the editor.
   - **Published**: whether the product appears in the shop.
   - **In Stock**: whether customers can add it to their cart.
3. Choose a **Featured Image** if you have one.
4. Click **Add Products** to save.

Once the product is saved you can add variations and gallery images.

### Variations

Customers always buy a variation, never the product on its own, so **every product needs at least one variation before it can be sold**.

1. Open the product and click **Add new variation**.
2. Fill in:
   - **Title**, e.g. "140mm pot" or "1 metre trunk".
   - **Description**: optional detail.
   - **Price**: in dollars, including GST.
   - **Available**: whether this variation can be bought.
3. Click **Submit**.

To change a variation, click **edit** on its card on the product screen. To remove one, open it and click **Delete Variation**. Variations marked unavailable show **Out of stock**.

### When can a customer buy something?

All three of these must be true:

| Setting | Where | Must be |
|---|---|---|
| Published | Product | Published |
| In Stock | Product | In Stock |
| Available | Variation | Available |

- To hide a product completely, set it to **Not Published**.
- To show a product but stop sales of all its sizes, set it to **Not In Stock**.
- To stop sales of just one size, set that variation to **Unavailable**.

### Images

- **Featured Image**: the main picture. Choose a file on the product screen and click **Update Product**. To remove the current image, tick **Delete image** and update.
- **Image Gallery**: extra pictures. Click **Add new image**, choose a file, then click **Add to gallery**. To remove one, click **delete** under it.

### Deleting a product

Click **Delete Product** at the bottom of the product screen and confirm. This can't be undone. To take a product off the shop temporarily, set it to **Not Published** instead.

---

## Plants

The plant catalogue is a reference list of plants, separate from the shop. For example, the **Ferns** page lists every published plant in the ferns category, in order of botanical name.

1. Click **Plants**, then **Add new plant**, or **edit** next to an existing one.
2. Fill in:
   - **Common Name**
   - **Botanical Name**
   - **Description**
   - **Published**: whether it appears on the website.
   - **Promoted**: marks the plant as one to feature.
   - **Category**: e.g. Ferns.
   - **Featured Image**
3. Click **Update Plant** to save. The button has this label even when you're adding a new plant.

---

## Pages

Click **Pages** to see every page on the website.

### Editing a page

Each page has:

- **Title**
- **Slug**: the page's web address.
- **Content**: the main text, written in the editor.
- **Meta Description**: the short summary search engines show under the page title in results. Aim for one or two sentences.
- **Meta Keywords**
- **Status**: Active or Inactive.
- **Image Gallery**: pictures attached to the page.

Click **Submit** to save.

> **Don't change the slug of these pages.** The website looks them up by slug, and changing it will break that part of the site:
>
> `/` (home) · `products` · `ferns` · `paulownia` · `contact-us` · `cart` · `checkout` · `thankyou`

### Adding a page

Click **Add new page**, fill in the fields and save.

### Deleting a page

Open the page and click **Delete Page**. Never delete any of the pages listed above.

---

## The home page and its blocks

The home page is built from **blocks** instead of a single block of text. Open **Pages** and edit the home page (the first page in the list) to see them.

There are two kinds of block:

- **Hero**: the large banner at the top of the home page. If more than one hero is published, **a different one is chosen at random each time the page loads**.
- **Sections**: the blocks shown down the page below the hero.

Each block on the home page edit screen shows a preview with an **Edit** button. Click **Add new block** to create one.

### Block settings

| Setting | What it does |
|---|---|
| **Type** | Hero or Block (section). |
| **Weight** | Order on the page, from 0 to 10. Lower numbers appear higher up. |
| **Text Colour** / **Background Colour** | Colours for the block. |
| **Background Image** | Optional picture behind the block. Tick **Delete image** to remove it. |
| **Background Image Attachment** | **Scroll** moves the image with the page. **Fixed** gives a parallax effect. |
| **Heading** and **Heading Colour** | The block's heading. |
| **Content** | The block's text. |
| **Content background** | None, Transparent Dark or Transparent Light. A transparent background makes text easier to read over a busy image. |
| **Content width** | Full width or half width. |
| **Content position** | Left or right. Only used with half width. |
| **Call to action** | Button **Text** and the **Link** it goes to. |
| **Published** | Whether the block shows on the home page. |

To take a block off the home page without losing it, set it to unpublished.

The **Meta Description** and **Meta Keywords** for the home page are edited at the bottom of the same screen.

---

## Users

The **Users** screen lists everyone with an account, by name and email. It's for viewing only. Ask your web developer to add a new administrator or remove one.

---

## Maintenance mode

Maintenance mode closes the site to the public, for example while making major changes.

- **To turn it on:** on the dashboard, click **Turn maintenance on** and confirm. Visitors will see a maintenance page instead of the website.
- **To turn it off:** click **Turn maintenance off**.

While it's on:

- signed-in administrators still see and use the whole site as normal, so you can check your changes
- the login page and backend stay open, so you can always sign in and turn it off
- search engines are told the site is only temporarily away, so your search rankings aren't affected

> Remember to turn maintenance mode off when you're done. Customers can't place orders while it's on.

---

## Emails the site sends

| Email | Sent to | When |
|---|---|---|
| Receipt | Customer, with a copy to sales | Automatically, after a successful card payment, or when you mark an unconfirmed payment as paid with the receipt box ticked |
| Invoice | Customer, with a copy to sales | Automatically, when a customer chooses direct deposit |
| Order shipped | Customer, with a copy to sales | Only when you click **Send** on the shipped email screen |
| Payment unconfirmed | Sales | Automatically, when a card payment result is unknown |
| Email failed | Sales | Automatically, if a receipt or invoice couldn't be sent, so someone can follow up with the customer |

---

## Quick reference

| I want to… | Do this |
|---|---|
| Find new orders to send | **Orders**, then sort by **Status** and look for **Paid** |
| Confirm a direct deposit | Open the order and click **Payment received** |
| Tell a customer their order has shipped | Open the order, click **Send Order Shipped Email**, then set the status to **Shipped** |
| Fix a "Payment unconfirmed" order | Open the order, read the **Pin status**, then click **Mark as paid** or **Release the order** |
| Stop selling something for a while | Set the product to **Not In Stock**, or the variation to **Unavailable** |
| Hide a product completely | Set the product to **Not Published** |
| Change a price | Open the product and **edit** the variation |
| Change the home page banner | **Pages**, edit the home page, then **Edit** the hero block |
| Close the site temporarily | **Dashboard**, then **Turn maintenance on** |
