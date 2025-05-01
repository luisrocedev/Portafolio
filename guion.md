<<<<<<< HEAD
---
# 🎤 Guion hablado para el Proyecto Portafolio

## Introducción

Hola, soy [tu nombre] y en este video voy a presentar mi proyecto “Portafolio”, una aplicación web pensada para mostrar mis proyectos y habilidades de forma visual y profesional. A lo largo de la presentación, responderé a una serie de preguntas técnicas que ayudan a entender cómo está construido el proyecto, qué decisiones tomé y por qué.
=======
## Introducción

Hola, soy [tu nombre] y en este vídeo voy a presentar el proyecto Portafolio, una web personal desarrollada con HTML, CSS y JavaScript. A lo largo de la presentación, mostraré cómo se han abordado los resultados de aprendizaje de los diferentes módulos, enseñando ejemplos concretos en el código y la aplicación.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71

---

## 1. Programación

<<<<<<< HEAD
Comenzamos por la parte de programación.

En el código de Portafolio utilizo variables y constantes para almacenar información como el nombre del proyecto, la versión o la lista de proyectos. Los tipos de datos principales son string, number, boolean, arrays y objetos.

Para controlar el flujo de la aplicación, empleo estructuras de selección como if y else, y de repetición como for y forEach, por ejemplo, para recorrer la lista de proyectos y mostrarlos en pantalla.

En cuanto a la gestión de errores, uso bloques try-catch en los scripts de JavaScript para capturar posibles fallos, aunque al ser una aplicación frontend, los errores suelen estar relacionados con la manipulación del DOM o la validación de formularios.

La documentación del código la realizo mediante comentarios en JavaScript y CSS, y también con archivos markdown como el README.

El paradigma que sigo es estructurado y modular, separando la lógica en funciones y archivos para que el código sea más mantenible y fácil de entender.

No utilizo clases, pero sí objetos literales para representar proyectos o usuarios, lo que simplifica la estructura y hace que el código sea más directo.

En cuanto a conceptos avanzados, la modularidad y la reutilización de funciones son clave, aunque no aplico herencia ni polimorfismo porque el proyecto no lo requiere.

Toda la información se gestiona en el frontend, no hay backend ni base de datos, así que los datos se almacenan en arrays y objetos dentro del propio JavaScript.

Por último, aplico técnicas como la validación de formularios y la manipulación del DOM para mejorar la experiencia del usuario.
=======
### a) Elementos Fundamentales

En [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) defino variables y constantes para gestionar la interacción:

**const** **menuButton** **=** **document**.**getElementById**(**'menu-btn'**)**;**

**let** **isMenuOpen** **=** **false**;

Uso tipos de datos como strings, booleanos y arrays para la lógica de la web.

---

### b) Estructuras de Control

En [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) uso condicionales y bucles:

**if** **(**isMenuOpen**)** **{**

**  **// Cerrar menú

**}** **else** **{**

**  **// Abrir menú

**}**

Y para recorrer elementos:

**document**.**querySelectorAll**(**'.project'**)**.**forEach**(**project** **=>** **{

**  **// Añadir eventos o modificar DOM

**}**)**;**

---

### c) Control de Excepciones y Errores

En JavaScript, uso try/catch para manejar posibles errores:

**try** **{**

**  **// Código que puede fallar

**}** **catch** **(**error**)** **{**

**  **console**.**error**(**'Error al cargar el portafolio:'**, **error**)**;

**}**

---

### d) Documentación del Código

En [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) comento las funciones:

**// Función para alternar el menú de navegación**

**function** **toggleMenu**(**)** **{**

**  **// ...código...

**}**

---

### e) Paradigma de Programación

El proyecto sigue un paradigma estructurado y modular, separando funciones en [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) para cada interacción.

---

### f) Clases y Objetos Principales

En este caso, no hay clases de JavaScript, pero sí objetos literales para almacenar información de proyectos:

**const** **proyectos** **=** **[**

**  **{** **nombre**: **"TPV-Voltereta"**, **descripcion**: **"TPV para hostelería"**, **url**: **"#"** **}**,**

**  **// ...

**]**;

---

### g) Conceptos Avanzados

Se usan funciones flecha y métodos modernos de arrays:

**proyectos**.**map**(**proyecto** **=>** **{**

**  **// Generar HTML dinámicamente

**}**)**;**

---

### h) Gestión de Información

La información de los proyectos puede estar en arrays de objetos en [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) o directamente en el HTML.

---

### i) Estructuras de Datos

