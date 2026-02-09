# Cinecritica

## Autor
Ramón Pons

## Contacto
- **Email:** mitziweb.com@gmail.com
- **Página web:** [mitziweb.com](https://mitziweb.com)

## Descripción de la App
Cinecritica es una aplicación que permite a los usuarios añadir y gestionar películas. A continuación se describen los pasos para añadir nuevas películas a la base de datos y gestionar imágenes.

## Funcionamiento de la App

### Cómo añadir películas nuevas

1. En el dashboard opcion ver novedades
2. una vez añadidas ejecutar el script 
	./procesar_imagenes.sh
 

## Build
```
npm install
npm run build
```
## Arrancar servidor local
```
npm run dev
```

## Build Vue desde el Dashboard
En el dashboard administrativo (ruta `/dashboard`), existe un botón en la sección **Utilidades** llamado **"Build Vue"** que permite ejecutar `npm run build` desde la interfaz web sin necesidad de acceder a la terminal del servidor.

**⚠️ IMPORTANTE - Medidas de Seguridad:**
- Este botón **solo está disponible para usuarios admin autenticados**
- El acceso está protegido por middleware `auth`, `verified` y `admin`
- Se ejecuta con confirmación para evitar acciones accidentales
- Los logs de ejecución se guardan en `storage/logs/`

**Cómo usar:**
1. Accede al dashboard como admin
2. Navega a la sección "🔧 Utilidades"
3. Haz click en "🏗️ Build Vue"
4. Confirma la acción en el popup
5. Espera a que se complete la compilación
6. Verás un mensaje de éxito o error

## Notas
- Asegúrate de tener permisos adecuados para mover archivos y modificar la base de datos.
- Verifica que las rutas y directorios existen y son accesibles antes de realizar cambios.
- Realiza respaldos de la base de datos y las imágenes antes de efectuar modificaciones importantes.
- El directorio `/public/build/` está en `.gitignore` y se genera automáticamente al ejecutar el build

## Licencia
Esta aplicación es de uso privativo y solo puede ser utilizada por el autor, Ramón Pons Mañosa.
