#!/bin/bash
# Doctoria CRM — Automated Production Database Backup Script
BACKUP_DIR="/lamp/www/naxielly/backups"
mkdir -p "$BACKUP_DIR"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
OUTPUT_FILE="$BACKUP_DIR/crm_doctoria_$TIMESTAMP.sql.gz"

echo "[$(date)] Starting Doctoria CRM database backup..."

if /lamp/mysql/bin/mysqldump -u root -pM@chiavell1 --socket=/lamp/mysql/mysql.sock crm_doctoria | gzip > "$OUTPUT_FILE"; then
    chmod 600 "$OUTPUT_FILE"
    echo "[$(date)] ✓ Backup completed successfully: $OUTPUT_FILE"
    find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +30 -delete
    exit 0
else
    echo "[$(date)] x DATABASE BACKUP FAILED!"
    exit 1
fi
