## Hito4

## Composición de servicios

&nbsp;

El clúster de contenedores desarrollado en este proyecto implementa una arquitectura basada en microservicios. Aunque en este caso no divido los microservicios separados. Mientras para los servicios auxiliares, cada componente se ejecuta en su propio contenedor, siguiendo el principio Single Responsibility y permitiendo escalabilidad, mantenibilidad y despliegue independiente.

&nbsp;
&nbsp;

![estructura contenedor](/docs/imgs/estructura_contenedor.png)

&nbsp;
&nbsp;
&nbsp;
&nbsp;


### 1. La estructura del clúster de contenedores.

&nbsp;

 - **servidor PHP-FPM:** Microservicio que ejecuta toda la lógica de negocio de la aplicación. El PHP-FPM, que significa PHP FastCGI Process Manager, es una implementación avanzada de PHP que usa el protocolo FastCGI para procesar solicitudes PHP de forma rápida y eficiente. Como hoy en dia, el protocolo de FastCGI es lo mas usado, y el FPM es el administrador de procesos que hace que PHP sea más rápido y más estable con FastCGI, pues en este caso, usamos un servidor de PHP-FPM.

 - **Base de dato MySQL:** El contenedor Base de dato MySQL desempeña un papel fundamental como sistema principal de persistencia de datos.Su función es almacenar, gestionar y garantizar la integridad de toda la información estructurada utilizada por la aplicación construida en Laravel.

 - **Nginx:** Se encarga exclusivamente de servir peticiones HTTP y de comunicarse con PHP-FPM, permitiendo que Nginx actúe como reverse proxy, gestione rutas y entregue contenido estático de forma eficiente. Aunque en este proyecto la mayoría de peticiones simplemente se redirigen directamente a PHP-FPM sin intervención adicional, para por un lado mantener una arquitectura alineada con entornos productivos reales, por otro lado facilitar la escalabilidad futura, introduzco el contenedor de Nginx.

 - **Sistema de caché y cola Redis:** Servicio NoSQL en memoria usado para caché, rate limiting, colas de trabajos y sesiones de Laravel. Como en el caso de Nginx, aunque en este proyecto, no usamos mucho la funcionalidad de Redis, aun introduczo el contenedor de Redis para uso futuro.

 - **herramienta de administración phpMyAdmin:** Herramienta de administración basada en web para MySQL,que permite la administración visual de la base de datos.

 - **Logs**: **ELK**, que consiste en tres contenedores como **elasticsearch**, **logstash** y **kibana**. 

            **Elasticsearch**: Motor de búsqueda y almacenamiento de logs estructurados.La aplicación y Logstash envían logs aquí para análisis avanzado.
            **Logstash**: Encargado de recolectar y transformar logs generados por Laravel (ubicados en storage/logs) para enviarlos a Elasticsearch.
            **Kibana**: Interfaz gráfica que permite consultar, analizar y visualizar los datos almacenados en Elasticsearch.


&nbsp;
&nbsp;
&nbsp;
&nbsp;


### 2. La configuración de cada uno de los contenedores que componen el clúster de contenedores

En este caso, como de momento el proyecto tiene funcionalidad sencilla, pues todos los contenedores son creados desde imagen basico.


 - **servidor PHP-FPM:** Imagen basico de **php:8.3-fpm**, proporciona una instalación oficial de PHP 8.3 configurada con FastCGI Process Manager (FPM). Está optimizada para ejecutar aplicaciones web de alto rendimiento, especialmente aquellas basadas en frameworks como Laravel. Tiene las siguientes características: **Basada en Debian, compatible con extensiones PHP adicionales**, **Incluye el motor FPM, ideal para integrarse con Nginx**.


 - **Base de dato MySQL:** Imagen basico de **mysql:8.0**, es la versión oficial del motor de bases de datos MySQL. Incluye todas las funcionalidades modernas de SQL necesarias para la aplicación. Tiene las siguientes características: **Alto rendimiento en consultas relacionales**,**Compatible con Eloquent ORM de Laravel**,**Permite la creación automática de bases de datos y usuarios mediante variables de entorno**.


- **Nginx:** Imagen basico de **nginx:stable**, es la distribución estable del servidor web Nginx. Se utiliza para servir peticiones HTTP y para actuar como reverse proxy hacia PHP-FPM. 


- **Sistema de caché y cola Redis:** Imagen basico de **redis:7**, contiene la versión oficial de Redis, un almacén en memoria extremadamente rápido utilizado para cache y colas. El proyecto utiliza Redis para mejorar el rendimiento general de la aplicación, gestionar caches y soportar tareas en segundo plano mediante el queue worker de Laravel. Aunque en este proyecto todavia no introduzco mucho el concepto de colas.


