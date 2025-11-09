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

     ### 1. disenar tabla
     ### 2. definir operacion
     ### 3. definir reglas que debe cumplir(Exception en caso no)
     ### 4. definir estructura


   - **Gestion de dato de grupo de tamano**

     ### 1. disenar tabla
     ### 2. definir operacion
     ### 3. definir reglas que debe cumplir(Exception en caso no)
     ### 4. definir estructura


   - **Gestion de dato de color**: a implementar.   
   - **Gestion de dato de grupo de color**: a implementar.
   - **Gestion de dato de compra de material**: a implementar.



   ### Pruebas segun la interfaz



### 3. Uso de logs


### 4. Correcta ejecución de los tests.

   -**Documento de construccion**
   -**Route de las APIs**
   -**Capa de controller**
   -**Capa de servicio**
   -**resultado en Logs**








![Entorno](/docs/imgs/entorno_docker.PNG)
![Pagina Laravel](/docs/imgs/laravel.png)







- **La estructura del repositorio se muestra en [README.md](../README.md)**
