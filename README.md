# BookExchange

## Overview

BookExchange is a PHP/MySQL marketplace for buying and selling second-hand books. It connects readers across Nepal, making it easy to list books, browse by location and condition, and manage orders — all with a modern, responsive UI.

## What it solves

- **No dedicated book marketplace** for Nepali readers — BookExchange fills that gap with district-based local listings.
- **Cumbersome selling workflows** — simplified listing form with price suggestions, drag-and-drop image upload, and savings calculator.
- **Hard to find local books** — filter by district (all 77 Nepal districts grouped by province) and condition (New/Used).
- **No visibility into orders** — unified dashboard showing stats, listings, orders, earnings, and recent activity.

## Key Features

- **Browse** — search by title/author, filter by New/Used condition and district, responsive card grid with image zoom and condition badges
- **Sell** — modern card form with sections (Book Info, Condition, Pricing, Location), drag-and-drop image upload, condition chips, price suggestion API, savings calculation, description character counter
- **Dashboard** — welcome header with avatar, 4 stat cards (listings/orders/sold/earnings), listings grid with Edit/Mark Sold/Delete actions, orders list with status badges, quick actions panel, recent activity timeline
- **My Listings** — card layout with image overlay badges (condition + status), zoom hover, Edit/Delete with inline modal
- **Orders** — buyer and seller order management with status tabs, inline status updates
- **Purchase History** — completed purchases with seller info and prices
- **Book Details** — full detail view with image, price, condition, location, seller info, and order placement
- **Responsive** — fully adaptive layout for desktop, tablet, and mobile

## Project Structure

```
book-exchange/
├── pages/          # Frontend pages (index, browse, sell-book, dashboard, etc.)
├── api/            # REST endpoints (get_books, add_book, update_book, orders, etc.)
├── css/            # Single stylesheet (style.css) with all component styles
├── js/             # API helper (api.js) and auth (auth.js)
├── includes/       # Shared header, footer, auth check
├── config/         # Database connection (db.php)
├── uploads/        # Book cover images
└── database/       # Schema SQL
```

## Pages

| Route | Description |
|-------|-------------|
| `/pages/index.php` | Homepage — hero with illustration, features, recently added books (API-fetched), how-it-works steps |
| `/pages/browse.php` | Browse books — search, condition/district filters, responsive grid with skeletons |
| `/pages/sell-book.php` | Sell form — sections, chips, drag-drop upload, price suggestion, savings calc |
| `/pages/dashboard.php` | User dashboard — stats, listings (edit/mark sold/delete), orders, activity, quick actions |
| `/pages/my-listings.php` | Full listing management — card grid, edit/delete with modal |
| `/pages/book-details.php` | Single book view — details, seller info, order button |
| `/pages/orders.php` | Order management — tabs (pending/confirmed/shipped/completed), status updates |
| `/pages/purchase-history.php` | Completed purchases list |
| `/pages/login.php` | Login form |
| `/pages/register.php` | Registration form |

## API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `get_books.php` | GET | List books (filter by search, condition, district, seller_id) |
| `get_book.php` | GET | Single book details |
| `add_book.php` | POST | Create listing (multipart with image) |
| `update_book.php` | POST | Update listing |
| `delete_book.php` | DELETE | Remove listing (JSON body) |
| `mark_sold.php` | POST | Mark listing as sold (JSON body) |
| `suggest_price.php` | GET | Price suggestion by condition |
| `get_orders.php` | GET | Orders by role (buyer/seller) |
| `place_order.php` | POST | Place new order |
| `update_order_status.php` | POST | Change order status |
| `finalize_location.php` | POST | Finalize delivery location |
| `get_purchased_books.php` | GET | Completed purchases |
| `get_seller_reviews.php` | GET | Reviews for a seller |
| `add_review.php` | POST | Add review for an order |
| `login.php` | POST | User login |
| `register.php` | POST | User registration |
| `logout.php` | POST | User logout |

## Database

- **Database**: `book_exchange` (MySQL via XAMPP)
- **Tables**: `users`, `categories`, `books`, `orders`, `reviews`
- **Books** include: title, author, description, condition_type (new/used), condition_notes, price, original_price, district (77 Nepal districts), location, image_url, status (available/pending/sold)
- **Orders** track: book_id, buyer_id, seller_id, price, status, delivery_location, location_finalized

## Setup

1. Start Apache + MySQL via XAMPP.
2. Create a MySQL database and import `database/schema.sql`.
3. Update `config/db.php` if needed (default: root, no password, `book_exchange`).
4. Place the project under `S:\xmpp\htdocs\book-exchange\`.
5. Open `http://localhost/book-exchange/pages/index.php` in a browser.
6. Register an account and start listing or browsing books.

## Tech Stack

- **Backend**: PHP 8+, MySQL (PDO)
- **Frontend**: Vanilla JavaScript (ES6+), CSS3 (custom properties, grid, flexbox, animations)
- **Typography**: Inter (system-ui fallback)
- **Design tokens**: Blue primary (#2563EB), light gray background (#F8FAFC), white cards with subtle shadows, 16px border-radius
- **No external CSS/JS frameworks** — fully custom implementation
