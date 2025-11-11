-- Tạo CSDL và các bảng
CREATE DATABASE IF NOT EXISTS db_thuvienn;
USE db_thuvienn;

CREATE TABLE Account (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) CHECK (role IN ('admin', 'docgia')) NOT NULL
);

CREATE TABLE DocGia (
    MaDG VARCHAR(10) PRIMARY KEY,
    HoTen VARCHAR(100),
    Email VARCHAR(100),
    username VARCHAR(50),
    FOREIGN KEY (username) REFERENCES Account(username)
);

CREATE TABLE Sach (
    MaSach VARCHAR(10) PRIMARY KEY,
    TenSach VARCHAR(100),
    TacGia VARCHAR(100),
    HinhAnh VARCHAR(255)
);

CREATE TABLE PhieuMuon (
    id INT PRIMARY KEY AUTO_INCREMENT,
    MaDG VARCHAR(10),
    MaSach VARCHAR(10),
    NgayMuon DATE,
    TrangThai VARCHAR(20) CHECK (TrangThai IN ('Đang mượn', 'Đã trả')),
    FOREIGN KEY (MaDG) REFERENCES DocGia(MaDG),
    FOREIGN KEY (MaSach) REFERENCES Sach(MaSach)
);