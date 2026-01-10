## Hito5

## Despliegue de la aplicación en un IaaS


&nbsp;
&nbsp;


### 1. El IaaS elegido - AWS-EC2

&nbsp;

AWS EC2 (Elastic Compute Cloud) es un servicio de IaaS ofrecido por Amazon Web Services. Permite crear y usar máquinas virtuales en la nube, que funcionan como servidores remotos accesibles por Internet.En este proyecto, AWS EC2 se utilizó como la infraestructura principal donde se ejecuta la aplicación PHP y los servicios necesarios para su funcionamiento. Se utilizó la versión gratuita de AWS, conocida como Free Tier, que ofrece recursos limitados pero suficientes para un proyecto académico:

 - **Tipo de instancia:** t2.micro / t3.micro → 1 vCPU y 1 GB de RAM

 - **Sistema operativ:** Ubuntu Linux

 - **Almacenamiento:** hasta 10 GB de disco EBS.

 - **Red:** Dirección IP pública, Configuración manual de puertos (SSH, HTTP, etc.)

 - **Acceso:** Conexión por SSH mediante clave privada 

 - **Coste:** Gratuito dentro de los límites del Free Tier

&nbsp;
&nbsp;

![EC2](/docs/imgs/EC2.png)

&nbsp;
&nbsp;

El uso de una solución IaaS como AWS EC2 frente a una PaaS permite tener un mayor control sobre la infraestructura y demuestra un conocimiento más profundo de sistemas, redes y despliegue de aplicaciones. 

Al principio se utilizó un servicio PaaS llamado Railway. Durante el proceso de despliegue se comprobó que, para un despliegue individual, Railway resulta más sencillo y más intuitivo que AWS EC2, ya que requiere menos configuración y permite poner la aplicación en funcionamiento de forma rápida.

Sin embargo, cuando se plantea la automatización del despliegue, la situación cambia. Con la ayuda de herramientas como Terraform, el uso de una solución IaaS como EC2 resulta más simple y más clara a largo plazo, ya que permite definir toda la infraestructura como código y repetir el proceso de forma automática y controlada.

Por este motivo, aunque Railway es más cómodo para despliegues puntuales, la opción final del proyecto fue AWS EC2, principalmente por la facilidad para implementar automatización y por el mayor control que ofrece sobre la infraestructura.


&nbsp;
&nbsp;


### 2. Las herramientas usadas para desplegar la aplicación en En IaaS

&nbsp;


 - **sAWS EC2:** La aplicación se desplegó sobre una instancia de AWS EC2, que proporciona una infraestructura de tipo IaaS. EC2 se utilizó como servidor principal, permitiendo un control total sobre el sistema operativo, la red y los servicios instalados.


- **Terraform para la automatización (clave del proyecto):** Para la automatización del despliegue de la infraestructura se utilizó Terraform. Gracias a Terraform, fue posible definir la infraestructura de EC2 como código, automatizando la creación y configuración de recursos en AWS, el que consiste en 4 archivos:

  - **main.tf:** Este es el archivo más importante del proyecto. Aquí es donde se define la infraestructura principal, por ejemplo: La instancia EC2, El tipo de instancia, El sistema operativo, La red básica, Los recursos que realmente se van a crear, etc. 

  - **variables.tf:** Este archivo se usa para definir variables, en lugar de escribir todos los valores directamente en el código.

  - **outputs.tf:** El archivo outputs.tf se utiliza para mostrar información importante al final del despliegue, en mi caso la direccion de la IP.

  - **user-data.sh**: Este archivo es clave para la automatización del despliegue, el que es un script que se ejecuta automáticamente la primera vez que se inicia la instancia EC2. En este script se incluyen tareas como: Actualizar el sistema, Instalar Docker y Docker Compose, Descargar el código del proyecto, Arrancar los contenedores Docker, etc. 


&nbsp;
&nbsp;

![terraform](/docs/imgs/terraform.png)

&nbsp;
&nbsp;


 - **Acceso por SSH:** El acceso al servidor EC2 se realizó mediante SSH, usando una clave privada. Esto permitió conectarse de forma segura al servidor para instalar dependencias, configurar el entorno y desplegar la aplicación manualmente. Sobre todo en este hito, la configuracion automatica en la nube es muy diferente que en la maquina local, pues despues de crear la instancia del servidor, habia muchos erroes durante el proceso de desplegar y debe acceder al mismo servidor a leer el log para ver donde esta el problema.


- **Sistema operativo Linux (Ubuntu):** La instancia EC2 utiliza Ubuntu Linux como sistema operativo. Este entorno facilita la instalación de herramientas comunes para desarrollo web y es muy habitual en servidores en producción.


