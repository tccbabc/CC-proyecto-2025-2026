## Hito3

## Diseño de microservicios
En este hito, dentro del framework Laravel, comenzaré a desarrollar todos los detalles relacionados con la lógica de negocio del proyecto, como las operaciones sobre datos básicos como tallas y colores, la creación de órdenes de compra de material, los cuales funcionan como microservicios. Y tambien disenare y pondre en ejecucion las
pruebas y logs.



### 1. Técnica del framework
En este caso, interviene unos conceptos muy fundamentales sobre el proyecto y el marco del microservicio, los que se muestra en siguiente: 
    

  - **MCV**

    El patrón MVC separa la lógica de negocio, la interfaz y el control de flujo en tres capas bien definidas, el **Modelo**, la **Vista** y el **Controlador**,
    esta separación mejora la mantenibilidad del código, facilita las pruebas unitarias y permite la escalabilidad del microservicio. 


  - **REST**

    Representational State Transfer, que define un conjunto de principios arquitectónicos para la comunicación entre cliente y servidor mediante peticiones 
    HTTP estándar, como GET, POST, PUT, DELETE. En este caso, como el proyecto es una pagina. 

    Comparando con otros metodos de comunicacion, como **SOAP**, **RPC**, el REST tiene los siguientes ventajas:

      - En REST utiliza el JSON, que es más simple y eficiente que XML.

      - Aprovecha los métodos estándar (GET, POST, PUT, DELETE).

      - Cada petición es independiente, facilitando la escalabilidad. El **Stateless** es un concepto mas importante y fundamental para el REST.
        En REST, el servidor no necesita guardar ninguna información de las peticiones anteriores del cliente, sino con un **token** que evalua
        la identificacion del cliente. Eso falicita mucho la vida. En otros casos, el servidor guarda la informacion del cliente y luego la encuentra
        en su memoria. Asi aparece un incoveniente cuando anada mas servidores, porque todos servidores tienen que recordar esa informacion, lo que no
        es conveniente para escalabilidad.
        
      - Cada recurso tiene su propia URL, con semántica bien definida.

      - casi todos los frameworks modernos (Laravel, Spring Boot, Django, etc.) soportan REST de forma nativa.



  - **Laravel**

    Laravel es un framework PHP basado en el patrón **MVC** (Modelo–Vista–Controlador) que permite desarrollar aplicaciones web y microservicios de manera estructurada, segura y mantenible. 
    
    Su diseño modular, su sistema de rutas **RESTful** y sus componentes integrados (controladores, servicios, manejo de excepciones, logs y middleware) lo convierten en una opción ideal para construir APIs limpias y escalables.

    Y tambien decimos que **laravel** es un marco muy elegante de **PHP**. El núcleo de Laravel es la **inyección de dependencias**.

    En primer lugar, PHP es un lenguaje muy particular. Por un lado, hereda la filosofía de la programación orientada a objetos de **Java**, lo que significa que en el desarrollo con PHP se definen numerosas interfaces, clases y objetos. Por otro lado, PHP es un lenguaje interpretado, similar a **Python**, y no un lenguaje compilado como Java. Esto le otorga una mayor eficiencia durante el desarrollo y las pruebas, ya que no requiere un proceso de compilación previo.

    Por tanto, una de las características de PHP es que ofrece una gran flexibilidad en la definición de clases, sin el sistema de tipado estricto que tiene Java. Sin embargo, esta misma flexibilidad puede dificultar el mantenimiento del código, ya que aumenta la posibilidad de cometer errores. 

    Cuando necesitamos crear una clase, a veces es necesario utilizar objetos de otras clases. Por ello, normalmente tendríamos que instanciar estos objetos dependientes dentro de la definición de la clase. Sin embargo, esto genera un alto acoplamiento y dificulta las pruebas(**tight coupling**). En este contexto, el mecanismo de **inyección de dependencias** de Laravel nos ofrece una gran ventaja, ya que permite gestionar estas dependencias de manera más flexible y desacoplada.

    **Inyección de dependencias (Dependency Injection)** En Laravel permite que las clases no creen directamente sus dependencias, sino que el contenedor del framework las proporcione automáticamente. En este caso, definimos una clase y la ponemos en el **contenedor de servicio**, Laravel gestiona automáticamente los objetos a través delcontenedor de servicio, y inyecta el objeto correcto sin que el desarrollador tenga que preocuparse por instanciarlo manualmente.

    **Eloquent ORM** En Laravel, tambien hay una herramienta de gestion de base de dato que se llama **Eloquent ORM**, que es el sistema de mapeo objeto-relacional (ORM) de Laravel. Permite trabajar con la base de datos de manera orientada a objetos, en lugar de escribir SQL directamente. En su caso, cada modelo representa una tabla de la base de datos, al mismo tiempo, cada instancia del modelo representa un registro de esa tabla. Y eso hace que trabajar con la base de datos sea más rápido, seguro y limpio, evitando escribir SQL manualmente.

    Un proyecto de Laravel consiste en los siguientes partes:

      - **Route**
      Las rutas definen cómo se manejan las peticiones HTTP. En Laravel, se declaran en archivos como routes/api.php.

      - **Controller**
      Los controladores agrupan la lógica relacionada con cada recurso o módulo de la API.

      - **Service**
      Los servicios encapsulan la lógica más compleja o reutilizable que no debe estar en los controladores

      - **Exception**
      Laravel permite capturar y gestionar los errores de forma centralizada mediante app/Exceptions/Handler.php.

      - **Log**
      Laravel incorpora el sistema Monolog, que permite registrar eventos y errores en archivos o servicios externos.

      - **MiddleWare(Aun no implementado)**  
      Los middlewares son capas intermedias que interceptan las peticiones HTTP para aplicar validaciones o políticas de seguridad



