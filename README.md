# 🚀 **PROYECTO CRUD CON PATRÓN MVC**  

Este proyecto es un **CRUD** basado en el **patrón MVC (Modelo-Vista-Controlador)**, desarrollado con **PHP, HTML y JavaScript**. Fue creado como una práctica para reforzar conocimientos en desarrollo web siguiendo un enfoque estructurado, cabe mecionar que no se enfatizo desarrollar la UI del fronted.

## 🎯 **Características y Funcionalidades**  

✅ **Gestión CRUD completa**: Crear, leer, actualizar y eliminar registros.  
✅ **Integración con MySQL** para almacenar y gestionar los datos.  
✅ **Autenticación y Recuperación de Contraseña** con integración de correo a través de **SMTP y .env**.  
✅ **Búsqueda Asíncrona**: Implementación de búsqueda en tiempo real con **fetch()** y **AJAX**.  
✅ **Modales** interactivos para una mejor experiencia de usuario.  
✅ **Generación de Reportes** en **PDF** para exportar la lista de empleados.  
✅ **Gráficos Estadísticos** con **Chart.js** para visualizar datos de manera dinámica.  

## 🛠 **Requisitos**  

Antes de ejecutar el proyecto, asegúrate de contar con los siguientes requisitos:  

- Un servidor web con PHP (Ejemplo: **XAMPP**, **WAMP**, **Laragon**).  
- MySQL como gestor de base de datos.  
- Un navegador web actualizado.  

## ⚙ **Configuración de la Base de Datos**  

1. Importa el archivo del esquema (`schema.sql`) en MySQL para crear la base de datos y las tablas necesarias.
2. Importa el archivo de los datos (`seed.sql`) en MySQL para crear los valores de la tabla "puestos".  
3. Configura las credenciales de conexión a la base de datos en (`conexionBD.php`). Por ejemplo:  

   ```php
   private static $host = 'localhost';
   private static $usuario = 'tu_usuario';
   private static $password = 'tu_contraseña';
   private static $db = 'nombre_base_de_datos';
   ```

4. Si clonaste el repositorio con **Git**, simplemente abre el proyecto en tu servidor local.  

## ✉ **Funcionalidad de "Olvidaste tu contraseña"**  

Para habilitar el envío de correos en la recuperación de contraseña, configura tus credenciales en un archivo `.env`. Un ejemplo:  

   ```env
   EMAIL_HOST=smtp.ejemplo.com
   EMAIL_PORT=587
   EMAIL_USERNAME=tu_correo@ejemplo.com
   EMAIL_PASSWORD=tu_contraseña
   ```

## 🚀 **Ejecución del Proyecto**  
 1. Clona el repositorio en tu servidor local:  
   ```sh
   git clone https://github.com/KEVIN-LUIS-CH-S/MVC-practica.git
   ```

2. Asegúrate de que el servidor **Apache y MySQL** estén corriendo en **XAMPP** (o tu entorno preferido).  
3. Abre tu navegador e ingresa a:  
   ```
   http://localhost/nombre-del-proyecto/
   ```

📢 **¡Cualquier comentario o sugerencia es bienvenido!**   
Si deseas contribuir o tienes alguna duda, no dudes en abrir un **issue** o realizar un **pull request**. ¡Gracias por tu interés en este proyecto! 🚀🎯  