- **herramienta de administración phpMyAdmin:** Imagen basico de **phpmyadmin/phpmyadmin**, ofrece una herramienta gráfica para administrar MySQL desde el navegador.


- **Elasticsearch:** Imagen basico de **docker.elastic.co/elasticsearch/elasticsearch:8.12.0**, un motor de búsqueda y análisis distribuido usado para almacenar datos estructurados y logs. Tiene las siguientes características: **Transformación y búsqueda de datos a gran escala**, **Compatibilidad con Logstash y Kibana**, **Modo “single-node” apto para entornos de desarrollo**. 


- **Logstash:** Imagen de **docker.elastic.co/logstash/logstash:8.12.0**, es el componente encargado de recibir, procesar y enviar logs hacia Elasticsearch.Recoge y transforma los logs del directorio storage/logs de Laravel para analizarlos dentro de Elasticsearch.


- **Kibana:** Imagen de **docker.elastic.co/kibana/kibana:8.12.0**, implementa la interfaz web para visualizar los datos almacenados en Elasticsearch. Permite visualizar los logs procesados por Logstash, facilitando el análisis del comportamiento de la aplicación y la detección de errores.


&nbsp;
&nbsp;
&nbsp;
&nbsp;


### 3. El Dockerfile 

En mi proyecto, aunque existen muchas clases de servicio con diferentes funcionalidades, desde el punto de vista de la lógica de negocio todas ellas solo pueden formar un microservicio relativamente completo. Por lo tanto, en este proyecto solo existe un Dockerfile correspondiente a un único microservicio. 


&nbsp;
&nbsp;
&nbsp;
&nbsp;


![dockerFile](/docs/imgs/dockerfile.png)


&nbsp;
&nbsp;
&nbsp;
&nbsp;


  - **Imagen base:** "FROM php:8.3-fpm", define la imagen base sobre la cual se construirá el contenedor.


  - **Instalación de dependencias del sistema y extensiones de PHP:** "RUN apt-get update && apt-get install -y \", en este trozo de codigo, hace la instalación de paquetes del sistema como **git, curl, wget, unzip etc.**, y tambien la instalación de extensiones internas de PHP como **pdo_mysql intl mbstring zip exif pcntl bcmath etc.**


  - **Instalación de Composer y extensiones de terceros:** "COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer", Copia el ejecutable de Composer desde la imagen oficial composer:2.7, evitando instalarlo manualmente.


  - **Directorio de trabajo y copia del código fuente:** "WORKDIR /var/www", "COPY ./src /var/www", establece el directorio de trabajo del contenedor, copia el código fuente de la aplicación dentro del contenedor.



  - **Configuración de usuario y permisos:** "RUN usermod -u 1000 www-data || true", ajusta el UID del usuario www-data para coincidir con el del sistema anfitrión y evitar conflictos de permisos; "RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \ && chmod -R 775 /var/www/storage /var/www/bootstrap/cache",asigna la propiedad de los directorios que requieren escritura por parte de PHP-FPM, establece permisos adecuados para que la aplicación pueda generar logs, caché y otros archivos temporales.


  - **Exposición del puerto del servicio:** "EXPOSE 9000", indica que PHP-FPM escuchará en el puerto 9000, el cual es utilizado por Nginx u otros servicios para comunicarse mediante FastCGI.



&nbsp;
&nbsp;
&nbsp;
&nbsp;



### 4. GitHub Packages

GitHub Packages es un servicio de GitHub que permite almacenar, gestionar y distribuir paquetes de software directamente desde un repositorio. Es un registro de paquetes (package registry) integrado con GitHub. Para almacenar el imagen en mi repositorio, sigo los siguientes pasos:

 - **Autenticación en GHCR:** "echo $CR_PAT | docker login ghcr.io -u tccbabc --password-stdin", despues de establecer el clave para la gestion con paquete, iniciar al docker con este comando. 


 - **Construcción de la imagen:** "docker build -t ghcr.io/tccbabc/laravel_app:latest -f ./docker/php/Dockerfile .", con este comando crear una imagen de la aplicacion desarrollado.


&nbsp;
&nbsp;
&nbsp;
&nbsp;


![constuccionImagen](/docs/imgs/crearImagen.png)


&nbsp;
&nbsp;
&nbsp;
&nbsp;


- **Publicación en el registro:** "docker push ghcr.io/tccbabc/laravel_app:latest", con este comando sube la imagen al git.


&nbsp;
&nbsp;
&nbsp;
&nbsp;

![pushImagen](/docs/imgs/pushImagen.png)


&nbsp;
&nbsp;
&nbsp;
&nbsp;


