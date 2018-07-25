# Como contribuir al desarrollo del Módulo

Agradecemos cualquier ayuda reportando errores en el módulo, y también sugerencias y mejoras a implementar. Pero agradecemos aún más los Pull Requests (PR en adelante) con ayuda directa para resolver errores o mejorar el módulo.

Si te solicitamos mejorar algún punto de un PR en torno a los estándares, por favor, no tomar a mal. Es por el bien de todos (usuarios y quienes aportarán) a futuro.

Para aportar directamente (PR), deberás considerar:

* Todo aporte debe seguir los [estándares de código de Prestashop](http://doc.prestashop.com/display/PS16/Coding+Standards). Esto corre para PHP, HTML, CSS y Javascript.
* Si vas a incluir una librería de terceros, deberás utilizar [Composer](http://getcomposer.org/) para PHP, y [Bower](https://bower.io/) para CSS y JS (por ahora; no necesitamos NPM ni Yarn u otros como Gulp o Webpack por ahora). Mientras hoy en el módulo no existe uso de librerías de terceros, sugerencias para archivos de configuración de Composer y Bower son bienvenidas.
* Para toda librería de tercero (PHP, CSS o JS) la licencia de aquella librería deberá ser compatible con la licencia GPLv2.
* Si vas a usar snippets de código de terceros, por ejemplo, desde GitHub (Gists) o StackOverflow, por favor entrega el crédito correspondiente al creador del snippet de código. Con un comentario (//) sobre el snippet de código y la URL de dónde el autor original publicó dicho snippet. En el caso de Stackoverflow [la atribución es requerida](https://meta.stackexchange.com/questions/272956/a-new-code-license-the-mit-this-time-with-attribution-required) mediante una URL al post donde se encontraba el snippet.
* Programa en inglés. Todo nombre de variable, función, clase, método, etc. deberá ser claro (por sobre el abreviado), siguiendo los [estándares de Prestashop](http://doc.prestashop.com/display/PS16/Coding+Standards) y escrito en inglés. Esto es para todo, excepto los textos visibles para el usuario en el front-end (por ahora no ofrecemos traducciones en el módulo; si a futuro lo hacemos, esta regla se extenderá).
* Comenta tu código. Nos ayuda mucho, a todos, a entender que estás tratando de hacer. Comentarios simples (//), multi-lineas y/o docBlocks (/** */) si es pertinente. Si tu código resuelve un issue en el repositorio del módulo, por favor incluye un comentario con la URL del issue que estás resolviendo en el fix que enviarás como PR (donde sea conveniente para saber que ese cambio es por un issue específico). Intenta escribir los comentarios en inglés (si fuese posible; no es mandatorio).
* Haber probado tus cambios en una instalación limpia de Prestashop y actualizada, con el módulo nuestro instalado y actualizado a la versión más reciente (recomendado descargar el .zip desde el [repositorio](https://github.com/qvo-team/qvo-prestashop-webpay-plus) y subir directo en la carpeta modules de Prestashop). 

Si tienes sugerencias respecto a este código para las contribuciones al módulo, por favor, abre un nuevo issue al respecto, y conversemos ;)

¡Gracias desde ya por vuestro tiempo y ayuda!