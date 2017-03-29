# Filmiere
A web application for a cinema
## Members
* Aarón Durán Sánchez (@AaronDur9)
* Carlos López Martínez (@CharlieGnomo)
* Sorin Draghici
* Mateo García Fuentes (@mateogar)

## INTRODUCCIÓN
La idea original era desarrollar una aplicación web que gestionara
el negocio de un cine. Tanto de cara a la compra de entradas por
parte de clientes y socios, como la parte de gestión de pases, salas,
promociones... llevada a cabo por los gestores y administradores
del cine.
Nuestra aplicación, a diferencia del resto de aplicaciones web
convencionales para cines, añade todo el proceso de gestión y
compra de entradas (excepto el pago), y no te redirige a otra
página a la hora de tramitar tu compra.
Finalmente la aplicación ha conseguido sus objetivos y soporta
todas estas tareas. Entre las funcionalidades más importantes de la
aplicación encontramos:

-Para el administrador:

* Registra a los gestores de salas, y les asigna a una o varias
salas. Tras registrarlos siempre puede reasignar un gestor con otras
salas.

* Registrar a otros administradores en el sistema.

* Puede monitorizar la actividad de los gestores viendo su
último registro en la aplicación.

* Puede modificar su propia contraseña.

* Puede eliminar por completo un usuario de la aplicación
(socios o gestores).

* Añade las películas a la base de datos (y puede modificarlas
o eliminarlas) para que un gestor la asigne a alguna de sus salas en
un pase determinado.

* Asigna el precio de los tres tipos de butacas que la
aplicación soporta : butaca normal, para minusválidos y la butaca
VIP (además puede modificar el suplemento para pases en 3D).

* Asigna el porcentaje de descuento aplicado a los dos tipos
de descuento generales que finalmente hay en la aplicación: Para
grupos de entre 4 y 5 personas, y para grupos de más de 5 personas.
Solo podrán ser utilizados por socios.

* Puede añadir nuevos códigos descuentos y modificar los
porcentajes de descuento de cada uno de ellos, además de activarlos
o desactivarlos. Estos códigos los podrán utilizar los socios paraconseguir descuentos en sus compras.

* Puede revisar los mensajes de contactos enviados por
clientes para conseguir información adicional.

-Para los gestores:

* Los gestores son los encargados de añadir los pases para las
películas. Cada pase consta de película, sala, fecha y hora (además
de incluir si la película se proyectará en 3D o no, ya que todas las
salas del cine están preparadas para ello).

* Una vez añadido un pase también pueden modificar su
información (la película que se proyectará y si será en 3D).

* También se encargan de añadir las promociones, las cuales
aparecen en la portada y los clientes pueden descargarse y presentar
físicamente en el cine para conseguir ofertas exclusivas.

-Para los socios:
* Los socios podrán ver su información personal en el
apartado perfil socio, además de poder modificar su contraseña.

* También en este apartado pueden ver su historial de compras
donde aparecen todas sus compras de entradas para el cine desde la
web.

* La ventaja de ser socio es que a la hora de comprar entradas
accedes a la posibilidad de utilizar alguno de los descuentos
aplicables a tu compra.
-Funcionalidades generales de la aplicación:

* La cabecera está compuesta por el logotipo de la empresa en
la esquina superior izquierda, el diseño del título de los cines en el
centro, abajo el menú de navegación necesario para permitir la
interacción correcta con la aplicación y un botón para loguearse
en la esquina superior derecha que una vez iniciada la sesión se
convierte en un mensaje de bienvenida al usuario logueado con la
opción de cerrar la sesión. Además, cuando se inicia sesión con
un rol determinado, en el menú de navegación se añade un nuevo
botón que da acceso a un apartado determinado, en el caso del:

Socio -> Perfil del usuario.\
Gestor -> Apartado del gestor.\
Administrador -> Apartado del administrador.\

En la portada aparecen las películas que tienen un horario
establecido en las fechas que aparecen en los desplegables de
elección de horario y las que tendrán horario pasadas dichas
fechas. En la portada también aparecen diferentes promociones
que podemos descargarnos y presentar en el cine.

* En la portada también aparecen diferentes promociones que
podemos descargarnos y presentar en el cine.

* En el apartado próximamente aparecen las películas cuya
fecha de estreno es superior a la fecha actual.

* En el apartado ¿Quiénes somos? se puede encontrar
información adicional sobre nosotros y nuestra localización.

* Desde el apartado contacto un cliente puede comunicarse
con el administrador para solicitar información adicional.

* En el pie de página podemos encontrar un enlace al twitter
oficial del cine.

* Tras pinchar sobre una película el siguiente paso es
seleccionar el día y la hora de entre los disponibles para esa película
(si en alguna de las horas disponibles la película se proyectará en
3D, esta información aparecerá junto a la hora).

* Tras seleccionar el día y la hora, toca seleccionar las
butacas. Se puede consultar la leyenda bajo las butacas para saber de
qué tipo es cada una.

* Para finalizar el proceso de compra nos aparecerá un
resumen con los datos de nuestra compra. Podremos seleccionar
alguno de los descuentos aplicables (si estás registrado como socio)
y pulsar el botón de comprar.