- **Uso de la imagen remota en el clúster:** Actualiza el fichero de **docker-compose.yaml**, para utilizar directamente la imagen publicada.

**Atencion** Como en este proyecto, todavia estoy desarrollando la aplicacion, la modificare frecuntemente, asique de momento no despliego la funcionalidad de actualización automática de la imagen en GitAction.


### 5. El compose.yaml

Es un archivo de configuración usado por Docker Compose que permite definir, configurar y ejecutar múltiples contenedores como si fueran un solo sistema o aplicación.

&nbsp;
&nbsp;
&nbsp;
&nbsp;

![dockercompose1](/docs/imgs/docker_compose1.png)
![dockercompose2](/docs/imgs/docker_compose2.png)
![dockercompose3](/docs/imgs/docker_compose3.png)


&nbsp;
&nbsp;
&nbsp;
&nbsp;


5.1 **microservicio PHP-FPM:** Este servicio contiene la lógica principal de la aplicación implementada en Laravel.
 
    - image: se utiliza la imagen remota, ghcr.io/tccbabc/laravel_app:latest, construida previamente y publicada en GitHub Packages.

    - build: permite reconstruir la imagen localmente durante el desarrollo.

    - working_dir: define el directorio de trabajo /var/www.

    - volumes: sincroniza el código fuente local con el contenedor.

    - environment: variables que permiten conectar con MySQL y Redis.

    - depends_on: garantiza que MySQL y Redis estén disponibles antes de iniciar Laravel.



5.2 **Nginx:** Este servicio implementa el servidor HTTP que recibe peticiones externas y las dirige al servicio app.

    - image: nginx:stable.

    - ports: expone el puerto 8080:80 para evitar conflictos con otros servidores locales.

    - volumes: monta el código fuente y el archivo de configuración Nginx.

    - depends_on: garantiza que Laravel esté disponible antes de iniciar Nginx.



5.3 **MySQL 8.0:** Servicio encargado de la persistencia relacional de datos.

    - image: mysql:8.0, ampliamente soportada por Laravel.

    - environment: define la base de datos inicial, usuario y credenciales.

    - ports: expone el puerto 3306 para acceder al motor desde el exterior.

    - volumes: db_data garantiza persistencia aunque el contenedor se elimine.



5.4 **redis:** Sistema de almacenamiento en memoria utilizado para cache y colas.

    - image: redis:7

    - ports: expone el puerto 6390:6379 para evitar conflictos con Redis instalados en la máquina local.



5.5 **phpmyadmin:** Panel web para administrar la base de datos MySQL.

    - image: phpmyadmin/phpmyadmin

    - environment: apunta al contenedor db.

    - ports: expuesto en 8081:80.

    - depends_on: espera a MySQL para iniciar.



5.6 **elasticsearch:** Componente central del stack ELK, encargado de almacenar y indexar logs.

    - image: docker.elastic.co/elasticsearch/elasticsearch:8.12.0

    - environment:

        discovery.type=single-node → modo desarrollo.

        xpack.security.enabled=false → evita autenticación.

        ES_JAVA_OPTS → limita el uso de memoria a 512 MB.

    - ports: expuesto en 9200.

    - volumes: elastic_data para persistir índices.



5.7 **logstash:** Procesa los logs generados por la aplicación y los envía a Elasticsearch.

    - image: docker.elastic.co/logstash/logstash:8.12.0

    - depends_on: espera a Elasticsearch.

    - ports: expone 5044, entrada de logs tipo Beats.

    - volumes:

         pipeline personalizado

         acceso a storage/logs de Laravel

    - environment: limita memoria a 256 MB.



5.8 **kibana:** Interfaz gráfica para visualizar los datos almacenados en Elasticsearch.

    - image: docker.elastic.co/kibana/kibana:8.12.0

    - depends_on: espera a Elasticsearch.

    - ports: expone 5601:5601.

    - environment: define el host de Elasticsearch.


5.9 **Definición de volúmenes persistentes:** Estos volúmenes garantizan que los datos críticos del sistema (base de datos e índices de Elasticsearch) sobrevivan a reconstrucciones o borrados de contenedores.


El archivo docker-compose.yaml implementa un clúster completo y modular, capaz de ejecutar la aplicación en un entorno idéntico en cualquier máquina. Su estructura clara y su integración con GHCR y ELK lo convierten en una solución profesional y preparada para un entorno cloud-native.



### 6. El funcionamiento del cúster de contenedores. 
En este paso, va a completar todas las funciones de la aplicacion desplegada.






![Pagina Laravel](/docs/imgs/laravel.png)


### Actualizar readme
- **La estructura del repositorio se muestra en [README.md](../README.md)**
