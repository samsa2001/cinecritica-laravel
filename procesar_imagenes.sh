#!/bin/bash

# --- Configuración ---
SOURCE_PATH="/home/cinecritica/web/cinecritica.com/public_html/storage/app/media"
DEST_PATH="/home/cinecritica/web/cdn1.cinecritica.com/public_html/media"
DB_NAME="cinecritica_cinecritica"
# Si tienes usuario y pass de mysql, puedes ponerlos aquí o dejar que el sistema use .my.cnf
DB_USER="cinecritica_cinecriticau"
DB_PASS="0*5Tzu4e0Em"

echo "1. Iniciando conversión de imágenes..."

# Ejecutamos tu comando original. 
# Añadimos 2>/dev/null para ignorar el aviso de "no such file" en carpetas sin .jpg
find "$SOURCE_PATH" -type d -exec bash -c '
mogrify -path "'"$DEST_PATH"'${1#'"$SOURCE_PATH"'}" -format webp -quality 50 -resize "x1080>" -define webp:method=6 -strip "$1"/*.jpg 2>/dev/null
' _ {} \;

echo "2. Limpiando archivos originales..."
# Borramos el contenido de la carpeta de origen
rm -rf "$SOURCE_PATH"/*

echo "3. Actualizando base de datos..."
# Ejecución de SQL
mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" <<EOF
UPDATE peliculas SET imagen = REPLACE(imagen, '.jpg', '.webp') WHERE imagen LIKE '%.jpg';
UPDATE peliculas SET imagen_principal = REPLACE(imagen_principal, '.jpg', '.webp') WHERE imagen_principal LIKE '%.jpg';
UPDATE series SET imagen = REPLACE(imagen, '.jpg', '.webp') WHERE imagen LIKE '%.jpg';
UPDATE series SET imagen_principal = REPLACE(imagen_principal, '.jpg', '.webp') WHERE imagen_principal LIKE '%.jpg';
UPDATE serie_temporadas SET imagen = REPLACE(imagen, '.jpg', '.webp') WHERE imagen LIKE '%.jpg';
UPDATE personas SET foto = REPLACE(foto, '.jpg', '.webp') WHERE foto LIKE '%.jpg';
EOF

echo "Proceso completado exitosamente."
