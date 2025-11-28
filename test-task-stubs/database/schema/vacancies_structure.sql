-- Vacancies Table Structure (ma'lumotlarsiz)
-- Bu faqat struktura, real ma'lumotlar yo'q

CREATE TABLE IF NOT EXISTS vacancies (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    company_name VARCHAR(255),
    position VARCHAR(255),
    vacancy_type_id INT,
    qualification_id INT,
    busy_type_id INT,
    start_salary DECIMAL(10,2),
    end_salary DECIMAL(10,2),
    currency_id INT,
    status VARCHAR(50),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    -- Boshqa maydonlar...
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
);

-- Vacancy Users Table (Arizalar)
CREATE TABLE IF NOT EXISTS vacancy_users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    vacancy_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    status VARCHAR(50), -- pending, reviewed, accepted, rejected
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (vacancy_id) REFERENCES vacancies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_vacancy_id (vacancy_id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
);

-- Students Table (Talabalar)
CREATE TABLE IF NOT EXISTS students (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    -- Boshqa maydonlar...
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    email VARCHAR(255),
    -- Boshqa maydonlar...
    INDEX idx_username (username)
);

