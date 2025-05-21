CREATE DATABASE eproject1;
USE eproject1;

-- Bảng users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    fullname VARCHAR(255),
    phone VARCHAR(20),
    role VARCHAR(50),
    dob DATE,
    gender TINYINT(1), -- 0 hoặc 1, hoặc NULL nếu không xác định
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng categories (phải tạo trước các bảng tham chiếu đến nó)
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- ========== 🪐 HÀNH TINH ==========
CREATE TABLE planets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    image VARCHAR(255),
    description TEXT,
    potential_for_life TEXT,
    orbit_and_rotation TEXT,
    rings BOOLEAN,
    structure TEXT,
    atmosphere TEXT,
    name_sake TEXT,
    size_and_distance TEXT,
    moons TEXT,
    formation TEXT,
    surface TEXT,
    magnetosphere TEXT,
    category_id INT, 
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- ========== 🌌 CHÒM SAO ==========
CREATE TABLE constellations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    notable_stars TEXT,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- ========== ☄️ SAO CHỔI ==========
CREATE TABLE comets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    features TEXT,
    last_observed DATE,
    orbital_period_years FLOAT,
    description TEXT,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- ========== 📰 TIN TỨC ==========
CREATE TABLE articles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    content TEXT,
    image_url VARCHAR(2083), -- Độ dài tiêu chuẩn cho URL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========== 🔭 ĐÀI THIÊN VĂN ==========
CREATE TABLE observatories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    location TEXT,
    description TEXT,
    image_url VARCHAR(2083)
);

-- ========== 🎥 VIDEO GIÁO DỤC ==========
CREATE TABLE videos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    url VARCHAR(2083),
    description TEXT,
    thumbnail_url VARCHAR(2083),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========== 📖 SÁCH LIÊN QUAN ==========
CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    image_url VARCHAR(2083),
    author VARCHAR(255),
    publisher VARCHAR(255),
    publish_year INT, -- Hoặc dùng kiểu YEAR(4)
    description TEXT,
    buy_link VARCHAR(2083)
);

-- ========== 🔑 PASSWORD RESET ==========
CREATE TABLE password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    token VARCHAR(255) UNIQUE,
    expired_at TIMESTAMP
);

-- Bảng trung gian cho quan hệ nhiều-nhiều giữa articles và categories
CREATE TABLE article_categories (
    article_id INT,
    category_id INT,
    PRIMARY KEY (article_id, category_id), -- Khóa chính kết hợp
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Bảng trung gian cho quan hệ nhiều-nhiều giữa videos và categories
CREATE TABLE video_categories (
    video_id INT,
    category_id INT,
    PRIMARY KEY (video_id, category_id),
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Bảng trung gian cho quan hệ nhiều-nhiều giữa books và categories
CREATE TABLE book_categories (
    book_id INT,
    category_id INT,
    PRIMARY KEY (book_id, category_id),
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);

 -- Tạo admin cho hệ thống
 -- Tài khoản admin
 -- Mật khẩu 123123
INSERT INTO users (username, password_hash, email, fullname, phone, role, dob, gender) VALUES
    ('admin', '$2y$12$bGpsc9JcHQb55tf2va70G.40jggJYn4cPXxl7YUxZ3ti/Se4wuMYO', 'admin@space.com', 'Administrator', '0968686868', 'admin', '2000-08-02', 0);

-- Tạo 3 categories chính
INSERT INTO categories (name) VALUES
    ('PLANET'),
    ('CONSTELLATION'),
    ('COMET');