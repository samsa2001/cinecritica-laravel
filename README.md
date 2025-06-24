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

1. En el fichero `App/Http/Controllers/backend/PeliculaController.php`, modificar la fecha desde la que busca películas en la función `verNovedades`.

2. Visitar la dirección web [http://cinecritica.com/backend/ver-novedades/pelis](http://cinecritica.test/backend/ver-novedades/pelis) y seleccionar las películas que se quieren añadir.

3. Las imágenes de las películas se guardan en formato `jpg` en la carpeta `storage/app/media` y deben ser movidas a la carpeta correspondiente de [http://cdn1.cinecritica.test/](http://cdn1.cinecritica.test/).

4. Si se modifica el formato de las imágenes de `jpg` a `webp`, se debe actualizar la base de datos con la siguiente sentencia SQL:

    ```sql
    UPDATE peliculas SET imagen = REPLACE(imagen, '.jpg', '.webp') WHERE imagen LIKE '%.jpg';
    UPDATE peliculas SET imagen_principal = REPLACE(imagen_principal, '.jpg', '.webp') WHERE imagen_principal LIKE '%.jpg';
    UPDATE series SET imagen = REPLACE(imagen, '.jpg', '.webp') WHERE imagen LIKE '%.jpg';
    UPDATE series SET imagen_principal = REPLACE(imagen_principal, '.jpg', '.webp') WHERE imagen_principal LIKE '%.jpg';
    UPDATE personas SET foto = REPLACE(foto, '.jpg', '.webp') WHERE foto LIKE '%.jpg';
    UPDATE serie_temporadas SET imagen = REPLACE(imagen, '.jpg', '.webp') WHERE imagen LIKE '%.jpg';
    ```
## Build
```
npm install

npm run dev

```
## Notas
- Asegúrate de tener permisos adecuados para mover archivos y modificar la base de datos.
- Verifica que las rutas y directorios existen y son accesibles antes de realizar cambios.
- Realiza respaldos de la base de datos y las imágenes antes de efectuar modificaciones importantes.

## Licencia
Esta aplicación es de uso privativo y solo puede ser utilizada por el autor, Ramón Pons Mañosa.
