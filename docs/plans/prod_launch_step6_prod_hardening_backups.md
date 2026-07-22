# Step 6: Production Hardening, Rate Limiting & Zero-Downtime Operations

## Objective
Harden Doctoria CRM for live enterprise production deployment by implementing rate limiting on authentication and sensitive API endpoints, enforcing strict session security headers, configuring automated daily database backups, and establishing a zero-downtime deployment doctrine.

## User Value
- **System Administrators**: Total peace of mind with automated database backup retention, zero-downtime maintenance capabilities, and real-time failure reporting.
- **Clinic Staff**: 99.99% system availability with bulletproof protection against brute-force attacks and session hijacking.

## Files or Modules Likely Affected
- **Core Security**: `app/core/Controller.php`, `config/config.php`, `.htaccess`.
- **Controllers**: `app/controllers/Users.php` (Rate limit login attempts), `app/controllers/Dashboard.php`.
- **Scripts**: Create `scripts/backup_database.sh` (Database backup script) and `scripts/deploy_production.sh` (Zero-downtime deploy).

## Implementation Plan
1. **HTTP Security Headers & Rate Limiting**:
   - Add security headers to `.htaccess` and `index.php`:
     - `X-Frame-Options: SAMEORIGIN`
     - `X-Content-Type-Options: nosniff`
     - `Strict-Transport-Security: max-age=31536000`
     - `Content-Security-Policy` header allowing trusted CDN fonts & FontAwesome.
   - Add session-based rate limiting in `Users::login()` (max 5 failed attempts per IP per 15 minutes).
2. **Automated Database Backup Script**:
   - Build `scripts/backup_database.sh`:
     ```bash
     #!/bin/bash
     BACKUP_DIR="/lamp/www/naxielly/backups"
     TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
     /lamp/mysql/bin/mysqldump -u root -pM@chiavell1 crm_doctoria | gzip > "$BACKUP_DIR/crm_doctoria_$TIMESTAMP.sql.gz"
     find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +30 -delete
     ```
3. **Session Fixation & Timeout Hardening**:
   - Regenerate session IDs (`session_regenerate_id(true)`) upon successful user login.
   - Enforce 2-hour idle session timeout.

## UX Expectations
- Attempting 5 consecutive bad passwords displays a friendly lockout message: *"Demasiados intentos fallidos. Por favor espera 15 minutos o restablece tu contraseña."*

## Security Considerations
- **SQL Dump Encryption**: Backup archives are chmod `600` restricted to system root.
- **Brute Force Protection**: IP address throttling prevents credential stuffing attacks.

## Failure Cases
- **Database Dump Failure**: Script checks `mysqldump` exit code; sends emergency alert to sysadmin log if backup fails.

## Test Plan
- Write `test_prod_step6_hardening.php`:
  1. Test rate-limiting logic with 6 simulated failed login attempts.
  2. Verify 6th attempt returns rate limit block.
  3. Verify security headers presence in HTTP response.
  4. Verify DB backup script generates valid gzipped SQL dump.

## Verification Evidence
- Terminal output log from `test_prod_step6_hardening.php` confirming rate limit block enforcement and backup file creation.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("SECURITY ALERT: Rate limit triggered for IP [ip_address] on route [route]")`.

## Definition of Done
- Rate limiting active on login.
- Security headers active in `.htaccess`.
- Backup script functional and tested.
- Production Launch Doctrine 100% complete.

## Next Logical Step
Execute Production Launch Doctrine steps sequentially in a single development loop!
