# 🐑 Test de Oveja Negra - Katharsis K

## 📋 **Requisitos Previos**

Para usar el test de oveja negra necesitas:

1. **Servidor local** con PHP y MySQL:
   - **XAMPP** (recomendado para Windows)
   - **WAMP** (Windows)
   - **MAMP** (Mac)
   - **LAMP** (Linux)

2. **PHP 7.4 o superior**
3. **MySQL 5.7 o superior**

## 🚀 **Instalación Paso a Paso**

### **1. Instalar XAMPP (Recomendado)**

1. Descarga XAMPP desde: https://www.apachefriends.org/
2. Instala XAMPP en tu computadora
3. Inicia **Apache** y **MySQL** desde el panel de control

### **2. Configurar la Base de Datos**

1. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
2. Crea una nueva base de datos llamada `katharsis_test`
3. Ve a la pestaña **SQL**
4. Copia y pega todo el contenido del archivo `database.sql`
5. Haz clic en **Continuar**

### **3. Configurar la Conexión**

1. Abre el archivo `config/database.php`
2. Verifica que las credenciales sean correctas:
   ```php
   define('DB_USER', 'root');        // Usuario por defecto de XAMPP
   define('DB_PASS', '');            // Contraseña por defecto (vacía)
   ```

### **4. Colocar los Archivos**

1. Copia toda la carpeta `Katharsis` a: `C:\xampp\htdocs\` (Windows) o `/Applications/XAMPP/htdocs/` (Mac)
2. Tu test estará disponible en: `http://localhost/Katharsis/`

## 🧪 **Cómo Funciona el Test**

### **Estructura del Test:**
1. **Formulario inicial**: Nombre, celular, país, email
2. **21 preguntas**: Una por una, sin cambiar de página
3. **Resultado final**: Tipo de oveja negra + puntaje
4. **Almacenamiento**: Todo se guarda en la base de datos

### **Tipos de Oveja Negra:**
- **ALFA** (35+ puntos): Oveja negra legendaria
- **INNOVADORA** (25-34 puntos): Gran potencial
- **EN DESARROLLO** (15-24 puntos): Espíritu en crecimiento
- **POTENCIAL** (0-14 puntos): El rebaño te espera

## 🔧 **Archivos del Sistema**

- `database.sql` - Estructura de la base de datos
- `config/database.php` - Configuración de conexión
- `test-oveja-negra.php` - Lógica del test
- `index.html` - Página principal con el test integrado

## 📊 **Panel de Administración**

Para ver los resultados:
1. Ve a `http://localhost/phpmyadmin`
2. Selecciona la base de datos `katharsis_test`
3. Revisa las tablas:
   - `usuarios` - Información de participantes
   - `respuestas` - Respuestas del test
   - `resultados` - Resultados finales

## 🐛 **Solución de Problemas**

### **Error de Conexión:**
- Verifica que MySQL esté corriendo
- Revisa las credenciales en `config/database.php`
- Asegúrate de que la base de datos exista

### **Test no Funciona:**
- Verifica que PHP esté habilitado
- Revisa los logs de error de Apache
- Asegúrate de que todos los archivos estén en la carpeta correcta

### **Base de Datos no Existe:**
- Ejecuta el archivo `database.sql` en phpMyAdmin
- Verifica que no haya errores de sintaxis

## 📱 **Características del Test**

- ✅ **Responsive** - Funciona en móviles y desktop
- ✅ **Paso a paso** - Sin cambiar de página
- ✅ **Validación** - Verifica email único
- ✅ **Persistencia** - Guarda progreso en sesión
- ✅ **Seguridad** - Sanitiza datos de entrada
- ✅ **Estadísticas** - Panel de administración

## 🎯 **Próximos Pasos**

Una vez que funcione localmente:
1. **Hosting**: Subir a un servidor con PHP y MySQL
2. **Dominio**: Configurar tu dominio personalizado
3. **SSL**: Agregar certificado de seguridad
4. **Backup**: Configurar respaldos automáticos

## 📞 **Soporte**

Si tienes problemas:
1. Revisa los logs de error
2. Verifica la configuración de la base de datos
3. Asegúrate de que todos los archivos estén presentes

---

**¡Listo para convertirte en una oveja negra! 🐑⚡**
