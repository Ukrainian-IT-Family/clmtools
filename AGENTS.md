# Repository Guidelines

## Project Structure & Module Organization
This repo is split into two apps:
- `api/`: Laravel 9 backend (REST API, auth, broadcasting, queue, DB migrations).
- `client/`: Vue 2 frontend (Vue Router, Vuex modules, BootstrapVue UI).

Key backend paths:
- `api/app/` business logic (Actions, Controllers, Models, Middleware)
- `api/routes/api.php` API routes (`/api/v1/...`)
- `api/database/migrations/` schema changes
- `api/tests/Feature/` API integration tests

Key frontend paths:
- `client/src/views/` page-level screens
- `client/src/components/` reusable UI parts
- `client/src/store/modules/` Vuex domain modules

## Build, Test, and Development Commands
Backend (Docker-first):
- `cd api && docker compose up -d` start API stack.
- `docker exec -it clm-app composer install` install PHP deps.
- `docker exec -it clm-app php artisan key:generate`
- `docker exec -it clm-app php artisan jwt:secret`
- `docker exec -it clm-app php artisan migrate && docker exec -it clm-app php artisan db:seed`

Frontend:
- `cd client && npm install` install deps.
- `npm run serve` run dev server at `http://localhost:8080`.
- `npm run build` production build.
- `npm run lint` run ESLint checks.

Tests:
- `cd api && ./vendor/bin/phpunit`
- CI uses: `./vendor/bin/phpunit -c phpunit.github.xml --coverage-clover coverage.xml`

## Coding Style & Naming Conventions
- Follow `.editorconfig`: UTF-8, LF, spaces, 4-space indent, trim trailing whitespace.
- PHP style follows PSR-12 (`.styleci.yml`).
- Laravel classes: PascalCase (`TaskControllers`, `AddMessageAction`), PSR-4 under `App\`.
- Vue components/views: PascalCase filenames (`AddTask.vue`); Vuex action/mutation constants are uppercase (`GET_TASKS`, `SET_LOADING`).

## Testing Guidelines
- Add/extend API tests in `api/tests/Feature/*ApiTest.php` for endpoint behavior.
- Keep tests close to feature area (auth, users, tasks, chat).
- Prefer request/response assertions and auth-role boundary checks.

## Commit & Pull Request Guidelines
- Existing history uses short imperative messages (`Auth error fix`, `Image size fix`).
- Branches commonly follow ticket prefixes: `feat/CAP-xxx-*`, `fix/CAP-xxx-*`.
- In PRs, include:
  - concise scope summary,
  - linked ticket (CAP id),
  - migration/env changes,
  - UI screenshots for frontend changes,
  - test evidence (commands run + result).

## Security & Configuration Tips
- Do not commit secrets; use `.env.example` templates.
- Ensure `PUSHER_*`, mail settings, and `JWT_SECRET` are configured per environment.

## Work History Logging (Required)
- Keep a running history of user requests and completed actions in repository docs.
- Logging is centralized at the repository root and applies to both `api/` and `client/`.
- Every session must record time metadata: `Session Start`, `Session End`, `Timezone`, and `Duration`.
- Use ISO-like local timestamps (example: `2026-02-07 22:12:55 EET`).
- If a session is still active, mark `Session End: in_progress` and update it when closed.
- For prompt-level or informational tasks (questions, explanations, setup guidance), append an entry to root `HISTORY.md`.
- For feature work (code changes that implement/fix functionality), document it in root `FEATURE.md`.
- For runtime or integration issues, append an incident entry to root `ERROR.md`.
- Each `ERROR.md` entry must include: date, scope (`api` or `client`), error message, where it happened, status (`open`/`resolved`), and if resolved, the solution and approach used.
- Each log entry should include: date, request/goal, actions taken, affected files, and outcome.
- Keep entries concise and chronological.
