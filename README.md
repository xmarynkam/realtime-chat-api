# Live Chat API – Laravel 12 + Reverb

This is the backend part of a **Live Chat** system built with **Laravel 12**, **PHP 8.4**, **Sanctum 4.0**, and **Reverb 1.0** for real-time WebSocket communication.

> **Frontend repository:**
> [realtime-chat-client (Vue 3 + Echo + Typing Indicator)](https://github.com/xmarynkam/realtime-chat-client)

---

## Requirements

* PHP >= 8.4
* Laravel 12.x
* Composer 2.x
* MySQL
* Laravel Reverb (WebSocket Server)

---

## Getting Started

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd <project-directory>

composer install
```

### 2. Configure Environment

```bash
cp .env.example .env
```

Then update `.env` file with your local settings:

```env
APP_NAME="Live Chat"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chat_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=reverb
REVERB_APP_ID=app-id
REVERB_APP_KEY=app-key
REVERB_APP_SECRET=app-secret

SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost
```

---

### 3. Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

**Password for all demo users:** `password123`

---

### 4. Run Queue Worker & WebSocket Server

```bash
php artisan queue:work --tries=1
php artisan reverb:start
```

> Make sure Laravel Reverb is installed via Composer:
>
> ```bash
> composer require laravel/reverb
> ```

---

## Authentication

Authentication is handled via Laravel Sanctum using token-based auth.
```
Authorization: Bearer YOUR_TOKEN_HERE
```

Your frontend app must attach the token in the Authorization header for all requests, including broadcasting:

Broadcasting authorization endpoint:
`POST /broadcasting/auth`

---

## Broadcasting Setup

Example channels in `routes/channels.php`:

```php
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return $user->chats()->where('chat_id', $chatId)->exists();
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
```

---

## Features

* Real-time messaging with Laravel Echo and Reverb
* Private channel authorization
* Whisper events for "user is typing" indicator
* Integration with Laravel Sanctum
* Queue-based message broadcasting

---

## API & Events

### Events

* `MessageSent` – Broadcast when a message is sent
* `typing` (via `whisper`) – Broadcast when a user is typing

### API Example (for testing)

You may use [Postman](https://www.postman.com/) or browser DevTools to inspect:

```
POST /api/login
POST /api/chats
GET  /api/chats
GET  /api/messages/{chat}
POST /api/messages
```

---

## Frontend Client

The frontend is implemented using **Vue 3 + Vite**, with real-time communication via **Laravel Echo** and **whisper()** for typing indicators.

**Frontend repo:**
[realtime-chat-client](https://github.com/xmarynkam/realtime-chat-client)

---

## License

This project is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).

---
