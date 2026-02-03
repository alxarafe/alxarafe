# Guía de Publicación y Versionado

Esta guía describe el proceso para lanzar una nueva versión oficial del framework **Alxarafe** y hacerla disponible en Packagist.

## 1. Versionado Semántico

El proyecto sigue el estándar [Semantic Versioning 2.0.0](https://semver.org/).
El formato de versión es **MAJOR.MINOR.PATCH** (ej. `1.0.2`).

*   **MAJOR (1.x.x):** Cambios incompatibles con la API anterior (Breaking Changes).
*   **MINOR (x.1.x):** Nuevas funcionalidades compatibles hacia atrás.
*   **PATCH (x.x.1):** Corrección de errores compatibles hacia atrás.

## 2. Proceso de Publicación

Una vez que el código en la rama `main` está listo, probado y commiteado, sigue estos pasos para publicar:

### Paso 1: Crear la Etiqueta (Tag)

Git utiliza etiquetas para marcar puntos específicos en la historia como versiones.

```bash
# Crear la etiqueta localmente (ej. v1.0.1)
git tag v1.0.1 -m "Descripción breve de la versión (ej. Corrección bug en Router)"
```

### Paso 2: Subir la Etiqueta a GitHub

Las etiquetas no se suben con un `git push` normal. Debes subirlas explícitamente:

```bash
# Subir una etiqueta específica
git push origin v1.0.1

# O subir todas las etiquetas locales (con cuidado)
git push origin --tags
```

## 3. Actualización en Packagist

### Automática (Recomendado)
Si has configurado el **Webhook de GitHub** en tu cuenta de Packagist (ver configuración del repo), Packagist detectará automáticamente el nuevo tag en cuanto hagas el `push` y publicará la versión en cuestión de minutos.

### Manual
Si no tienes configurado el webhook o necesitas forzar la actualización inmediatamente:

1.  Entra en [Packagist.org](https://packagist.org/).
2.  Ve a la página de tu paquete: [alxarafe/alxarafe](https://packagist.org/packages/alxarafe/alxarafe).
3.  Haz clic en el botón verde **"Update"** a la derecha.
4.  Packagist escaneará GitHub y encontrará la nueva versión `v1.0.1`.

## 4. Verificar

Para confirmar que la versión está disponible, puedes ejecutar en cualquier proyecto local:

```bash
composer show alxarafe/alxarafe --all
```

Deberías ver la nueva versión en la lista de `versions`.
