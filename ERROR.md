# ERROR

Chronological incident log for runtime/integration issues across the repository.

## Entry Template
- Date:
- Scope: `api` | `client`
- Where it happened:
- Error:
- Status: `open` | `resolved`
- Root cause:
- Solution and approach (for resolved issues):

## 2026-02-07

### 1) Registration email send failure
- Scope: `api`
- Where it happened:
  - During user registration flow (`POST /api/v1/auth/register`)
  - Call chain includes `RegisterAction` -> `User::sendEmailVerificationNotification()`
- Error:
  - `Symfony\Component\Mime\Exception\LogicException: An email must have a "From" or a "Sender" header.`
- Status: `resolved`
- Root cause:
  - Mail message is created without sender identity.
  - Current `api/.env` has `MAIL_FROM_ADDRESS=` (empty), so Symfony rejects the email before sending.
- Solution and approach (for resolved issues):
  1. Set `MAIL_FROM_ADDRESS` to a valid address (example: `no-reply@clmtools.local`).
  2. Keep `MAIL_FROM_NAME` set (or set explicitly).
  3. Clear/reload config: `php artisan optimize:clear`.
  4. Retry registration request.
  5. Verification in current env shows these sender fields are now configured.

### 2) SMTP authentication failure during registration email
- Scope: `api`
- Where it happened:
  - During user registration flow (`POST /api/v1/auth/register`)
  - Symfony SMTP transport while sending notification email
- Error:
  - `Symfony\Component\Mailer\Exception\TransportException: Expected response code "250" but got code "530", with message "530 5.7.1 Authentication required".`
- Status: `open`
- Root cause:
  - SMTP server requires valid authentication, but current `api/.env` app password is not in a valid format for Gmail auth.
  - The configured `MAIL_PASSWORD` contains non-breaking spaces (`\u00A0`) between groups (`... \u00A0 ... \u00A0 ...`), which leads to bad credentials.
  - This project uses Laravel 9 `MAIL_MAILER` config; README mail snippet still uses old `MAIL_DRIVER` naming.
- Solution and approach (for resolved issues):
  - Pending.
  - Recommended fix:
    1. Use real SMTP credentials (Mailtrap/Gmail/SMTP provider).
    2. Keep `MAIL_MAILER=smtp`, set proper `MAIL_HOST`, `MAIL_PORT`, `MAIL_ENCRYPTION`.
    3. Clear/reload config and retry request.
  - Progress:
    - `api/.env` was switched to Gmail SMTP settings (`smtp.gmail.com`, port `465`, `ssl`).
    - Final resolution still requires setting a valid Gmail App Password in `MAIL_PASSWORD` (16 chars, no spaces/non-breaking spaces).
