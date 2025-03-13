# 🚀 **PROYECTO CRUD CON PATRÓN MVC**  

Este proyecto es un **CRUD** basado en el **patrón MVC (Modelo-Vista-Controlador)**, desarrollado con **PHP, HTML y JavaScript**. Fue creado como una práctica para reforzar conocimientos en desarrollo web siguiendo un enfoque estructurado.  

## 🛠 **Requisitos**  

Antes de ejecutar el proyecto, asegúrate de contar con los siguientes requisitos:  

- Un servidor web con PHP (Ejemplo: **XAMPP**, **WAMP**, **Laragon**).  
- MySQL como gestor de base de datos.  
- Un navegador web actualizado.  

## ⚙ **Configuración de la Base de Datos**  

1. Importa el archivo del esquema (`schema.sql`) en MySQL para crear la base de datos y las tablas necesarias.  
2. Configura las credenciales de conexión a la base de datos en tu proyecto. Por ejemplo:  

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'tu_usuario');
   define('DB_PASS', 'tu_contraseña');
   define('DB_NAME', 'nombre_base_de_datos');
   ```

3. Si clonaste el repositorio con **Git**, simplemente abre el proyecto en tu servidor local.  

## ✉ **Funcionalidad de "Olvidaste tu contraseña"**  

Para habilitar el envío de correos en la recuperación de contraseña, configura tus credenciales en un archivo `.env`. Un ejemplo:  

   ```env
   MAIL_HOST=smtp.ejemplo.com
   MAIL_USER=tu_correo@ejemplo.com
   MAIL_PASS=tu_contraseña
   MAIL_PORT=587
   ```

## 🚀 **Ejecución del Proyecto**  

1. Asegúrate de que el servidor **Apache y MySQL** estén corriendo en **XAMPP** (o tu entorno preferido).  
2. Abre tu navegador e ingresa a:  
   ```
   http://localhost/nombre-del-proyecto/
   ```
3. El sistema cargará automáticamente el `index.php` y mostrará la interfaz del CRUD.  

---

📌 **Siguientes mejoras**: Se planea agregar nuevas funcionalidades como reportes en PDF, integración con API REST y mejoras en la interfaz con **Tailwind CSS**.  

⚡ **¡Gracias por visitar el proyecto!** Si tienes sugerencias o mejoras, no dudes en compartirlas. 🚀  

---

Esta versión es más estructurada, clara y visualmente atractiva. Si quieres agregar más detalles o imágenes, puedes usar `![Texto alternativo](ruta_imagen)`.  

Déjame saber si quieres cambios o más mejoras. 😃