- **Contenedor-docker:** Para facilitar el despliegue y asegurar que la aplicación se ejecute siempre en el mismo entorno, se utilizó Docker. Docker permite empaquetar la aplicación junto con todas sus dependencias en contenedores, evitando problemas de compatibilidad entre entornos.


- **Git para el despliegue del código:** El código de la aplicación se gestionó mediante Git, permitiendo clonar el repositorio directamente en el servidor EC2. Esto facilitó el control de versiones y la actualización del código durante el despliegue.



&nbsp;
&nbsp;


### 3. La configuración para el despliegue automático de la aplicación

&nbsp;

La aplicación se desplegó de forma automática sobre una infraestructura IaaS utilizando AWS EC2, con el repositorio de código alojado en GitHub. En general, se consisten en los siguientes partes:

- **3.1 Definición de la infraestructura con Terraform:** La infraestructura se definió utilizando Terraform, siguiendo el enfoque de Infraestructura como Código (IaC). Mediante varios archivos de configuración, se describieron los recursos necesarios, principalmente una instancia EC2. Cuando se ejecuta la instruccion **terraform apply   -var="key_name=cc-iaas-key"**, Terraform se encarga automáticamente de Crear la instancia EC2 y Asociar un script de inicialización (user-data.sh).

- **3.2 Uso de user-data para la automatización inicial:** Durante la creación de la instancia EC2, se utiliza un script user-data.sh, que se ejecuta automáticamente en el primer arranque del servidor. Este script es definido por nosotros, el que he contado en el parte arriba.

- **3.3 Despliegue de la aplicación con Docker:** La aplicación se ejecuta dentro de contenedores creados con Docker.Docker permite que todo el entorno de la aplicación esté definido previamente, incluyendo dependencias y configuración.De esta forma, una vez que el repositorio se clona desde GitHub y los contenedores se inician, la aplicación queda funcionando automáticamente.


&nbsp;
&nbsp;

![docker](/docs/imgs/docker.png)

&nbsp;
&nbsp;


Esta configuración demuestra cómo una solución IaaS permite un alto nivel de automatización cuando se combina con herramientas adecuadas. El uso conjunto de Terraform, GitHub y Docker facilita un despliegue controlado y repetible, aportando mayor valor técnico al proyecto frente a soluciones más cerradas como PaaS.


&nbsp;
&nbsp;


### 4. Las herramientas de observabilidad implementadas

- **AWS CloudWatch:** AWS proporciona de forma nativa AWS CloudWatch, que se utilizó para supervisar el estado de la instancia EC2. Con CloudWatch se pueden observar métricas como: **Uso de CPU**, **Consumo de memoria**, **Estado de la instancia**, **Tráfico de red**, etc. Estas métricas permiten comprobar si el servidor está funcionando correctamente o si existe sobrecarga de recursos, algo especialmente importante al usar instancias pequeñas del Free Tier.

- **Ventajas de la monitorización básica con AWS CloudWatch:** 

En primer lugar, CloudWatch está integrado directamente con AWS, por lo que no es necesario instalar ni configurar herramientas adicionales en la instancia EC2. Desde el primer momento se dispone de métricas básicas sin esfuerzo extra. 

Otra ventaja clave es que permite tener visibilidad en tiempo real sobre el estado del servidor. Métricas como el uso de CPU, el tráfico de red o el estado de la instancia ayudan a detectar rápidamente si el servidor está funcionando con normalidad o si existe algún problema de carga. 

Además, CloudWatch resulta especialmente útil cuando se utilizan instancias pequeñas del Free Tier, ya que permite comprobar si los recursos son suficientes o si el servidor está llegando a sus límites.

&nbsp;
&nbsp;


![AWS CloudWatch](/docs/imgs/AWSCloudWatch.png)

&nbsp;
&nbsp;

- **ELK:** En este caso, como estoy usando una version gratis de AWS, no me da suficiente espacio para desplegar el sistema de log que habia desplegado en el hito anterior. Pues considerando de momento lo mas importante es asegurar que la aplicacion se pueda ser desplegado con exito en la nube, al final deja de usa el ELK.


&nbsp;
&nbsp;


![falloELK](/docs/imgs/falloELK.png)

&nbsp;
&nbsp;


### 5. Funcionamiento correcto del despliegue


Para verificar que la aplicación desplegada en el servidor funciona correctamente, se utilizó **Postman** como endpoint para realizar pruebas sobre el sistema. La aplicación se encuentra accesible a través de la IP pública **13.62.20.183** y, debido a que se utiliza Nginx como proxy, el servicio está expuesto en el puerto **8080**. Para las pruebas se utilizó la API de **grupos de tallas**, realizando varias llamadas a dicho endpoint con el objetivo de comprobar que la API responde correctamente y que el sistema funciona de manera estable. Aqui estan las APIs usadas:

