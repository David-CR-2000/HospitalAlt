USE `Hospital_Alt`;

-- Datos para pacientes
INSERT INTO pacientes (nombre, apellido1, apellido2, DNI, TLF, num_poliza, datos_biometricos, estado, implante) VALUES
('María', 'García', 'López', '12345678A', '600111222', 'POL123', '{"altura": 170, "peso": 65}', 'alta', NULL),
('Carlos', 'Martínez', 'Sánchez', '87654321B', '699888777', 'POL456', '{"altura": 180, "peso": 80}', 'ingresado', 'Brazo biónico'),
('Ana', 'Rodríguez', NULL, '11223344C', '611222333', 'POL789', '{"altura": 165, "peso": 60}', 'alta', 'Diadema de sueño');

-- Datos para personal médico
INSERT INTO personal_medico (nombre, apellido1, apellido2, DNI, TLF, num_poliza, especialidad, turno) VALUES
('Dr. Alejandro', 'Vázquez', 'Ruiz', '22334455D', '622333444', 'MED123', 'Neurocirugía', 'mañana'),
('Dra. Laura', 'Molina', 'Gómez', '33445566E', '633444555', 'MED456', 'Cirugía Robótica', 'tarde');

-- Datos para equipamiento tecnológico
INSERT INTO equipamiento_tecnologico (Nombre_Dispositivo, Funcion, Estado, Ultimo_Mantenimiento) VALUES
('Brazo biónico', 'Prótesis neural con sensores táctiles', 'operativo', '2024-03-15'),
('Robot cirugía', 'Asistencia en procedimientos quirúrgicos', 'mantenimiento', '2024-02-28'),
('Escáner cerebral', 'Detección temprana de anomalías', 'operativo', '2024-03-01');

-- Datos para implantes
INSERT INTO implantes (nombre) VALUES
('Brazo biónico con dedos inteligentes'),
('Diadema para control del sueño'),
('Implante neural OMI');

-- ... (Agregar datos para las demás tablas)