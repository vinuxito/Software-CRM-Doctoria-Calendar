CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(40) DEFAULT NULL,
    role ENUM('admin','medico','cliente') NOT NULL DEFAULT 'cliente',
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    doctor_id INT NOT NULL,
    patient_id INT NOT NULL,
    created_by INT NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    contact_phone VARCHAR(40) DEFAULT NULL,
    status ENUM('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
    source_channel VARCHAR(100) DEFAULT 'crm',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (patient_id) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

INSERT INTO users (id, name, email, phone, role, password) VALUES
(1, 'Administrador CRM', 'admin@doctoria.com', '+57 300 100 0001', 'admin', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(2, 'Dr. Gregory House', 'house@doctoria.com', '+57 300 100 0002', 'medico', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(3, 'Dra. Elena Torres', 'elena@doctoria.com', '+57 300 100 0003', 'medico', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(4, 'Dr. Alfredo Hidalgo', 'alfredo@doctoria.com', '+57 300 100 0004', 'medico', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(5, 'Pepe Paciente', 'pepe@doctoria.com', '+57 300 100 0005', 'cliente', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(6, 'Ana Suarez', 'ana@doctoria.com', '+57 300 100 0006', 'cliente', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(7, 'Carlos Rivas', 'carlos@doctoria.com', '+57 300 100 0007', 'cliente', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C'),
(8, 'Marta Perez', 'marta@doctoria.com', '+57 300 100 0008', 'cliente', '$2y$10$KSmTkuLZX8fHk7g38BYuP.kLVRXGWdgIHYhfOF92aaQuVSb8AbQ5C')
ON DUPLICATE KEY UPDATE
name=VALUES(name), email=VALUES(email), phone=VALUES(phone), role=VALUES(role), password=VALUES(password);

INSERT INTO appointments (user_id, title, doctor_id, patient_id, created_by, start_date, end_date, contact_phone, status, source_channel, description) VALUES
('5', 'Consulta General', 2, 5, 5, '2026-03-18 09:00:00', '2026-03-18 09:30:00', '+57 300 100 0005', 'pending', 'web', 'Primera consulta'),
('6', 'Control Mensual', 2, 6, 2, '2026-03-18 10:00:00', '2026-03-18 10:30:00', '+57 300 100 0006', 'approved', 'crm', 'Seguimiento'),
('7', 'Revisión Laboratorio', 3, 7, 7, '2026-03-19 08:30:00', '2026-03-19 09:00:00', '+57 300 100 0007', 'pending', 'whatsapp', 'Resultados de exámenes'),
('8', 'Chequeo Preventivo', 4, 8, 1, '2026-03-19 11:00:00', '2026-03-19 11:45:00', '+57 300 100 0008', 'approved', 'crm', 'Chequeo anual'),
('6', 'Consulta Pediátrica', 3, 6, 6, '2026-03-20 14:00:00', '2026-03-20 14:30:00', '+57 300 100 0006', 'approved', 'web', 'Control pediátrico'),
('7', 'Teleconsulta', 2, 7, 7, '2026-03-21 15:00:00', '2026-03-21 15:30:00', '+57 300 100 0007', 'pending', 'chatbot', 'Telemedicina'),
('5', 'Control Presión', 4, 5, 5, '2026-03-22 09:30:00', '2026-03-22 10:00:00', '+57 300 100 0005', 'rejected', 'web', 'Reprogramar'),
('8', 'Consulta Dermatología', 3, 8, 8, '2026-03-23 12:00:00', '2026-03-23 12:30:00', '+57 300 100 0008', 'approved', 'crm', 'Lesión cutánea'),
('6', 'Dolor Lumbar', 2, 6, 6, '2026-03-24 13:00:00', '2026-03-24 13:30:00', '+57 300 100 0006', 'pending', 'whatsapp', 'Dolor persistente'),
('7', 'Seguimiento Nutricional', 4, 7, 1, '2026-03-25 16:00:00', '2026-03-25 16:30:00', '+57 300 100 0007', 'approved', 'crm', 'Plan alimentario');

INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES
(5, 2, 'Hola doctor, necesito reagendar mi cita'),
(2, 5, 'Claro, ¿te funciona mañana a las 10:00?'),
(6, 3, 'Doctora, tengo una duda sobre la receta'),
(3, 6, 'Te llamo en 15 minutos para explicarte'),
(7, 4, '¿Ya están mis resultados?'),
(4, 7, 'Sí, te los reviso en consulta hoy'),
(8, 3, 'Necesito renovar mi fórmula'),
(3, 8, 'Listo, te la envío por correo');
