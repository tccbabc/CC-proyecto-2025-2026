## Hito2

## Configuración del entorno del proyecto **CC-proyecto-2025-2026**
Este proyecto está compuesto por varios servicios que interactúan entre sí a través de contenedores Docker. A continuación, se detalla la arquitectura y la función de cada componente:

### 1. Servidor Web (nginx)
- **Contenedor:** `nginx_proxy`
- **Imagen:** `nginx:stable`
 Actúa como proxy reverso, manejando las solicitudes HTTP entrantes y redirigiéndolas al contenedor de la aplicación Laravel. Es el punto de entrada principal del proyecto para los usuarios.

### 2. Aplicación Backend (Laravel)
- **Contenedor:** `laravel_app`
- **Imagen:** `cc-proyecto-2025-2026-app`
  Contiene la aplicación web desarrollada en Laravel (PHP). Maneja la lógica del negocio, la interacción con la base de datos y sirve la API o la interfaz web según sea necesario.

### 3. Panel de Administración de Base de Datos (phpMyAdmin)
- **Contenedor:** `phpmyadmin`
- **Imagen:** `phpmyadmin/phpmyadmin`
  Proporciona una interfaz web para gestionar la base de datos MySQL. Permite realizar operaciones de administración como consultas SQL, gestión de tablas y usuarios.

### 4. Cache y Gestión de Sesiones (Redis)
- **Contenedor:** `redis_cache`
- **Imagen:** `redis:7`
  Se utiliza para almacenamiento en caché y gestión de sesiones de la aplicación Laravel, mejorando el rendimiento y la velocidad de respuesta de la aplicación.

### 5. Base de Datos (MySQL)
- **Contenedor:** `mysql_db`
- **Imagen:** `mysql:8.0`
  Base de datos principal del proyecto, donde se almacena toda la información persistente de la aplicación, incluyendo usuarios, datos de negocio y configuraciones.



![Entorno](/docs/imgs/entorno_docker.PNG)



### 6. Entorno de Desarrollo Local (PHPStorm)
El proyecto se desarrolla utilizando **PHPStorm** como IDE principal. PHPStorm se ejecuta en la máquina local del desarrollador y, tras la configuración inicial, ya es posible acceder a la aplicación web a través del navegador. 



![Pagina Laravel](/docs/imgs/laravel.png)



## Integración continua


1. **Elección y configuración del gestor de tareas.**

  - **make + Makefile + Laravel Artisan**
      Artisan es un comando o instrucción que viene incluido con Laravel. Permite ejecutar tareas comunes de desarrollo de manera rápida y automatizada, como migraciones de base de datos, generación de controladores o pruebas. Desde un punto de vista básico, solo necesitamos ejecutar los comandos de Artisan. Por ejemplo, esto es suficiente durante el desarrollo local o para pruebas propias.

      Sin embargo, una situación muy común es que algunas tareas de prueba son altamente repetitivas. En estos casos, repetir la misma prueba manualmente puede ser muy   tedioso. Por otro lado, si escribimos scripts manualmente para las pruebas, surge un problema de uniformidad, ya que diferentes personas podrían escribir scripts distintos.

      Por eso se utiliza Makefile. Desde mi perspectiva, esencialmente sirve para asignar un nombre breve a un comando de prueba y luego organizar estos nombres de manera estructurada. De este modo, todos pueden simplemente usar los nombres de los comandos. Además, su entorno de lenguaje está más orientado al backend y, combinado con su legibilidad y simplicidad, lo hace muy adecuado para la integración continua (CI). 


  ![Gestor de tareas](/docs/imgs/makeFile.PNG)


2. **Elección y uso de la biblioteca de aserciones.**

  - **biblioteca de aserciones PHP**
  Dado que este proyecto se desarrolla bajo el framework Laravel, se utiliza la biblioteca de assertions que viene incluida con PHP. Primero, ya está integrada en el framework Laravel, por lo que es muy conveniente y no es necesario incorporar otra biblioteca de assertions adicional. Además, su funcionalidad es bastante potente; considerando que este proyecto se centra principalmente en operaciones CRUD, la biblioteca de assertions de PHP es suficiente.



![Biblioteca de aserciones](/docs/imgs/PHP-assertacion.PNG)


3. **Elección y uso del marco de pruebas.**

  - **PHPUnit**
  Igual como en el ejemplo d biblioteca de asercionse, en PHP, el framework de pruebas más utilizado es PHPUnit, que prácticamente se considera el estándar para pruebas unitarias en proyectos PHP. Por ejemplo:
  
     - **Organización de pruebas:** Para cada escenario de prueba, se puede crear diferentes clase y metodos.

     - **Assertions:** En su caso, usa la biblioteca de aserciones de PHP, que ya esta integrado en el marco.

     - **Configuración flexible:** Archivo `phpunit.xml` permite definir directorios, filtros y formatos de log. 

     - **Reportes:** Consola, XML o HTML, útil para CI/CD.



![PHPUnit](/docs/imgs/PHPUnit.PNG)


4. **Integración continua funcionando y correcta justificación del sistema elegido.**

![Perfil](/docs/imgs/profile.PNG)


5. **Correcta implementación y ejecución de los tests.**

![2FA](/docs/imgs/second-authentication.PNG)



- **La estructura del repositorio se muestra en [README.md](../README.md)**