- **GET http://13.62.20.183:8080/api/size-groups/**

- **POST http://13.62.20.183:8080/api/size-groups/**

- **PUT http://13.62.20.183:8080/api/size-groups/STD**


Esta prueba se centra principalmente en comprobar si la aplicación puede leer y escribir correctamente en la base de datos en la nube. 

El proceso es bastante sencillo: primero se consultan los datos de los grupos de tallas, que inicialmente están vacíos. A continuación, se añade un grupo de tallas, se vuelve a consultar la información, después se modifica dicho grupo y, finalmente, se realiza una última consulta para verificar los cambios.

Como se muestra en las imágenes siguientes, los resultados de la prueba indican que el despliegue en la nube se ha realizado correctamente y que la aplicación funciona como se esperaba.


&nbsp;
&nbsp;

![nubeprueba1](/docs/imgs/nubeprueba1.png)

&nbsp;

![nubeprueba2](/docs/imgs/nubeprueba2.png)

&nbsp;

![nubeprueba3](/docs/imgs/nubeprueba3.png)

&nbsp;

![nubeprueba4](/docs/imgs/nubeprueba4.png)


&nbsp;
&nbsp;


### 6. Pruebas de las prestaciones de la aplicación. 

&nbsp;

Para evaluar las prestaciones de la aplicación desplegada en la nube, se realizaron varias pruebas orientadas a comprobar su comportamiento bajo carga y su capacidad de respuesta ante múltiples peticiones simultáneas. Como en el parte anterior he probado con unos APIs de la aplicacion, en este caso voy a usar una de ellos, pero con diferentes cargas, es decir, hace las pruebas de carga con múltiples peticiones concurrentes. En concreto, se ejecutaron varias peticiones concurrentes al endpoint de grupos de tallas, comprobando que:

- **La aplicación responde sin errores**

- **El servidor mantiene la estabilidad**

- **No se producen caídas del servicio**

Para evaluar las prestaciones de la aplicación desplegada en la nube, se realizó una prueba de carga sobre el endpoint REST: **GET /api/size-groups**


La prueba se ejecutó desde un cliente externo (máquina local con Windows) utilizando PowerShell, sin necesidad de instalar herramientas adicionales, simulando múltiples usuarios concurrentes accediendo a la aplicación.

El procedimiento consistió en lanzar 20 procesos concurrentes (jobs), y cada uno de ellos realizó 50 peticiones HTTP GET consecutivas al endpoint, alcanzando un total de: **Número total de peticiones: 1000**, **Nivel de concurrencia: 20**.
 

   $jobs = 1..20 | ForEach-Object {
    Start-Job {
        1..50 | ForEach-Object {
            Invoke-WebRequest "http://13.62.20.183:8080/api/size-groups" -UseBasicParsing
        }
    }
   }  
   $jobs | Wait-Job


Posteriormente, se repitió el experimento incrementando el nivel de concurrencia y el número total de peticiones (hasta 5000 solicitudes) con el objetivo de observar el comportamiento del sistema bajo una mayor carga.


   $jobs = 1..50 | ForEach-Object {
    Start-Job {
        1..100 | ForEach-Object {
            Invoke-WebRequest "http://13.62.20.183:8080/api/size-groups" -UseBasicParsing
        }
    }
   }  
   $jobs | Wait-Job


A partir de las métricas observadas en Amazon CloudWatch, se obtuvieron los siguientes resultados:

- **Utilización de CPU:** La utilización máxima de CPU alcanzó aproximadamente el 20% durante el pico de carga, Tras finalizar la prueba, el uso de CPU volvió rápidamente a valores cercanos a cero.

- **Tráfico de red:** El aumento del tráfico de red confirma que las peticiones HTTP fueron procesadas correctamente y que el servidor respondió a los clientes sin interrupciones ni pérdidas de paquetes.

- **Paquetes de red:** El elevado número de paquetes procesados demuestra que la aplicación mantuvo una comunicación estable con los clientes durante la prueba, sin errores de red apreciables.

- **CPU Credits:** El CPU credit usage muestra picos durante la prueba, El CPU credit usage muestra picos durante la prueba.


&nbsp;
&nbsp;


![EC2-P](/docs/imgs/EC2-P.png)

&nbsp;
&nbsp;


### Actualizar readme
- **La estructura del repositorio se muestra en [README.md](../README.md)**
