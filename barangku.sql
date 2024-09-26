CREATE DATABASE barangku;

USE barangku;

CREATE TABLE barang (
  kode_barang INT PRIMARY KEY,
  nama_barang VARCHAR(100),
  harga DECIMAL(10,2),
  image VARCHAR(255),
  keterangan TEXT
);
