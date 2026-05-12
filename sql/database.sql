-- Database: bps_umkm
CREATE DATABASE IF NOT EXISTS bps_umkm DEFAULT CHARACTER SET utf8mb4;
USE bps_umkm;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    poin INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel tasks (tugas pendataan UMKM yang dibuat admin)
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    lokasi VARCHAR(150),
    poin_reward INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel surveys (data UMKM yang dikirim user)
CREATE TABLE IF NOT EXISTS surveys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task_id INT NOT NULL,
    nama_umkm VARCHAR(150) NOT NULL,
    alamat TEXT,
    jenis_usaha VARCHAR(100),
    no_telepon VARCHAR(30),
    deskripsi TEXT,
    foto_umkm VARCHAR(255),
    bukti_lokasi VARCHAR(255),
    status_validasi ENUM('pending','approved','rejected') DEFAULT 'pending',
    poin INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE
);

-- Tabel rewards
CREATE TABLE IF NOT EXISTS rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_reward VARCHAR(150) NOT NULL,
    gambar VARCHAR(255),
    poin_required INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel redeem_rewards
CREATE TABLE IF NOT EXISTS redeem_rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reward_id INT NOT NULL,
    tanggal_redeem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reward_id) REFERENCES rewards(id) ON DELETE CASCADE
);

-- Seed admin (password: Hamadamisan78)
INSERT INTO users (nama, email, password, role) VALUES
('Sakinah', 'sa@gmail.com', '$2y$10$E9Q7s3eYxJ1uG5j7cM2H9e4pK1qvRkXwQ3tYzZb0W8sV5oM2nH9rO', 'admin');
-- NOTE: password hash di atas adalah placeholder. Gunakan halaman register atau jalankan:
-- UPDATE users SET password = '<hash baru>' WHERE email = 'sa@gmail.com';
-- Hash dapat dibuat dengan: php -r "echo password_hash('Hamadamisan78', PASSWORD_DEFAULT);"

-- Seed contoh tasks
INSERT INTO tasks (judul, deskripsi, lokasi, poin_reward) VALUES
('Pendataan UMKM Pasar Beringharjo', 'Data warung & toko di area pasar', 'Yogyakarta', 20),
('Pendataan UMKM Malioboro', 'Data pedagang sepanjang Malioboro', 'Yogyakarta', 25),
('Pendataan UMKM Kuliner Solo', 'Survey UMKM kuliner di Solo', 'Solo', 30);

-- Seed contoh rewards
INSERT INTO rewards (nama_reward, poin_required) VALUES
('Pulsa Rp 10.000', 50),
('Voucher Belanja Rp 25.000', 100),
('E-Wallet Rp 50.000', 200),
('Merchandise BPS', 150);
