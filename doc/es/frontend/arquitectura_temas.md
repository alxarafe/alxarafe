# Arquitectura de Temas y Gestión de Assets

## Resumen

En Alxarafe, la definición de los temas (themes) se encuentra centralizada en el directorio `templates/themes` del núcleo (paquete o módulo). Esto garantiza que el control de versiones y las actualizaciones se gestionen a través de Composer, mientras que los assets públicos (CSS, JS, Imágenes) se publican en la raíz web (`public/themes`) durante la instalación, actualización o ejecución en tiempo de ejecución si faltan.

## Estructura de Directorios

### Fuente (Desarrollo)
Los assets del tema residen junto a sus plantillas Blade:
```
/src (o raíz)
  /templates
    /themes
      /default
        /css
          default.css
        /js
        /partial
          head.blade.php
      /alternative
        /css
          default.css
        /component
          ...
```

### Destino (Público)
Solo los assets estáticos se publican en el directorio público del servidor web:
```
/public
  /themes
    /default
      /css
        default.css
    /alternative
      /css
        default.css
```

## Mecanismo de Publicación

La clase `Alxarafe\Scripts\ComposerScripts` gestiona la sincronización. Escanea `templates/themes` buscando directorios de assets específicos (`css`, `js`, `assets`, `img`, `fonts`) y los copia a `public/themes`.

### ¿Por qué este enfoque?
1.  **Encapsulación**: Todos los recursos del tema (lógica/vistas y estilos) se mantienen juntos en el código fuente.
2.  **Seguridad**: Los archivos PHP/Blade permanecen fuera de la raíz web.
3.  **Mantenibilidad**: Las actualizaciones del paquete principal actualizan automáticamente los assets públicos.
4.  **Resiliencia en Docker**: Si los assets faltan en el entorno `public` (por ejemplo, debido a montajes de volúmenes en Docker), `index.php` detecta la ausencia y desencadena la publicación automática.

## Uso

Al crear un nuevo tema:
1.  Crea una carpeta en `templates/themes/{mi-tema}`.
2.  Coloca tu CSS en `templates/themes/{mi-tema}/css/`.
3.  Ejecuta `composer update` o dispara el script manualmente.
4.  En tu layout Blade, referencia los assets usando la ruta pública: `/themes/{mi-tema}/css/style.css`.

## Autopublicación en Entornos de Desarrollo
Para facilitar el desarrollo en entornos contenerizados (Docker), el punto de entrada `index.php` incluye una comprobación de existencia. Si detecta que faltan las carpetas `themes` o `css` en `public`, invocará automáticamente a `ComposerScripts::postUpdate` para regenerarlos.