Uso arrays y objetos para manejar listas de proyectos y datos personales.

---

### j) Técnicas Avanzadas

Uso selectores avanzados de CSS y JavaScript para manipular el DOM y animaciones CSS para mejorar la experiencia visual.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71

---

## 2. Sistemas Informáticos

<<<<<<< HEAD
Pasando a la parte de sistemas informáticos:

El desarrollo lo realizo en un MacBook con al menos 8GB de RAM, y la aplicación se despliega en un hosting web estático, lo que facilita el acceso y la disponibilidad.

El sistema operativo de desarrollo es macOS, mientras que en producción se utiliza Linux, que es el estándar en la mayoría de los servidores de hosting.

La aplicación es accesible públicamente a través de HTTP y HTTPS, y utilizo un dominio personalizado para darle un aspecto más profesional.

Las copias de seguridad las gestiono de forma manual y también a través del repositorio de GitHub, lo que me permite restaurar el proyecto fácilmente si surge algún problema.

Para la seguridad e integridad de los datos, valido las entradas de los formularios y utilizo HTTPS en producción para proteger la información transmitida.

No hay gestión de usuarios ni permisos en el sistema, ya que el acceso es público y no se almacena información sensible.

La documentación técnica se mantiene en archivos markdown y en los propios comentarios del código.
=======
### a) Hardware y Entornos

Desarrollo en Windows, pero la web es multiplataforma y puede visualizarse en cualquier navegador moderno.

---

### b) Sistema Operativo

He elegido Windows para el desarrollo, pero la web es independiente del sistema operativo.

---

### c) Configuración de Redes

El proyecto se puede desplegar en cualquier servidor web o plataforma como GitHub Pages.

---

### d) Copias de Seguridad

Guardo copias del código en GitHub y puedo descargar el proyecto completo para respaldo.

---

### e) Seguridad e Integridad de Datos

No se gestionan datos sensibles, pero se valida la entrada de formularios si los hubiera.

---

### f) Gestión de Usuarios y Permisos

No hay gestión de usuarios, ya que es un portafolio público.

---

### g) Documentación Técnica

Toda la documentación está en el propio código y en el README del repositorio si se publica en GitHub.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71

---

## 3. Entornos de Desarrollo

<<<<<<< HEAD
En cuanto al entorno de desarrollo:

Utilizo Visual Studio Code como IDE principal, con extensiones para HTML, CSS, JavaScript y Live Server, que me permite ver los cambios en tiempo real.

La automatización de tareas es sencilla, ya que al ser un proyecto estático, solo necesito Live Server para recargar la página automáticamente al guardar cambios.

El control de versiones lo realizo con Git y GitHub, creando ramas para pruebas y para la versión de producción, lo que facilita el trabajo y la colaboración si en el futuro se amplía el equipo.

Refactorizo el código de forma periódica para mejorar la eficiencia y la legibilidad, y la documentación técnica se mantiene tanto en markdown como en los comentarios del código.

Opcionalmente, puedo crear diagramas de flujo para planificar la navegación o la estructura de la aplicación.
=======
### a) IDE y Configuración

Utilizo Visual Studio Code con extensiones para HTML, CSS y JavaScript.

---

### b) Automatización de Tareas

No es necesario automatizar tareas, pero podría usar Live Server para recargar la web automáticamente.

---

### c) Control de Versiones

Uso Git y GitHub para gestionar el código y el historial de cambios.

---

### d) Refactorización

Refactorizo el código separando estilos en [style.css](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) y la lógica en [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html).

---

### e) Documentación Técnica

Toda la documentación técnica está en el archivo [README.md](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) si el proyecto se publica.

---

### f) Diagramas

Puedo incluir diagramas de flujo o wireframes en el README o como imágenes en la carpeta del proyecto.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71

---

## 4. Bases de Datos

<<<<<<< HEAD
En este proyecto no utilizo bases de datos, ya que toda la información es estática o se gestiona en arrays de JavaScript.
No hay modelo entidad-relación ni funcionalidades avanzadas como vistas o procedimientos almacenados.
La protección y recuperación de datos se basa en los backups del repositorio de GitHub.
=======
### a) Sistema Gestor

No se utiliza base de datos, toda la información es estática o gestionada en arrays de JavaScript.

---

### b) Modelo Entidad-Relación

No aplica, pero si se quisiera ampliar, se podría conectar a una base de datos para mostrar proyectos dinámicamente.

---

### c) Funcionalidades Avanzadas

