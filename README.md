# Hospital Alt

Hospital Alt es un proyecto de un hospital futurista que integra tecnología avanzada con cuidado humano para redefinir los límites de la medicina. Este proyecto incluye varias páginas web, controladores PHP, scripts de JavaScript y archivos de estilo CSS.

## Estructura del Proyecto

El proyecto está organizado en las siguientes carpetas y archivos:

### Carpetas Principales

- **hospital**: Contiene las páginas web y controladores PHP del hospital.
- **alt-salud**: Contiene las páginas web y controladores PHP de Alt Salud, la sección de seguros médicos.
- **database**: Contiene los archivos SQL para la creación de la base de datos y datos ficticios.
- **chat-api**: Contiene los archivos para la API del chat médico.

### Archivos Importantes

#### Páginas Web

- `hospital/index.html`: Página principal del hospital.
- `hospital/about.html`: Página "Quiénes Somos".
- `hospital/servicios.html`: Página de servicios médicos.
- `hospital/synthesis_academy.html`: Página de Synthesis Academy.
- `hospital/gestion_pacientes.html`: Página de gestión de pacientes.
- `hospital/medicos.html`: Página de médicos.
- `hospital/equipos.html`: Página de equipos tecnológicos.
- `alt-salud/index.html`: Página principal de Alt Salud.
- `alt-salud/nosotros.html`: Página "Nosotros" de Alt Salud.
- `alt-salud/precios.html`: Página de pólizas de Alt Salud.

#### Controladores PHP

- `hospital/php/pacientes_controller.php`: Controlador para la gestión de pacientes.
- `hospital/php/medicos_controller.php`: Controlador para la gestión de médicos.
- `hospital/php/equipos_controller.php`: Controlador para la gestión de equipos tecnológicos.
- `alt-salud/php/polizas_controller.php`: Controlador para la gestión de pólizas de Alt Salud.
- `hospital/php/conexion.php`: Archivo de conexión a la base de datos para el hospital.
- `alt-salud/php/conexion.php`: Archivo de conexión a la base de datos para Alt Salud.

#### Archivos SQL

- `database/Hospital_Alt.sql`: Script para la creación de la base de datos y tablas.
- `database/datos_ficticios.sql`: Script para insertar datos ficticios en la base de datos.

#### Archivos de Estilo CSS

- `hospital/css/styles.css`: Estilos CSS para las páginas del hospital.
- `alt-salud/css/styles.css`: Estilos CSS para las páginas de Alt Salud.

#### Scripts de JavaScript

- `hospital/js/main.js`: Script principal para la funcionalidad del hospital.
- `alt-salud/js/main.js`: Script principal para la funcionalidad de Alt Salud.

#### API del Chat

- `chat-api/index.js`: Servidor de la API del chat médico.
- `chat-api/package.json`: Archivo de configuración de dependencias para la API del chat.

## Instalación

1. Clona el repositorio en tu servidor local.
2. Configura tu servidor web (por ejemplo, XAMPP) para que apunte a la carpeta `c:\xampp\htdocs\HospitalAlt`.
3. Importa los archivos SQL en tu base de datos MySQL.
4. Configura los archivos de conexión a la base de datos (`conexion.php`) con tus credenciales de MySQL.
5. Instala las dependencias de la API del chat:
    ```bash
    cd chat-api
    npm install
    ```
6. Inicia el servidor de la API del chat:
    ```bash
    npm start
    ```

## Instalación de dependencias

Para instalar las dependencias necesarias para este proyecto, sigue los siguientes pasos:

1. Asegúrate de tener [Node.js](https://nodejs.org/) instalado en tu sistema.

2. Navega a la carpeta del proyecto:

   ```sh
   cd c:\xampp\htdocs\HospitalAlt
   ```

3. Inicializa un nuevo proyecto de Node.js (si aún no lo has hecho):

   ```sh
   npm init -y
   ```

4. Instala las dependencias de Express.js y Deepseek:

   ```sh
   npm install express
   npm install deepseek
   ```

## Ejecutar el servidor

Para ejecutar el servidor, utiliza el siguiente comando:

```sh
node server.js
```

El servidor estará escuchando en [http://localhost:3000](http://localhost:3000).

## Uso

- Accede a las diferentes páginas web a través de tu navegador.
- Utiliza los formularios para gestionar pacientes, médicos y equipos tecnológicos.
- Interactúa con el chat médico para obtener asistencia virtual.

## Contribución

Si deseas contribuir a este proyecto, por favor sigue los siguientes pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza tus cambios y haz commit (`git commit -am 'Añadir nueva funcionalidad'`).
4. Haz push a la rama (`git push origin feature/nueva-funcionalidad`).
5. Abre un Pull Request.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.
