# FEATURE

Chronological log for feature implementation work (new functionality, fixes, refactors with behavior impact).

## Entry Template
- Date:
- Feature / Fix:
- Goal:
- Implementation:
- Files changed:
- Verification:
- Result:

## 2026-02-07

### API Docker compatibility for Apple Silicon
- Goal: Make API stack runnable on macOS M-series hardware.
- Implementation:
  - Updated compose services to use amd64 emulation where required.
  - Removed obsolete compose `version` key.
- Files changed:
  - `api/docker-compose.yml`
- Verification:
  - Ran `docker compose up -d` in `api/` and confirmed all services started.
- Result:
  - API containers run successfully on M2 Pro.

### Notifications read-state end-to-end feature
- Goal: Add unread counter + read-state flow across backend and frontend notifications.
- Implementation:
  - Added `read_at` column to `notifications` table and extended `Notification` model/presenter payload (`is_read`, `read_at`).
  - Added API endpoints/actions/repository methods for:
    - read one notification,
    - read all notifications for current user,
    - unread-count retrieval.
  - Updated Vuex notifications module to track unread count, read state, and `all/unread` filter.
  - Updated notifications UI with mark-read, mark-all-read, unread filter, and unread badge sync.
  - Added feature tests for unread count, read-one, read-all, validation, and unauthorized access.
- Files changed:
  - `api/database/migrations/2026_02_07_201500_add_read_at_to_notifications_table.php`
  - `api/app/Models/Notification.php`
  - `api/app/Http/Presenters/NotificationArrayPresenter.php`
  - `api/app/Repository/NotificationRepository.php`
  - `api/app/Http/Controllers/Api/NotificationController.php`
  - `api/app/Actions/Notifications/GetUnreadNotificationsCountByCurrentUserIdAction.php`
  - `api/app/Actions/Notifications/MarkNotificationAsReadAction.php`
  - `api/app/Actions/Notifications/MarkNotificationAsReadRequest.php`
  - `api/app/Actions/Notifications/MarkNotificationsAsReadByCurrentUserIdAction.php`
  - `api/app/Http/Requests/Api/Notifications/MarkNotificationAsReadValidationRequest.php`
  - `api/routes/api.php`
  - `api/lang/en/notifications.php`
  - `api/lang/ua/notifications.php`
  - `api/tests/Feature/NotificationsApiTest.php`
  - `client/src/views/Notifications.vue`
  - `client/src/store/modules/notifications/actions.js`
  - `client/src/store/modules/notifications/mutations.js`
  - `client/src/store/modules/notifications/getters.js`
  - `client/src/store/modules/notifications/state.js`
  - `client/src/store/modules/notifications/types/actions.js`
  - `client/src/store/modules/notifications/types/getters.js`
  - `client/src/store/modules/notifications/types/mutations.js`
  - `client/src/locales/Locales.js`
- Verification:
  - `docker exec -i clm-app php artisan test --filter=NotificationsApiTest`
  - `docker exec -i clm-app php artisan test`
  - `cd client && npm run build`
- Result:
  - End-to-end notification read flow is implemented and validated.
