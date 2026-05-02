#!/bin/bash
set -e

CERT_DIR="/etc/nginx/ssl"
CERT_KEY="$CERT_DIR/localhost.key"
CERT_CRT="$CERT_DIR/localhost.crt"

mkdir -p "$CERT_DIR"

# Generate hanya jika file tidak ada dan folder mount bukan kosong
if [ ! -f "$CERT_KEY" ] || [ ! -f "$CERT_CRT" ]; then
  if [ "$(ls -A $CERT_DIR)" ]; then
    echo "Certificate directory not empty, skipping generation."
  else
    echo "Generating self-signed SSL certificate..."
    openssl req -x509 -nodes -days 365 \
      -subj "/C=ID/ST=Jakarta/L=Jakarta/O=KoiN-CoDeveloper/CN=localhost" \
      -newkey rsa:2048 \
      -keyout "$CERT_KEY" \
      -out "$CERT_CRT"
  fi
else
  echo "SSL certificate already exists, skipping generation."
fi

exec apache2-foreground