### 2. Diseño en general de la API


   ### diseno de negocio
   El negocio principal de este proyecto (por el momento) se divide en las siguientes tres partes:

   - Gestión de los datos de tallas y grupos de tallas.

   - Gestión de los datos de colores y grupos de colores.

   - Definición, por parte del departamento de diseño, de los requisitos de tallas y colores en las nuevas fichas de diseño.

   Una vez definidos los requisitos en la ficha de diseño, el departamento de compras se encarga de buscar proveedores en función de las necesidades establecidas en dicho diseño.



   ### Interfaz de microServicio


   - **Gestion de dato de tamano**: 

   #### 1. disenar tabla


    CREATE TABLE `sizes` (

      `sizeCode` VARCHAR(255) NOT NULL,

      `sizeName` VARCHAR(255) NOT NULL,

      `sizeGroup` VARCHAR(255) NOT NULL,

      `sizeStatus` TINYINT(1) NOT NULL DEFAULT 1,

      `created_at` TIMESTAMP NULL DEFAULT NULL,

      `updated_at` TIMESTAMP NULL DEFAULT NULL,

      PRIMARY KEY (`sizeCode`)

     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;





     CREATE TABLE `size_relations` (

      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

      `sizeGroupCode` VARCHAR(255) NOT NULL,

      `sizeCode` VARCHAR(255) NOT NULL,

      `created_at` TIMESTAMP NULL DEFAULT NULL,

      `updated_at` TIMESTAMP NULL DEFAULT NULL,

      PRIMARY KEY (`id`),

      CONSTRAINT `size_relations_sizeGroupCode_foreign`

       FOREIGN KEY (`sizeGroupCode`) REFERENCES `size_groups`(`sizeGroupCode`)

       ON DELETE NO ACTION,

      CONSTRAINT `size_relations_sizeCode_foreign`

       FOREIGN KEY (`sizeCode`) REFERENCES `sizes`(`sizeCode`)

       ON DELETE NO ACTION

     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






   #### 2. definir estructura del microServicio



   ![estructura](/docs/imgs/estructura.png)



   - **capa Router**: Un fichero **api.php** donde define las rutina de api de los servicios de tamano.

   ![api](/docs/imgs/listRouter.png)

   - **capa Controller**: Un fichero **SizeController.php** donde define la validacion de los parametros de api y llama el servicio. 
   definido en capa de servicio.

   - **capa Service**: Un fichero **SizeService.php** donde realiza la logica de negicio concreto de los servicios.


   #### 3. definir operacion

   - **listSize**: Mostrar todos los tamanos guardados en la tabla **sizes**.

   ![listSize](/docs/imgs/listSize.png)

   - **addSize**: Anadir un tamano nuevo al tabla **sizes**, establecer una vinculacion entre el tamano y grupo de tamano en la talba **sizeRelation**.

   ![addSize](/docs/imgs/addSize.png)

   - **editSize**: Editar las informaciones de tamano en la tabla **sizes** y **sizeRelation**.

   ![editSize](/docs/imgs/editSize.png)

   - **delSize**: Eliminar el dato de un tamano en la tabla **sizes** y **sizeRelation**.

   ![delSize](/docs/imgs/delSize.png)



   #### 4. definir reglas que debe cumplir(Exception en caso no)
   Como en este hito hacemos un servicio de producction, necesita definir unas reglas o restricciones en el entorno mas practico.
   En el caso de no cumplir, llamaria la exception de la libreria de Laravel.

   - **Unicidad de tamano**: Cuando anadir un nuevo tamano, no debe obtener un mismo sizeCode guardado en la tabla size.

   - **Existencia de tamano**: Cuando editar o eliminar un tamano, este tamano debe haber existido en la tabla size.

   - **Existencia de Grupo de tamano**: Cuando anadir o editar un tamano, el sizeGroupCode que inscribe debe haber existido en la tabla sizeGroup






     
### **Gestion de dato de grupo de tamano** (Un parte a implementar)



  #### 1. disenar tabla


     CREATE TABLE `size_groups` (

     `sizeGroupCode` VARCHAR(255) NOT NULL,

     `sizeGroupName` VARCHAR(255) NOT NULL,

     `sizeGroupStatus` TINYINT(1) NOT NULL DEFAULT 1,

     `created_at` TIMESTAMP NULL DEFAULT NULL,

     `updated_at` TIMESTAMP NULL DEFAULT NULL,

     PRIMARY KEY (`sizeGroupCode`)

     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




     CREATE TABLE `size_relations` (

     `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

     `sizeGroupCode` VARCHAR(255) NOT NULL,

     `sizeCode` VARCHAR(255) NOT NULL,

     `created_at` TIMESTAMP NULL DEFAULT NULL,

     `updated_at` TIMESTAMP NULL DEFAULT NULL,

     PRIMARY KEY (`id`),

     CONSTRAINT `size_relations_sizeGroupCode_foreign`

     FOREIGN KEY (`sizeGroupCode`) REFERENCES `size_groups`(`sizeGroupCode`)

     ON DELETE NO ACTION,

     CONSTRAINT `size_relations_sizeCode_foreign`

     FOREIGN KEY (`sizeCode`) REFERENCES `sizes`(`sizeCode`)

     ON DELETE NO ACTION

     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






  #### 2. definir estructura del microServicio



   ![estructura](/docs/imgs/estructura.png)


   - **capa Router**: Un fichero **api.php** donde define las rutina de api de los servicios de grupo de tamano.


   ![api](/docs/imgs/listRouter.png)


   - **capa Controller**: Un fichero **SizeGroupController.php** donde define la validacion de los parametros de api y llama el servicio. 
   definido en capa de servicio.


   - **capa Service**: Un fichero **SizeGroupService.php** donde realiza la logica de negicio concreto de los servicios.



  #### 3. definir operacion

   - **listSizeGroup**: Mostrar todos los groups de tamano establecidos.

   - **addSizeGroup**: Anadir un nuevo grupo de tamano.

   - **editSizeGroup**: Editar un grupo de tamano.

   - **delSizeGroup**: Eliminar un grupo de tamano.

   - **removeSize** : Eliminar un tamano desde el mismo grupo de tamano.

   - **appendSize**: Meter un tamano dentro al grupo de tamano.



  #### 4. definir reglas que debe cumplir(Exception en caso no)

   - **Unicidad de grupo de tamano**: Cuando anadir un nuevo grupo de tamano, no debe obtener un mismo sizeGroupCode guardado en la tabla sizeGroup.

   - **Existencia de grupo de tamano**: Cuando editar o eliminar un grupo de tamano, este grupo debe haber existido en la tabla sizeGroup.

   - **Existencia de tamano**: Cuando anadir un tamano a este mismo grupo, este tamano debe haber existido.

   - **Estado de tamano**: Cuando anadir un tamano a este mismo grupo, este tamano debe tener el estado activo. 


     
#### Otros microServicios

  - **Gestion de dato de color** (a implementar).   
  - **Gestion de dato de grupo de color** (a implementar).
  - **Gestion de dato de compra de material** (a implementar).



### 3. Uso de logs 

   **Monolog**: Monolog es una librería de registro de logs para PHP, muy utilizada y que sigue el estándar PSR-3. Laravel la usa por defecto para manejar todos los logs del sistema. Monolog tiene los siguientes componentes principales: 

   - **Logger** (registrador): Recibe los mensajes de log (según su canal o nombre) y los envía a uno o varios handlers.

   - **Handler** (manejador): Determina dónde se escribe el log, por ejemplo, en un archivo, en Syslog, en Slack, en un correo o en una base de datos.

   - **Processor** (procesador): Añade o modifica información en cada entrada de log (por ejemplo: ID de usuario, IP, ID de la petición, etc.).

   En este caso, usar el Monolog porque por un lado, es un log generico para PHP, por otro lado, es muy extenible, es decir, existe muchos tipos de handlers y formatters, y tambien es facil de implementar, sobre todo este proyecto no es muy grande, el Monolog es bastante suficiente para este proyecto.



   **api.log**: En este proyecto, establecer un canal nuevo de log se llama **api**. Generalmente, el marco de Laravel ya ha establecido varios canales de logs
   Pero en este proyecto, para mostrar la funcionalidad del log, establecer uno nuevo. La deficinion del nuevo canel se muestra en el siguiente:


   ![canalLog](/docs/imgs/canalLog.png)


   Aqui hay unos claves interesantes:
   
   - **single**: Eso significa que el log se escribe a un archivo fijo. Como en este proyecto, de momento no hace fatla una funcionalidad muy complicado.

   - **debug**: Eso significa un nivel mas bajo de log. Eso es para mostrar toda la informacion durante el proceso de desarrolar. 

   - **tap**: Con eso podemos definir nuestro propio formato de log.

   - **path**: La ruta del archivo donde se escribre el log como el Handler, en este caso es un archivo api.log.
   

   En el parte anterior, ya sabemos el Handler es un archivo de log. Y el Logger en este caso se cae en el Contrller. Como el siguiente ejemplo:


   **Log::channel('api')->error('sizes.add_failed', ['error' => $e->getMessage()]);**


   Aqui hay unos ejemplos sencillos del resultado en log, siguiendo el proceso de desarrollo, aparece algunos errores, porque todavia no he anadido ningun grupo de tamano:


   ![ejemploLog](/docs/imgs/ejemploLog.png)



### 4. Correcta ejecución de los tests.

En este parte, voy a hacer un conjunto de pruebas sobre el microServicio de tamano con la herramienta de endPoint **Postman** manualmente.

- **Sin grupo de tamano establecido**:


  **Anadir un tamano nuevo**: En este caso, cuando anadir un tamano nuevo, pero el grupo de tamano no existe, sale error.



  ![error1](/docs/imgs/error1.png)



  **Editar un tamano a un grupo no existente**: En este caso, editar un tamano existente, pero cambia su grupo de tamano a uno no establecido.



  ![error3](/docs/imgs/error3.png)



- **Con grupo de tamano establecido**:

  Despues de establecer un grupo de tamano con el codico de "STD", hacer los siguientes pruebas. Por ejemplo:


  **Anadir un tamano nuevo**: Ya puede anadir un tamano nuevo. Con el api de **listSize**, vemos el tanamo nuevo,



  ![tamano_nuevo](/docs/imgs/tamano_nuevo.png)


  **Anadir un tamano repetido**: Ahora anadir un tamano nuevo con el mismo sizeCode que existe en el base de dato, en este caso, sale error y el sistema 
  llama la Exception.



  ![error2](/docs/imgs/error1.png)


  **Editar un tamano existente**: Ahora modifica el estado del tamano a 0.


  ![editarTamano](/docs/imgs/editarTamano.png)



  **Editar un tamano no existente**: Ahora modifica el estado de un tamano no existente.



  ![error4](/docs/imgs/error4.png)



  **Eliminar un tamano no existente**: Ahora eliminar un tamano no existente.



  ![error5](/docs/imgs/error5.png)



  **Eliminar un tamano existente**: Ahora elimina el tamano "L".



  ![eliminar1](/docs/imgs/eliminar1.png)



  ![eliminar2](/docs/imgs/eliminar2.png)


Mientras hace las pruebas, todos los resultados se guarda en el archivo de log.


![logs](/docs/imgs/logs.png)




- **La estructura del repositorio se muestra en [README.md](../README.md)**
