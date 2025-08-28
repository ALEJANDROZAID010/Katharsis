# 🐑 Katharsis K - Test de Oveja Negra

## 📖 **Descripción**

Katharsis K es una plataforma web que incluye un test interactivo para descubrir tu nivel de "rebeldía creativa" y determinar qué tipo de oveja negra eres en nuestro rebaño.

## ✨ **Características**

- 🎯 **Test de Oveja Negra**: 21 preguntas para medir tu creatividad disruptiva
- 🎨 **Diseño Moderno**: Interfaz responsive con tema oscuro y gradientes
- 🗄️ **Base de Datos**: Almacenamiento de respuestas y resultados
- 📱 **Responsive**: Funciona perfectamente en móviles y desktop
- 🌍 **Cultura Organizacional**: Sección dedicada a nuestros valores

## 🚀 **Instalación Local**

### **Requisitos:**
- XAMPP, WAMP, MAMP o similar
- PHP 7.4+
- MySQL 5.7+

### **Pasos:**
1. Clona este repositorio
2. Coloca la carpeta en tu directorio `htdocs`
3. Ejecuta `database.sql` en phpMyAdmin
4. Configura `config/database.php` con tus credenciales
5. Accede a `http://localhost/Katharsis/`

## 📁 **Estructura del Proyecto**

```
Katharsis/
├── index.html              # Página principal con el test
├── cultura-organizacional.html  # Página de cultura organizacional
├── config/
│   └── database.php        # Configuración de base de datos
├── test-oveja-negra.php    # Lógica del test (AJAX)
├── database.sql            # Estructura de la base de datos
├── README.md               # Este archivo
└── .gitignore             # Archivos a excluir de Git
```

## 🧪 **Cómo Funciona el Test**

1. **Registro**: El usuario ingresa sus datos personales
2. **21 Preguntas**: Se presentan una por una con opciones A, B, C
3. **Puntaje**: Cada respuesta tiene un valor (0, 1, o 2 puntos)
4. **Resultado**: Se calcula el tipo de oveja negra según el puntaje total

### **Tipos de Oveja Negra:**
- **ALFA** (35+ puntos): Oveja negra legendaria
- **INNOVADORA** (25-34 puntos): Gran potencial
- **EN DESARROLLO** (15-24 puntos): Espíritu en crecimiento
- **POTENCIAL** (0-14 puntos): El rebaño te espera

## 🎨 **Tecnologías Utilizadas**

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL
- **Diseño**: CSS Grid, Flexbox, Variables CSS
- **Fuentes**: Plus Jakarta Sans (Google Fonts)

## 📱 **Responsive Design**

El proyecto está optimizado para:
- 📱 **Móviles** (320px+)
- 📱 **Tablets** (768px+)
- 💻 **Desktop** (1024px+)

## 🔧 **Configuración de Base de Datos**

Edita `config/database.php` con tus credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'katharsis_test');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

## 📊 **Panel de Administración**

Para ver los resultados del test:
1. Accede a phpMyAdmin
2. Selecciona la base de datos `katharsis_test`
3. Revisa las tablas: `usuarios`, `respuestas`, `resultados`

## 🚀 **Despliegue en Producción**

1. **Hosting**: Sube los archivos a tu servidor web
2. **Base de Datos**: Crea la base de datos en tu hosting
3. **Configuración**: Actualiza `config/database.php`
4. **Dominio**: Configura tu dominio personalizado

## 🤝 **Contribuir**

1. Haz un Fork del proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 **Licencia**

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 **Contacto**

- **WhatsApp**: [573197550813](https://wa.me/573197550813)
- **Sitio Web**: [Katharsis K](https://katharsisk.com)

---

**¡Únete al rebaño de ovejas negras! 🐑⚡**
