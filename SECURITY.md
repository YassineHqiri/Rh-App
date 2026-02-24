# AtlasTech HR - Security Architecture

## Authentication

- **Password Hashing**: All passwords are hashed using bcrypt via Laravel's `Hash::make()` (cost factor 10 by default).
- **Session Management**: Sessions are stored in the database (`sessions` table) for auditability. Sessions are regenerated on login to prevent session fixation. Sessions are invalidated on logout.
- **Rate Limiting**: Login attempts are throttled to 5 attempts per email/IP combination per 5 minutes. After exceeding the limit, the user is locked out with a countdown timer.
- **Remember Me**: Optional secure "remember me" token stored as HTTP-only cookie.

## Authorization (RBAC)

- **Roles**: `admin` and `hr` — only users with these roles and `is_active = true` can access the system.
- **Middleware**: `CheckHrRole` middleware verifies HR access on every protected route.
- **Policies**: `EmployeePolicy` controls who can create, read, update, and delete employee records. Only admins can delete employees.
- **FormRequest Authorization**: Each form request class verifies the user has HR access before processing.

## OWASP Protection

### SQL Injection
- All database queries use Eloquent ORM or the Laravel query builder with parameterized bindings.
- No raw SQL queries are used anywhere in the application.
- User input is never concatenated into query strings.

### Cross-Site Scripting (XSS)
- All output in Blade templates uses `{{ }}` (double curly braces) which auto-escapes HTML entities via `htmlspecialchars()`.
- Explicit `e()` helper used where needed for additional safety.
- Content Security Policy headers configured in Apache.

### Cross-Site Request Forgery (CSRF)
- Laravel's `VerifyCsrfToken` middleware is active on all web routes.
- All forms include `@csrf` directive generating a hidden CSRF token.
- Session tokens are regenerated after login.

### Insecure Direct Object References
- Employee records use route model binding with authorization policies.
- Users cannot access records they aren't authorized for.

### Security Misconfiguration
- `APP_DEBUG=false` in production.
- `.env` file excluded from version control.
- Error pages don't leak stack traces in production.
- Directory listing disabled in Apache config.

### Sensitive Data Exposure
- Passwords never stored in plain text.
- Salary data only visible to authorized HR users.
- Session cookies marked as HTTP-only and Secure (HTTPS).
- `SameSite=Lax` cookie attribute prevents CSRF via cross-origin requests.

## Input Validation

All user input is validated through dedicated `FormRequest` classes:

- `LoginRequest` — validates email format and password minimum length; enforces rate limiting.
- `StoreEmployeeRequest` — validates all employee fields with regex patterns for names and phone numbers.
- `UpdateEmployeeRequest` — same validation with unique email exception for the current record.

## Audit Logging

Every significant action is logged to the `audit_logs` table:

- Employee creation, updates, and deletions (with before/after values)
- Successful and failed login attempts
- Logout events
- IP address and user agent captured for forensic analysis

## Session Security

| Setting | Value | Purpose |
|---------|-------|---------|
| Driver | database | Enables audit trail for active sessions |
| Lifetime | 120 min | Auto-expire idle sessions |
| HTTP Only | true | Prevents JavaScript access to session cookie |
| Secure | true (prod) | Cookie only sent over HTTPS |
| SameSite | lax | Mitigates CSRF attacks |
| Encrypt | false | Performance (data in DB is already server-side) |

## Deployment Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Generate a new `APP_KEY` with `php artisan key:generate`
- [ ] Configure strong MySQL password for the application user
- [ ] Enable HTTPS with valid SSL certificate
- [ ] Set `SESSION_SECURE_COOKIE=true`
- [ ] Run `php artisan config:cache` and `php artisan route:cache`
- [ ] Set proper file permissions (storage/ and bootstrap/cache/ writable)
- [ ] Disable directory listing in Apache
- [ ] Configure firewall to restrict access to HR department IPs only
- [ ] Set up automated database backups
- [ ] Review and rotate the APP_KEY periodically