No hay procedimientos almacenados ni triggers, pero se podría ampliar con almacenamiento local (`localStorage`) para guardar preferencias del usuario.

---

### d) Protección y Recuperación de Datos

El código está respaldado en GitHub y puede restaurarse fácilmente.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71

---

## 5. Lenguajes de Marcas y Gestión de Información

<<<<<<< HEAD
En la parte de lenguajes de marcas y gestión de información:

La estructura HTML sigue buenas prácticas, utilizando etiquetas semánticas como header, main y footer para mejorar la accesibilidad y el SEO.

El frontend está construido con HTML, CSS y JavaScript, que son tecnologías estándar y ampliamente soportadas.

JavaScript se utiliza para mostrar y ocultar secciones, validar formularios y manipular el DOM, mejorando la interactividad de la web.

Valido el HTML y el CSS con herramientas online y extensiones del IDE para asegurarme de que cumplen los estándares.

No es necesario convertir datos entre formatos como XML o JSON, aunque podría usarse JSON para guardar información en el localStorage si se quisiera ampliar la funcionalidad.

No hay integración con sistemas de gestión empresarial, ya que el objetivo es mostrar información personal y profesional.
=======
### a) Estructura HTML y Buenas Prácticas

En [index.html](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) uso etiquetas semánticas:

**<**main**>**

**  <**section** **id**=**"proyectos"**></**section**>**

**  <**section** **id**=**"contacto"**></**section**>**

**</**main**>**

Esto mejora la accesibilidad y la estructura del contenido.

---

### b) Tecnologías Frontend

Utilizo CSS para el diseño (`style.css`) y JavaScript para la lógica de la interfaz (`script.js`).

---

### c) Interacción con el DOM

En [script.js](vscode-file://vscode-app/c:/Users/Luis/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html) manipulo el DOM para mostrar proyectos dinámicamente:

**document**.**getElementById**(**'proyectos'**)**.**innerHTML** **=** **generarHTMLProyectos**(**proyectos**)**;

---

### d) Validación

Si hay formularios de contacto, valido los datos antes de enviarlos:

**if** **(**email** **===** **''** **||** **!**emailRegex**.**test**(**email**)**)** **{**

**  **// Mostrar error

**}**

---

### e) Conversión de Datos

Si se usara AJAX, podría enviar y recibir datos en formato JSON, pero en este caso la web es estática.

---

### f) Integración con Sistemas de Gestión Empresarial

No aplica, ya que es un portafolio personal, pero podría integrarse con APIs externas para mostrar proyectos de GitHub, por ejemplo.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71

---

## 6. Proyecto Intermodular

<<<<<<< HEAD
Por último, en cuanto al enfoque intermodular:

El objetivo del software es mostrar mis proyectos y habilidades de forma visual y profesional, facilitando la presentación y la búsqueda de información tanto para mí como para posibles empleadores o colaboradores.

La necesidad que cubre es la de centralizar y organizar mi información profesional, evitando la dispersión y mejorando la imagen que transmito.

El stack de tecnologías es sencillo: HTML, CSS y JavaScript para el desarrollo, y Git y GitHub para el control de versiones.

El desarrollo se ha planteado por versiones: la primera versión incluye la estructura básica y la presentación de proyectos, y en versiones posteriores se han añadido mejoras visuales, animaciones y un formulario de contacto.

---

## Cierre

Y hasta aquí la presentación de mi proyecto Portafolio.
Espero que haya quedado claro cómo está construido, qué decisiones técnicas he tomado y cómo responde a las necesidades planteadas.
Si tienes cualquier duda o sugerencia, puedes dejarla en los comentarios.
¡Gracias por ver el video!
=======
### a) Objetivo del Software

El objetivo es mostrar mis proyectos, habilidades y experiencia de forma profesional y accesible.

---

### b) Stack Tecnológico

Uso HTML, CSS y JavaScript por su compatibilidad y facilidad de despliegue en la web.

---

### c) Desarrollo por Versiones

Empecé con una versión mínima y fui añadiendo secciones como proyectos, contacto y mejoras visuales.

---

## 7. Evaluación y Entrega

Entrego el código fuente en GitHub y la web publicada en una plataforma como GitHub Pages o un servidor propio.

---

## Despedida

Esto ha sido un recorrido completo por el proyecto Portafolio, mostrando cómo se han abordado todos los resultados de aprendizaje requeridos.
Gracias por vuestra atención.
>>>>>>> 8ab3de7c5757f95f22151cc2a19b95957a010d71
