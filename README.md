# CC-proyecto-2025-2026
Proyecto de despliegue de una pagina web en la nube, desarrollado a lo largo de la asignatura CC 2025-2026

## Descripción del Proyecto
Este proyecto está dirigido principalmente al departamento de diseño de una empresa de moda, y tiene como objetivo crear una 
página web para realizar operaciones CRUD sobre los datos básicos de la industria de la confección, como colores, tallas y unidades,etc.
De momento, Este proyecto consiste en desarrollar una aplicación que resuelva el siguiente problema de negocio: 
> [Operaciones sobre los datos básicos de tallas,Operaciones sobre los datos básicos de colores,Sistema de autenticación de usuarios, etc.] 

# Informacion del proyecto

## Arquitectura del Proyecto
Este proyecto está compuesto por: **cliente**, **servidor web**, **servidor de base de datos**, **proxy Nginx** y **Redis**.

### Descripción de la Arquitectura

1. **Cliente (PC)**  
   - Envía solicitudes al **proxy Nginx**.

2. **Proxy Nginx**  
   - Se encarga del **balanceo de carga** y **proxy inverso**, y reenvía las solicitudes al **servidor web**.

3. **Servidor Web**  
   - Procesa la **lógica de negocio**.  
   - Consulta la **caché Redis**; si no encuentra los datos en la caché, accede al **servidor de base de datos**.

4. **Servidor de Base de Datos**  
   - Almacena los **datos persistentes**.

![Arquitectura del Proyecto](/docs/imgs/estructura-proyecto.png)

## Proveedor de la nube
Actualmente aún no se ha determinado un proveedor de servicios en la nube; se decidirá según el avance del proyecto.

## Herramientas del Proyecto

### Lenguaje
**PHP**  
- Amplia comunidad y soporte.  
- Fácil integración con servidores web.  

### Framework
**Laravel**  
- Estructura MVC que facilita la organización del código.  
- Sistema de migraciones y ORM potente (Eloquent).  
- Seguridad y autenticación integradas.

### Base de Datos
**MySQL**  
- Rendimiento estable y fiable.  
- Buen manejo de datos relacionales.

### Herramienta de Pruebas
**Postman**  
- Facilita la prueba y depuración de APIs.  
- Interfaz intuitiva y fácil de usar.

# Informacion del repositorio
Este repositorio contiene el código fuente, documentación por hitos y archivos de configuración.

## Documentación por hitos
La documentación del proyecto se encuentra en la carpeta [docs](docs/).
A medida que avance cada clase de práctica, se irán agregando nuevos archivos markdown de hito y otros archivos complementarios a esta carpeta.

## Código fuente de la aplicación.
El código fuente de la aplicación se encuentra en la carpeta [src](src/).
La estructura específica del proyecto se añadirá a este archivo después de que el proyecto sea generado.

## Licencia
- MIT License [MIT](LICENSE).
Teniendo en cuenta que se trata de un proyecto con fines de aprendizaje y que no implica mucho contenido comercial, 
se ha elegido la licencia MIT, que además es la más utilizada.

## .gitignore
- segun se conviene del proyecto concreto de Laravel [.gitignore](.gitignore).

