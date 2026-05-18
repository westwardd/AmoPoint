# AmoPoint Test Assignment

## What's implemented
- Console command `jokes:fetch` that pulls data every 5 minutes from `https://official-joke-api.appspot.com/random_joke` and stores it in DB.
- API route `GET /api/jokes` that returns all records as JSON.
- JS snippet `public/js/field-filter.js` that shows/hides fields by matching `name` with selected "Тип" value.
- Visit counter:
  - JS tracker `public/js/visit-tracker.js` collects `ip`, `city`, `device` and sends to backend.
  - Backend stores visits and renders stats page with:
    - bar chart of unique visits per hour (last 24h)
    - pie chart by city
  - Stats page protected by basic auth.

## Local run
```bash
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Scheduler
To run the 5‑minute job locally:
```bash
php artisan schedule:work
```
Or add a cron entry:
```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

## Endpoints
- `GET /api/jokes` — JSON list of stored jokes
- `POST /api/track` — visit tracking (CORS enabled)
- `GET /stats` — stats page (Basic Auth)

## Auth for stats
Configured via env:
```
STATS_USER=admin
STATS_PASS=admin
```

## JS snippets
### 1) Field filter
Include on `http://test.amopoint-dev.ru/testzz/testlist.html`:
```html
<script src="https://YOUR_DOMAIN/js/field-filter.js"></script>
```
Logic: only fields whose `name` contains the selected value remain visible.

Algorithm notes:
- Alternative: map of type => list of field IDs. Not chosen because spec says match by `name` substring, so direct string match is simpler and less brittle.
- Alternative: hide via CSS selectors only. Not chosen because required matching is dynamic per selection.

### 2) Visit tracker
Include on any site:
```html
<script src="https://YOUR_DOMAIN/js/visit-tracker.js" data-endpoint="https://YOUR_DOMAIN/api/track"></script>
```

Algorithm notes:
- Alternative: backend-only geo by IP. Not chosen because task explicitly asks JS to collect ip/city.
- Alternative: store only aggregate counters. Not chosen because charts require grouping by time/city with uniqueness.

## Render deploy (Docker)
This repo includes `Dockerfile` and `render.yaml`.
On Render:
- Create **Web Service** with **Docker**
- Add Postgres (or override to SQLite + disk)
- Set env vars (see `.env.example`)

## Files of interest
- Command: `app/Console/Commands/FetchJokeCommand.php`
- API routes: `routes/api.php`
- Stats page: `resources/views/stats.blade.php`
- Tracker: `public/js/visit-tracker.js`
- Field filter: `public/js/field-filter.js`
