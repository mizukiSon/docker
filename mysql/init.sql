-- Устанавливаем кодировку UTF8
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Используем базу данных teh
USE teh;

-- Таблица студентов
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    birth_date DATE,
    group_name VARCHAR(50),
    specialty VARCHAR(150),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица преподавателей
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    birth_date DATE,
    discipline VARCHAR(150),
    education VARCHAR(200),
    experience_years INT,
    phone VARCHAR(20),
    email VARCHAR(100),
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    full_name VARCHAR(150),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Вставляем тестовые данные (уже в UTF8)
INSERT IGNORE INTO students (full_name, birth_date, group_name, specialty, phone, email, address) VALUES
('Иванов Иван Иванович', '2005-03-15', 'ТЭ-21', 'Техническая эксплуатация оборудования', '+79001234567', 'ivanov@apt.ru', 'г. Ангарск, ул. Ленина 1'),
('Петрова Анна Сергеевна', '2006-07-22', 'ПК-23', 'Программирование в компьютерных системах', '+79007654321', 'petrova@apt.ru', 'г. Ангарск, ул. Гагарина 15'),
('Сидоров Алексей Дмитриевич', '2005-11-10', 'ЭЛ-22', 'Электроснабжение', '+79123456789', 'sidorov@apt.ru', 'г. Ангарск, мкр. 8, д. 10');

INSERT IGNORE INTO teachers (full_name, birth_date, discipline, education, experience_years, phone, email) VALUES
('Сидоров Петр Николаевич', '1980-11-05', 'Web-разработка и программирование', 'Иркутский государственный университет', 15, '+79111234567', 'sidorov.pn@apt.ru'),
('Кузнецова Мария Викторовна', '1985-02-18', 'Базы данных и SQL', 'Ангарский государственный технический университет', 10, '+79117654321', 'kuznecova.mv@apt.ru'),
('Волков Андрей Сергеевич', '1975-08-22', 'Электротехника', 'Иркутский политехнический институт', 20, '+79119876543', 'volkov.as@apt.ru');

-- Вставляем пользователей (пароль: password)
INSERT IGNORE INTO users (username, password, role, full_name, email) VALUES
('user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'Обычный пользователь', 'user@apt.ru'),
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Администратор', 'admin@apt.ru');

SELECT 'All tables created with UTF8 encoding!' as Status;
