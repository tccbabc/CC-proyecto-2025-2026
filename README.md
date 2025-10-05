# CC-proyecto-2025-2026
Proyecto de despliegue de una pagina web en la nube, desarrollado a lo largo de la asignatura CC 2025-2026

## Descripción del Proyecto
Este proyecto está dirigido principalmente al departamento de diseño de una empresa de moda, y tiene como objetivo crear una 
página web para realizar operaciones CRUD sobre los datos básicos de la industria de la confección, como colores, tallas y unidades, etc.
El trasfondo de este proyecto es establecer una base de datos básica que permita, cuando los diseñadores necesiten crear prendas de vestir, comparar la información de esta base de datos con la base de datos de los proveedores, con el fin de determinar posteriormente la compra de ciertos materiales y otras tareas relacionadas.
Por lo tanto, este proyecto es principalmente un servicio del lado del servidor orientado al negocio (business-oriented). En este curso, el contenido que se desea implementar actualmente es el siguiente:

- Muestra y operaciones sobre los datos básicos de tallas en una pagina web
- Muestra y operaciones sobre los datos básicos de colores en una pagina web
- Sistema de autenticación de usuarios, etc.


# Informacion del proyecto


## Arquitectura del Proyecto
Este proyecto utiliza una arquitectura típica **MVC**, que representa respectivamente:  

- **M (Modelo)**: Se encarga del acceso a los datos y la lógica de negocio.  
- **V (Vista)**: Se encarga de la presentación de la interfaz y la interacción con el usuario.  
- **C (Controlador)**: Se encarga de recibir las solicitudes del usuario y llamar al modelo y la vista para su procesamiento.

En este caso, el **VC** se encapsula en un proyecto de Laravel, mientras el **M** es desplegado en un base de dato.

Está compuesto por: **cliente**, **servidor web**, **servidor de base de datos**, **proxy Nginx** y **Redis**.

### Descripción de la Arquitectura

1. **Cliente (PC)**  
   - Envía solicitudes al **proxy Nginx**, desempeñar el papel de cliente en este proyecto.

2. **Proxy Nginx**  
   - Se encarga del **balanceo de carga** y **proxy inverso**, y reenvía las solicitudes al **servidor web**.
   - Aunque en este proyecto no se utilice la función de balanceo de carga, se despliega de forma anticipada para futuras expansiones.

3. **Servidor Web**  
   - Procesa la **lógica de negocio**. Sus funcionalidades se implementan mediante un proyecto Laravel, que incluye todas las funciones completas del frontend y del backend. 
   - Consulta la **caché Redis**; si no encuentra los datos en la caché, accede al **servidor de base de datos**.

4. **Servidor de Base de Datos**  
   - Almacena los **datos persistentes**.

![Arquitectura del Proyecto](/docs/imgs/estructura-proyecto.png)


## Proveedor de la nube
El servidor y la base de datos de este proyecto están configurados en la nube, Pero ctualmente aún no se ha determinado un proveedor de servicios en la nube; 
se decidirá según el avance del proyecto.


## Herramientas del Proyecto

### Lenguaje
**PHP 8.x**  un lenguaje de scripting del lado del servidor de código abierto, ampliamente utilizado para desarrollar páginas web dinámicas y aplicaciones web.

- Amplia comunidad y soporte.  
- Fácil integración con servidores web.  

### Framework
**Laravel 12.x** es un popular framework de PHP que utiliza la arquitectura MVC y está diseñado para simplificar el desarrollo de aplicaciones web. Ofrece funciones completas como enrutamiento, motor de plantillas, ORM, autenticación y seguridad, haciendo que el desarrollo sea más eficiente y estructurado.

- Estructura MVC que facilita la organización del código.  
- Sistema de migraciones y ORM potente (Eloquent).  
- Seguridad y autenticación integradas.

### Base de Datos
**MySQL** es un sistema de gestión de bases de datos relacional (RDBMS) de código abierto, conocido por su alto rendimiento, fiabilidad y facilidad de uso.

- Rendimiento estable y fiable.  
- Buen manejo de datos relacionales.

### Herramienta de Pruebas
**Postman** es una herramienta poderosa para probar y depurar APIs, que permite enviar diferentes tipos de solicitudes, ver los resultados de las respuestas, realizar pruebas automatizadas y generar documentación.

- Facilita la prueba y depuración de APIs.  
- Interfaz intuitiva y fácil de usar.

### Contenedor
**Docker** es una plataforma de contenedores de código abierto utilizada para desarrollar, desplegar y ejecutar aplicaciones.


# Informacion del repositorio
Este repositorio contiene el código fuente, documentación por hitos y archivos de configuración.


## Documentación por hitos
- La documentación del proyecto se encuentra en la carpeta [docs](docs/).
- A medida que avance cada clase de práctica, se irán agregando nuevos archivos markdown de hito y otros archivos complementarios a esta carpeta.


## Código fuente de la aplicación.
- El código fuente de la aplicación se encuentra en la carpeta [src](src/).
- La estructura específica del proyecto se añadirá a este archivo después de que el proyecto sea generado.


## Licencia
- MIT License [MIT](LICENSE).
- Teniendo en cuenta que se trata de un proyecto con fines de aprendizaje y que no implica mucho contenido comercial, 
se ha elegido la licencia MIT, que además es la más utilizada.


## .gitignore
- segun se conviene del proyecto concreto de Laravel [.gitignore](.gitignore).

