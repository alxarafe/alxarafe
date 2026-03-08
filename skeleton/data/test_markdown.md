---
title: Historia de Supermercados CODI
author: Rafael San José
date: 2026-03-08
---

<div class="markdown-showcase">

Corría el año **1996** cuando me incorporó a la cadena *Supermercados CODI*. Las tiendas aún no habían abierto: todo estaba **en preparación para la inauguración**, y el calendario no se movía. Tenía apenas unas semanas para entender un ecosistema heredado, estabilizarlo y dejarlo listo para arrancar.

:::: feature-grid
::: feature-card icon="fa-server"
## La central
Nuevo desarrollo en **FoxPro 2.6 para Windows**, ambicioso e inacabado. La empresa que lo estaba implantando terminó abandonándolo y nos cedió los fuentes.  
Yo había hecho pequeños scripts en FoxPro, pero nada comparable a un sistema logístico completo. Tocaba aprender *dentro* del propio proyecto.  
Las comunicaciones con las tiendas se realizaban mediante un script de **Telnet** que llamaba a cada tienda a partir de medianoche. Tampoco tenía experiencia en ese terreno.
:::

::: feature-card icon="fa-network-wired"
## La trastienda
Un PC con MS‑DOS actuaba como servidor **Novell** y se comunicaba con las cajas TPV y con las balanzas Dibal vía RS‑232.  
El ordenador tenía una aplicación en **Clipper** que era madura y estable, de la cual **no tenía los fuentes**. Dicha aplicación recibía un archivo plano con las ventas y un DBF con los precios de la central, y gestionaba el intercambio con las cajas y balanzas, además de imprimir las etiquetas con los nuevos precios recibidos de la central, si habían cambios.
:::

::: feature-card icon="fa-cash-register"
## Las cajas
Las cajas eran TPV **IBM 4694** con una aplicación en **TurboPascal**, también madura y ampliamente utilizada por la empresa proveedora en pequeñas empresas.
Al ser un software maduro y cumplir con su cometido de gestionar las ventas, tampoco dispuse de los fuentes.
Además de las cajas, teníamos balanzas Dibal que recibían artículos y precios… **Cuando querían**.
:::
::::

::: .mt-5
![IBM 4694](https://alxarafe.es/uploads/images/ibm-4694.png)
:::

::: callout-info
## Software heredado
Salvo el programa de central, todo el software era lo suficientemente maduro como para que la empresa desarrolladora no cediera los fuentes.  
La central, en cambio, era un desarrollo nuevo que había crecido demasiado rápido.
Hay que considerar que hablamos de una época, en la que prácticamente, **Internet no existía**.
:::

Muchos hablan hoy de "resiliencia", pero la de verdad la aprendí cuando la comunicación se hacía por **Telnet** y se caía si alguien levantaba el auricular en casa, o sencillamente, cuando un error interrumpía el script y las tiendas no se comunicaban con la central.

Sin los pedidos en la central, el personal de almacén, no podía trabajar.

## Migración de Telnet a Telix

**Telix** era un software mucho más potente y robusto que Telnet, por lo que de las primeras cosas que hice para que no me llamasen a las 5 de la mañana para que saliera corriendo a realizar las comunicaciones, fue instalar Telix en central y tiendas y reescribir por completo los scripts para que reintentase y fuese sacando los pedidos aunque no estuviese la información de todas las tiendas.

::: callout-info
La aplicación cogía los pedidos de todas las tiendas y los procesaba antes de hacer la preparación, más que nada porque sería necesario preparar el almacén haciendo tranferencias de mercancía de *huecos de reserva* a *Picking*, o directamente de reserva a un pedido si se pedía un palet completo.
:::

También aproveché para poder enviar actualizaciones de los scripts en el propio paquete y evitar desplazamientos a las tiendas.

## El misterio de los huecos que se esfumaban

:::: feature-grid
::: feature-item
### El problema: Centinelas
El sistema de ubicación del almacén se basaba en "**centinelas**": marcas lógicas que indicaban qué huecos eran de picking.
Si un proceso fallaba, el centinela desaparecía… y el hueco también.

### La solución: Inmutabilidad
Definí una **estructura estática de almacén**.  
Si un hueco existe físicamente, existe en el software.  
Una lección temprana sobre **entidades inmutables** que sigo aplicando hoy.
:::

::: feature-item
![El centinela perdió el hueco](https://alxarafe.es/uploads/images/el-centinela-perdio-el-hueco.png)
:::
::::

## Sobrevivir al Euro sin código fuente

La aplicación en **Clipper** era madura y estable, pero **no tenía los fuentes** , así que recurrí a ingeniería inversa para poder adaptarla a la moneda dual.

Tampoco disponía de las fuentes de la aplicación que se ejecutaba en los terminales IBM de las cajas (TurboPascal).

Para la adaptación al Euro desarrollé un software liviano en **C++**, usando los ejemplos de IBM para comunicarme con los periféricos con el que sustituí el programa original. En ese momento, todo el código estaba bajo mi control.

Fue mi primera lección de interoperabilidad:  

::: callout-info
El lenguaje es secundario; lo importante es entender cómo hablan las máquinas entre sí.
:::

## El controlador de frescos

Había poco personal. Un empleado salía de madrugada con un camión hacia **Mercasevilla** y volvía cada mañana con un único albarán de compra y el reparto individual a cada tienda. Creé un controlador que, en un solo paso, generaba el albarán de compra y los albaranes de venta para cada tienda como columnas del albarán de compra.

El software debe **reducir la carga cognitiva del humano**, no aumentarla.

</div>
