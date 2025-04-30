## Introducción

Hola, soy [tu nombre] y en este vídeo voy a presentar el proyecto Portafolio, una web personal desarrollada con HTML, CSS y JavaScript. A lo largo de la presentación, mostraré cómo se han abordado los resultados de aprendizaje de los diferentes módulos, enseñando ejemplos concretos en el código y la aplicación.

---

## 1. Programación

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

---

## 2. Sistemas Informáticos

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

---

## 3. Entornos de Desarrollo

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

---

## 4. Bases de Datos

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

---

## 5. Lenguajes de Marcas y Gestión de Información

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

---

## 6. Proyecto Intermodular

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
