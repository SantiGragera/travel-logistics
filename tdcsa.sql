CREATE TABLE IF NOT EXISTS niveles (
    id_nivel INT AUTO_INCREMENT PRIMARY KEY,
    denominacion VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    apellido VARCHAR(100) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(20) NOT NULL UNIQUE,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT 1,
    id_nivel INT,
    fecha_creacion DATETIME,
    imagen VARCHAR(255) DEFAULT 'assets/img/profile-img.jpg',
    FOREIGN KEY (id_nivel) REFERENCES niveles(id_nivel)
);

CREATE TABLE IF NOT EXISTS marcas (
    id_marca INT AUTO_INCREMENT PRIMARY KEY,
    denominacion VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS transportes (
    id_transporte INT AUTO_INCREMENT PRIMARY KEY,
    id_marca INT,
    modelo VARCHAR(100) NOT NULL,
    anio INT(4),
    patente VARCHAR(7) NOT NULL UNIQUE,
    disponible BOOLEAN DEFAULT 1,
    fecha_carga DATETIME,
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca)
);

CREATE TABLE IF NOT EXISTS destinos (
    id_destino INT AUTO_INCREMENT PRIMARY KEY,
    denominacion VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS viajes (
    id_viaje INT AUTO_INCREMENT PRIMARY KEY,
    id_chofer INT,
    id_transporte INT,
    fecha_viaje DATE,
    id_destino INT,
    costo DECIMAL(10,2),
    porcentaje_chofer INT,
    fecha_creacion_viaje DATETIME,
    id_usuario_registro INT,
    FOREIGN KEY (id_chofer) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_transporte) REFERENCES transportes(id_transporte),
    FOREIGN KEY (id_destino) REFERENCES destinos(id_destino),
    FOREIGN KEY (id_usuario_registro) REFERENCES usuarios(id_usuario)
);

INSERT INTO niveles (denominacion) VALUES ('Admin'), ('Operador'), ('Chofer');

INSERT INTO marcas (denominacion) VALUES ('Iveco'), ('Volvo'), ('Scania'), ('Volkswagen');

INSERT INTO destinos (denominacion) VALUES ('Córdoba Capital'), ('Villa María'), ('Río Cuarto'), ('San Francisco'), ('Carlos Paz');

INSERT INTO usuarios (apellido, nombre, dni, usuario, clave, id_nivel, activo, fecha_creacion) 
VALUES ('Santi', 'Admin', '40123456', 'admin', '1234', 1, 1, NOW());