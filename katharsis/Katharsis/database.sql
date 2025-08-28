-- Base de datos para Test de Oveja Negra - Katharsis K
-- Ejecutar este archivo en MySQL para crear la estructura

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS katharsis_test;
USE katharsis_test;

-- Tabla de usuarios que han hecho el test
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    celular VARCHAR(20) NOT NULL,
    pais VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45)
);

-- Tabla de respuestas del test
CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    pregunta_numero INT NOT NULL,
    respuesta VARCHAR(10) NOT NULL, -- A, B, o C
    puntaje INT NOT NULL, -- 0, 1, o 2
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    UNIQUE KEY unique_respuesta (usuario_id, pregunta_numero)
);

-- Tabla de resultados finales
CREATE TABLE resultados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    puntaje_total INT NOT NULL,
    tipo_oveja VARCHAR(50) NOT NULL,
    mensaje_resultado TEXT NOT NULL,
    fecha_resultado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertar las 21 preguntas del test
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    pregunta TEXT NOT NULL,
    opcion_a TEXT NOT NULL,
    opcion_b TEXT NOT NULL,
    opcion_c TEXT NOT NULL,
    valor_a INT NOT NULL DEFAULT 0,
    valor_b INT NOT NULL DEFAULT 1,
    valor_c INT NOT NULL DEFAULT 2
);

-- Insertar las preguntas del test
INSERT INTO preguntas (numero, pregunta, opcion_a, opcion_b, opcion_c, valor_a, valor_b, valor_c) VALUES
(1, '¿Termino sabiendo de otras cosas cuando estoy averiguando algo?', 'Obvio', 'A veces', 'Ehhm, nah', 2, 1, 0),
(2, 'Prefiero no meterme donde nadie me ha llamado, no me gusta que me tilden de sapo', 'Soy un sapo', 'De vez en cuando lo hago', 'Nunca lo hago', 2, 1, 0),
(3, 'Soy de los que encuentro una aguja en un pajar', 'Sí', 'A veces', 'Nunca en la vida', 2, 1, 0),
(4, 'Cuando la gente va por leche, yo ya vengo con el queso', 'Así es', 'A veces', 'No', 2, 1, 0),
(5, 'Mis amigos me llaman bola de cristal... siempre presiento como saldrán las cosas', 'Así es', 'A veces me sale', 'No, pocas veces acierto', 2, 1, 0),
(6, 'Mientras los demás están pensando en las Eliminatorias, yo estoy buscando los tiquetes para el Mundial', 'Así es, soy atrevida/o', 'A veces lo hago', 'No, prefiero ser precavido', 2, 1, 0),
(7, '¿Cómo me miran cuándo propongo mis ideas?', '«Se enloqueció»', '«Ehmmm, podría funcionar, no sé»', '«¡ESO ES!»', 2, 1, 0),
(8, 'Siempre me caso con la primera idea que se me ocurre', 'Sí, siempre', 'A veces. No sé. Depende...', 'NUNCA', 2, 1, 0),
(9, 'Me invento nuevos caminos para llegar a Roma', 'Ya sé que existe un camino, ¿por qué no llegar por otro?', 'Depende...', 'No, si ya hay un camino, debe ser generalmente el mejor', 2, 1, 0),
(10, 'Hago lo que me gusta cuando encuentro el tiempo', 'Sí, lo hago', 'A veces sí, a veces no', 'Nah', 2, 1, 0),
(11, 'Tengo claro a lo que vine a este mundo', 'Claro que yes', 'Ehmmm, tengo sospechas', 'NPI', 2, 1, 0),
(12, 'Prefiero la comedia al drama', 'Vivo de la comedia', 'Un poco de esto, un poco de aquello...', 'Drama queen', 2, 1, 0),
(13, 'Creo que no necesito la aprobación de nadie', 'Prefiero pedir perdón que permiso', 'Depende...', 'Sí la necesito. Me ayuda a saber que voy por buen camino', 2, 1, 0),
(14, 'Creo que decir lo que otros piensan pero no dicen, es un arma de doble filo', 'Calladito/a me veo más bonito/a', 'Bueno, a veces...', 'Digo lo que pienso. Cero censura', 2, 1, 0),
(15, 'Nací de noche pero no anoche', 'Así es, más sabe el diablo por viejo que por diablo', 'Tengo mi experiencia...', 'Me falta muchísimo por aprender', 2, 1, 0),
(16, 'Cuando digo que lo voy a hacer es porque ya tengo un plan claro', 'Sí, sin un plan sería un desastre todo', 'A veces es conveniente', 'No. Sin mente como el demente', 2, 1, 0),
(17, 'Tengo claro que todo pasa y de todo se aprende', 'Vivir es aprender', 'La mayoría de las veces', 'No. Hay muchísimas experiencias innecesarias', 2, 1, 0),
(18, '¿Cómo te sientes trabajando en equipo?', 'Prefiero trabajar solo', 'Me adapto según el proyecto', '¡Me encanta la colaboración!', 0, 1, 2),
(19, 'Ante una idea diferente a la tuya, ¿qué haces?', 'La descarto inmediatamente', 'La analizo con cuidado', 'La celebro y la mejoro', 0, 1, 2),
(20, '¿Cómo manejas los errores del equipo?', 'Señalo la culpa', 'Busco soluciones', 'Los veo como oportunidades de aprendizaje', 0, 1, 2),
(21, '¿Qué te motiva más en el trabajo?', 'El reconocimiento personal', 'Un buen salario', 'El impacto colectivo', 0, 1, 2);

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_respuestas_usuario ON respuestas(usuario_id);
CREATE INDEX idx_resultados_usuario ON resultados(usuario_id);

-- Mostrar mensaje de confirmación
SELECT 'Base de datos creada exitosamente' AS mensaje;
