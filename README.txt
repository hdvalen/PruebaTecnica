------------
REQUISITOS
------------

Para ejecutar correctamente este proyecto necesitas:

1. Un servidor local como:
   - XAMPP
   - WAMP
   - Laragon
   - O usar el servidor embebido de PHP: `php -S localhost:8000`

2. Tener PHP instalado (versión 7 o superior).

3. Un navegador moderno (Google Chrome, Firefox, Edge, etc.)

---------------
ESTRUCTURA DE CARPETAS
---------------

Tu carpeta del proyecto debe tener la siguiente estructura:

📁 tu-proyecto/
├── index.html                 ← Página principal con el formulario
├── js/
│   └── script.js              ← JavaScript con validaciones y carga de países
└── php/
    ├── obtener_paises.php     ← Devuelve la lista de países en formato JSON
    └── procesar_registro.php  ← (opcional) Procesa los datos del formulario

----------------------------
INSTRUCCIONES PARA EJECUTAR
----------------------------

1. Copia toda la carpeta del proyecto en el directorio del servidor local.
   - Ejemplo en XAMPP: `C:\xampp\htdocs\registro`

2. Inicia el servidor web (Apache) desde el panel de XAMPP/WAMP/Laragon.

3. Abre tu navegador y accede a:
   http://localhost/registro/index.html

4. El formulario cargará automáticamente los países desde el archivo PHP.
   - Asegúrate de que la carpeta `php/` esté correctamente ubicada.
   - Verifica que no haya errores de ruta ni espacios en blanco en los archivos PHP.

----------------------------
DETALLES DEL FUNCIONAMIENTO
----------------------------

- El formulario valida los siguientes campos:
  ✓ Nombre completo  
  ✓ Correo electrónico  
  ✓ Contraseña (mínimo 8 caracteres, una mayúscula, un número y un símbolo)  
  ✓ Confirmación de contraseña  
  ✓ Fecha de nacimiento  
  ✓ Género  
  ✓ País (se carga dinámicamente)  
  ✓ Aceptación de términos y condiciones  

- La lista de países se obtiene desde `php/obtener_paises.php`, que retorna un arreglo en formato JSON.

----------------------------
AUTOR
----------------------------

Nombre: Hodeth Valentina Caballero Gutierrez  
Fecha: 22/05/2025 
Contacto: hodethcaballero@gmail.com

