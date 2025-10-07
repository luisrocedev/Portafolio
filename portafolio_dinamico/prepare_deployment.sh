#!/bin/bash

# ========================================
# Script de Preparación para Deployment
# Portafolio Dinámico
# ========================================

echo "🚀 Preparando archivos para producción..."
echo ""

# Colores
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Variables
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"
DB_NAME="portafolio_db"
MYSQL_USER="root"
MYSQL_PASS="root"
MYSQL_PORT="8889"
MYSQL_BIN="/Applications/MAMP/Library/bin/mysql80/bin"

echo "================================================"
echo "  PASO 1: Crear backup de base de datos"
echo "================================================"

# Crear carpeta de backup
mkdir -p "$BACKUP_DIR"

# Exportar base de datos
echo "📦 Exportando base de datos..."
"$MYSQL_BIN/mysqldump" -u "$MYSQL_USER" -p"$MYSQL_PASS" -P "$MYSQL_PORT" "$DB_NAME" > "$BACKUP_DIR/portafolio_db_$(date +%Y%m%d).sql"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Base de datos exportada: $BACKUP_DIR/portafolio_db_$(date +%Y%m%d).sql${NC}"
else
    echo -e "${RED}❌ Error al exportar base de datos${NC}"
    exit 1
fi

echo ""
echo "================================================"
echo "  PASO 2: Verificar archivos a eliminar"
echo "================================================"

# Lista de archivos de desarrollo
DEV_FILES=(
    "test_images.php"
    "reset_password.php"
    "admin/setup_admin.php"
)

echo "⚠️  Los siguientes archivos de desarrollo se deberían eliminar antes de subir:"
for file in "${DEV_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${YELLOW}  - $file (existe)${NC}"
    else
        echo -e "${GREEN}  - $file (no existe ✓)${NC}"
    fi
done

echo ""
echo "================================================"
echo "  PASO 3: Preparar archivos de configuración"
echo "================================================"

# Copiar archivos de configuración
if [ -f "config/database.NEW.php" ]; then
    echo "📝 Archivo database.NEW.php listo para usar en producción"
    echo "   Recuerda renombrarlo a database.php después de configurarlo"
fi

if [ -f ".htaccess.production" ]; then
    echo "📝 Archivo .htaccess.production listo para usar"
    echo "   Recuerda renombrarlo a .htaccess en el servidor"
fi

echo ""
echo "================================================"
echo "  PASO 4: Verificar estructura de carpetas"
echo "================================================"

# Verificar carpetas importantes
FOLDERS=(
    "admin"
    "assets"
    "config"
    "uploads/projects"
)

for folder in "${FOLDERS[@]}"; do
    if [ -d "$folder" ]; then
        echo -e "${GREEN}✅ $folder${NC}"
    else
        echo -e "${RED}❌ $folder (no existe)${NC}"
    fi
done

echo ""
echo "================================================"
echo "  PASO 5: Crear archivo .zip para subir"
echo "================================================"

ZIP_NAME="portafolio_produccion_$(date +%Y%m%d_%H%M%S).zip"

echo "📦 Creando archivo $ZIP_NAME..."

# Excluir archivos no necesarios
zip -r "$ZIP_NAME" . \
    -x "*.git*" \
    -x "*node_modules*" \
    -x "*.DS_Store" \
    -x "*test_*.php" \
    -x "*reset_password.php" \
    -x "*backup_*" \
    -x "*.zip" \
    -x "*CHECKLIST*" \
    -x "*.md" \
    > /dev/null 2>&1

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Archivo creado: $ZIP_NAME${NC}"
    echo "   Tamaño: $(du -h "$ZIP_NAME" | cut -f1)"
else
    echo -e "${RED}❌ Error al crear archivo ZIP${NC}"
fi

echo ""
echo "================================================"
echo "  RESUMEN"
echo "================================================"
echo ""
echo "✅ Preparación completada. Los siguientes archivos están listos:"
echo ""
echo "1. 📦 Backup de BD: $BACKUP_DIR/portafolio_db_$(date +%Y%m%d).sql"
echo "2. 📦 Archivo para subir: $ZIP_NAME"
echo ""
echo "⚠️  ANTES DE SUBIR AL SERVIDOR:"
echo ""
echo "1. Elimina archivos de desarrollo:"
for file in "${DEV_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "   - rm $file"
    fi
done
echo ""
echo "2. Configura database.php con credenciales de producción"
echo "3. Usa .htaccess.production en el servidor"
echo "4. Cambia contraseña del admin desde el panel"
echo ""
echo "📖 Guía completa: DEPLOYMENT_GUIDE_COMPLETA.md"
echo ""
echo "🚀 ¡Listo para deployment!"
echo ""
