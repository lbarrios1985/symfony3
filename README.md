Prueba de Symfony

Aplicacion web realizada en Symfony 3, mysql como gestor de base de datos, boostrap...

Instalación:

1.- Dentro del Directorio raiz escribir el siguiente comando:
	
	composer install

2.- Dentro del gestor, crear la base de datos a utilizar en el proyecto y configurar el archivo parameters.yml

3.- Generar las tablas de la base de datos con el comando:

	php bin/console doctrine:schema:update --force

4.- Montar la aplicacion en el servidor de prueba 

	php bin/console server:run

5.- Ir al navegador a la direccion:

	http://127.0.0.1:8000/login
